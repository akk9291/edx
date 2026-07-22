@extends('layouts.app')

@section('title', 'Privacy Policy - Perch Bottle')

@section('content')
<div class="page-content privacy-policy-page-content">
    <div class="breadcrumb-block style-shared">
        <div class="breadcrumb-main bg-linear overflow-hidden">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center">Privacy Policy</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}">Homepage</a>
                            <i class="ph ph-caret-right text-sm text-secondary2"></i>
                            <span class="text-secondary2 capitalize">Privacy Policy</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="privacy-policy-block md:py-20 py-10">
        <div class="container">
            <div class="content max-w-4xl mx-auto">
                <div class="body1 text-secondary space-y-6">
                    @php $privacyContent = \App\Models\Setting::get('privacy_policy'); @endphp
                    @if($privacyContent)
                        {!! nl2br(e($privacyContent)) !!}
                    @else
                    <p>We wish to ensure authentic and conveyed dealings with each customer. Thus, we have formulated a comprehensive privacy policy to serve you or any other concerned person about how their personal information can be used while they browse online. Kindly devote a few of your precious minutes and go through Perch's privacy policy to understand how we collect, protect, or otherwise deal with your personal information shared on our website.</p>

                    <h5 class="heading5 text-black font-semibold mt-8">Who we are</h5>
                    <p>We are the manufacturers of stainless steel bottles and lunchboxes under the brand name Perch. Our one and only official website address is: <a href="{{ route('home') }}" class="text-button hover:underline">{{ url('/') }}</a>. Refrain from purchasing or surfing through any other website posing to be us.</p>

                    <h5 class="heading5 text-black font-semibold mt-8">What personal information do we collect when people visit our website?</h5>
                    <p>For safe, smooth, and error-free shopping, a buyer may be asked to fill in details like name, email address, mailing address, phone number, etc. Thus, we collect info about such identifiable details of the buyers.</p>

                    <h5 class="heading5 text-black font-semibold mt-8">How do we collect personal information when people visit our website?</h5>
                    <p>Besides filling out such a form as stated above, we also collect contact information when a person subscribes to our newsletter or shares their reviews about us or our products. More details are pointed out herein:-</p>

                    <h6 class="heading6 text-black font-semibold mt-6">Comments</h6>
                    <p>Our system collects data when any visitor posts a comment in the designated section of our website. We also record the visitor's IP address and browser user agent string to detect spam users. An anonymized string or hash created from your email address may be provided to the Gravatar service to see if you are the one using it. Once approved, your posted comment and profile picture becomes visible to the public.</p>
                    <p>Find the Gravatar service privacy policy at: <a href="https://automattic.com/privacy/" target="_blank" rel="noopener" class="text-button hover:underline">https://automattic.com/privacy/</a>.</p>

                    <h6 class="heading6 text-black font-semibold mt-6">Media</h6>
                    <p>We wish to caution you while you post images on our website about a product or your profile. The precautionary point will be to avoid uploading images embedded with location data (EXIF GPS). Remove such location details before uploading so that no other visitor can extract your location by downloading the image posted by you.</p>

                    <h6 class="heading6 text-black font-semibold mt-6">Cookies</h6>
                    <p>Leaving a comment on a website usually implies allowing the website to save your name, email address, and website in cookies. The reason behind such cookie usage is to provide you with the convenience of not having to refill all details repeatedly when you wish to submit another feedback. More details are as follows.</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>When you visit our login page, we set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</li>
                        <li>When you log in with us, we set several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year.</li>
                        <li>If you select "Remember Me", your login persists for two weeks. If you log out of your account, the login cookies get removed.</li>
                        <li>If you edit or publish a comment, an additional cookie gets saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after one day.</li>
                    </ul>

                    <h6 class="heading6 text-black font-semibold mt-6">Embedded content from other websites</h6>
                    <p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website. These websites may collect your info, use cookies, embed additional third-party trackers, and monitor your interaction with that embedded content. This may however be subjected to further tracking if you have an account and have also logged in to that particular website.</p>

                    <h6 class="heading6 text-black font-semibold mt-6">Password resetting</h6>
                    <p>When you create an account with us through an email address or a phone number, you cannot use it again for another registration. Thus, anybody forgetting their password to an already registered email address or phone number can ask for a password reset. However, requesting this resetting implies including your IP address in the reset email.</p>

                    <h5 class="heading5 text-black font-semibold mt-8">For how long do we retain your data?</h5>
                    <p>Leaving a comment on our website means allowing the comment and its metadata to stay on the portal indefinitely. This allows easy and quick approval for follow-up comments automatically instead of being held in a moderation queue.</p>
                    <p>One cannot change their username but can anytime view, edit, or delete their personal information. Website administrators can also see and edit such information for fair reasons.</p>

                    <h5 class="heading5 text-black font-semibold mt-8">What rights do you have over your data?</h5>
                    <p>You can always request to receive an exported file of the personal data we hold about you; we will be quick to share the same. We can proceed ahead with this service only when you have an account on our website or when you have posted comments/ feedback.</p>
                    <p>Let us know if you wish to erase any personal data we hold about you. However, please note that we might not be able to erase data we are obliged to keep for administrative, legal, or security purposes.</p>

                    <h5 class="heading5 text-black font-semibold mt-8">Where do we send your data?</h5>
                    <p>Any comment or feedback posted by a visitor on our website is subjected to a thorough and protective spam detection service. Sensitive information like card details, etc. are embraced with SSL encryption.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
