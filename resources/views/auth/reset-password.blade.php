@extends('layouts.app')

@section('title', 'Reset Password - Perch Bottle')

@section('content')
<style>
.reset-error-alert.hidden,
.reset-success-alert.hidden { display: none !important; }
.reset-error-alert:not(.hidden) { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 16px; padding: 12px 16px; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #b91c1c; font-size: 14px; }
.reset-error-alert i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
.reset-success-alert:not(.hidden) { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 16px; padding: 12px 16px; background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; color: #15803d; font-size: 14px; }
.reset-success-alert i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
</style>
<div class="page-content">
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">Reset Password</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <a href="{{ route('forgot-password') }}">Forgot Password</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2 capitalize">Reset Password</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="reset-pass md:py-20 py-10">
        <div class="container max-w-xl mx-auto">
            <div class="p-6 border border-line rounded-lg">
                <div class="heading4">Set new password</div>
                <div class="body1 mt-2 text-secondary">Enter the OTP sent to your email and your new password.</div>
                <form id="reset-password-form" class="mt-6 space-y-4">
                    <div id="reset-error" class="reset-error-alert hidden"><i class="ph ph-warning-circle"></i><span class="reset-error-text"></span></div>
                    <div id="reset-success" class="reset-success-alert hidden"><i class="ph ph-check-circle"></i><span class="reset-success-text"></span></div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Email *</label>
                        <input class="border border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reset-email" name="email" type="email" placeholder="Your email" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">OTP (6 digits) *</label>
                        <input class="border border-line px-4 pt-3 pb-3 w-full rounded-lg text-center tracking-widest font-mono" id="reset-otp" name="otp" type="text" placeholder="Enter OTP" maxlength="6" pattern="[0-9]*" inputmode="numeric" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">New Password *</label>
                        <input class="border border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reset-password" name="password" type="password" placeholder="Min 8 characters" minlength="8" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Confirm Password *</label>
                        <input class="border border-line px-4 pt-3 pb-3 w-full rounded-lg" id="reset-password-confirm" name="password_confirmation" type="password" placeholder="Confirm new password" minlength="8" required />
                    </div>
                    <div class="block-button mt-6" style="display: block !important;">
                        <button type="submit" class="button-main w-full text-center py-3 bg-black text-white hover:bg-gray-800" id="reset-submit-btn" style="display: block !important; visibility: visible !important; background-color: #000 !important; color: #fff !important;">Reset Password</button>
                    </div>
                </form>
                <div class="mt-4 text-center">
                    <a href="{{ route('forgot-password') }}" class="text-button hover:underline">Back to Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var params = new URLSearchParams(window.location.search);
    var emailParam = params.get('email');
    if (emailParam) {
        var emailEl = document.getElementById('reset-email');
        if (emailEl) emailEl.value = emailParam;
    }

    var form = document.getElementById('reset-password-form');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var emailEl = document.getElementById('reset-email');
        var otpEl = document.getElementById('reset-otp');
        var passEl = document.getElementById('reset-password');
        var confirmEl = document.getElementById('reset-password-confirm');
        var errorEl = document.getElementById('reset-error');
        var successEl = document.getElementById('reset-success');
        var btn = document.getElementById('reset-submit-btn');

        var email = (emailEl && emailEl.value || '').trim();
        var otp = (otpEl && otpEl.value || '').trim().replace(/\D/g, '');
        var password = passEl && passEl.value || '';
        var passwordConfirmation = confirmEl && confirmEl.value || '';

        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');
        var errorTextEl = errorEl.querySelector('.reset-error-text');
        var successTextEl = successEl.querySelector('.reset-success-text');
        if (!email) {
            if (errorTextEl) errorTextEl.textContent = 'Please enter your email.';
            errorEl.classList.remove('hidden');
            return;
        }
        if (otp.length !== 6) {
            if (errorTextEl) errorTextEl.textContent = 'Please enter the 6-digit OTP from your email.';
            errorEl.classList.remove('hidden');
            return;
        }
        if (password.length < 8) {
            if (errorTextEl) errorTextEl.textContent = 'Password must be at least 8 characters.';
            errorEl.classList.remove('hidden');
            return;
        }
        if (password !== passwordConfirmation) {
            if (errorTextEl) errorTextEl.textContent = 'Passwords do not match.';
            errorEl.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Resetting...';
        fetch('/api/auth/reset-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                email: email,
                otp: otp,
                password: password,
                password_confirmation: passwordConfirmation
            })
        })
        .then(function(r) {
            return r.json().then(function(data) {
                return { ok: r.ok, status: r.status, data: data };
            });
        })
        .then(function(result) {
            var data = result.data;
            if (result.ok && data && data.success) {
                if (successTextEl) successTextEl.textContent = data.message || 'Password reset successfully! Redirecting to login...';
                successEl.classList.remove('hidden');
                setTimeout(function() {
                    window.location.href = '{{ route("login") }}';
                }, 1500);
            } else {
                var msg = data && data.message;
                if (data && data.errors) {
                    var parts = [];
                    Object.keys(data.errors).forEach(function(k) {
                        if (Array.isArray(data.errors[k])) parts.push(data.errors[k][0]);
                    });
                    if (parts.length) msg = parts.join(' ');
                }
                if (errorTextEl) errorTextEl.textContent = msg || 'Failed to reset password. Please check your OTP and try again.';
                errorEl.classList.remove('hidden');
                btn.disabled = false;
                btn.textContent = 'Reset Password';
            }
        })
        .catch(function(err) {
            console.error(err);
            if (errorTextEl) errorTextEl.textContent = 'An error occurred. Please try again.';
            errorEl.classList.remove('hidden');
            btn.disabled = false;
            btn.textContent = 'Reset Password';
        });
    });
});
</script>
@endpush
@endsection
