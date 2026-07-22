#!/usr/bin/env python3
"""
Script to convert HTML files from perch folder to Laravel Blade templates
"""
import re
import os
from pathlib import Path

def convert_html_to_blade(html_content, file_name):
    """Convert HTML content to Blade template"""
    
    # Convert asset paths
    html_content = re.sub(r'src="\./assets/', r'src="{{ asset(\'assets/', html_content)
    html_content = re.sub(r'href="\./assets/', r'href="{{ asset(\'assets/', html_content)
    html_content = re.sub(r'\.webp"', r'.webp\') }}"', html_content)
    html_content = re.sub(r'\.png"', r'.png\') }}"', html_content)
    html_content = re.sub(r'\.jpg"', r'.jpg\') }}"', html_content)
    html_content = re.sub(r'\.jpeg"', r'.jpeg\') }}"', html_content)
    html_content = re.sub(r'\.css"', r'.css\') }}"', html_content)
    html_content = re.sub(r'\.js"', r'.js\') }}"', html_content)
    
    # Convert links to routes
    route_mapping = {
        'index.php': 'route(\'home\')',
        'index.html': 'route(\'home\')',
        'shop-default-list.php': 'route(\'shop\')',
        'shop-default-list.html': 'route(\'shop\')',
        'product-discount.php': 'route(\'product.show\', $product->slug)',
        'product-discount.html': 'route(\'product.show\', $product->slug)',
        'my-account.php': 'route(\'account\')',
        'my-account.html': 'route(\'account\')',
        'cart.php': 'route(\'cart.index\')',
        'cart.html': 'route(\'cart.index\')',
        'checkout.php': 'route(\'checkout.index\')',
        'checkout.html': 'route(\'checkout.index\')',
        'login.php': 'route(\'login\')',
        'login.html': 'route(\'login\')',
        'register.php': 'route(\'register\')',
        'register.html': 'route(\'register\')',
        'forgot-password.php': 'route(\'forgot-password\')',
        'forgot-password.html': 'route(\'forgot-password\')',
        'order-tracking.php': 'route(\'order.track\')',
        'order-tracking.html': 'route(\'order.track\')',
        'wishlist.php': 'route(\'wishlist\')',
        'wishlist.html': 'route(\'wishlist\')',
        'search-result.php': 'route(\'search\')',
        'search-result.html': 'route(\'search\')',
        'about.php': 'route(\'about\')',
        'about.html': 'route(\'about\')',
        'contact.php': 'route(\'contact\')',
        'contact.html': 'route(\'contact\')',
        'faqs.php': 'route(\'faqs\')',
        'faqs.html': 'route(\'faqs\')',
    }
    
    for old_link, new_route in route_mapping.items():
        html_content = re.sub(rf'href="{re.escape(old_link)}"', rf'href="{{ {new_route} }}"', html_content)
        html_content = re.sub(rf'href="{re.escape(old_link)}', rf'href="{{ {new_route}', html_content)
    
    # Fix double conversions
    html_content = re.sub(r'\{\{ asset\(\'assets/([^\']+)\'\) \}\}"', r'{{ asset(\'assets/\1\') }}"', html_content)
    
    return html_content

def extract_main_content(html_content):
    """Extract main content between header and footer"""
    # Find header end
    header_patterns = [
        r'</header>',
        r'<!-- Slider -->',
        r'<div class="slider-block',
        r'<div class="breadcrumb-block',
    ]
    
    # Find footer start
    footer_patterns = [
        r'<div id="footer"',
        r'<footer',
    ]
    
    header_end = -1
    for pattern in header_patterns:
        match = re.search(pattern, html_content, re.IGNORECASE)
        if match:
            header_end = match.start()
            break
    
    footer_start = -1
    for pattern in footer_patterns:
        match = re.search(pattern, html_content, re.IGNORECASE)
        if match:
            footer_start = match.start()
            break
    
    if header_end > 0 and footer_start > 0:
        return html_content[header_end:footer_start]
    elif footer_start > 0:
        return html_content[:footer_start]
    else:
        return html_content

if __name__ == '__main__':
    perch_folder = Path('/Users/mousamjain/Downloads/perch')
    output_folder = Path('/Users/mousamjain/Documents/GitHub/supertops/resources/views')
    
    # Files to convert
    files_to_convert = {
        'perch.html': 'home.blade.php',
        'shop-default-list.html': 'shop.blade.php',
        'product-discount.html': 'product/show.blade.php',
        'my-account.html': 'account/index.blade.php',
        'cart.html': 'cart.blade.php',
        'checkout.html': 'checkout.blade.php',
        'login.html': 'auth/login.blade.php',
        'register.html': 'auth/register.blade.php',
        'forgot-password.html': 'auth/forgot-password.blade.php',
        'order-tracking.html': 'order-tracking.blade.php',
        'wishlist.html': 'wishlist.blade.php',
        'search-result.html': 'search-result.blade.php',
        'category.html': 'category.blade.php',
        'faqs.html': 'faqs.blade.php',
        'about.html': 'about.blade.php',
        'contact.html': 'contact.blade.php',
    }
    
    for html_file, blade_file in files_to_convert.items():
        html_path = perch_folder / html_file
        if html_path.exists():
            print(f'Converting {html_file}...')
            with open(html_path, 'r', encoding='utf-8') as f:
                html_content = f.read()
            
            # Extract main content
            main_content = extract_main_content(html_content)
            
            # Convert to Blade
            blade_content = convert_html_to_blade(main_content, html_file)
            
            # Create Blade template with extends
            blade_template = f"""@extends('layouts.app')

@section('title', '{html_file.replace(".html", "").replace("-", " ").title()} - Perch Bottle')

@section('content')
{blade_content}
@endsection
"""
            
            # Write to output
            output_path = output_folder / blade_file
            output_path.parent.mkdir(parents=True, exist_ok=True)
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(blade_template)
            
            print(f'  -> {blade_file}')
        else:
            print(f'File not found: {html_file}')
