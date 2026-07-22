<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PolicyPage;
use Illuminate\Http\Request;

class PolicyPageController extends Controller
{
    /** Default slugs that must exist in the table. */
    protected const DEFAULT_SLUGS = [
        'about-us' => 'About Us',
        'terms-and-conditions' => 'Terms & Conditions',
        'privacy-policy' => 'Privacy Policy',
        'return-and-refund' => 'Return and Refund Policy',
        'cancellation-policy' => 'Cancellation Policy',
    ];

    /**
     * List all policy pages. Creates any missing default pages so they appear in the list.
     */
    public function index()
    {
        foreach (self::DEFAULT_SLUGS as $slug => $title) {
            PolicyPage::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => '<p>Edit this page to add content.</p>',
                    'is_active' => true,
                ]
            );
        }

        $pages = PolicyPage::orderBy('slug')->get();
        return view('admin.policy-pages.index', compact('pages'));
    }

    /**
     * Show edit form for a policy page.
     */
    public function edit(PolicyPage $policy_page)
    {
        return view('admin.policy-pages.edit', compact('policy_page'));
    }

    /**
     * Update a policy page.
     */
    public function update(Request $request, PolicyPage $policy_page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:100000',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $policy_page->update($validated);

        return redirect()->route('admin.policy-pages.index')
            ->with('success', 'Policy page updated successfully!');
    }
}
