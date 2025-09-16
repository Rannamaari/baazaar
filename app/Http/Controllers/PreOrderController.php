<?php

namespace App\Http\Controllers;

use App\Models\PreOrder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PreOrderController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of user's pre-orders.
     */
    public function index(): View
    {
        $preOrders = auth()->user()
            ->preOrders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pre-orders.index', compact('preOrders'));
    }

    /**
     * Show the form for creating a new pre-order.
     */
    public function create(): View
    {
        return view('pre-orders.create');
    }

    /**
     * Store a newly created pre-order.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'product_url' => 'required|string|max:500',
            'additional_details' => 'nullable|string|max:1000',
        ]);

        // Normalize the URL - add https:// if no protocol is provided
        $productUrl = $request->product_url;
        if (!preg_match('/^https?:\/\//', $productUrl)) {
            $productUrl = 'https://' . $productUrl;
        }

        // Validate the normalized URL
        if (!filter_var($productUrl, FILTER_VALIDATE_URL)) {
            return back()->withErrors(['product_url' => 'Please provide a valid product URL.'])->withInput();
        }

        auth()->user()->preOrders()->create([
            'product_name' => $request->product_name,
            'brand' => $request->brand,
            'product_url' => $productUrl,
            'additional_details' => $request->additional_details,
            'status' => 'pending',
        ]);

        return redirect()->route('pre-orders.index')
            ->with('success', 'Pre-order request submitted successfully! We will review and contact you soon.');
    }

    /**
     * Display the specified pre-order.
     */
    public function show(PreOrder $preOrder): View
    {
        $this->authorize('view', $preOrder);

        return view('pre-orders.show', compact('preOrder'));
    }
}
