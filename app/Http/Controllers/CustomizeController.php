<?php

namespace App\Http\Controllers;

use App\Services\CustomizeConfigService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomizeController extends Controller
{
    /**
     * Serve the large Three.js customizer bundle from the app origin.
     * Avoids 404s when ASSET_URL/CDN omits public/assets/js or deploy skips big files.
     */
    public function appJs(): BinaryFileResponse
    {
        $path = public_path('assets/js/customize-app.js');
        abort_unless(is_readable($path), 404, 'Customizer script missing. Ensure public/assets/js/customize-app.js is deployed.');

        return response()->file($path, [
            'Content-Type' => 'application/javascript; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400, immutable',
        ]);
    }

    /**
     * Serve part STLs from the app origin so static/CDN deploy gaps do not 404
     * (same idea as {@see appJs}).
     */
    public function partStl(string $part): BinaryFileResponse
    {
        $map = [
            'body' => 'assets/models/tumbler-1200ml-parts/body.stl',
            'logo' => 'assets/models/tumbler-1200ml-parts/logo.stl',
            'cap' => 'assets/models/tumbler-1200ml-parts/cover.stl',
            'ring' => 'assets/models/tumbler-1200ml-parts/ring.stl',
            'straw' => 'assets/models/tumbler-1200ml-parts/straw.stl',
            'handle' => 'assets/models/tumbler-1200ml-parts/handle.stl',
            'boot' => 'assets/models/tumbler-1200ml-parts/base.stl',
        ];
        abort_unless(isset($map[$part]), 404);

        $path = public_path($map[$part]);
        abort_unless(is_readable($path), 404, 'STL missing on server. Deploy public/'.$map[$part]);

        return response()->file($path, [
            'Content-Type' => 'model/stl',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Single public customizer at /customize (settings-driven, no catalog product).
     * Old /customize/{slug} URLs redirect here.
     */
    public function show(?string $slug = null)
    {
        if ($slug !== null && $slug !== '') {
            return redirect()->route('customize', [], 301);
        }

        $config = CustomizeConfigService::getStandaloneConfig();

        return view('customize', [
            'product' => null,
            'config' => $config,
        ]);
    }
}
