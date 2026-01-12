<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's addresses
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Store a new address
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'province' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        $address = auth()->user()->addresses()->create($request->all());

        if ($request->is_default) {
            $address->setAsDefault();
        }

        return redirect()->route('addresses.index')
                       ->with('success', __('messages.address.created'));
    }

    /**
     * Update address
     */
    public function update(Request $request, UserAddress $address)
    {
        // Check if user owns this address
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'province' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        $address->update($request->all());

        if ($request->is_default) {
            $address->setAsDefault();
        }

        return redirect()->route('addresses.index')
                       ->with('success', __('messages.address.updated'));
    }

    /**
     * Delete address
     */
    public function destroy(UserAddress $address)
    {
        // Check if user owns this address
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('addresses.index')
                       ->with('success', __('messages.address.deleted'));
    }

    /**
     * Set address as default
     */
    public function setDefault(UserAddress $address)
    {
        // Check if user owns this address
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->setAsDefault();

        return redirect()->route('addresses.index')
                       ->with('success', __('messages.address.set_default'));
    }
}
