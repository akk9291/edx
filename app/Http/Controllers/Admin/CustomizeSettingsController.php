<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CustomizeConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomizeSettingsController extends Controller
{
    public function index()
    {
        $rowCount = 12;

        $raw = CustomizeConfigService::getGlobalCustomizeConfig();
        $merged = CustomizeConfigService::mergedForAdminForm($raw);

        $paddedPalettes = [
            'bottle' => $this->padPalette($merged['bottle_colors'] ?? [], $rowCount),
            'cap' => $this->padPalette($merged['cap_colors'] ?? [], $rowCount),
            'strap' => $this->padPalette($merged['strap_colors'] ?? [], $rowCount),
            'handle' => $this->padPalette($merged['handle_colors'] ?? [], $rowCount),
            'boot' => $this->padPalette($merged['boot_colors'] ?? [], $rowCount),
        ];

        $sizesRows = $this->padSizes($merged['sizes'] ?? [], 5);

        $displayName = (string) ($raw['display_name'] ?? '');
        $hasEngraving = (bool) ($raw['has_engraving'] ?? false);
        $engravingPrice = (string) ($raw['engraving_price'] ?? '0');
        $engravingMaxChars = (int) ($raw['engraving_max_chars'] ?? 40);
        $engravingLabel = (string) ($raw['engraving_label'] ?? '');
        $engravingCategoryRows = $this->padEngravingCategoryRows($raw['engraving_categories'] ?? []);

        return view('admin.customize.index', [
            'paddedPalettes' => $paddedPalettes,
            'sizesRows' => $sizesRows,
            'displayName' => $displayName,
            'hasEngraving' => $hasEngraving,
            'engravingPrice' => $engravingPrice,
            'engravingMaxChars' => $engravingMaxChars,
            'engravingLabel' => $engravingLabel,
            'engravingCategoryRows' => $engravingCategoryRows,
            'hasGlobalSaved' => CustomizeConfigService::getGlobalCustomizeConfig() !== [],
        ]);
    }

    /**
     * @param  array<int, array{name?: string, hex?: string}>  $colors
     * @return array<int, array{name: string, hex: string}>
     */
    private function padPalette(array $colors, int $targetRows): array
    {
        $out = [];
        foreach ($colors as $c) {
            if (!is_array($c)) {
                continue;
            }
            $name = trim((string) ($c['name'] ?? ''));
            $hex = trim((string) ($c['hex'] ?? '#888888'));
            if ($name === '') {
                continue;
            }
            if ($hex !== '' && !str_starts_with($hex, '#')) {
                $hex = '#'.$hex;
            }
            $out[] = ['name' => $name, 'hex' => $hex];
        }
        while (count($out) < $targetRows) {
            $out[] = ['name' => '', 'hex' => '#888888'];
        }

        return $out;
    }

    /**
     * @param  array<int, array{name?: string, desc?: string, price?: float|int|string}>  $sizes
     * @return array<int, array{name: string, desc: string, price: string}>
     */
    private function padSizes(array $sizes, int $targetRows): array
    {
        $out = [];
        foreach ($sizes as $s) {
            if (!is_array($s)) {
                continue;
            }
            $name = trim((string) ($s['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $out[] = [
                'name' => $name,
                'desc' => trim((string) ($s['desc'] ?? '')),
                'price' => (string) ($s['price'] ?? '0'),
            ];
        }
        while (count($out) < $targetRows) {
            $out[] = ['name' => '', 'desc' => '', 'price' => ''];
        }

        return $out;
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{name: string, slug: string, price: string, type: string, icon: string}>
     */
    private function padEngravingCategoryRows(array $rows): array
    {
        $out = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }
            $rawType = strtolower(trim((string) ($row['type'] ?? '')));
            $type = in_array($rawType, ['text', 'simple', 'upload'], true) ? $rawType : 'simple';
            $out[] = [
                'name' => (string) ($row['name'] ?? ''),
                'slug' => (string) ($row['slug'] ?? ''),
                'price' => (string) ($row['price'] ?? ''),
                'type' => $type,
                'icon' => (string) ($row['icon'] ?? ''),
            ];
        }
        // Only one empty row by default; more rows come from saved data or “Add category”.
        while (count($out) < 1) {
            $out[] = ['name' => '', 'slug' => '', 'price' => '', 'type' => 'simple', 'icon' => ''];
        }

        return $out;
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return list<array{name: string, slug: string, price: float, type: string, icon: ?string}>
     */
    private function parseEngravingCategories(array $rows, Request $request): array
    {
        $out = [];
        foreach ($rows as $i => $row) {
            if (! is_array($row)) {
                continue;
            }
            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $slug = trim((string) ($row['slug'] ?? ''));
            $price = round(max(0, (float) ($row['price'] ?? 0)), 2);
            $type = strtolower(trim((string) ($row['type'] ?? 'simple')));
            if (! in_array($type, ['text', 'simple', 'upload'], true)) {
                $type = 'simple';
            }
            $icon = trim((string) ($row['icon'] ?? ''));
            if ($type === 'upload') {
                $upload = $request->file("engraving_categories.$i.icon_upload");
                if ($upload && $upload->isValid()) {
                    $path = $upload->store('customize/engraving-icons', 'public');
                    if ($path !== false) {
                        $icon = Storage::disk('public')->url($path);
                    }
                }
            }
            $out[] = [
                'name' => $name,
                'slug' => $slug,
                'price' => $price,
                'type' => $type,
                'icon' => $icon !== '' ? $icon : null,
            ];
        }

        return $out;
    }

    public function update(Request $request)
    {
        $request->validate([
            'display_name' => 'nullable|string|max:255',
            'engraving_price' => 'nullable|numeric|min:0',
            'engraving_max_chars' => 'nullable|integer|min:1|max:500',
            'engraving_label' => 'nullable|string|max:255',
            'engraving_categories.*.icon_upload' => 'nullable|file|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $cfg = CustomizeConfigService::getGlobalCustomizeConfig();

        $cfg['bottle_colors'] = $this->parsePalette($request->input('palette_bottle', []));
        $cfg['cap_colors'] = $this->parsePalette($request->input('palette_cap', []));
        $cfg['strap_colors'] = $this->parsePalette($request->input('palette_strap', []));
        $cfg['handle_colors'] = $this->parsePalette($request->input('palette_handle', []));
        $cfg['boot_colors'] = $this->parsePalette($request->input('palette_boot', []));

        $sizes = $this->parseSizes($request->input('sizes', []));
        if (empty($sizes)) {
            return redirect()->back()->withInput()->withErrors(['sizes' => 'Add at least one size with name and price.']);
        }
        $cfg['sizes'] = $sizes;

        $cfg['has_engraving'] = $request->boolean('has_engraving');
        $cfg['engraving_price'] = round(max(0, (float) $request->input('engraving_price', 0)), 2);
        $cfg['engraving_max_chars'] = max(1, min(500, (int) $request->input('engraving_max_chars', 40)));
        if ($request->filled('engraving_label')) {
            $cfg['engraving_label'] = trim((string) $request->engraving_label);
        } else {
            unset($cfg['engraving_label']);
        }

        $cfg['engraving_categories'] = $this->parseEngravingCategories($request->input('engraving_categories', []), $request);

        if ($request->filled('display_name')) {
            $cfg['display_name'] = trim((string) $request->display_name);
        } else {
            unset($cfg['display_name']);
        }

        Setting::set(CustomizeConfigService::SETTING_GLOBAL, json_encode($cfg, JSON_UNESCAPED_UNICODE));

        return redirect()
            ->route('admin.customize.index')
            ->with('success', 'Customizer settings saved.');
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{name: string, hex: string}>
     */
    private function parsePalette(array $rows): array
    {
        $out = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $hex = trim((string) ($row['hex'] ?? '#888888'));
            if ($hex !== '' && !str_starts_with($hex, '#')) {
                $hex = '#'.$hex;
            }
            if (preg_match('/^#([0-9A-Fa-f]{3})$/', $hex, $m)) {
                $h = $m[1];
                $hex = '#'.$h[0].$h[0].$h[1].$h[1].$h[2].$h[2];
            }
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $hex)) {
                $hex = '#888888';
            }
            $out[] = ['name' => $name, 'hex' => strtolower($hex)];
        }

        return $out;
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{name: string, desc: string, price: float}>
     */
    private function parseSizes(array $rows): array
    {
        $out = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $out[] = [
                'name' => $name,
                'desc' => trim((string) ($row['desc'] ?? '')),
                'price' => max(0, (float) ($row['price'] ?? 0)),
            ];
        }

        return $out;
    }
}
