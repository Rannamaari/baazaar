<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegistrationFlowController extends Controller
{
    /**
     * Show the address setup form after registration.
     */
    public function showAddressSetup(): View|RedirectResponse
    {
        $user = auth()->user();

        // If user already has addresses, redirect to dashboard
        if ($user->hasAddresses()) {
            return redirect()->route('dashboard');
        }

        $atolls = DB::table('atolls')->orderBy('order')->get();

        return view('auth.address-setup', compact('atolls'));
    }

    /**
     * Store the initial addresses after registration.
     */
    public function storeAddresses(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // If user already has addresses, redirect to dashboard
        if ($user->hasAddresses()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            // Phone number validation
            'phone' => 'required|string|max:20',
            
            // Address validation
            'type' => 'required|in:home,office',
            'label' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'road_name' => 'nullable|string|max:255',
            'island' => 'required|string|max:255',
            'atoll' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'additional_notes' => 'nullable|string|max:1000',
        ]);

        // Update user's phone number
        $user->update(['phone' => $request->phone]);

        // Create address
        $user->addresses()->create([
            'type' => $request->type,
            'label' => $request->label ?: ($request->type === 'home' ? 'My Home' : 'My Office'),
            'street_address' => $request->street_address,
            'road_name' => $request->road_name,
            'island' => $request->island,
            'atoll' => $request->atoll,
            'postal_code' => $request->postal_code,
            'additional_notes' => $request->additional_notes,
            'is_default' => true, // First address is default
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome! Your address and phone number have been saved. You can now shop with ease!');
    }

    /**
     * Skip address setup (optional).
     */
    public function skipAddressSetup(): RedirectResponse
    {
        return redirect()->route('dashboard')
            ->with('info', 'You can add your addresses later from your profile.');
    }
}
