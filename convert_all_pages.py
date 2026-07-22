#!/usr/bin/env python3
"""
Script to convert all HTML files from Downloads/perch to Blade templates
"""
import os
import re
from pathlib import Path

# Mapping of HTML files to Blade template paths
PAGE_MAPPING = {
    'perch.html': 'resources/views/home.blade.php',
    'shop-default-list.html': 'resources/views/shop.blade.php',
    'product-discount.html': 'resources/views/product/show.blade.php',
    'cart.html': 'resources/views/cart/index.blade.php',
    'checkout.html': 'resources/views/checkout/index.blade.php',
    'login.html': 'resources/views/auth/login.blade.php',
    'register.html': 'resources/views/auth/register.blade.php',
    'forgot-password.html': 'resources/views/auth/forgot-password.blade.php',
    'order-tracking.html': 'resources/views/order-tracking.blade.php',
    'wishlist.html': 'resources/views/wishlist.blade.php',
    'search-result.html': 'resources/views/search-result.blade.php',
    'about.html': 'resources/views/about.blade.php',
    'contact.html': 'resources/views/contact.blade.php',
    'faqs.html': 'resources/views/faqs.blade.php',
    'my-account.html': 'resources/views/my-account.blade.php',
}

HTML_DIR = Path('/Users/mousamjain/Downloads/perch')
OUTPUT_DIR = Path('/Users/mousamjain/Documents/GitHub/supertops')

def convert_asset_paths(content):
    """Convert asset paths to Laravel asset() helper"""
    # Convert ./assets/ to {{ asset('assets/...') }}
    content = re.sub(r'src="\./assets/([^"]+)"', r"src=\"{{ asset('assets/\1') }}\"", content)
    content = re.sub(r'href="\./assets/([^"]+)"', r"href=\"{{ asset('assets/\1') }}\"", content)
    content = re.sub(r'src="assets/([^"]+)"', r"src=\"{{ asset('assets/\1') }}\"", content)
    content = re.sub(r'href="assets/([^"]+)"', r"href=\"{{ asset('assets/\1') }}\"", content)
    
    # Fix escaped quotes
    content = content.replace('\\"', '"')
    
    return content

def convert_php_links(content):
    """Convert PHP links to Laravel routes"""
    route_mapping = {
        'index.php': "{{ route('home') }}",
        'shop-breadcrumb1.php': "{{ route('shop') }}",
        'shop-breadcrumb-img.php': "{{ route('shop') }}",
        'shop-breadcrumb2.php': "{{ route('shop') }}",
        'shop-collection.php': "{{ route('shop') }}",
        'shop-default.php': "{{ route('shop') }}",
        'shop-default-list.php': "{{ route('shop') }}",
        'shop-default-grid.php': "{{ route('shop') }}",
        'product-default.php': "{{ route('product.show', ['slug' => 'product-slug']) }}",
        'product-discount.php': "{{ route('product.show', ['slug' => 'product-slug']) }}",
        'cart.php': "{{ route('cart.index') }}",
        'checkout.php': "{{ route('checkout.index') }}",
        'login.php': "{{ route('login') }}",
        'register.php': "{{ route('register') }}",
        'forgot-password.php': "{{ route('password.request') }}",
        'order-tracking.php': "{{ route('order-tracking') }}",
        'wishlist.php': "{{ route('wishlist') }}",
        'search-result.php': "{{ route('search-result') }}",
        'about.php': "{{ route('about') }}",
        'contact.php': "{{ route('contact') }}",
        'faqs.php': "{{ route('faqs') }}",
        'my-account.php': "{{ route('my-account') }}",
    }
    
    for php_file, route in route_mapping.items():
        # Replace in href attributes
        content = re.sub(rf'href="{re.escape(php_file)}"', f'href="{route}"', content)
        # Replace in action attributes
        content = re.sub(rf'action="{re.escape(php_file)}"', f'action="{route}"', content)
    
    return content

def extract_body_content(html_content):
    """Extract content between header and footer"""
    # Find the start of main content - look for Slider comment or slider-block
    header_end = html_content.find('<!-- Slider -->')
    if header_end == -1:
        header_end = html_content.find('<div class="slider-block')
    if header_end == -1:
        header_end = html_content.find('<div class="breadcrumb-block')
    if header_end == -1:
        # Try to find after header closes
        header_close = html_content.find('</div>', html_content.find('id="header"'))
        if header_close != -1:
            # Find next opening div or comment
            header_end = html_content.find('<!--', header_close)
            if header_end == -1:
                header_end = html_content.find('<div', header_close)
    
    # Find the start of footer
    footer_start = html_content.find('<div id="footer"')
    if footer_start == -1:
        footer_start = html_content.find('id="footer"')
    if footer_start == -1:
        footer_start = html_content.find('<footer')
    
    if header_end != -1 and footer_start != -1 and header_end < footer_start:
        content = html_content[header_end:footer_start].strip()
        # Remove any closing divs at the start
        content = re.sub(r'^</div>\s*', '', content)
        return content
    elif header_end != -1:
        # If no footer found, take everything after header
        content = html_content[header_end:].strip()
        # Remove any closing divs at the start
        content = re.sub(r'^</div>\s*', '', content)
        return content
    else:
        # Fallback: try to find body content
        body_start = html_content.find('<body>')
        body_end = html_content.find('</body>')
        if body_start != -1 and body_end != -1:
            return html_content[body_start+6:body_end].strip()
    
    return html_content

def convert_to_blade(html_file_path, output_path):
    """Convert HTML file to Blade template"""
    print(f"Converting {html_file_path.name} to {output_path}")
    
    try:
        with open(html_file_path, 'r', encoding='utf-8') as f:
            html_content = f.read()
        
        # Extract main content
        body_content = extract_body_content(html_content)
        
        # Convert asset paths
        body_content = convert_asset_paths(body_content)
        
        # Convert PHP links
        body_content = convert_php_links(body_content)
        
        # Create Blade template
        blade_content = f"""@extends('layouts.app')

@section('title', '{html_file_path.stem.replace("-", " ").title()}')

@section('content')
{body_content}
@endsection
"""
        
        # Ensure output directory exists
        output_path.parent.mkdir(parents=True, exist_ok=True)
        
        # Write Blade file
        with open(output_path, 'w', encoding='utf-8') as f:
            f.write(blade_content)
        
        print(f"✓ Created {output_path}")
        return True
        
    except Exception as e:
        print(f"✗ Error converting {html_file_path.name}: {e}")
        return False

def main():
    """Main conversion function"""
    converted = 0
    failed = 0
    
    for html_file, blade_path in PAGE_MAPPING.items():
        html_path = HTML_DIR / html_file
        output_path = OUTPUT_DIR / blade_path
        
        if html_path.exists():
            if convert_to_blade(html_path, output_path):
                converted += 1
            else:
                failed += 1
        else:
            print(f"⚠ File not found: {html_path}")
            failed += 1
    
    print(f"\n✓ Converted: {converted}")
    print(f"✗ Failed: {failed}")

if __name__ == '__main__':
    main()
