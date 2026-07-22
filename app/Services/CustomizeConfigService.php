<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Str;

class CustomizeConfigService
{
    public const SETTING_GLOBAL = 'customize_global';

    /** Color name to hex mapping for known Perch/Hydro Flask colors */
    protected static array $colorHexMap = [
        'Mermaid Green' => '#4aab6a',
        'Dragonfruit' => '#c4426a',
        'Pacific' => '#3b78c4',
        'Lava' => '#c94b2f',
        'Slate' => '#5e7080',
        'Tan' => '#c2a97d',
        'Carnation' => '#e8a29a',
        'Birch' => '#b8b0a0',
        'Black' => '#1a1a1a',
        'White' => '#f0f0ee',
        'Lupine' => '#5b4ea8',
        'Agave' => '#5aaa7a',
        'Cascade' => '#6b8fbd',
        'Sage' => '#8aaa8a',
        'Citron' => '#d4c03a',
        'Green' => '#3aaa5a',
        'Pink' => '#e87aaa',
    ];

    protected static array $defaultBottleColors = [
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Lava', 'hex' => '#c94b2f'],
        ['name' => 'Slate', 'hex' => '#5e7080'],
        ['name' => 'Tan', 'hex' => '#c2a97d'],
        ['name' => 'Carnation', 'hex' => '#e8a29a'],
        ['name' => 'Birch', 'hex' => '#b8b0a0'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Lupine', 'hex' => '#5b4ea8'],
        ['name' => 'Agave', 'hex' => '#5aaa7a'],
    ];

    protected static array $defaultCapColors = [
        ['name' => 'Cascade', 'hex' => '#6b8fbd'],
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Sage', 'hex' => '#8aaa8a'],
        ['name' => 'Carnation', 'hex' => '#e8a29a'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Birch', 'hex' => '#c0b9a8'],
    ];

    protected static array $defaultStrapColors = [
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Citron', 'hex' => '#d4c03a'],
        ['name' => 'Green', 'hex' => '#3aaa5a'],
        ['name' => 'Pink', 'hex' => '#e87aaa'],
        ['name' => 'Cascade', 'hex' => '#8ab4d4'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
    ];

    protected static array $defaultBootColors = [
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
    ];

    protected static array $defaultTumblerColors = [
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Mermaid Green', 'hex' => '#4aab6a'],
        ['name' => 'Dragonfruit', 'hex' => '#c4426a'],
        ['name' => 'Carnation', 'hex' => '#e8a29a'],
        ['name' => 'Tan', 'hex' => '#c2a97d'],
    ];

    protected static array $defaultLidColors = [
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'White', 'hex' => '#f0f0ee'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
        ['name' => 'Green', 'hex' => '#3aaa5a'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
    ];

    protected static array $defaultStrawColors = [
        ['name' => 'Lavender', 'hex' => '#c4b8e8'],
        ['name' => 'Stone', 'hex' => '#6b6b6b'],
        ['name' => 'Black', 'hex' => '#1a1a1a'],
        ['name' => 'Pacific', 'hex' => '#3b78c4'],
        ['name' => 'Camellia', 'hex' => '#e87aaa'],
        ['name' => 'Neon Yellow', 'hex' => '#ffe000'],
    ];

    /**
     * Global customizer JSON from settings (title, colors, sizes, prices).
     *
     * @return array<string, mixed>
     */
    public static function getGlobalCustomizeConfig(): array
    {
        $raw = Setting::get(self::SETTING_GLOBAL);
        if (!is_string($raw) || $raw === '') {
            return [];
        }
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Catalog product used for cart/checkout lines for /customize builds (slug from seeder).
     */
    public static function getCartProductId(): ?int
    {
        $id = Product::query()
            ->where('slug', '1200ml-running-tumbler')
            ->where('is_active', true)
            ->value('id');

        return $id ? (int) $id : null;
    }

    /**
     * Size rows as on the public customizer (aligned with composeFrontendConfig defaults).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function effectiveCustomizerSizes(): array
    {
        $customizeConfig = self::getGlobalCustomizeConfig();

        return $customizeConfig['sizes'] ?? [
            ['name' => '24 oz', 'desc' => 'Insulated tumbler for life on the go.', 'price' => 3500],
            ['name' => '32 oz', 'desc' => 'Medium insulated tumbler.', 'price' => 4000],
            ['name' => '40 oz', 'desc' => 'Large insulated tumbler with handle and straw.', 'price' => 4500],
        ];
    }

    public static function unitPriceForCustomizerSizeIndex(int $sizeIndex): ?float
    {
        $sizes = self::effectiveCustomizerSizes();
        if ($sizeIndex < 0 || $sizeIndex >= count($sizes)) {
            return null;
        }
        $row = $sizes[$sizeIndex];
        if (!is_array($row) || !array_key_exists('price', $row)) {
            return null;
        }

        return max(0, round((float) $row['price'], 2));
    }

    /**
     * Merged palettes/sizes for admin form padding (no product color fallback).
     *
     * @param  array<string, mixed>  $stored
     * @return array<string, mixed>
     */
    public static function mergedForAdminForm(array $stored): array
    {
        $stub = new Product(['customize_config' => $stored, 'colors' => null]);

        return self::composeFrontendConfig($stored, $stub, false);
    }

    /**
     * Public /customize page — settings only, not tied to a catalog product.
     *
     * @return array<string, mixed>
     */
    public static function getStandaloneConfig(): array
    {
        $customizeConfig = self::getGlobalCustomizeConfig();
        $stub = new Product([
            'slug' => 'customize',
            'name' => 'Customize',
            'price' => 0,
            'sale_price' => null,
            'colors' => null,
            'customize_config' => null,
        ]);

        return self::composeFrontendConfig($customizeConfig, $stub, false);
    }

    public static function getConfig(Product $product): array
    {
        $global = self::getGlobalCustomizeConfig();
        $useGlobal = $global !== [];
        $customizeConfig = $useGlobal ? $global : ($product->customize_config ?? []);

        return self::composeFrontendConfig($customizeConfig, $product, !$useGlobal);
    }

    /**
     * @param  array<string, mixed>  $customizeConfig
     * @return array<string, mixed>
     */
    private static function composeFrontendConfig(array $customizeConfig, Product $product, bool $allowProductColorFallback): array
    {
        $bottleColors = $customizeConfig['bottle_colors'] ?? $customizeConfig['tumbler_colors'] ?? null;
        if (!$bottleColors && $allowProductColorFallback && !empty($product->colors)) {
            $bottleColors = self::colorsArrayToConfig($product->colors);
        }
        $bottleColors = $bottleColors ?: self::$defaultTumblerColors;

        $capColors = $customizeConfig['cap_colors'] ?? $customizeConfig['lid_colors'] ?? self::$defaultLidColors;
        $strapColors = $customizeConfig['strap_colors'] ?? $customizeConfig['straw_colors'] ?? self::$defaultStrawColors;
        $bootColors = $customizeConfig['boot_colors'] ?? self::$defaultBootColors;
        $handleColors = $customizeConfig['handle_colors'] ?? $customizeConfig['boot_colors'] ?? self::$defaultBootColors;

        $sizes = $customizeConfig['sizes'] ?? [
            ['name' => '24 oz', 'desc' => 'Insulated tumbler for life on the go.', 'price' => 3500],
            ['name' => '32 oz', 'desc' => 'Medium insulated tumbler.', 'price' => 4000],
            ['name' => '40 oz', 'desc' => 'Large insulated tumbler with handle and straw.', 'price' => 4500],
        ];

        $lastSize = end($sizes);
        $basePrice = (float) ($lastSize['price'] ?? $product->sale_price ?? $product->price ?? 45);

        $defaultPartStlUrls = [
            'body' => route('customize.part.stl', ['part' => 'body']),
            'logo' => route('customize.part.stl', ['part' => 'logo']),
            'cap' => route('customize.part.stl', ['part' => 'cap']),
            'ring' => route('customize.part.stl', ['part' => 'ring']),
            'straw' => route('customize.part.stl', ['part' => 'straw']),
            'handle' => route('customize.part.stl', ['part' => 'handle']),
            'boot' => route('customize.part.stl', ['part' => 'boot']),
        ];
        $partStlUrls = array_replace(
            $defaultPartStlUrls,
            is_array($customizeConfig['part_stl_urls'] ?? null) ? $customizeConfig['part_stl_urls'] : []
        );

        $displayName = isset($customizeConfig['display_name']) && $customizeConfig['display_name'] !== ''
            ? (string) $customizeConfig['display_name']
            : 'Customize';

        $hasEngravingFlag = ! empty($customizeConfig['has_engraving']);
        $engravingPrice = round(max(0, (float) ($customizeConfig['engraving_price'] ?? 0)), 2);
        $engravingMaxChars = max(1, min(500, (int) ($customizeConfig['engraving_max_chars'] ?? 40)));
        $engravingLabel = isset($customizeConfig['engraving_label']) && is_string($customizeConfig['engraving_label']) && trim($customizeConfig['engraving_label']) !== ''
            ? trim($customizeConfig['engraving_label'])
            : 'Engraving';

        $engravingCategories = self::normalizeEngravingCategoriesArray($customizeConfig['engraving_categories'] ?? []);
        $engravingCategoryMode = count($engravingCategories) > 0;
        // Any saved category row enables the engraving step (upload/text/simple), even if the master checkbox was left off.
        $hasEngraving = $hasEngravingFlag || $engravingCategoryMode;
        $customizeMaxStep = $engravingCategoryMode ? 6 : 5;

        return [
            'product_id' => $product->id,
            'cart_product_id' => self::getCartProductId(),
            'product_name' => $displayName,
            'product_slug' => $product->slug,
            'stl_model_url' => asset('assets/models/perch-tumbler-1200ml.stl'),
            'part_stl_urls' => $partStlUrls,
            'bottle_colors' => $bottleColors,
            'cap_colors' => $capColors,
            'strap_colors' => $strapColors,
            'boot_colors' => $bootColors,
            'handle_colors' => $handleColors,
            'sizes' => $sizes,
            'base_price' => $basePrice,
            'currency' => '₹',
            'has_engraving' => $hasEngraving,
            'engraving_price' => $engravingPrice,
            'engraving_max_chars' => $engravingMaxChars,
            'engraving_label' => $engravingLabel,
            'engraving_categories' => $engravingCategories,
            'engraving_category_mode' => $engravingCategoryMode,
            'customize_max_step' => $customizeMaxStep,
        ];
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return list<array{slug: string, name: string, price: float, type: string, icon: ?string}>
     */
    public static function normalizeEngravingCategoriesArray(array $rows): array
    {
        $out = [];
        $usedSlugs = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }
            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $slug = trim((string) ($row['slug'] ?? ''));
            if ($slug === '') {
                $slug = Str::slug($name);
            }
            $slug = strtolower(preg_replace('/[^a-z0-9\-]+/', '-', $slug) ?? '');
            $slug = trim($slug, '-');
            if ($slug === '') {
                $slug = 'option-'.(count($out) + 1);
            }
            while (isset($usedSlugs[$slug])) {
                $slug .= 'x';
            }
            $usedSlugs[$slug] = true;
            $price = round(max(0, (float) ($row['price'] ?? 0)), 2);
            $type = strtolower(trim((string) ($row['type'] ?? 'simple')));
            if (! in_array($type, ['text', 'simple', 'upload'], true)) {
                $type = 'simple';
            }
            $icon = isset($row['icon']) && is_string($row['icon']) && trim($row['icon']) !== ''
                ? trim($row['icon']) : null;
            if ($icon !== null && strlen($icon) > 2000) {
                $icon = null;
            }
            $out[] = [
                'slug' => $slug,
                'name' => $name,
                'price' => $price,
                'type' => $type,
                'icon' => $icon,
            ];
        }

        return $out;
    }

    /**
     * @return list<array{slug: string, name: string, price: float, type: string, icon: ?string}>
     */
    public static function normalizedEngravingCategoriesFromGlobal(): array
    {
        $g = self::getGlobalCustomizeConfig();

        return self::normalizeEngravingCategoriesArray($g['engraving_categories'] ?? []);
    }

    public static function engravingCategoryMode(): bool
    {
        return self::engravingEnabled() && count(self::normalizedEngravingCategoriesFromGlobal()) > 0;
    }

    /**
     * Apply engraving add-on to customizer unit price. Supports category grid or legacy single text + price.
     *
     * @param  array<string, mixed>  $customizationPayload
     * @return array{ok: bool, unit?: float, message?: string}
     */
    public static function applyCustomizerEngravingToUnit(float $baseUnit, array $customizationPayload): array
    {
        if (! self::engravingEnabled()) {
            if (self::customizationPayloadHasEngravingSelection($customizationPayload)) {
                return ['ok' => false, 'message' => 'Engraving is not available.'];
            }

            return ['ok' => true, 'unit' => $baseUnit];
        }

        $categories = self::normalizedEngravingCategoriesFromGlobal();
        if (count($categories) > 0) {
            return self::applyCategoryEngravingToUnit($baseUnit, $customizationPayload, $categories);
        }

        $text = isset($customizationPayload['engraving_text']) && is_string($customizationPayload['engraving_text'])
            ? trim($customizationPayload['engraving_text']) : '';
        if ($text === '') {
            return ['ok' => true, 'unit' => $baseUnit];
        }
        $maxChars = self::engravingMaxChars();
        if (mb_strlen($text) > $maxChars) {
            return ['ok' => false, 'message' => "Engraving text must be at most {$maxChars} characters."];
        }
        $addon = self::engravingPrice();

        return ['ok' => true, 'unit' => round($baseUnit + $addon, 2)];
    }

    /**
     * @param  array<string, mixed>  $customizationPayload
     */
    public static function customizationPayloadHasEngravingSelection(array $customizationPayload): bool
    {
        if (isset($customizationPayload['engraving_text']) && is_string($customizationPayload['engraving_text']) && trim($customizationPayload['engraving_text']) !== '') {
            return true;
        }
        $e = $customizationPayload['engraving'] ?? null;
        if (! is_array($e)) {
            return false;
        }

        if (trim((string) ($e['category_slug'] ?? '')) !== '') {
            return true; // legacy single
        }
        $top = isset($e['top']) && is_array($e['top']) ? $e['top'] : null;
        $bottom = isset($e['bottom']) && is_array($e['bottom']) ? $e['bottom'] : null;
        if ($top && trim((string) ($top['category_slug'] ?? '')) !== '') {
            return true;
        }
        if ($bottom && trim((string) ($bottom['category_slug'] ?? '')) !== '') {
            return true;
        }

        return false;
    }

    /**
     * @param  list<array{slug: string, name: string, price: float, type: string, icon: ?string}>  $categories
     * @param  array<string, mixed>  $customizationPayload
     * @return array{ok: bool, unit?: float, message?: string}
     */
    protected static function applyCategoryEngravingToUnit(float $baseUnit, array $customizationPayload, array $categories): array
    {
        $e = $customizationPayload['engraving'] ?? [];
        if (! is_array($e)) {
            $e = [];
        }
        $maxChars = self::engravingMaxChars();

        // Legacy: single selection stored directly on engraving.*
        $legacySlug = trim((string) ($e['category_slug'] ?? ''));
        if ($legacySlug !== '') {
            $e = ['top' => ['category_slug' => $legacySlug, 'text' => $e['text'] ?? null, 'image_data' => $e['image_data'] ?? null]];
        }

        $mode = strtolower(trim((string) ($e['mode'] ?? 'single')));
        if (! in_array($mode, ['single', 'double'], true)) {
            $mode = 'single';
        }

        $slots = [];
        if (isset($e['top']) && is_array($e['top'])) {
            $slots['top'] = $e['top'];
        }
        if ($mode === 'double' && isset($e['bottom']) && is_array($e['bottom'])) {
            $slots['bottom'] = $e['bottom'];
        }

        if ($slots === []) {
            if (isset($customizationPayload['engraving_text']) && trim((string) $customizationPayload['engraving_text']) !== '') {
                return ['ok' => false, 'message' => 'Please choose an engraving option on the Engraving step.'];
            }

            return ['ok' => true, 'unit' => $baseUnit];
        }

        $addonSum = 0.0;
        foreach ($slots as $slotKey => $slot) {
            $slug = trim((string) ($slot['category_slug'] ?? ''));
            if ($slug === '') {
                continue;
            }
            $cat = null;
            foreach ($categories as $c) {
                if ($c['slug'] === $slug) {
                    $cat = $c;
                    break;
                }
            }
            if ($cat === null) {
                return ['ok' => false, 'message' => 'Invalid engraving selection.'];
            }
            $addonSum += (float) $cat['price'];

            if ($cat['type'] === 'text') {
                $text = isset($slot['text']) && is_string($slot['text']) ? trim($slot['text']) : '';
                if ($text === '') {
                    return ['ok' => false, 'message' => 'Please enter engraving text for this option.'];
                }
                if (mb_strlen($text) > $maxChars) {
                    return ['ok' => false, 'message' => "Engraving text must be at most {$maxChars} characters."];
                }
            } elseif ($cat['type'] === 'upload') {
                $img = isset($slot['image_data']) && is_string($slot['image_data']) ? trim($slot['image_data']) : '';
                if ($img === '' || ! str_starts_with($img, 'data:image/')) {
                    return ['ok' => false, 'message' => 'Please upload an image for this engraving option.'];
                }
                if (strlen($img) > 1_500_000) {
                    return ['ok' => false, 'message' => 'Image is too large. Use a smaller file.'];
                }
            }
        }

        if ($addonSum <= 0.0) {
            return ['ok' => true, 'unit' => $baseUnit];
        }

        return ['ok' => true, 'unit' => round($baseUnit + round($addonSum, 2), 2)];
    }

    public static function engravingEnabled(): bool
    {
        $g = self::getGlobalCustomizeConfig();
        if (! empty($g['has_engraving'])) {
            return true;
        }

        return count(self::normalizeEngravingCategoriesArray($g['engraving_categories'] ?? [])) > 0;
    }

    public static function engravingPrice(): float
    {
        $g = self::getGlobalCustomizeConfig();

        return round(max(0, (float) ($g['engraving_price'] ?? 0)), 2);
    }

    public static function engravingMaxChars(): int
    {
        $g = self::getGlobalCustomizeConfig();

        return max(1, min(500, (int) ($g['engraving_max_chars'] ?? 40)));
    }

    protected static function colorsArrayToConfig(array $colors): array
    {
        $result = [];
        foreach ($colors as $c) {
            $name = is_array($c) ? ($c['name'] ?? $c['label'] ?? '') : (string) $c;
            $hex = is_array($c) && isset($c['hex']) ? $c['hex'] : (self::$colorHexMap[$name] ?? self::nameToHex($name));
            if ($name) {
                $result[] = ['name' => $name, 'hex' => $hex];
            }
        }
        return $result ?: self::$defaultBottleColors;
    }

    protected static function nameToHex(string $name): string
    {
        return self::$colorHexMap[$name] ?? '#' . substr(md5($name), 0, 6);
    }
}
