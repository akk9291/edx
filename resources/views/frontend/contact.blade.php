@extends('layouts.frontend')

@section('title', 'Contact Us - EDX Rulmenti Romania')

@section('styles')
<style>
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #E31E24;
    }
    .form-group input:focus-visible,
    .form-group textarea:focus-visible {
        outline: 2px solid rgba(227, 30, 36, 0.45);
        outline-offset: 2px;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    .btn-submit {
        background: #E31E24;
        color: #fff;
        border: none;
        padding: 14px 30px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-submit:hover {
        background: #c91a1f;
    }
    .btn-submit:focus-visible {
        outline: 2px solid #E31E24;
        outline-offset: 3px;
    }
    .success-message {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .info-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }
    .info-icon {
        width: 50px;
        height: 50px;
        background: #fef2f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-icon i {
        font-size: 24px;
        color: #E31E24;
    }
    .info-content h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .info-content p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }
    .map-container {
        margin-top: 30px;
        border-radius: 8px;
        overflow: hidden;
        height: 250px;
        background: #f5f5f5;
    }
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }
    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-block style-shared" style="background-color: #ec2127;">
    <div class="breadcrumb-main overflow-hidden">
        <div class="container pt-3 pb-5 relative">
            <div class="main-content w-full h-full flex flex-col relative z-[1]">
                <div class="text-content" style="color: aliceblue;">
                    <div class="heading2">Contact Us</div>
                    <div class="link flex gap-1 caption1 mt-3">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="ph ph-caret-right text-sm"></i>
                        <div class="capitalize">Contact</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<section class="lg:py-20 md:py-14 py-10">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form">
                <div class="heading4 mb-2">Get in Touch</div>
                <p class="text-secondary mb-8">Have a question or need assistance? Fill out the form below and our team will get back to you shortly.</p>
                
                @if(session('success'))
                    <div class="success-message">{{ session('success') }}</div>
                @endif
                
                <form action="{{ route('frontend.contact.submit') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" name="first_name" required value="{{ old('first_name') }}">
                            @error('first_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Last Name *</label>
                            <input type="text" name="last_name" required value="{{ old('last_name') }}">
                            @error('last_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label>Subject *</label>
                        <input type="text" name="subject" required value="{{ old('subject') }}">
                        @error('subject')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Message *</label>
                        <textarea name="message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div class="contact-info">
                <div class="heading4 mb-8">Contact Information</div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="ph ph-map-pin"></i>
                    </div>
                    <div class="info-content">
                        <h4>Address</h4>
                        <p>Sediu social: București Sectorul 4,<br>Bulevardul METALURGIEI, Nr. 132,<br>bloc B9, Etaj 4, Ap. 42</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="ph ph-phone"></i>
                    </div>
                    <div class="info-content">
                        <h4>Phone</h4>
                        <p>+40 723 370 345</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="ph ph-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h4>Email</h4>
                        <p>info@edxromania.ro</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="ph ph-clock"></i>
                    </div>
                    <div class="info-content">
                        <h4>Business Hours</h4>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday - Sunday: Closed</p>
                    </div>
                </div>
                
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2849.5!2d26.1!3d44.4!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDTCsDI0JzAwLjAiTiAyNsKwMDYnMDAuMCJF!5e0!3m2!1sen!2sro!4v1234567890" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
