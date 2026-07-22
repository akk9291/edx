<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * List admins
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', true);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $admins = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $admins,
        ]);
    }

    /**
     * Create admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_admin' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully',
            'data' => $admin,
        ], 201);
    }

    /**
     * Get admin
     */
    public function show($id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $admin,
        ]);
    }

    /**
     * Update admin
     */
    public function update(Request $request, $id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:20', \Illuminate\Validation\Rule::unique('users', 'phone')->ignore($id)],
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        if ($request->has('password') && !empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        // Update name if first_name or last_name changed
        if ($request->has('first_name') || $request->has('last_name')) {
            $admin->name = ($admin->first_name ?? '') . ' ' . ($admin->last_name ?? '');
            $admin->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Admin updated successfully',
            'data' => $admin->fresh(),
        ]);
    }

    /**
     * Delete admin
     */
    public function destroy($id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        // Prevent deleting yourself
        if ($admin->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account',
            ], 403);
        }

        // Check if it's the only admin
        $adminCount = User::where('is_admin', true)->count();
        if ($adminCount <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete the only admin account',
            ], 400);
        }

        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully',
        ]);
    }
}




