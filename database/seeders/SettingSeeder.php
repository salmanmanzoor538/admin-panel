<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Settings
            [
                'key' => 'site_name',
                'value' => 'Admin Panel',
                'type' => 'string',
                'group' => 'site',
                'label' => 'Site Name',
                'description' => 'The name of your website',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'A modern admin panel and CMS built with Laravel and Filament',
                'type' => 'string',
                'group' => 'site',
                'label' => 'Site Description',
                'description' => 'Brief description of your website',
                'is_public' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'site_url',
                'value' => 'http://localhost',
                'type' => 'string',
                'group' => 'site',
                'label' => 'Site URL',
                'description' => 'The main URL of your website',
                'is_public' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'site_email',
                'value' => 'admin@example.com',
                'type' => 'string',
                'group' => 'site',
                'label' => 'Site Email',
                'description' => 'Main contact email address',
                'is_public' => true,
                'sort_order' => 4,
            ],
            [
                'key' => 'site_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'string',
                'group' => 'site',
                'label' => 'Site Phone',
                'description' => 'Main contact phone number',
                'is_public' => true,
                'sort_order' => 5,
            ],
            [
                'key' => 'site_address',
                'value' => '123 Business Street, City, State 12345',
                'type' => 'string',
                'group' => 'site',
                'label' => 'Site Address',
                'description' => 'Physical address of your business',
                'is_public' => true,
                'sort_order' => 6,
            ],

            // Blog Settings
            [
                'key' => 'posts_per_page',
                'value' => '10',
                'type' => 'integer',
                'group' => 'blog',
                'label' => 'Posts Per Page',
                'description' => 'Number of posts to display per page',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'featured_image_required',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'blog',
                'label' => 'Featured Image Required',
                'description' => 'Require featured image for posts',
                'is_public' => false,
                'sort_order' => 2,
            ],
            [
                'key' => 'allow_comments',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'blog',
                'label' => 'Allow Comments',
                'description' => 'Enable comments on posts',
                'is_public' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'auto_approve_comments',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'blog',
                'label' => 'Auto Approve Comments',
                'description' => 'Automatically approve comments',
                'is_public' => false,
                'sort_order' => 4,
            ],

            // SEO Settings
            [
                'key' => 'default_title',
                'value' => 'Admin Panel - Modern CMS',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Title',
                'description' => 'Default page title for SEO',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'default_description',
                'value' => 'A modern admin panel and CMS built with Laravel and Filament',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Description',
                'description' => 'Default meta description for SEO',
                'is_public' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'default_keywords',
                'value' => 'admin, panel, cms, laravel, filament',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Keywords',
                'description' => 'Default meta keywords for SEO',
                'is_public' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'twitter_card',
                'value' => 'summary',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Twitter Card Type',
                'description' => 'Type of Twitter card to display',
                'is_public' => true,
                'sort_order' => 4,
            ],

            // Theme Settings
            [
                'key' => 'default_theme',
                'value' => 'light',
                'type' => 'string',
                'group' => 'theme',
                'label' => 'Default Theme',
                'description' => 'Default theme for the website',
                'is_public' => true,
                'sort_order' => 1,
                'options' => json_encode([
                    'light' => 'Light',
                    'dark' => 'Dark',
                ]),
            ],
            [
                'key' => 'user_can_switch_theme',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'theme',
                'label' => 'User Can Switch Theme',
                'description' => 'Allow users to switch between light and dark themes',
                'is_public' => true,
                'sort_order' => 2,
            ],

            // Notification Settings
            [
                'key' => 'email_notifications_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Email Notifications',
                'description' => 'Enable email notifications',
                'is_public' => false,
                'sort_order' => 1,
            ],
            [
                'key' => 'sms_notifications_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'SMS Notifications',
                'description' => 'Enable SMS notifications',
                'is_public' => false,
                'sort_order' => 2,
            ],
            [
                'key' => 'push_notifications_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Push Notifications',
                'description' => 'Enable push notifications',
                'is_public' => false,
                'sort_order' => 3,
            ],

            // Media Settings
            [
                'key' => 'max_upload_size',
                'value' => '10240',
                'type' => 'integer',
                'group' => 'media',
                'label' => 'Max Upload Size (KB)',
                'description' => 'Maximum file upload size in kilobytes',
                'is_public' => false,
                'sort_order' => 1,
            ],
            [
                'key' => 'allowed_file_types',
                'value' => 'jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,zip',
                'type' => 'string',
                'group' => 'media',
                'label' => 'Allowed File Types',
                'description' => 'Comma-separated list of allowed file extensions',
                'is_public' => false,
                'sort_order' => 2,
            ],
            [
                'key' => 'image_quality',
                'value' => '90',
                'type' => 'integer',
                'group' => 'media',
                'label' => 'Image Quality',
                'description' => 'Image compression quality (1-100)',
                'is_public' => false,
                'sort_order' => 3,
            ],

            // Cache Settings
            [
                'key' => 'cache_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'cache',
                'label' => 'Cache Enabled',
                'description' => 'Enable caching for better performance',
                'is_public' => false,
                'sort_order' => 1,
            ],
            [
                'key' => 'cache_ttl',
                'value' => '3600',
                'type' => 'integer',
                'group' => 'cache',
                'label' => 'Cache TTL (seconds)',
                'description' => 'Cache time to live in seconds',
                'is_public' => false,
                'sort_order' => 2,
            ],

            // Social Media Settings
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Twitter profile URL',
                'is_public' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'is_public' => true,
                'sort_order' => 3,
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'LinkedIn profile URL',
                'is_public' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}