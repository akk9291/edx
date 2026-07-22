<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    // Middleware is applied in routes, no need to duplicate here
    
    /**
     * Store a newly created address
     */
    public function store(Request $request)
    {
        $wantsJson = $request->ajax() || $request->wantsJson();
        if (!Auth::check()) {
            if ($wantsJson) {
                return response()->json(['success' => false, 'message' => 'Session expired. Please login again.'], 401);
            }
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please login again.');
        }

        $validator = Validator::make($request->all(), [
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|min:5|max:6',
            'is_default' => 'nullable',
        ]);

        if ($validator->fails()) {
            $redirect = redirect()->route('my-account', ['tab' => 'address'])
                ->withErrors($validator)
                ->withInput();
            if ($wantsJson) {
                return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }
            return $redirect;
        }

        $validated = $validator->validated();
        $isDefault = $request->has('is_default') && ($request->is_default == '1' || $request->is_default === true);

        // If this is set as default, unset other defaults
        if ($isDefault) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        try {
            Address::create([
                'user_id' => Auth::id(),
                'label' => $validated['label'] ?? 'Home',
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'is_default' => $isDefault,
            ]);

            $redirectUrl = route('my-account', ['tab' => 'address']);

            if ($wantsJson) {
                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully!',
                    'redirect' => $redirectUrl,
                ]);
            }

            return redirect($redirectUrl)->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            Log::error('Address save error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($wantsJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save address. Please try again.',
                ], 500);
            }

            return redirect()->route('my-account', ['tab' => 'address'])
                ->withErrors(['error' => 'Failed to save address. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Update an existing address
     */
    public function update(Request $request, $id)
    {
        $wantsJson = $request->ajax() || $request->wantsJson();
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'label' => 'nullable|string|max:255',
            'full_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address_line_1' => 'sometimes|required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'pincode' => 'sometimes|required|string|min:5|max:6',
            'is_default' => 'nullable',
        ]);

        if ($validator->fails()) {
            $redirect = redirect()->route('my-account', ['tab' => 'address', 'edit' => $id])
                ->withErrors($validator)
                ->withInput();
            if ($wantsJson) {
                return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }
            return $redirect;
        }

        $validated = $validator->validated();
        $isDefault = $request->has('is_default') && ($request->is_default == '1' || $request->is_default === true);

        if ($isDefault) {
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        try {
            $address->update(array_merge($validated, ['is_default' => $isDefault]));

            $redirectUrl = route('my-account', ['tab' => 'address']);
            if ($wantsJson) {
                return response()->json([
                    'success' => true,
                    'message' => 'Address updated successfully!',
                    'redirect' => $redirectUrl,
                ]);
            }
            return redirect($redirectUrl)->with('success', 'Address updated successfully!');
        } catch (\Exception $e) {
            Log::error('Address update error: ' . $e->getMessage());
            if ($wantsJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update address. Please try again.',
                ], 500);
            }
            return redirect()->route('my-account', ['tab' => 'address'])
                ->withErrors(['error' => 'Failed to update address. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Delete an address
     */
    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        $address->delete();

        return redirect()->route('my-account')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Set an address as default
     */
    public function setDefault($id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        // Unset other defaults
        Address::where('user_id', Auth::id())
            ->where('id', '!=', $id)
            ->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return redirect()->route('my-account')
            ->with('success', 'Default address updated!');
    }
}
