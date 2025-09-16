<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $itemSubtotal = $details['qty'] * $product->price;
                $cartItems[] = [
                    'product' => $product,
                    'qty' => $details['qty'],
                    'subtotal' => $itemSubtotal,
                ];
                $subtotal += $itemSubtotal;
            }
        }

        $shippingTotal = 0; // Free shipping for now
        $taxTotal = 0; // No tax for now
        $grandTotal = $subtotal + $shippingTotal + $taxTotal;

        // Get user addresses
        $user = auth()->user();
        $addresses = $user->addresses()->orderBy('type')->orderBy('is_default', 'desc')->get();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingTotal', 'taxTotal', 'grandTotal', 'addresses', 'defaultAddress'));
    }

    public function place(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'payment_method' => 'required|string|in:cash,bank_transfer,card',
            'delivery_address_id' => 'required|exists:addresses,id',
            'delivery_phone' => 'required|string|max:20',
            'payment_slip' => 'required_if:payment_method,bank_transfer|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Verify the address belongs to the user
        $deliveryAddress = Address::where('id', $request->delivery_address_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        try {
            $order = DB::transaction(function () use ($cart, $request, $deliveryAddress) {
                $subtotal = 0;
                $orderItems = [];

                // Calculate totals and prepare order items
                foreach ($cart as $id => $details) {
                    $product = Product::find($id);
                    if ($product && $product->stock >= $details['qty']) {
                        $lineTotal = $details['qty'] * $product->price;
                        $subtotal += $lineTotal;

                        $orderItems[] = [
                            'product' => $product,
                            'qty' => $details['qty'],
                            'unit_price' => $product->price,
                            'line_total' => $lineTotal,
                        ];

                        // Reduce stock
                        $product->decrement('stock', $details['qty']);
                    } else {
                        throw new \Exception("Product {$product->name} is out of stock or insufficient quantity available.");
                    }
                }

                $shippingTotal = 0;
                $taxTotal = 0;
                $grandTotal = $subtotal + $shippingTotal + $taxTotal;

                // Handle payment slip upload for bank transfer
                $paymentSlipPath = null;
                if ($request->payment_method === 'bank_transfer' && $request->hasFile('payment_slip')) {
                    $paymentSlipFile = $request->file('payment_slip');

                    // Generate a clean filename
                    $extension = $paymentSlipFile->getClientOriginalExtension();
                    $filename = 'payment_slip_'.time().'_'.uniqid().'.'.$extension;

                    $paymentSlipPath = $paymentSlipFile->storeAs('payment-slips', $filename, 'public');
                }

                // Determine payment status based on payment method
                $paymentStatus = $request->payment_method === 'cash' ? 'pending' : 'pending';

                // Create order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'discount_total' => 0,
                    'tax_total' => $taxTotal,
                    'shipping_total' => $shippingTotal,
                    'grand_total' => $grandTotal,
                    'currency' => 'MVR',
                    'payment_method' => $request->payment_method,
                    'payment_status' => $paymentStatus,
                    'payment_slip_path' => $paymentSlipPath,
                    'delivery_address' => $deliveryAddress->full_address,
                    'delivery_phone' => $request->delivery_phone,
                ]);

                // Create order items
                foreach ($orderItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'name' => $item['product']->name,
                        'unit_price' => $item['unit_price'],
                        'qty' => $item['qty'],
                        'line_total' => $item['line_total'],
                    ]);
                }

                // Clear cart
                session()->forget('cart');

                return $order;
            });

            // Send order confirmation email
            $order->load(['user', 'items']);
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));

            return redirect()->route('thank-you', ['order_id' => $order->id])->with('success', 'Order placed successfully! We will contact you soon.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'cart' => $e->getMessage(),
            ])->withInput();
        }
    }
}
