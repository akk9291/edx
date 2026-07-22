#!/usr/bin/env python3
"""
Complete script to convert ALL HTML files from perch folder to Laravel Blade templates
"""
import re
import os
from pathlib import Path

def convert_html_to_blade(html_content, file_name):
    """Convert HTML content to Blade template"""
    
    # Convert asset paths
    html_content = re.sub(r'src="\./assets/', r'src="{{ asset(\'assets/', html_content)
    html_content = re.sub(r'href="\./assets/', r'href="{{ asset(\'assets/', html_content)
    html_content = re.sub(r'url\(\./assets/', r'url({{ asset(\'assets/', html_content)
    
    # Fix escaped quotes in asset paths
    html_content = re.sub(r'\.webp\'\)"', r'.webp\') }}"', html_content)
    html_content = re.sub(r'\.png\'\)"', r'.png\') }}"', html_content)
    html_content = re.sub(r'\.jpg\'\)"', r'.jpg\') }}"', html_content)
    html_content = re.sub(r'\.jpeg\'\)"', r'.jpeg\') }}"', html_content)
    html_content = re.sub(r'\.css\'\)"', r'.css\') }}"', html_content)
    html_content = re.sub(r'\.js\'\)"', r'.js\') }}"', html_content)
    html_content = re.sub(r'\.svg\'\)"', r'.svg\') }}"', html_content)
    html_content = re.sub(r'\.eot\'\)"', r'.eot\') }}"', html_content)
    html_content = re.sub(r'\.woff\'\)"', r'.woff\') }}"', html_content)
    html_content = re.sub(r'\.woff2\'\)"', r'.woff2\') }}"', html_content)
    html_content = re.sub(r'\.ttf\'\)"', r'.ttf\') }}"', html_content)
    
    # Route mapping for all pages
    route_mapping = {
        'index.html': 'route(\'home\')',
        'perch.html': 'route(\'home\')',
        'shop-default-list.html': 'route(\'shop\')',
        'shop-default-grid.html': 'route(\'shop\')',
        'shop-default.html': 'route(\'shop\')',
        'shop-breadcrumb1.html': 'route(\'shop\')',
        'shop-breadcrumb2.html': 'route(\'shop\')',
        'shop-breadcrumb-img.html': 'route(\'shop\')',
        'shop-collection.html': 'route(\'shop\')',
        'shop-filter-canvas.html': 'route(\'shop\')',
        'shop-filter-dropdown.html': 'route(\'shop\')',
        'shop-filter-options.html': 'route(\'shop\')',
        'shop-sidebar-list.html': 'route(\'shop\')',
        'shop-fullwidth.html': 'route(\'shop\')',
        'shop-square.html': 'route(\'shop\')',
        'product-discount.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-default.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-sale.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-countdown-timer.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-grouped.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-bought-together.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-out-of-stock.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-variable.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-external.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-on-sale.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-sidebar.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-fixed-price.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-thumbnail-left.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-thumbnail-bottom.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-one-scrolling.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-two-scrolling.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-combined-one.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-combined-two.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-style1.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-style2.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-style3.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-style4.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'product-style5.html': 'route(\'product.show\', $product->slug ?? \'#\')',
        'my-account.html': 'route(\'my-account\')',
        'cart.html': 'route(\'cart.index\')',
        'checkout.html': 'route(\'checkout.index\')',
        'checkout2.html': 'route(\'checkout.index\')',
        'login.html': 'route(\'login\')',
        'register.html': 'route(\'register\')',
        'forgot-password.html': 'route(\'forgot-password\')',
        'order-tracking.html': 'route(\'order-tracking\')',
        'wishlist.html': 'route(\'wishlist\')',
        'search-result.html': 'route(\'search\')',
        'about.html': 'route(\'about\')',
        'contact.html': 'route(\'contact\')',
        'faqs.html': 'route(\'faqs\')',
        'category.html': 'route(\'shop\')',
        'blog-default.html': 'route(\'blog\')',
        'blog-list.html': 'route(\'blog\')',
        'blog-grid.html': 'route(\'blog\')',
        'blog-detail1.html': 'route(\'blog.show\', $post->slug ?? \'#\')',
        'blog-detail2.html': 'route(\'blog.show\', $post->slug ?? \'#\')',
        'compare.html': 'route(\'compare\')',
        'store-list.html': 'route(\'stores\')',
        'page-not-found.html': 'route(\'404\')',
        'coming-soon.html': 'route(\'coming-soon\')',
        'customer-feedbacks.html': 'route(\'feedbacks\')',
    }
    
    # Convert links to routes
    for old_link, new_route in route_mapping.items():
        # Handle href attributes
        html_content = re.sub(rf'(href|action)="{re.escape(old_link)}"', rf'\1="{{ {new_route} }}"', html_content)
        # Handle .php versions
        old_link_php = old_link.replace('.html', '.php')
        html_content = re.sub(rf'(href|action)="{re.escape(old_link_php)}"', rf'\1="{{ {new_route} }}"', html_content)
    
    # Fix double conversions
    html_content = re.sub(r'\{\{ asset\(\'assets/([^\']+)\'\) \}\}"', r'{{ asset(\'assets/\1\') }}"', html_content)
    
    return html_content

def extract_main_content(html_content):
    """Extract main content between header and footer"""
    # Find the end of the main header
    header_end_match = re.search(r'(?s)<div id="header".*?</div>\s*<!-- Menu Mobile -->', html_content, re.IGNORECASE)
    if header_end_match:
        header_end_index = header_end_match.end()
    else:
        # Fallback: look for body start
        body_start_match = re.search(r'<body[^>]*>', html_content, re.IGNORECASE)
        header_end_index = body_start_match.end() if body_start_match else 0

    # Find the start of the footer
    footer_start_match = re.search(r'(?s)<div id="footer".*?</div>\s*<a class="scroll-to-top-btn"', html_content, re.IGNORECASE)
    if footer_start_match:
        footer_start_index = footer_start_match.start()
    else:
        # Fallback: look for body end
        body_end_match = re.search(r'</body>', html_content, re.IGNORECASE)
        footer_start_index = body_end_match.start() if body_end_match else len(html_content)

    # Extract content between identified points
    return html_content[header_end_index:footer_start_index].strip()

if __name__ == '__main__':
    perch_folder = Path('/Users/mousamjain/Downloads/perch')
    output_folder = Path('/Users/mousamjain/Documents/GitHub/supertops/resources/views')
    
    # Files to convert with their output paths
    files_to_convert = {
        # Main pages
        'perch.html': 'home.blade.php',
        'index.html': 'home.blade.php',  # Will overwrite perch.html if both exist
        'about.html': 'about.blade.php',
        'contact.html': 'contact.blade.php',
        'faqs.html': 'faqs.blade.php',
        
        # Shop pages
        'shop-default-list.html': 'shop.blade.php',
        'shop-default-grid.html': 'shop/grid.blade.php',
        'shop-default.html': 'shop/default.blade.php',
        'shop-breadcrumb1.html': 'shop/breadcrumb1.blade.php',
        'shop-breadcrumb2.html': 'shop/breadcrumb2.blade.php',
        'shop-breadcrumb-img.html': 'shop/breadcrumb-img.blade.php',
        'shop-collection.html': 'shop/collection.blade.php',
        'shop-filter-canvas.html': 'shop/filter-canvas.blade.php',
        'shop-filter-dropdown.html': 'shop/filter-dropdown.blade.php',
        'shop-filter-options.html': 'shop/filter-options.blade.php',
        'shop-sidebar-list.html': 'shop/sidebar-list.blade.php',
        'shop-fullwidth.html': 'shop/fullwidth.blade.php',
        'shop-square.html': 'shop/square.blade.php',
        'category.html': 'shop/category.blade.php',
        
        # Product pages
        'product-discount.html': 'product/show.blade.php',
        'product-default.html': 'product/default.blade.php',
        'product-sale.html': 'product/sale.blade.php',
        'product-countdown-timer.html': 'product/countdown-timer.blade.php',
        'product-grouped.html': 'product/grouped.blade.php',
        'product-bought-together.html': 'product/bought-together.blade.php',
        'product-out-of-stock.html': 'product/out-of-stock.blade.php',
        'product-variable.html': 'product/variable.blade.php',
        'product-external.html': 'product/external.blade.php',
        'product-on-sale.html': 'product/on-sale.blade.php',
        'product-sidebar.html': 'product/sidebar.blade.php',
        'product-fixed-price.html': 'product/fixed-price.blade.php',
        'product-thumbnail-left.html': 'product/thumbnail-left.blade.php',
        'product-thumbnail-bottom.html': 'product/thumbnail-bottom.blade.php',
        'product-one-scrolling.html': 'product/one-scrolling.blade.php',
        'product-two-scrolling.html': 'product/two-scrolling.blade.php',
        'product-combined-one.html': 'product/combined-one.blade.php',
        'product-combined-two.html': 'product/combined-two.blade.php',
        'product-style1.html': 'product/style1.blade.php',
        'product-style2.html': 'product/style2.blade.php',
        'product-style3.html': 'product/style3.blade.php',
        'product-style4.html': 'product/style4.blade.php',
        'product-style5.html': 'product/style5.blade.php',
        
        # Auth pages
        'login.html': 'auth/login.blade.php',
        'register.html': 'auth/register.blade.php',
        'forgot-password.html': 'auth/forgot-password.blade.php',
        
        # Account pages
        'my-account.html': 'my-account.blade.php',
        'cart.html': 'cart/index.blade.php',
        'checkout.html': 'checkout/index.blade.php',
        'checkout2.html': 'checkout/index2.blade.php',
        'wishlist.html': 'wishlist.blade.php',
        'order-tracking.html': 'order-tracking.blade.php',
        'search-result.html': 'search-result.blade.php',
        'compare.html': 'compare.blade.php',
        
        # Blog pages
        'blog-default.html': 'blog/index.blade.php',
        'blog-list.html': 'blog/list.blade.php',
        'blog-grid.html': 'blog/grid.blade.php',
        'blog-detail1.html': 'blog/show.blade.php',
        'blog-detail2.html': 'blog/show2.blade.php',
        
        # Other pages
        'store-list.html': 'stores/index.blade.php',
        'page-not-found.html': 'errors/404.blade.php',
        'coming-soon.html': 'coming-soon.blade.php',
        'customer-feedbacks.html': 'feedbacks.blade.php',
    }
    
    converted_count = 0
    failed_count = 0
    skipped_count = 0

    for html_file, blade_file in files_to_convert.items():
        html_path = perch_folder / html_file
        if html_path.exists():
            print(f'Converting {html_file} to {output_folder / blade_file}')
            try:
                with open(html_path, 'r', encoding='utf-8') as f:
                    html_content = f.read()
                
                # Extract main content
                main_content = extract_main_content(html_content)
                
                # Convert to Blade
                blade_content = convert_html_to_blade(main_content, html_file)
                
                # Create Blade template with extends
                title = html_file.replace(".html", "").replace("-", " ").title()
                blade_template = f"""@extends('layouts.app')

@section('title', '{title} - Perch Bottle')

@section('content')
{blade_content}
@endsection
"""
                
                # Write to output
                output_path = output_folder / blade_file
                output_path.parent.mkdir(parents=True, exist_ok=True)
                with open(output_path, 'w', encoding='utf-8') as f:
                    f.write(blade_template)
                
                print(f'✓ Created {output_path}')
                converted_count += 1
            except Exception as e:
                print(f'✗ Failed to convert {html_file}: {e}')
                failed_count += 1
        else:
            print(f'⚠ File not found: {html_file}')
            skipped_count += 1
    
    print(f'\n✓ Converted: {converted_count}')
    print(f'✗ Failed: {failed_count}')
    print(f'⚠ Skipped: {skipped_count}')
