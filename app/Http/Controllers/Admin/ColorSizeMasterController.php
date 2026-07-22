<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterColor;
use App\Models\MasterSize;
use Illuminate\Http\Request;

class ColorSizeMasterController extends Controller
{
    public function index()
    {
        $colors = MasterColor::orderBy('sort_order')->orderBy('name')->get();
        $sizes = MasterSize::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.color-size-master.index', compact('colors', 'sizes'));
    }

    public function storeColor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'color_code' => 'nullable|string|max:20',
        ]);
        $colorCode = $request->filled('color_code') ? trim($request->color_code) : null;
        if ($colorCode && !preg_match('/^#[0-9A-Fa-f]{3,6}$/', $colorCode)) {
            $colorCode = '#' . ltrim($colorCode, '#');
            if (!preg_match('/^#[0-9A-Fa-f]{3,6}$/', $colorCode)) {
                $colorCode = null;
            }
        }
        MasterColor::create([
            'name' => trim($request->name),
            'color_code' => $colorCode,
            'sort_order' => (int) $request->get('sort_order', 0),
        ]);
        return redirect()->route('admin.color-size-master.index')->with('success', 'Color added.');
    }

    public function updateColor(Request $request, MasterColor $color)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'color_code' => 'nullable|string|max:20',
        ]);
        $colorCode = $request->filled('color_code') ? trim($request->color_code) : null;
        if ($colorCode && !preg_match('/^#[0-9A-Fa-f]{3,6}$/', $colorCode)) {
            $colorCode = '#' . ltrim($colorCode, '#');
            if (!preg_match('/^#[0-9A-Fa-f]{3,6}$/', $colorCode)) {
                $colorCode = null;
            }
        }
        $color->update([
            'name' => trim($request->name),
            'color_code' => $colorCode,
            'sort_order' => (int) $request->get('sort_order', 0),
        ]);
        return redirect()->route('admin.color-size-master.index')->with('success', 'Color updated.');
    }

    public function destroyColor(MasterColor $color)
    {
        $color->delete();
        return redirect()->route('admin.color-size-master.index')->with('success', 'Color deleted.');
    }

    public function storeSize(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        MasterSize::create([
            'name' => trim($request->name),
            'sort_order' => (int) $request->get('sort_order', 0),
        ]);
        return redirect()->route('admin.color-size-master.index')->with('success', 'Size added.');
    }

    public function updateSize(Request $request, MasterSize $size)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $size->update([
            'name' => trim($request->name),
            'sort_order' => (int) $request->get('sort_order', 0),
        ]);
        return redirect()->route('admin.color-size-master.index')->with('success', 'Size updated.');
    }

    public function destroySize(MasterSize $size)
    {
        $size->delete();
        return redirect()->route('admin.color-size-master.index')->with('success', 'Size deleted.');
    }
}
