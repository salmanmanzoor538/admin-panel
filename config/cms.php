<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CMS Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the CMS module.
    | You can customize various aspects of the content management system.
    |
    */

    'site' => [
        'name' => env('SITE_NAME', 'Admin Panel'),
        'description' => env('SITE_DESCRIPTION', 'A modern admin panel and CMS'),
        'logo' => env('SITE_LOGO', '/assets/images/logo.png'),
        'favicon' => env('SITE_FAVICON', '/assets/images/favicon.ico'),
        'url' => env('SITE_URL', env('APP_URL')),
        'email' => env('SITE_EMAIL', 'admin@example.com'),
        'phone' => env('SITE_PHONE', '+1234567890'),
        'address' => env('SITE_ADDRESS', '123 Main St, City, Country'),
    ],

    'posts' => [
        'per_page' => env('POSTS_PER_PAGE', 10),
        'featured_image_required' => env('POSTS_FEATURED_IMAGE_REQUIRED', false),
        'allow_comments' => env('POSTS_ALLOW_COMMENTS', true),
        'auto_approve_comments' => env('POSTS_AUTO_APPROVE_COMMENTS', false),
    ],

    'pages' => [
        'per_page' => env('PAGES_PER_PAGE', 20),
        'allow_nested' => env('PAGES_ALLOW_NESTED', true),
        'max_depth' => env('PAGES_MAX_DEPTH', 3),
    ],

    'media' => [
        'disk' => env('MEDIA_DISK', 'public'),
        'max_file_size' => env('MAX_UPLOAD_SIZE', 10240), // KB
        'allowed_types' => explode(',', env('ALLOWED_FILE_TYPES', 'jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,zip')),
        'image_quality' => env('IMAGE_QUALITY', 90),
        'thumbnail_sizes' => [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [600, 600],
        ],
    ],

    'seo' => [
        'default_title' => env('SEO_DEFAULT_TITLE', 'Admin Panel'),
        'default_description' => env('SEO_DEFAULT_DESCRIPTION', 'A modern admin panel and CMS'),
        'default_keywords' => env('SEO_DEFAULT_KEYWORDS', 'admin, panel, cms, laravel'),
        'twitter_card' => env('SEO_TWITTER_CARD', 'summary'),
        'og_image' => env('SEO_OG_IMAGE', '/assets/images/og-image.jpg'),
    ],

    'notifications' => [
        'email_enabled' => env('NOTIFICATIONS_EMAIL_ENABLED', true),
        'sms_enabled' => env('NOTIFICATIONS_SMS_ENABLED', false),
        'push_enabled' => env('NOTIFICATIONS_PUSH_ENABLED', false),
    ],

    'themes' => [
        'default' => 'light',
        'available' => ['light', 'dark'],
        'user_can_switch' => env('THEME_USER_CAN_SWITCH', true),
    ],

    'languages' => [
        'default' => env('APP_LOCALE', 'en'),
        'available' => ['en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'ar'],
        'rtl_languages' => ['ar'],
    ],

    'cache' => [
        'enabled' => env('CMS_CACHE_ENABLED', true),
        'ttl' => env('CMS_CACHE_TTL', 3600), // seconds
        'tags' => ['cms', 'pages', 'posts', 'media'],
    ],

    'analytics' => [
        'google_analytics_id' => env('GOOGLE_ANALYTICS_ID'),
        'google_tag_manager_id' => env('GOOGLE_TAG_MANAGER_ID'),
        'facebook_pixel_id' => env('FACEBOOK_PIXEL_ID'),
    ],
];