@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Site Settings</h5>
            </div>
            <div class="card-body">
                <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button">Content</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button">Social Media</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button">Other</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="settingsTabsContent">
                        {{-- General Tab --}}
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? 'Perch Bottle') }}" placeholder="Perch Bottle">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Logo</label>
                                    @if(!empty($settings['site_logo']))
                                        <div class="mb-2">
                                            <img src="{{ storage_asset($settings['site_logo'] ?? '') }}" alt="Logo" style="max-height: 60px;">
                                        </div>
                                    @endif
                                    <input type="file" name="site_logo" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? 'ecom@perchbottle.in') }}" placeholder="ecom@perchbottle.in">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" placeholder="+91 1234567890">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Address Line 1</label>
                                    <input type="text" name="contact_address" class="form-control" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}" placeholder="Street address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="contact_address_line2" class="form-control" value="{{ old('contact_address_line2', $settings['contact_address_line2'] ?? '') }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="contact_city" class="form-control" value="{{ old('contact_city', $settings['contact_city'] ?? '') }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" name="contact_state" class="form-control" value="{{ old('contact_state', $settings['contact_state'] ?? '') }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" name="contact_pincode" class="form-control" value="{{ old('contact_pincode', $settings['contact_pincode'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Helpline Number</label>
                                    <input type="text" name="helpline_number" class="form-control" value="{{ old('helpline_number', $settings['helpline_number'] ?? '') }}" placeholder="e.g. 1800-123-4567 or +91 9876543210">
                                    <small class="text-muted">Shown on contact page and in footer.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Working Hours</label>
                                    <textarea name="working_hours" class="form-control" rows="4" placeholder="Mon - Fri: 9:00am - 6:00pm&#10;Saturday: 10:00am - 4:00pm&#10;Sunday: Closed">{{ old('working_hours', $settings['working_hours'] ?? '') }}</textarea>
                                    <small class="text-muted">One line per slot. Shown on contact page.</small>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Map Embed</label>
                                    <textarea name="map_embed" class="form-control font-monospace" rows="5" placeholder="Paste Google Maps embed iframe code here (from Google Maps → Share → Embed a map)">{{ old('map_embed', $settings['map_embed'] ?? '') }}</textarea>
                                    <small class="text-muted">Paste the full &lt;iframe&gt;...&lt;/iframe&gt; code from Google Maps. Leave empty to hide map on contact page.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency Code</label>
                                    <input type="text" name="currency" class="form-control" value="{{ old('currency', $settings['currency'] ?? 'INR') }}" placeholder="INR">
                                    <small class="text-muted">Currency code (e.g., INR, USD, EUR)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency Symbol</label>
                                    <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $settings['currency_symbol'] ?? '₹') }}" placeholder="₹">
                                    <small class="text-muted">Currency symbol (e.g., ₹, $, €)</small>
                                </div>
                            </div>
                        </div>

                        {{-- Content Tab (Contact page text only; About Us & Policy pages are in Policy Pages) --}}
                        <div class="tab-pane fade" id="content" role="tabpanel">
                            <p class="text-muted small mb-3">Edit About Us, Privacy Policy, Terms, Return & Refund, and Cancellation Policy from <a href="{{ route('admin.policy-pages.index') }}">Policy Pages</a>.</p>
                            <div class="mb-3">
                                <label class="form-label">Footer About Us Text</label>
                                <div id="editor-contact-page-text" class="bg-white border rounded" style="min-height: 120px;"></div>
                                <textarea name="contact_page_text" id="settings-contact-page-text" class="d-none" rows="3">{{ old('contact_page_text', $settings['contact_page_text'] ?? '') }}</textarea>
                                <small class="text-muted">Short text for the contact page (e.g. "We're Here To Help").</small>
                            </div>
                        </div>

                        {{-- Social Media Tab --}}
                        <div class="tab-pane fade" id="social" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-facebook me-1"></i> Facebook URL</label>
                                    <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-instagram me-1"></i> Instagram URL</label>
                                    <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-twitter-x me-1"></i> Twitter URL</label>
                                    <input type="url" name="twitter_url" class="form-control" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" placeholder="https://twitter.com/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-youtube me-1"></i> YouTube URL</label>
                                    <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-pinterest me-1"></i> Pinterest URL</label>
                                    <input type="url" name="pinterest_url" class="form-control" value="{{ old('pinterest_url', $settings['pinterest_url'] ?? '') }}" placeholder="https://pinterest.com/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="919876543210 (with country code)">
                                </div>
                            </div>
                        </div>

                        {{-- Other Tab --}}
                        <div class="tab-pane fade" id="other" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label">Free Shipping Text (Header)</label>
                                <input type="text" name="free_shipping_text" class="form-control" value="{{ old('free_shipping_text', $settings['free_shipping_text'] ?? 'FREE SHIPPING ON ALL ORDERS OVER ₹75') }}" placeholder="FREE SHIPPING ON ALL ORDERS OVER ₹75">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Copyright Text</label>
                                <input type="text" name="copyright_text" class="form-control" value="{{ old('copyright_text', $settings['copyright_text'] ?? '') }}" placeholder="{{ '©' . date('Y') . ' Perch. All Rights Reserved.' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description (SEO)</label>
                                <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                            </div>
                            <hr class="my-4">
                            <h6 class="mb-3">Product Page Features (shown on product detail page)</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 1 Title</label>
                                    <input type="text" name="product_feature_1_title" class="form-control" value="{{ old('product_feature_1_title', $settings['product_feature_1_title'] ?? 'Shipping Faster') }}" placeholder="Shipping Faster">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 1 Text</label>
                                    <input type="text" name="product_feature_1_text" class="form-control" value="{{ old('product_feature_1_text', $settings['product_feature_1_text'] ?? '') }}" placeholder="Free shipping on orders over ₹75">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 2 Title</label>
                                    <input type="text" name="product_feature_2_title" class="form-control" value="{{ old('product_feature_2_title', $settings['product_feature_2_title'] ?? 'Premium Material') }}" placeholder="Premium Material">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 2 Text</label>
                                    <input type="text" name="product_feature_2_text" class="form-control" value="{{ old('product_feature_2_text', $settings['product_feature_2_text'] ?? '') }}" placeholder="Crafted from high-quality materials">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 3 Title</label>
                                    <input type="text" name="product_feature_3_title" class="form-control" value="{{ old('product_feature_3_title', $settings['product_feature_3_title'] ?? 'High Quality') }}" placeholder="High Quality">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 3 Text</label>
                                    <input type="text" name="product_feature_3_text" class="form-control" value="{{ old('product_feature_3_text', $settings['product_feature_3_text'] ?? '') }}" placeholder="Built to last">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 4 Title</label>
                                    <input type="text" name="product_feature_4_title" class="form-control" value="{{ old('product_feature_4_title', $settings['product_feature_4_title'] ?? 'Highly Compatible') }}" placeholder="Highly Compatible">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Feature 4 Text</label>
                                    <input type="text" name="product_feature_4_text" class="form-control" value="{{ old('product_feature_4_text', $settings['product_feature_4_text'] ?? '') }}" placeholder="Works beautifully everywhere">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Save Settings
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toolbar = [
        [{ 'header': [5, 6, false] }],
        ['bold', 'italic', 'underline'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['link'],
        ['clean']
    ];
    var contactText = new Quill('#editor-contact-page-text', { theme: 'snow', modules: { toolbar: toolbar } });
    var taContact = document.getElementById('settings-contact-page-text');
    if (taContact && taContact.value) contactText.clipboard.dangerouslyPasteHTML(taContact.value);
    document.getElementById('settings-form').addEventListener('submit', function(e) {
        e.preventDefault();
        taContact.value = contactText.root.innerHTML;
        this.submit();
    });
});
</script>
@endpush
