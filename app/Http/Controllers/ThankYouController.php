<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ThankYouController extends Controller
{
    public function index(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = null;

        if ($orderId) {
            $order = Order::with(['user', 'orderItems.product'])->find($orderId);
        }

        return view('thank-you', compact('order'));
    }
}
