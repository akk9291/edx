<?php

namespace Database\Seeders;

use App\Models\PolicyPage;
use Illuminate\Database\Seeder;

class PolicyPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about-us',
                'title' => 'About Us',
                'content' => "<p>Perch Bottle is your trusted brand for premium stainless steel bottles and lunchboxes. We are committed to quality, sustainability, and customer satisfaction.</p>
<h5>Our story</h5>
<p>We started with a simple idea: to offer durable, eco-friendly products that help you stay hydrated and carry your meals with style. Today, we serve customers across India with products designed for everyday use.</p>
<h5>Our mission</h5>
<p>To reduce single-use plastic by providing high-quality reusable bottles and food containers that last. Every Perch product is built to be used daily and to stand the test of time.</p>
<h5>Why choose us</h5>
<p>We use food-grade stainless steel, ensure leak-proof designs, and offer responsive customer support. Get in touch for any queries or feedback.</p>
<p>Thank you for choosing Perch Bottle.</p>",
                'is_active' => true,
            ],
            [
                'slug' => 'terms-and-conditions',
                'title' => 'Terms & Conditions',
                'content' => "<p>Welcome to Perch Bottle. By accessing and using this website, you accept and agree to be bound by the following terms and conditions.</p>
<h5>1. Use of Website</h5>
<p>You may use our website for lawful purposes only. You must not use the site in any way that causes, or may cause, damage to the website or impairment of the availability or accessibility of the website.</p>
<h5>2. Intellectual Property</h5>
<p>All content on this website, including text, graphics, logos, and images, is the property of Perch Bottle or its content suppliers and is protected by applicable intellectual property laws.</p>
<h5>3. Product Information</h5>
<p>We strive to display our products and their colours as accurately as possible. However, we cannot guarantee that your device's display will accurately reflect the colour of the products.</p>
<h5>4. Limitation of Liability</h5>
<p>To the fullest extent permitted by law, Perch Bottle shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of or inability to use the website or products.</p>
<h5>5. Changes</h5>
<p>We reserve the right to modify these terms at any time. Your continued use of the website following any changes indicates your acceptance of the new terms.</p>
<p>If you have any questions about these Terms &amp; Conditions, please contact us.</p>",
                'is_active' => true,
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'content' => "<p>At Perch Bottle, we are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our website or make a purchase.</p>
<h5>Who we are</h5>
<p>We are the manufacturers of stainless steel bottles and lunchboxes under the brand name Perch. Our official website is: " . url('/') . ".</p>
<h5>Information we collect</h5>
<p>We collect information you provide when placing an order, subscribing to our newsletter, creating an account, or contacting us. This may include your name, email address, mailing address, phone number, and payment details.</p>
<h5>How we use your information</h5>
<p>We use your information to process orders, send order updates, respond to inquiries, send promotional communications (with your consent), and improve our website and services.</p>
<h5>Data security</h5>
<p>We implement appropriate security measures to protect your personal information. Sensitive data such as payment information is encrypted using SSL.</p>
<h5>Cookies</h5>
<p>We use cookies to enhance your browsing experience, remember your preferences, and understand how you use our website. You can control cookie settings through your browser.</p>
<h5>Your rights</h5>
<p>You may request access to, correction of, or deletion of your personal data. Contact us for any privacy-related requests.</p>
<p>We may update this Privacy Policy from time to time. Please review this page periodically for changes.</p>",
                'is_active' => true,
            ],
            [
                'slug' => 'return-and-refund',
                'title' => 'Return and Refund Policy',
                'content' => "<p>At Perch Bottle, we want you to be completely satisfied with your purchase. Please read our return and refund policy carefully.</p>
<h5>Return eligibility</h5>
<p>You may return most unused items in their original condition within 14 days of delivery for a full refund. Items must be in original packaging with tags attached.</p>
<h5>Non-returnable items</h5>
<p>Certain items such as personalised or custom-made products may not be eligible for return. Please check the product page before ordering.</p>
<h5>How to initiate a return</h5>
<p>Contact our customer support at the email or phone number provided on our Contact page. Include your order number and reason for return. We will provide you with return instructions and a Return Authorization if applicable.</p>
<h5>Refund process</h5>
<p>Once we receive and inspect your return, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed within 7–10 business days to your original payment method.</p>
<h5>Shipping costs</h5>
<p>Original shipping charges are non-refundable unless the return is due to our error or a defective product. You are responsible for return shipping costs unless otherwise stated.</p>
<h5>Damaged or defective items</h5>
<p>If you receive a damaged or defective item, please contact us within 48 hours of delivery with photos. We will arrange a replacement or full refund at no extra cost to you.</p>
<p>For any queries regarding returns or refunds, please reach out to our customer support team.</p>",
                'is_active' => true,
            ],
            [
                'slug' => 'cancellation-policy',
                'title' => 'Cancellation Policy',
                'content' => "<p>At Perch Bottle, we understand that sometimes plans change. Here is our cancellation policy for orders.</p>
<h5>Cancellation by customer</h5>
<p>You may cancel your order free of charge before it has been shipped. Once the order is dispatched, we cannot guarantee cancellation. Please contact us as soon as possible if you wish to cancel.</p>
<h5>How to cancel</h5>
<p>To cancel an order, email us at our contact email or call our customer support with your order number. We will confirm the cancellation and process any applicable refund.</p>
<h5>Cancellation by Perch Bottle</h5>
<p>We reserve the right to cancel an order in the following circumstances: (a) the product is out of stock, (b) we suspect fraudulent activity, (c) pricing or other errors on the website, or (d) force majeure. In such cases, you will receive a full refund if payment was already made.</p>
<h5>Refund after cancellation</h5>
<p>If your order is cancelled (by you or by us), any payment made will be refunded to the original payment method within 7–10 business days.</p>
<h5>Prepaid orders</h5>
<p>For orders paid online, the refund will be credited to the same card or payment account. For Cash on Delivery (COD) orders, cancellation before dispatch involves no charges.</p>
<p>If you have any questions about cancelling your order, please contact our customer support team.</p>",
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            PolicyPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
