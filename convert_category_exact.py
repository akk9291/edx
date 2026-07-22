#!/usr/bin/env python3
"""
Convert category.html to category.blade.php matching exact structure
"""

import re

# Read the HTML file
with open('/Users/mousamjain/Downloads/perch/category.html', 'r', encoding='utf-8') as f:
    html_content = f.read()

# Find the main content section (after header, before footer)
# Look for the banner section that starts after menu_bar
start_marker = '<div class="list-banner sm:-mt-[75px]">'
end_marker = '<div id="footer" class="footer">'

start_idx = html_content.find(start_marker)
end_idx = html_content.find(end_marker)

if start_idx == -1 or end_idx == -1:
    print("Could not find content markers")
    exit(1)

# Extract main content
main_content = html_content[start_idx:end_idx].strip()

# Convert asset paths
main_content = re.sub(r'src="\./assets/', r'src="{{ asset(\'assets/', main_content)
main_content = re.sub(r'src="\./assets/', r'src="{{ asset(\'assets/', main_content)
main_content = re.sub(r'href="\./assets/', r'href="{{ asset(\'assets/', main_content)
main_content = re.sub(r'\.webp"', r'.webp\') }}"', main_content)
main_content = re.sub(r'\.png"', r'.png\') }}"', main_content)
main_content = re.sub(r'\.jpg"', r'.jpg\') }}"', main_content)
main_content = re.sub(r'\.jpeg"', r'.jpeg\') }}"', main_content)

# Fix asset() calls that might have been broken
main_content = re.sub(r'asset\(\'assets/([^\']+)\'\) }}"', r'asset(\'assets/\1\') }}"', main_content)

# Convert PHP links to Laravel routes
main_content = re.sub(r'href="([^"]+)\.php"', r'href="{{ route(\'shop\') }}"', main_content)
main_content = re.sub(r'href="/shop-breadcrumb1\.html"', r'href="{{ route(\'shop\') }}"', main_content)
main_content = re.sub(r'href="index\.php"', r'href="{{ route(\'home\') }}"', main_content)

# Add Blade template structure
blade_content = """@extends('layouts.app')

@section('title', ($category ? $category->name : 'Category') . ' - Perch Bottle')

@section('content')
""" + main_content + """
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching for product types
    const tabItems = document.querySelectorAll('.tab-item[data-item]');
    const indicator = document.querySelector('.indicator');
    
    if (tabItems.length > 0 && indicator) {
        tabItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                const type = this.getAttribute('data-item');
                
                // Update active tab
                tabItems.forEach(tab => tab.classList.remove('active'));
                this.classList.add('active');
                
                // Move indicator
                const itemWidth = 100 / tabItems.length;
                indicator.style.left = (index * itemWidth) + '%';
                indicator.style.width = itemWidth + '%';
                
                // Filter products (you can implement AJAX filtering here)
                if (typeof window.categorySlug !== 'undefined') {
                    window.location.href = '{{ route("category", $category->slug ?? "") }}?type=' + type;
                }
            });
        });
    }
    
    // Initialize Swiper for brands if exists
    if (typeof Swiper !== 'undefined') {
        const brandSwiper = document.querySelector('.swiper-brand');
        if (brandSwiper) {
            new Swiper('.swiper-brand', {
                slidesPerView: 'auto',
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                    1280: {
                        slidesPerView: 6,
                    },
                },
            });
        }
    }
});
</script>
@endsection
"""

# Write to file
with open('resources/views/category.blade.php', 'w', encoding='utf-8') as f:
    f.write(blade_content)

print("✓ Converted category.html to category.blade.php")
