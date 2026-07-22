<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuotaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuotaRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = QuotaRequest::withCount('items')->orderByDesc('created_at');

        $status = $request->get('status');
        $search = $request->get('search');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', '%'.$search.'%')
                    ->orWhere('contact_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('company_name', 'like', '%'.$search.'%');
            });
        }

        $quotaRequests = $query->paginate(20)->withQueryString();

        return view('admin.quota-requests.index', compact('quotaRequests', 'status', 'search'));
    }

    public function show(QuotaRequest $quotaRequest): View
    {
        $quotaRequest->load(['items.product.category']);

        return view('admin.quota-requests.show', compact('quotaRequest'));
    }

    public function update(Request $request, QuotaRequest $quotaRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_review,quoted,closed,cancelled',
            'admin_notes' => 'nullable|string|max:10000',
        ]);

        $quotaRequest->update($validated);

        return redirect()
            ->route('admin.quota-requests.show', $quotaRequest)
            ->with('success', 'Quota request updated.');
    }

    public function destroy(QuotaRequest $quotaRequest): RedirectResponse
    {
        $quotaRequest->delete();

        return redirect()
            ->route('admin.quota-requests.index')
            ->with('success', 'Quota request deleted.');
    }
}
