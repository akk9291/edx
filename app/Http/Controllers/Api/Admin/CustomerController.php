<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * List customers
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false)
            ->withCount('orders');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  ->orWhere('phone', 'LIKE', '%' . $search . '%');
            });
        }

        $customers = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $customers,
        ]);
    }

    /**
     * Get customer
     */
    public function show($id)
    {
        $customer = User::where('is_admin', false)
            ->with(['addresses', 'orders' => function($query) {
                $query->latest()->limit(10);
            }])
            ->withCount('orders')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }

    /**
     * Update customer
     */
    public function update(Request $request, $id)
    {
        $customer = User::where('is_admin', false)->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:20', \Illuminate\Validation\Rule::unique('users', 'phone')->ignore($id)],
        ]);

        $customer->update($validated);

        // Update name if first_name or last_name changed
        if ($request->has('first_name') || $request->has('last_name')) {
            $customer->name = ($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '');
            $customer->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully',
            'data' => $customer->fresh(),
        ]);
    }

    /**
     * Delete customer
     */
    public function destroy($id)
    {
        $customer = User::where('is_admin', false)->findOrFail($id);

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete customer with orders',
            ], 400);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
        ]);
    }
}




