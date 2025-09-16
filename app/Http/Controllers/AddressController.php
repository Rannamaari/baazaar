<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AddressController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the user's addresses.
     */
    public function index(): View
    {
        $user = auth()->user();
        $addresses = $user->addresses()->orderBy('type')->orderBy('is_default', 'desc')->get();

        return view('addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create(): View
    {
        $atolls = DB::table('atolls')->orderBy('order')->get();

        return view('addresses.create', compact('atolls'));
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:home,office',
            'label' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'road_name' => 'nullable|string|max:255',
            'island' => 'required|string|max:255',
            'atoll' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'additional_notes' => 'nullable|string|max:1000',
            'is_default' => 'boolean',
        ]);

        $user = auth()->user();

        // If this is set as default, unset other defaults of the same type
        if ($request->boolean('is_default')) {
            $user->addresses()
                ->where('type', $request->type)
                ->update(['is_default' => false]);
        }

        $address = $user->addresses()->create([
            'type' => $request->type,
            'label' => $request->label,
            'street_address' => $request->street_address,
            'road_name' => $request->road_name,
            'island' => $request->island,
            'atoll' => $request->atoll,
            'postal_code' => $request->postal_code,
            'additional_notes' => $request->additional_notes,
            'is_default' => $request->boolean('is_default'),
        ]);

        return redirect()->route('addresses.index')
            ->with('success', 'Address added successfully!');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(Address $address): View
    {
        $this->authorize('update', $address);

        $atolls = DB::table('atolls')->orderBy('order')->get();

        return view('addresses.edit', compact('address', 'atolls'));
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, Address $address): RedirectResponse
    {
        $this->authorize('update', $address);

        $request->validate([
            'type' => 'required|in:home,office',
            'label' => 'nullable|string|max:255',
            'street_address' => 'required|string|max:255',
            'road_name' => 'nullable|string|max:255',
            'island' => 'required|string|max:255',
            'atoll' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'additional_notes' => 'nullable|string|max:1000',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, unset other defaults of the same type
        if ($request->boolean('is_default')) {
            auth()->user()->addresses()
                ->where('type', $request->type)
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update([
            'type' => $request->type,
            'label' => $request->label,
            'street_address' => $request->street_address,
            'road_name' => $request->road_name,
            'island' => $request->island,
            'atoll' => $request->atoll,
            'postal_code' => $request->postal_code,
            'additional_notes' => $request->additional_notes,
            'is_default' => $request->boolean('is_default'),
        ]);

        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Remove the specified address.
     */
    public function destroy(Address $address): RedirectResponse
    {
        $this->authorize('delete', $address);

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Set an address as default.
     */
    public function setDefault(Address $address): RedirectResponse
    {
        $this->authorize('update', $address);

        // Unset other defaults of the same type
        auth()->user()->addresses()
            ->where('type', $address->type)
            ->update(['is_default' => false]);

        // Set this address as default
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')
            ->with('success', 'Default address updated!');
    }

    /**
     * Get islands for a specific atoll (AJAX).
     */
    public function getIslands(string $atoll)
    {
        if (! $atoll) {
            return response()->json([]);
        }

        $islands = DB::table('islands')
            ->join('atolls', 'islands.atoll_id', '=', 'atolls.id')
            ->where('atolls.name', $atoll)
            ->select('islands.name')
            ->orderBy('islands.name')
            ->pluck('name');

        return response()->json($islands);
    }
}
