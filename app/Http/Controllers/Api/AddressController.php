<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of addresses
     */
    public function index(Request $request)
    {
        $addresses = Address::where('user_id', $request->user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $addresses,
        ]);
    }

    /**
     * Store a newly created address
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|size:6',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->boolean('is_default')) {
            Address::where('user_id', $request->user()->id)
                ->update(['is_default' => false]);
        }

        $address = Address::create([
            'user_id' => $request->user()->id,
            'label' => $request->label ?? 'Home',
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'is_default' => $request->boolean('is_default', false),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address created successfully',
            'data' => $address,
        ], 201);
    }

    /**
     * Display the specified address
     */
    public function show(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $address,
        ]);
    }

    /**
     * Update the specified address
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $request->validate([
            'label' => 'sometimes|string|max:255',
            'full_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address_line_1' => 'sometimes|required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'pincode' => 'sometimes|required|string|size:6',
            'is_default' => 'sometimes|boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->has('is_default') && $request->boolean('is_default')) {
            Address::where('user_id', $request->user()->id)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $address->update($request->only([
            'label', 'full_name', 'phone', 'address_line_1',
            'address_line_2', 'city', 'state', 'pincode', 'is_default'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully',
            'data' => $address->fresh(),
        ]);
    }

    /**
     * Remove the specified address
     */
    public function destroy(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully',
        ]);
    }

    /**
     * Set address as default
     */
    public function setDefault(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)
            ->findOrFail($id);

        // Unset other defaults
        Address::where('user_id', $request->user()->id)
            ->where('id', '!=', $id)
            ->update(['is_default' => false]);

        $address->is_default = true;
        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'Default address updated successfully',
            'data' => $address->fresh(),
        ]);
    }
}




