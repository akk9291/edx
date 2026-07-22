<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Payment Methods',
                'slug' => 'payment-methods',
                'sort_order' => 1,
                'items' => [
                    ['question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit/debit cards, UPI, net banking, and other online payment methods through our secure payment gateway.'],
                    ['question' => 'Is it safe to pay online?', 'answer' => 'Yes. We use industry-standard encryption and secure payment gateways. Your card details are never stored on our servers.'],
                ],
            ],
            [
                'name' => 'Delivery',
                'slug' => 'delivery',
                'sort_order' => 2,
                'items' => [
                    ['question' => 'How can I track my order?', 'answer' => 'Once your order is shipped, you will receive a tracking link via email/SMS. You can also track your order from the Order History section in your account.'],
                    ['question' => 'What are the delivery charges?', 'answer' => 'We offer FREE shipping on all orders over ₹75. For orders below that, standard delivery charges apply at checkout.'],
                    ['question' => 'How long does delivery take?', 'answer' => 'Standard delivery takes 3–7 business days. Express delivery options may be available at checkout for faster shipping.'],
                ],
            ],
            [
                'name' => 'Exchanges & Returns',
                'slug' => 'exchanges-returns',
                'sort_order' => 3,
                'items' => [
                    ['question' => 'What is your return policy?', 'answer' => 'You can return most items within 14 days of delivery if they are unused and in original packaging. Some items may be excluded.'],
                    ['question' => 'How do I exchange an item?', 'answer' => 'Contact our support team with your order number. We will guide you through the exchange process and arrange a replacement.'],
                ],
            ],
            [
                'name' => 'Registration',
                'slug' => 'registration',
                'sort_order' => 4,
                'items' => [
                    ['question' => 'Do I need to create an account to order?', 'answer' => 'You can checkout as a guest, but creating an account lets you track orders, save addresses, and manage wishlists.'],
                    ['question' => 'How do I reset my password?', 'answer' => 'Click "Forgot Password" on the login page. Enter your email and we will send you a link to reset your password.'],
                ],
            ],
            [
                'name' => 'Look After Your Garments',
                'slug' => 'look-after-your-garments',
                'sort_order' => 5,
                'items' => [
                    ['question' => 'How should I wash my garments?', 'answer' => 'Check the care label on each item. Generally, we recommend gentle wash, cold water, and air drying for best results.'],
                    ['question' => 'Can I iron these products?', 'answer' => 'Yes, but use low to medium heat and iron on the reverse side when possible to protect the fabric.'],
                ],
            ],
            [
                'name' => 'Contacts',
                'slug' => 'contacts',
                'sort_order' => 6,
                'items' => [
                    ['question' => 'How can I reach customer support?', 'answer' => 'You can email us, use the contact form on our website, or call our helpline during business hours.'],
                    ['question' => 'What are your business hours?', 'answer' => 'Our customer support team is available Monday–Saturday, 9 AM–6 PM. We respond to emails within 24 hours.'],
                ],
            ],
        ];

        foreach ($categories as $cat) {
            $category = FaqCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'sort_order' => $cat['sort_order'],
                    'is_active' => true,
                ]
            );

            if ($category->items()->count() === 0) {
                foreach ($cat['items'] as $i => $item) {
                    FaqItem::create([
                        'faq_category_id' => $category->id,
                        'question' => $item['question'],
                        'answer' => $item['answer'],
                        'sort_order' => $i + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
