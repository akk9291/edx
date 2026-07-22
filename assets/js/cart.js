// Cart functionality for dynamic products
(function() {
    'use strict';

    function readQtyControl(el) {
        if (!el) return 1;
        var raw = el.tagName === 'INPUT' ? el.value : el.textContent;
        var n = parseInt(String(raw).trim(), 10);
        if (isNaN(n) || n < 1) return 1;
        return Math.min(n, 9999);
    }
    function writeQtyControl(el, n) {
        if (!el) return;
        n = Math.max(1, Math.min(parseInt(n, 10) || 1, 9999));
        if (el.tagName === 'INPUT') el.value = String(n);
        else el.textContent = String(n);
    }

    // Add to cart functionality
    let isAddingToCart = false; // Prevent double clicks
    
    function initAddToCart() {
        // Use capture phase so we run before main.js Quick View modal's stopPropagation (which blocks bubble)
        document.addEventListener('click', function(e) {
            const addCartBtn = e.target.closest('.add-cart-btn');
            if (!addCartBtn) return;

            if (addCartBtn.closest('.customize-page')) {
                return;
            }

            // Skip only on product detail page (full page), not inside Quick View modal
            if (addCartBtn.closest('.product-infor') && !addCartBtn.closest('.modal-quickview-block')) {
                return; // Let product detail page handler take care of it
            }

            // Prevent double clicks
            if (isAddingToCart || addCartBtn.disabled) {
                e.preventDefault();
                e.stopPropagation();
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            let productId = addCartBtn.getAttribute('data-product-id');
            if (!productId || String(productId).trim() === '') {
                const productItem = addCartBtn.closest('.product-item');
                productId = productItem ? productItem.getAttribute('data-item') : null;
            }
            if (!productId || String(productId).trim() === '') {
                showNotification('Could not add this product. Please try again or open the product page.', 'error');
                return;
            }
            productId = String(productId).trim();

            // Set flag to prevent double clicks
            isAddingToCart = true;

            // Get size and color if available
            const sizeItem = addCartBtn.closest('.product-item')?.querySelector('.size-item.active');
            const colorItem = addCartBtn.closest('.product-item')?.querySelector('.color-item.active');
            
            const size = sizeItem?.getAttribute('data-size') || null;
            const color = colorItem?.getAttribute('data-color') || null;

            // Quantity: from Quick View modal if this button is inside it, else 1
            var quantity = 1;
            var qvModal = addCartBtn.closest('.modal-quickview-main');
            if (qvModal) {
                var qtyEl = qvModal.querySelector('.choose-quantity .quantity');
                if (qtyEl) quantity = readQtyControl(qtyEl);
            }

            // Show loading state
            const originalText = addCartBtn.innerHTML;
            const originalDisabled = addCartBtn.disabled;
            addCartBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Adding...';
            addCartBtn.disabled = true;
            addCartBtn.style.pointerEvents = 'none';

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            // Make API call
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    product_id: parseInt(productId, 10),
                    quantity: quantity,
                    size: size,
                    color: color
                })
            })
            .then(function(response) {
                var contentType = response.headers.get('content-type');
                if (contentType && contentType.indexOf('application/json') !== -1) {
                    return response.json().then(function(data) {
                        return { ok: response.ok, status: response.status, data: data };
                    });
                }
                var msg = response.status === 419 ? 'Page session expired. Please refresh and try again.' : 'Please refresh the page and try again.';
                return Promise.resolve({ ok: false, status: response.status, data: { success: false, message: msg } });
            })
            .then(function(result) {
                var data = result.data;
                if (result.status === 401 || result.status === 403 || (data && (data.message === 'Unauthorized' || data.message === 'Unauthenticated.'))) {
                    showNotification('Session expired or cart changed. Please refresh the page and try again.', 'error');
                    if (typeof updateCartCount === 'function') updateCartCount();
                    if (typeof loadCartItems === 'function') loadCartItems();
                    return;
                }
                if (data && data.success) {
                    if (typeof updateCartCount === 'function') updateCartCount();
                    showNotification('Product added to cart!', 'success');
                    const allCart = document.querySelectorAll('.modal-cart-block .modal-cart-main');
                    const cartModalMain = allCart.length ? allCart[allCart.length - 1] : null;
                    if (cartModalMain) {
                        cartModalMain.classList.add('open');
                        if (typeof loadCartItems === 'function') loadCartItems();
                    }
                } else {
                    showNotification(data && data.message ? data.message : 'Failed to add product to cart', 'error');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                // Always reset button state
                addCartBtn.innerHTML = originalText;
                addCartBtn.disabled = originalDisabled;
                addCartBtn.style.pointerEvents = '';
                isAddingToCart = false;
            });
        }, true); // capture phase: run before modal's stopPropagation so Quick View Add to Cart works
    }

    // Quick View modal: size and color selection (toggle .active)
    function initQuickViewSizeColor() {
        document.addEventListener('click', function(e) {
            var target = e.target.closest('.modal-quickview-main .size-item, .modal-quickview-main .color-item');
            if (!target) return;
            e.preventDefault();
            e.stopPropagation();
            var parent = target.parentElement;
            if (!parent) return;
            parent.querySelectorAll('.size-item.active, .color-item.active').forEach(function(el) { el.classList.remove('active'); });
            target.classList.add('active');
        });
    }

    // Quick view functionality - open modal with product (capture:true to run first)
    function initQuickView() {
        document.addEventListener('click', function(e) {
            const quickViewBtn = e.target.closest('.quick-view-btn');
            if (!quickViewBtn) return;

            e.preventDefault();
            e.stopPropagation();

            let productId = quickViewBtn.getAttribute('data-product-id');
            let productSlug = quickViewBtn.getAttribute('data-product-slug');
            if (!productSlug && !productId) {
                const productItem = quickViewBtn.closest('.product-item, [data-item]');
                if (productItem) {
                    productId = productId || productItem.getAttribute('data-item');
                    const slugEl = productItem.querySelector('[data-product-slug]');
                    productSlug = productSlug || (slugEl ? slugEl.getAttribute('data-product-slug') : null);
                }
            }

            if (productSlug) {
                loadQuickViewProductBySlug(productSlug);
            } else if (productId) {
                loadQuickViewProductById(productId);
            } else {
                console.warn('[QUICK VIEW] No product slug or id found');
            }
        }, true);

        // Close quick view on overlay/close click (use capture so it runs before modal's stopPropagation)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.modal-quickview-block .close-btn') || (e.target.closest('.modal-quickview-block') && !e.target.closest('.modal-quickview-main'))) {
                const all = document.querySelectorAll('.modal-quickview-block .modal-quickview-main');
                const main = all.length ? all[all.length - 1] : null;
                if (main) {
                    main.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        }, true);
        document.querySelectorAll('.modal-quickview-main').forEach(function(m) {
            m.addEventListener('click', function(e) { e.stopPropagation(); });
        });
    }

    function getQuickViewModal() {
        const all = document.querySelectorAll('.modal-quickview-block .modal-quickview-main');
        return all.length ? all[all.length - 1] : null;
    }

    function loadQuickViewProductBySlug(slug) {
        fetch(`/api/products/${encodeURIComponent(slug)}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(response => response.ok ? response.json() : null)
            .then(data => {
                if (data && data.success && data.data) {
                    showQuickViewModal(data.data);
                } else {
                    window.location.href = `/product/${slug}`;
                }
            })
            .catch(() => { window.location.href = `/product/${slug}`; });
    }

    function loadQuickViewProductById(productId) {
        const productItem = document.querySelector(`[data-item="${productId}"]`);
        const slug = productItem?.querySelector('.quick-view-btn')?.getAttribute('data-product-slug');
        if (slug) {
            loadQuickViewProductBySlug(slug);
        } else {
            fetch(`/api/products?per_page=100`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data?.data) {
                        const p = data.data.data.find(x => x.id == productId);
                        if (p?.slug) loadQuickViewProductBySlug(p.slug);
                    }
                })
                .catch(() => {});
        }
    }

    function getStorageBase() {
        return (typeof window !== 'undefined' && window.STORAGE_PATH) ? '/' + window.STORAGE_PATH : '/storage';
    }
    function getImageUrl(path) {
        if (!path) return '/assets/images/product/perch-bottal.webp';
        if (path.startsWith('http')) return path;
        if (path.startsWith('assets/') || path.startsWith('/assets/')) return path.startsWith('/') ? path : '/' + path;
        var base = getStorageBase();
        if (path.startsWith('storage/') || path.startsWith('/storage/')) return base + '/' + path.replace(/^\/?storage\/?/, '');
        return base + '/' + path.replace(/^\/+/, '');
    }

    function showQuickViewModal(product) {
        const main = getQuickViewModal();
        if (!main) return;

        // Reset quantity to 1 when switching to another product
        const qtyEl = main.querySelector('.choose-quantity .quantity');
        if (qtyEl) {
            if (qtyEl.tagName === 'INPUT') qtyEl.value = '1';
            else qtyEl.textContent = '1';
        }

        const allImages = [];
        if (product.image) allImages.push(product.image);
        if (product.images && Array.isArray(product.images)) product.images.forEach(function(p) { if (p && allImages.indexOf(p) === -1) allImages.push(p); });
        const imgUrl = allImages.length ? getImageUrl(allImages[0]) : getImageUrl(null);
        const mainImgWrap = main.querySelector('.qv-main-img');
        const mainImg = mainImgWrap ? mainImgWrap.querySelector('img') : null;
        if (mainImg) {
            mainImg.src = imgUrl;
            mainImg.alt = (product.name || '').replace(/"/g, '');
        }
        const thumbsWrap = main.querySelector('.qv-thumbs');
        if (thumbsWrap) {
            if (allImages.length > 1) {
                thumbsWrap.style.display = 'flex';
                thumbsWrap.innerHTML = allImages.slice(0, 5).map(function(p, i) {
                    var u = getImageUrl(p);
                    return '<button type="button" class="qv-thumb w-14 h-14 rounded-lg overflow-hidden border-2 border-line hover:border-black flex-shrink-0" data-index="' + i + '"><img src="' + u + '" alt="" class="w-full h-full object-cover" /></button>';
                }).join('');
                thumbsWrap.querySelectorAll('.qv-thumb').forEach(function(btn, i) {
                    btn.addEventListener('click', function() {
                        var u = getImageUrl(allImages[i]);
                        if (mainImg) mainImg.src = u;
                        thumbsWrap.querySelectorAll('.qv-thumb').forEach(function(b) { b.classList.remove('border-black'); b.classList.add('border-line'); });
                        btn.classList.add('border-black');
                        btn.classList.remove('border-line');
                    });
                    if (i === 0) { btn.classList.add('border-black'); btn.classList.remove('border-line'); }
                });
            } else {
                thumbsWrap.style.display = 'none';
                thumbsWrap.innerHTML = '';
            }
        }

        const category = main.querySelector('.product-infor .category');
        if (category) category.textContent = product.category?.name || '';

        const name = main.querySelector('.product-infor .name');
        if (name) name.textContent = product.name || '';

        const price = main.querySelector('.product-infor .product-price');
        const salePrice = parseFloat(product.sale_price || product.price || 0);
        const origPrice = parseFloat(product.price || 0);
        if (price) price.textContent = '₹' + salePrice.toFixed(2);
        const origEl = main.querySelector('.product-infor .product-origin-price');
        if (origEl) {
            origEl.style.display = origPrice > salePrice ? 'block' : 'none';
            const del = origEl.querySelector('del');
            if (del) del.textContent = '₹' + origPrice.toFixed(2);
        }
        const saleEl = main.querySelector('.product-infor .product-sale');
        if (saleEl && origPrice > salePrice) {
            const pct = Math.round(((origPrice - salePrice) / origPrice) * 100);
            saleEl.textContent = '-' + pct + '%';
            saleEl.style.display = 'inline-block';
        } else if (saleEl) saleEl.style.display = 'none';

        // Stock status
        const stockEl = main.querySelector('.qv-stock');
        if (stockEl) {
            const qty = product.stock_quantity != null ? parseInt(product.stock_quantity, 10) : null;
            if (qty !== null) {
                stockEl.style.display = 'block';
                if (qty <= 0) stockEl.textContent = 'Out of stock';
                else if (qty < 10) stockEl.textContent = 'Only ' + qty + ' left in stock';
                else stockEl.textContent = 'In stock';
            } else stockEl.style.display = 'none';
        }

        // Description
        const descBlock = main.querySelector('.qv-description-block');
        const descEl = main.querySelector('.qv-description');
        if (descBlock && descEl) {
            const raw = product.short_description || product.description || '';
            let text = '';
            if (raw) {
                if (typeof raw === 'string' && raw.trim()) {
                    const div = document.createElement('div');
                    div.innerHTML = raw;
                    text = (div.textContent || div.innerText || '').trim();
                    if (text.length > 280) text = text.substring(0, 277) + '...';
                }
            }
            if (text) {
                descBlock.style.display = 'block';
                descEl.textContent = text;
            } else {
                descBlock.style.display = 'none';
                descEl.textContent = '';
            }
        }

        // Specifications
        const specsBlock = main.querySelector('.qv-specs-block');
        const specsEl = main.querySelector('.qv-specs');
        if (specsBlock && specsEl) {
            const spec = product.specifications;
            let html = '';
            if (spec && typeof spec === 'object') {
                const entries = Array.isArray(spec) ? spec : Object.entries(spec);
                if (Array.isArray(entries)) {
                    entries.forEach(function(item) {
                        const label = item.key || item.name || item[0];
                        const value = item.value || item[1];
                        if (label != null && value != null) html += '<div class="flex justify-between gap-2 py-0.5"><span class="text-secondary2">' + String(label).replace(/</g, '&lt;') + '</span><span>' + String(value).replace(/</g, '&lt;') + '</span></div>';
                    });
                }
            }
            if (html) {
                specsBlock.style.display = 'block';
                specsEl.innerHTML = html;
            } else {
                specsBlock.style.display = 'none';
                specsEl.innerHTML = '';
            }
        }

        // Size options – show on Quick View card
        var sizeBlock = main.querySelector('.qv-size-block');
        var listSize = main.querySelector('.list-size');
        if (sizeBlock && listSize) {
            var sizes = product.sizes && (Array.isArray(product.sizes) ? product.sizes : []);
            if (sizes.length > 0) {
                sizeBlock.style.display = 'block';
                listSize.style.display = 'flex';
                listSize.innerHTML = sizes.map(function(s, idx) {
                    var active = idx === 0 ? ' active' : '';
                    return '<div class="size-item w-9 h-9 rounded-full flex flex-shrink-0 items-center justify-center text-button bg-white border border-line hover:border-black cursor-pointer duration-300' + active + '" data-size="' + String(s).replace(/"/g, '&quot;') + '">' + String(s) + '</div>';
                }).join('');
            } else {
                sizeBlock.style.display = 'none';
                listSize.innerHTML = '';
            }
        }
        // Color options – show on Quick View card
        var colorBlock = main.querySelector('.qv-color-block');
        var listColor = main.querySelector('.list-color');
        if (colorBlock && listColor) {
            var colors = product.colors && (Array.isArray(product.colors) ? product.colors : []);
            var images = product.images && (Array.isArray(product.images) ? product.images : []);
            if (colors.length > 0) {
                colorBlock.style.display = 'block';
                listColor.style.display = 'flex';
                listColor.innerHTML = colors.map(function(c, i) {
                    var img = images[i];
                    var style = !img ? ' style="background-color:' + String(c) + '"' : '';
                    var active = i === 0 ? ' active' : '';
                    var cls = 'color-item duration-300 relative cursor-pointer border border-line hover:border-black' + (img ? ' w-12 h-12 rounded-xl' : ' w-8 h-8 rounded-full') + active;
                    var inner = img ? '<img src="' + getImageUrl(img) + '" alt="" class="rounded-xl w-full h-full object-cover" />' : '';
                    return '<div class="' + cls + '"' + style + ' data-color="' + String(c).replace(/"/g, '&quot;') + '">' + inner + '</div>';
                }).join('');
            } else {
                colorBlock.style.display = 'none';
                listColor.innerHTML = '';
            }
        }

        const addCart = main.querySelector('.add-cart-btn');
        if (addCart) {
            addCart.setAttribute('data-product-id', product.id);
        }
        const addWishlistBtn = main.querySelector('.add-wishlist-btn');
        if (addWishlistBtn) {
            addWishlistBtn.setAttribute('data-product-id', product.id || '');
        }
        const viewLink = main.querySelector('.view-product-link');
        if (viewLink && product.slug) viewLink.href = '/product/' + product.slug;

        main.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    // Update cart count
    function updateCartCount() {
        fetch('/api/cart/count', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const count = data.data?.count || data.count || 0;
                    const cartCountElements = document.querySelectorAll('.cart-count, .cart-count-number, .cart-quantity, [data-cart-count]');
                    cartCountElements.forEach(el => {
                        el.textContent = count;
                        if (el.style) {
                            if (count > 0) {
                                el.style.display = (el.classList && el.classList.contains('mobile-app-nav__badge')) ? 'flex' : 'block';
                            } else {
                                el.style.display = 'none';
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }

    // Load cart items
    function loadCartItems() {
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Use layout's modal (last in DOM when home has duplicates)
                    const allBlocks = document.querySelectorAll('.modal-cart-block');
                    const cartBlock = allBlocks.length ? allBlocks[allBlocks.length - 1] : null;
                    const cartList = cartBlock ? cartBlock.querySelector('.list-cart, .list-product.cart-items, .cart-items') : document.querySelector('.list-cart, .list-product.cart-items, .cart-items');
                    if (cartList) {
                        cartList.innerHTML = '';
                        // API returns data.data.items or data.data directly
                        const items = (data.data?.items || data.data || []).filter(item => item && item.product);
                        if (items && items.length > 0) {
                            let total = 0;
                            items.forEach(item => {
                                if (!item.product) return;
                                const cartItem = createCartItemElement(item);
                                cartList.appendChild(cartItem);
                                const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
                                total += price * item.quantity;
                            });
                            
                            // Update total - use API total if available, otherwise calculate
                            const totalFromAPI = data.data?.total || total;
                            const totalElement = cartBlock ? cartBlock.querySelector('.total-price') : document.querySelector('.total-price');
                            if (totalElement) {
                                totalElement.textContent = totalFromAPI.toFixed(2);
                            }
                        } else {
                            cartList.innerHTML = '<div class="text-center py-10 text-secondary">Your cart is empty</div>';
                            const totalElement = cartBlock ? cartBlock.querySelector('.total-price') : document.querySelector('.total-price');
                            if (totalElement) {
                                totalElement.textContent = '0.00';
                            }
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading cart:', error));
        loadYouMayAlsoLike();
    }

    // "You May Also Like" in cart modal – load recommended products
    function loadYouMayAlsoLike() {
        var cartBlock = document.querySelectorAll('.modal-cart-block').length
            ? document.querySelectorAll('.modal-cart-block')[document.querySelectorAll('.modal-cart-block').length - 1]
            : document.querySelector('.modal-cart-block');
        if (!cartBlock) return;
        var leftCol = cartBlock.querySelector('.left');
        var listEl = cartBlock.querySelector('.left .list');
        if (!leftCol || !listEl) return;

        fetch('/api/products?per_page=4&sort_by=created_at&sort_order=desc', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                var products = res.success && res.data && res.data.data ? res.data.data : [];
                if (!products.length) {
                    leftCol.style.display = 'none';
                    return;
                }
                leftCol.style.display = '';
                listEl.innerHTML = products.map(function(p) {
                    var img = p.image || (p.images && p.images[0]);
                    var url = getImageUrl(img);
                    var price = parseFloat(p.sale_price || p.price || 0);
                    var slug = p.slug || ('product-' + p.id);
                    return '<a href="/product/' + slug + '" class="product-item grid-type block mb-4 rounded-xl overflow-hidden border border-line hover:border-black duration-300">' +
                        '<div class="aspect-square bg-surface"><img src="' + url + '" alt="" class="w-full h-full object-cover" /></div>' +
                        '<div class="p-3"><div class="name text-button truncate">' + (p.name || '') + '</div>' +
                        '<div class="product-price text-title mt-1">₹' + price.toFixed(2) + '</div></div></a>';
                }).join('');
            })
            .catch(function() {
                leftCol.style.display = 'none';
            });
    }

    // Create cart item element
    function createCartItemElement(item) {
        const div = document.createElement('div');
        div.className = 'product-item item pb-5 flex items-center justify-between gap-3 border-b border-line';
        
        // Get image URL - match Laravel asset() helper logic
        function getImageUrl(path) {
            if (!path) return '/assets/images/product/perch-bottal.webp';
            
            // Full URL
            if (path.startsWith('http://') || path.startsWith('https://')) {
                return path;
            }
            
            // Asset path (assets/ or /assets/)
            if (path.startsWith('assets/') || path.startsWith('/assets/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            
            // Storage path - use configurable STORAGE_PATH (e.g. media)
            var base = (typeof window !== 'undefined' && window.STORAGE_PATH) ? '/' + window.STORAGE_PATH : '/storage';
            if (path.startsWith('storage/') || path.startsWith('/storage/')) {
                return base + '/' + path.replace(/^\/?storage\/?/, '');
            }
            return base + '/' + path.replace(/^\/+/, '');
        }
        
        const imageUrl = item.customization_image_url ? item.customization_image_url : getImageUrl(item.product?.image);
        const lineName = item.display_name || item.product?.name || 'Product';
        
        const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
        const totalPrice = price * item.quantity;
        
        div.innerHTML = `
            <div class="infor flex items-center gap-5 w-full">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${lineName.replace(/"/g, '&quot;')}" class="w-[100px] aspect-square flex-shrink-0 rounded-lg object-cover" />
                </div>
                <div class="flex-1">
                    <div class="name text-button">${lineName}</div>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="product-price text-title">₹${price.toFixed(2)}</div>
                        ${item.size ? `<span class="text-sm text-secondary2">Size: ${item.size}</span>` : ''}
                        ${item.color ? `<span class="text-sm text-secondary2">Color: ${item.color}</span>` : ''}
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <div class="quantity-block flex items-center gap-2 border border-line rounded-lg px-2 py-1">
                            <i class="ph-bold ph-minus cursor-pointer text-sm quantity-decrease text-secondary2 hover:text-black" data-cart-id="${item.id}"></i>
                            <input type="number" min="1" max="9999" step="1" value="${item.quantity}" inputmode="numeric" aria-label="Quantity" class="quantity text-button font-semibold min-w-[2.5rem] w-12 text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" data-cart-id="${item.id}" />
                            <i class="ph-bold ph-plus cursor-pointer text-sm quantity-increase text-secondary2 hover:text-black" data-cart-id="${item.id}"></i>
                        </div>
                        <div class="text-sm text-secondary2 item-total-price">= ₹${totalPrice.toFixed(2)}</div>
                    </div>
                </div>
            </div>
            <button type="button" class="remove-cart-item button-main sm:py-3 py-2 sm:px-5 px-4 bg-red hover:bg-red-700 text-white rounded-full cursor-pointer flex-shrink-0" data-cart-id="${item.id}" onclick="var id=this.getAttribute('data-cart-id');if(id&&window.removeCartItem){window.removeCartItem(id);}return false;">Remove</button>
        `;
        
        // Remove: inline onclick above + delegated listener (backup)

        // Add quantity increase/decrease functionality
        const decreaseBtn = div.querySelector('.quantity-decrease');
        const increaseBtn = div.querySelector('.quantity-increase');
        const quantityElement = div.querySelector('.quantity');
        const totalPriceElement = div.querySelector('.item-total-price');

        if (decreaseBtn && quantityElement) {
            decreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let qty = readQtyControl(quantityElement);
                if (qty > 1) {
                    qty--;
                    updateCartItemQuantityInModal(item.id, qty, quantityElement, totalPriceElement, price);
                }
            });
        }

        if (increaseBtn && quantityElement) {
            increaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let qty = readQtyControl(quantityElement) + 1;
                updateCartItemQuantityInModal(item.id, qty, quantityElement, totalPriceElement, price);
            });
        }

        if (quantityElement && quantityElement.tagName === 'INPUT') {
            quantityElement.addEventListener('change', function() {
                var qty = readQtyControl(quantityElement);
                updateCartItemQuantityInModal(item.id, qty, quantityElement, totalPriceElement, price);
            });
        }
        
        return div;
    }

    // Update cart item quantity in modal
    function updateCartItemQuantityInModal(cartId, quantity, quantityElement, totalPriceElement, unitPrice) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch(`/api/cart/update/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                writeQtyControl(quantityElement, quantity);
                const totalPrice = unitPrice * quantity;
                if (totalPriceElement) {
                    totalPriceElement.textContent = `= ₹${totalPrice.toFixed(2)}`;
                }
                // Reload cart to update totals
                loadCartItems();
                updateCartCount();
            } else {
                showNotification(data.message || 'Failed to update quantity', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Remove cart item
    let isRemovingCartItem = false;
    function removeCartItem(cartId) {
        if (isRemovingCartItem) return;
        cartId = String(cartId || '').trim();
        if (!cartId) return;
        isRemovingCartItem = true;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch(`/api/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                loadCartItems();
                // Also reload cart page if on cart page
                if (document.querySelector('.list-product-main')) {
                    loadCartPageItems();
                }
                if (document.querySelector('.list-product-checkout')) {
                    loadCheckoutCartItems();
                }
                showNotification('Item removed from cart', 'success');
            } else {
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing cart item:', error);
            showNotification('An error occurred', 'error');
        })
        .finally(() => {
            isRemovingCartItem = false;
        });
    }

    // Delegated click for Remove button (works even after cart list is re-rendered)
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-cart-item');
        if (!removeBtn) return;
        e.preventDefault();
        e.stopPropagation();
        const cartId = removeBtn.getAttribute('data-cart-id');
        if (cartId) removeCartItem(cartId);
    }, true);

    // Show notification
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existing = document.querySelector('.notification');
        if (existing) existing.remove();

        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Quick shop = opens Quick View modal (same as Quick View, for quick add-to-cart)
    function initQuickShop() {
        document.addEventListener('click', function(e) {
            const quickShopBtn = e.target.closest('.quick-shop-btn');
            if (!quickShopBtn) return;
            e.preventDefault();
            e.stopPropagation();
            let slug = quickShopBtn.getAttribute('data-product-slug');
            let id = quickShopBtn.getAttribute('data-product-id');
            if (!slug && id) {
                const qv = quickShopBtn.closest('.product-item')?.querySelector('.quick-view-btn');
                if (qv) slug = qv.getAttribute('data-product-slug');
            }
            if (slug) loadQuickViewProductBySlug(slug);
            else if (id) loadQuickViewProductById(id);
        }, true);
        
        // Handle size selection
        document.addEventListener('click', function(e) {
            const sizeItem = e.target.closest('.size-item');
            if (!sizeItem || !sizeItem.closest('.quick-shop-block')) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove active class from siblings
            const siblings = sizeItem.parentElement.querySelectorAll('.size-item');
            siblings.forEach(sib => sib.classList.remove('active'));
            
            // Add active class to clicked item
            sizeItem.classList.add('active');
        });
        
        // Handle color selection
        document.addEventListener('click', function(e) {
            const colorItem = e.target.closest('.color-item');
            if (!colorItem || !colorItem.closest('.quick-shop-block')) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove active class from siblings
            const siblings = colorItem.parentElement.querySelectorAll('.color-item');
            siblings.forEach(sib => sib.classList.remove('active'));
            
            // Add active class to clicked item
            colorItem.classList.add('active');
        });
    }

    // Initialize checkout button
    function initCheckoutButton() {
        const checkoutForm = document.getElementById('checkout-form');
        const checkoutBtn = document.getElementById('checkout-link');
        
        if (!checkoutForm || !checkoutBtn) {
            // Retry after a delay if not found
            setTimeout(initCheckoutButton, 500);
            return;
        }

        // Get form action URL
        const checkoutUrl = checkoutForm.getAttribute('action');
        if (!checkoutUrl || checkoutUrl === '#') {
            console.error('Checkout URL not found');
            return;
        }

        // Remove any existing handlers by cloning the form
        const newForm = checkoutForm.cloneNode(true);
        const newBtn = newForm.querySelector('#checkout-link');
        checkoutForm.parentNode.replaceChild(newForm, checkoutForm);

        // Direct navigation function
        const navigateToCheckout = function() {
            let url = checkoutUrl;
            const pincodeInput = document.getElementById('cart-pincode');
            if (pincodeInput) {
                const p = String(pincodeInput.value || '').trim().replace(/\D/g, '');
                if (p.length === 6) {
                    url = checkoutUrl + (checkoutUrl.indexOf('?') >= 0 ? '&' : '?') + 'pincode=' + encodeURIComponent(p);
                }
            }
            window.location.replace(url);
            setTimeout(function() {
                if (window.location.href.indexOf(checkoutUrl) === -1) {
                    window.location.href = url;
                }
            }, 100);
        };

        // Handle form submission - prevent default and navigate
        newForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            navigateToCheckout();
            return false;
        }, true);

        // Handle button click - prevent default and navigate
        if (newBtn) {
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                navigateToCheckout();
                return false;
            }, true);
            
            // Also handle mousedown to catch early
            newBtn.addEventListener('mousedown', function(e) {
                if (e.button === 0) { // Left click
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        }
    }

    // Load checkout cart items
    function loadCheckoutCartItems() {
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const checkoutList = document.querySelector('.list-product-checkout');
                    if (checkoutList) {
                        checkoutList.innerHTML = '';
                        const items = data.data?.items || data.data || [];
                        if (items && items.length > 0) {
                            let total = 0;
                            items.forEach(item => {
                                const checkoutItem = createCheckoutItemElement(item);
                                checkoutList.appendChild(checkoutItem);
                                const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
                                total += price * item.quantity;
                            });
                            
                            // Update total - use API total if available
                            const totalFromAPI = data.data?.total || total;
                            const totalElement = document.querySelector('.total-cart, .checkout-total');
                            if (totalElement) {
                                totalElement.textContent = '₹' + totalFromAPI.toFixed(2);
                            }
                        } else {
                            checkoutList.innerHTML = '<div class="text-center py-10 text-secondary">Your cart is empty</div>';
                            const totalElement = document.querySelector('.total-cart, .checkout-total');
                            if (totalElement) {
                                totalElement.textContent = '₹0.00';
                            }
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading checkout cart:', error));
    }
    
    // Load cart page items
    function loadCartPageItems() {
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartList = document.querySelector('.list-product-main');
                    if (cartList) {
                        cartList.innerHTML = '';
                        const items = data.data?.items || data.data || [];
                        if (items && items.length > 0) {
                            let subtotal = 0;
                            items.forEach(item => {
                                const cartItem = createCartPageItemElement(item);
                                cartList.appendChild(cartItem);
                                const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
                                subtotal += price * item.quantity;
                            });
                            
                            // Update subtotal
                            const subtotalElement = document.querySelector('.total-product');
                            if (subtotalElement) {
                                subtotalElement.textContent = subtotal.toFixed(2).split('.')[0];
                                const centsElement = subtotalElement.nextElementSibling;
                                if (centsElement && centsElement.tagName === 'SPAN') {
                                    centsElement.textContent = '.' + subtotal.toFixed(2).split('.')[1];
                                }
                            }
                            
                            // Update total (subtotal - discount + shipping)
                            updateCartPageTotal(subtotal);
                        } else {
                            cartList.innerHTML = '<div class="text-center py-10 text-secondary col-span-full">Your cart is empty</div>';
                            updateCartPageTotal(0);
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading cart page items:', error));
    }
    
    // Create cart page item element (table row format)
    function createCartPageItemElement(item) {
        const row = document.createElement('div');
        row.className = 'product-item-cart flex items-center py-4 border-b border-line';
        row.setAttribute('data-cart-id', item.id);
        
        // Get image URL
        function getStorageBase() {
            return (typeof window !== 'undefined' && window.STORAGE_PATH) ? '/' + window.STORAGE_PATH : '/storage';
        }
        function getImageUrl(path) {
            if (!path) return '/assets/images/product/perch-bottal.webp';
            if (path.startsWith('http://') || path.startsWith('https://')) return path;
            if (path.startsWith('assets/') || path.startsWith('/assets/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            var base = getStorageBase();
            if (path.startsWith('storage/') || path.startsWith('/storage/')) {
                return base + '/' + path.replace(/^\/?storage\/?/, '');
            }
            return base + '/' + path.replace(/^\/+/, '');
        }
        
        const imageUrl = item.customization_image_url ? item.customization_image_url : getImageUrl(item.product?.image);
        const lineName = item.display_name || item.product?.name || 'Product';
        const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
        const totalPrice = price * item.quantity;
        const custLabel = item.customization_label ? String(item.customization_label).replace(/</g, '&lt;').replace(/&/g, '&amp;') : '';
        
        row.innerHTML = `
            <div class="w-2/5 flex items-center gap-4">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${lineName.replace(/"/g, '&quot;')}" class="w-20 h-20 object-cover rounded-lg" />
                </div>
                <div>
                    <div class="name text-button font-semibold">${lineName}</div>
                    ${custLabel ? `<div class="text-sm text-secondary2 mt-1">${custLabel}</div>` : ''}
                    ${item.size || item.color ? `
                        <div class="text-sm text-secondary2 mt-1">
                            ${item.size ? `Size: ${item.size}` : ''}
                            ${item.size && item.color ? ' | ' : ''}
                            ${item.color ? `Color: ${item.color}` : ''}
                        </div>
                    ` : ''}
                </div>
            </div>
            <div class="w-1/12 text-center">
                <div class="product-price text-title">₹${price.toFixed(2)}</div>
            </div>
            <div class="w-1/6 flex items-center justify-center">
                <div class="quantity-block flex items-center gap-3 border border-line rounded-lg px-3 py-2">
                    <i class="ph-bold ph-minus cursor-pointer text-lg quantity-decrease" data-cart-id="${item.id}"></i>
                    <input type="number" min="1" max="9999" step="1" value="${item.quantity}" inputmode="numeric" aria-label="Quantity" class="quantity text-button font-semibold w-12 min-w-[2.5rem] text-center bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" data-cart-id="${item.id}" />
                    <i class="ph-bold ph-plus cursor-pointer text-lg quantity-increase" data-cart-id="${item.id}"></i>
                </div>
            </div>
            <div class="w-1/6 text-center">
                <div class="total-price text-title">₹${totalPrice.toFixed(2)}</div>
            </div>
            <div class="w-1/12 text-center">
                <button class="remove-cart-item-btn text-red hover:text-red-700 cursor-pointer font-semibold text-sm underline" data-cart-id="${item.id}">
                    Remove
                </button>
            </div>
        `;
        
        // Add quantity update handlers
        const decreaseBtn = row.querySelector('.quantity-decrease');
        const increaseBtn = row.querySelector('.quantity-increase');
        const quantityElement = row.querySelector('.quantity');
        const totalPriceElement = row.querySelector('.total-price');
        
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const cartId = this.getAttribute('data-cart-id');
                let qty = readQtyControl(quantityElement);
                if (qty > 1) {
                    qty--;
                    updateCartItemQuantity(cartId, qty, quantityElement, totalPriceElement, price);
                }
            });
        }
        
        if (increaseBtn) {
            increaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const cartId = this.getAttribute('data-cart-id');
                let qty = readQtyControl(quantityElement) + 1;
                updateCartItemQuantity(cartId, qty, quantityElement, totalPriceElement, price);
            });
        }

        if (quantityElement && quantityElement.tagName === 'INPUT') {
            quantityElement.addEventListener('change', function() {
                const cartId = quantityElement.getAttribute('data-cart-id');
                var qty = readQtyControl(quantityElement);
                updateCartItemQuantity(cartId, qty, quantityElement, totalPriceElement, price);
            });
        }

        // Add remove button functionality
        const removeBtn = row.querySelector('.remove-cart-item-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const cartId = this.getAttribute('data-cart-id');
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    removeCartItem(cartId);
                }
            });
        }
        
        return row;
    }
    
    // Update cart item quantity
    function updateCartItemQuantity(cartId, quantity, quantityElement, totalPriceElement, unitPrice) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch(`/api/cart/update/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                writeQtyControl(quantityElement, quantity);
                const totalPrice = unitPrice * quantity;
                totalPriceElement.textContent = '₹' + totalPrice.toFixed(2);
                updateCartCount();
                loadCartPageItems(); // Reload to update totals
            } else {
                showNotification(data.message || 'Failed to update quantity', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Cart page: stored shipping charge from pincode API (used when no radios)
    let cartShippingCharge = 0;
    
    // Update cart page total
    function updateCartPageTotal(subtotal) {
        const discountElement = document.querySelector('.discount');
        const discount = discountElement ? parseFloat(discountElement.textContent) || 0 : 0;
        
        // Use pincode-based shipping charge (from API)
        const shipping = cartShippingCharge;
        
        const total = subtotal - discount + shipping;
        
        // Update total display - format like $116.00
        const totalElement = document.querySelector('.total-cart');
        if (totalElement) {
            const totalParts = total.toFixed(2).split('.');
            totalElement.textContent = totalParts[0];
            const nextSibling = totalElement.nextElementSibling;
            if (nextSibling && nextSibling.tagName === 'SPAN') {
                nextSibling.textContent = '.' + totalParts[1];
            } else {
                totalElement.textContent = total.toFixed(2);
            }
        }
    }
    
    // Cart page: pincode shipping - call API and update charge
    function initCartPincodeShipping() {
        const pincodeInput = document.getElementById('cart-pincode');
        const checkBtn = document.getElementById('cart-check-shipping');
        const chargeEl = document.getElementById('cart-shipping-charge');
        const labelEl = document.getElementById('cart-shipping-label');
        const estimateEl = document.getElementById('cart-delivery-estimate');
        const errorEl = document.getElementById('cart-shipping-error');
        
        if (!pincodeInput || !checkBtn || !chargeEl) return;

        function hideMessages() {
            if (estimateEl) { estimateEl.classList.add('hidden'); estimateEl.textContent = ''; }
            if (errorEl) { errorEl.classList.add('hidden'); errorEl.textContent = ''; }
        }

        checkBtn.addEventListener('click', function() {
            const pincode = String(pincodeInput.value || '').trim().replace(/\D/g, '');
            hideMessages();
            
            if (pincode.length !== 6) {
                if (errorEl) {
                    errorEl.textContent = 'Please enter a valid 6-digit pincode';
                    errorEl.classList.remove('hidden');
                }
                return;
            }

            checkBtn.disabled = true;
            checkBtn.textContent = 'Checking...';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch('/api/shipping/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    pincode: pincode,
                    weight: 1,
                    cod_amount: 0
                })
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success && res.data) {
                    cartShippingCharge = parseFloat(res.data.shipping_charge) || 0;
                    chargeEl.textContent = cartShippingCharge === 0 ? 'Free' : '₹' + cartShippingCharge.toFixed(2);
                    if (labelEl) labelEl.textContent = pincode + ' — serviceable';
                    if (estimateEl && res.data.estimated_delivery) {
                        estimateEl.textContent = 'Delivery: ' + res.data.estimated_delivery;
                        estimateEl.classList.remove('hidden');
                    }
                    // Recalculate total
                    fetch('/api/cart', {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin'
                    })
                    .then(function(cr) { return cr.json(); })
                    .then(function(cartData) {
                        if (cartData.success) {
                            const items = cartData.data?.items || cartData.data || [];
                            let subtotal = 0;
                            items.forEach(function(item) {
                                const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
                                subtotal += price * item.quantity;
                            });
                            updateCartPageTotal(subtotal);
                        }
                    });
                } else {
                    if (errorEl) {
                        errorEl.textContent = res.message || 'Pincode not serviceable. Please try another.';
                        errorEl.classList.remove('hidden');
                    }
                }
            })
            .catch(function(err) {
                console.error('Shipping API error:', err);
                if (errorEl) {
                    errorEl.textContent = 'Unable to check shipping. Please try again.';
                    errorEl.classList.remove('hidden');
                }
            })
            .finally(function() {
                checkBtn.disabled = false;
                checkBtn.textContent = 'Check';
            });
        });

        // Allow Enter key in pincode field
        pincodeInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                checkBtn.click();
            }
        });
    }

    // Create checkout item element
    function createCheckoutItemElement(item) {
        const div = document.createElement('div');
        div.className = 'product-item-checkout flex items-center justify-between gap-3 py-4 border-b border-line';
        
        // Get image URL - use same function as cart items
        function getStorageBase() {
            return (typeof window !== 'undefined' && window.STORAGE_PATH) ? '/' + window.STORAGE_PATH : '/storage';
        }
        function getImageUrl(path) {
            if (!path) return '/assets/images/product/perch-bottal.webp';
            if (path.startsWith('http://') || path.startsWith('https://')) return path;
            if (path.startsWith('assets/') || path.startsWith('/assets/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            var base = getStorageBase();
            if (path.startsWith('storage/') || path.startsWith('/storage/')) {
                return base + '/' + path.replace(/^\/?storage\/?/, '');
            }
            return base + '/' + path.replace(/^\/+/, '');
        }
        const imageUrl = item.customization_image_url ? item.customization_image_url : getImageUrl(item.product?.image);
        const lineName = item.display_name || item.product?.name || 'Product';
        
        const price = parseFloat(item.unit_price ?? item.product?.sale_price ?? item.product?.price ?? 0);
        const totalPrice = price * item.quantity;
        const custLabel = item.customization_label ? String(item.customization_label).replace(/</g, '&lt;').replace(/&/g, '&amp;') : '';
        
        div.innerHTML = `
            <div class="infor flex items-center gap-3">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${lineName.replace(/"/g, '&quot;')}" class="w-[60px] aspect-square flex-shrink-0 rounded-lg object-cover" />
                </div>
                <div>
                    <div class="name text-sm font-semibold">${lineName}</div>
                    ${custLabel ? `<div class="text-xs text-secondary2 mt-1">${custLabel}</div>` : ''}
                    <div class="text-xs text-secondary2 mt-1">
                        ${item.size ? `Size: ${item.size} ` : ''}
                        ${item.color ? `Color: ${item.color}` : ''}
                    </div>
                    <div class="text-xs text-secondary2 mt-1">Qty: ${item.quantity}</div>
                </div>
            </div>
            <div class="text-title">₹${totalPrice.toFixed(2)}</div>
        `;
        
        return div;
    }

    // Wishlist button: add/remove product and open wishlist modal (card or quick view modal)
    function initWishlistBtn() {
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.add-wishlist-btn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();

            var productId = btn.getAttribute('data-product-id');
            if (!productId) return;

            var wishlistStore = localStorage.getItem('wishlistStore');
            var items = wishlistStore ? JSON.parse(wishlistStore) : [];
            if (!Array.isArray(items)) items = [];

            var existingIndex = items.findIndex(function(item) { return String(item.id) === String(productId); });

            // Remove if already in wishlist (toggle off)
            if (existingIndex > -1) {
                items.splice(existingIndex, 1);
                btn.classList.remove('active');
                var icon = btn.querySelector('i');
                if (icon) { icon.classList.add('ph'); icon.classList.remove('ph-fill'); }
                localStorage.setItem('wishlistStore', JSON.stringify(items));
                if (typeof window.handleItemModalWishlist === 'function') window.handleItemModalWishlist();
                if (typeof window.updateWishlistIcons === 'function') window.updateWishlistIcons();
                if (typeof window.showNotification === 'function') window.showNotification('Removed from wishlist');
                return;
            }

            // Add to wishlist: fetch product then save
            btn.classList.add('active');
            var icon = btn.querySelector('i');
            if (icon) { icon.classList.remove('ph'); icon.classList.add('ph-fill'); }

            var apiBase = window.location.origin + '/api';
            fetch(apiBase + '/products/by-id/' + productId, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            })
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    if (res.success && res.data) {
                        var alreadyIn = items.some(function(item) { return String(item.id) === String(res.data.id); });
                        if (!alreadyIn) items.push(res.data);
                        localStorage.setItem('wishlistStore', JSON.stringify(items));
                        if (typeof window.handleItemModalWishlist === 'function') window.handleItemModalWishlist();
                        if (typeof window.updateWishlistIcons === 'function') window.updateWishlistIcons();
                        if (typeof window.showNotification === 'function') window.showNotification('Added to wishlist');
                        var wm = document.querySelectorAll('.modal-wishlist-block .modal-wishlist-main');
                        var modal = wm.length ? wm[wm.length - 1] : null;
                        if (modal) {
                            modal.classList.add('open');
                            document.body.style.overflow = 'hidden';
                        }
                    }
                })
                .catch(function() {
                    btn.classList.remove('active');
                    if (icon) { icon.classList.add('ph'); icon.classList.remove('ph-fill'); }
                });
        }, true);
    }

    // Initialize all functionality
    function init() {
        initAddToCart();
        initQuickView();
        initQuickViewSizeColor();
        initWishlistBtn();
        initQuickShop();
        updateCartCount();
        
        // Load cart on page load
        if (document.querySelector('.modal-cart-block')) {
            loadCartItems();
        }
        
        // Load checkout cart items if on checkout page
        if (document.querySelector('.list-product-checkout')) {
            loadCheckoutCartItems();
        }
        
        // Load cart page items if on cart page
        if (document.querySelector('.list-product-main')) {
            loadCartPageItems();
            initCartPincodeShipping();
        }
        
        // Initialize checkout button handler
        initCheckoutButton();
        
        // Load cart when cart modal opens
        const cartModal = document.querySelector('.modal-cart-block');
        if (cartModal) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        if (cartModal.classList.contains('open')) {
                            loadCartItems();
                        }
                    }
                });
            });
            observer.observe(cartModal, { attributes: true });
        }
    }

    // Make functions globally accessible
    window.updateCartCount = updateCartCount;
    window.loadCartItems = loadCartItems;
    window.loadCartPageItems = loadCartPageItems;
    window.loadCheckoutCartItems = loadCheckoutCartItems;
    window.removeCartItem = removeCartItem;
    window.showNotification = showNotification;
    window.openQuickView = function(slug) { if(slug) loadQuickViewProductBySlug(slug); };

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
