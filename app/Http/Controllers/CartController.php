<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $qty = $request->input('qty', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
                'image' => $product->images->first()?->path ?? null,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'product' => $product->name,
                'quantity' => $qty,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'qty' => $details['qty'],
                    'subtotal' => $details['qty'] * $product->price,
                ];
                $total += $details['qty'] * $product->price;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $details) {
            $count += $details['qty'];
        }

        return response()->json(['count' => $count]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] = $request->qty;
            session()->put('cart', $cart);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart!',
            ]);
        }

        return back()->with('success', 'Product removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared successfully!');
    }
}
