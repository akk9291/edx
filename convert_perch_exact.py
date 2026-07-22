#!/usr/bin/env python3
import re

# Read the HTML file
with open('/Users/mousamjain/Downloads/perch/perch.html', 'r', encoding='utf-8') as f:
    html_content = f.read()

# Find the start of main content (after header closes)
start_marker = '<!-- Slider -->'
end_marker = '</body>'

start_idx = html_content.find(start_marker)
end_idx = html_content.find(end_marker)

if start_idx == -1 or end_idx == -1:
    print("Error: Could not find content markers")
    exit(1)

main_content = html_content[start_idx:end_idx].strip()

# Convert asset paths: ./assets/images/... to {{ asset('assets/images/...') }}
def convert_src_asset(match):
    path = match.group(1)
    # Remove leading ./
    if path.startswith('./'):
        path = path[2:]
    # Escape single quotes in path
    path_escaped = path.replace("'", "\\'")
    return f'src="{{{{ asset(\'{path_escaped}\') }}}}"'

def convert_href_asset(match):
    path = match.group(1)
    # Remove leading ./
    if path.startswith('./'):
        path = path[2:]
    # Escape single quotes in path
    path_escaped = path.replace("'", "\\'")
    return f'href="{{{{ asset(\'{path_escaped}\') }}}}"'

# Convert src="./assets/..." to src="{{ asset('assets/...') }}"
main_content = re.sub(r'src="(\./assets/[^"]+)"', convert_src_asset, main_content)
# Convert href="./assets/..." to href="{{ asset('assets/...') }}"
main_content = re.sub(r'href="(\./assets/[^"]+)"', convert_href_asset, main_content)

# Convert PHP links to Laravel routes (simple mapping)
route_mapping = {
    'index.php': 'home',
    'shop-breadcrumb1.php': 'shop',
    'shop-breadcrumb-img.php': 'shop',
    'shop-collection.php': 'shop.collection',
    'product-default.php': 'product.show',
}

def convert_php_link(match):
    php_file = match.group(1)
    if php_file in route_mapping:
        route_name = route_mapping[php_file]
        return f'href="{{{{ route(\'{route_name}\') }}}}"'
    # Default to shop route
    return f'href="{{{{ route(\'shop\') }}}}"'

# Convert href="something.php" to Laravel routes
main_content = re.sub(r'href="([^"]+\.php)"', convert_php_link, main_content)

# Write to Blade file
blade_content = """@extends('layouts.app')

@section('title', 'Index - Perch Bottle')

@section('content')
""" + main_content + """
@endsection
"""

with open('resources/views/home.blade.php', 'w', encoding='utf-8') as f:
    f.write(blade_content)

print("✓ Conversion complete!")
print(f"✓ Extracted {len(main_content)} characters")
print("✓ File written to resources/views/home.blade.php")
