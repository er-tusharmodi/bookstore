<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Seed the site settings.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => ['text' => 'BookNest'],
                'group' => 'branding',
                'description' => 'Primary site name used in headers and titles.',
            ],
            [
                'key' => 'site_tagline',
                'value' => ['text' => 'Curated books, trusted authors, fast discovery.'],
                'group' => 'branding',
                'description' => 'Short marketing tagline for the site.',
            ],
            [
                'key' => 'logo_path',
                'value' => ['text' => 'logo.png'],
                'group' => 'branding',
                'description' => 'Logo file path stored in public/ (dark mode).',
            ],
            [
                'key' => 'logo_light_path',
                'value' => ['text' => 'logo-light.png'],
                'group' => 'branding',
                'description' => 'Logo file path stored in public/ (light mode).',
            ],
            [
                'key' => 'logo_alt',
                'value' => ['text' => 'BookNest'],
                'group' => 'branding',
                'description' => 'Logo alt text for accessibility.',
            ],
            [
                'key' => 'favicon_path',
                'value' => ['text' => 'favicon.ico'],
                'group' => 'branding',
                'description' => 'Favicon file path stored in public/.',
            ],
            [
                'key' => 'logo_height',
                'value' => ['text' => '40px'],
                'group' => 'branding',
                'description' => 'Logo height (e.g. 40px).',
            ],
            [
                'key' => 'contact_email',
                'value' => ['text' => 'hello@booknest.test'],
                'group' => 'contact',
                'description' => 'Primary contact email address.',
            ],
            [
                'key' => 'contact_phone',
                'value' => ['text' => '+1-555-0100'],
                'group' => 'contact',
                'description' => 'Primary contact phone number.',
            ],
            [
                'key' => 'address',
                'value' => ['text' => '24 Harbor Lane, Seattle, WA'],
                'group' => 'contact',
                'description' => 'Business address shown in footer and invoices.',
            ],
            [
                'key' => 'footer_text',
                'value' => ['text' => 'Built for readers.'],
                'group' => 'branding',
                'description' => 'Footer short text snippet.',
            ],
            [
                'key' => 'social_links',
                'value' => [
                    'twitter' => 'https://x.com/booknest',
                    'instagram' => 'https://instagram.com/booknest',
                    'facebook' => 'https://facebook.com/booknest',
                    'linkedin' => 'https://linkedin.com/company/booknest',
                ],
                'group' => 'social',
                'description' => 'Social profile URLs used in the footer.',
            ],
            [
                'key' => 'support_links',
                'value' => [
                    [
                        'title' => 'Help Center',
                        'text' => 'Get quick help and FAQs',
                    ],
                    [
                        'title' => 'Legacy Catalog',
                        'text' => 'Open the classic catalog route',
                    ],
                    [
                        'title' => 'Contact Authors',
                        'text' => 'Browse and connect with authors',
                    ],
                ],
                'group' => 'support',
                'description' => 'Support links in the footer.',
            ],
            [
                'key' => 'currency',
                'value' => ['text' => 'USD'],
                'group' => 'commerce',
                'description' => 'Default currency code for pricing displays.',
            ],
            [
                'key' => 'timezone',
                'value' => ['text' => 'America/Los_Angeles'],
                'group' => 'system',
                'description' => 'Primary timezone for reports and emails.',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'description' => $setting['description'],
                ]
            );
        }
    }
}
