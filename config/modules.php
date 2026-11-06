<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Module Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for all available modules in the admin panel.
    | Enable or disable modules as needed for your application.
    |
    */

    'enabled' => [
        'blog' => env('MODULE_BLOG_ENABLED', true),
        'ecommerce' => env('MODULE_ECOMMERCE_ENABLED', true),
        'lms' => env('MODULE_LMS_ENABLED', true),
        'crm' => env('MODULE_CRM_ENABLED', true),
        'forms' => env('MODULE_FORMS_ENABLED', true),
        'ai' => env('MODULE_AI_ENABLED', true),
        'analytics' => env('MODULE_ANALYTICS_ENABLED', true),
        'notifications' => env('MODULE_NOTIFICATIONS_ENABLED', true),
        'backup' => env('MODULE_BACKUP_ENABLED', true),
        'multi_tenant' => env('MODULE_MULTI_TENANT_ENABLED', true),
    ],

    'blog' => [
        'enabled' => env('MODULE_BLOG_ENABLED', true),
        'features' => [
            'ai_content_generation' => env('BLOG_AI_CONTENT', true),
            'seo_optimization' => env('BLOG_SEO', true),
            'social_sharing' => env('BLOG_SOCIAL_SHARING', true),
            'comments' => env('BLOG_COMMENTS', true),
            'categories' => env('BLOG_CATEGORIES', true),
            'tags' => env('BLOG_TAGS', true),
            'featured_posts' => env('BLOG_FEATURED', true),
            'related_posts' => env('BLOG_RELATED', true),
            'reading_time' => env('BLOG_READING_TIME', true),
            'views_tracking' => env('BLOG_VIEWS', true),
        ],
        'settings' => [
            'posts_per_page' => env('BLOG_POSTS_PER_PAGE', 10),
            'excerpt_length' => env('BLOG_EXCERPT_LENGTH', 150),
            'auto_save_drafts' => env('BLOG_AUTO_SAVE', true),
            'require_approval' => env('BLOG_REQUIRE_APPROVAL', false),
            'allow_guest_comments' => env('BLOG_GUEST_COMMENTS', false),
        ],
    ],

    'ecommerce' => [
        'enabled' => env('MODULE_ECOMMERCE_ENABLED', true),
        'features' => [
            'products' => env('ECOMMERCE_PRODUCTS', true),
            'categories' => env('ECOMMERCE_CATEGORIES', true),
            'orders' => env('ECOMMERCE_ORDERS', true),
            'payments' => env('ECOMMERCE_PAYMENTS', true),
            'inventory' => env('ECOMMERCE_INVENTORY', true),
            'shipping' => env('ECOMMERCE_SHIPPING', true),
            'taxes' => env('ECOMMERCE_TAXES', true),
            'coupons' => env('ECOMMERCE_COUPONS', true),
            'reviews' => env('ECOMMERCE_REVIEWS', true),
            'wishlist' => env('ECOMMERCE_WISHLIST', true),
            'compare' => env('ECOMMERCE_COMPARE', true),
            'variations' => env('ECOMMERCE_VARIATIONS', true),
        ],
        'payment_gateways' => [
            'stripe' => env('PAYMENT_STRIPE_ENABLED', true),
            'paypal' => env('PAYMENT_PAYPAL_ENABLED', true),
            'square' => env('PAYMENT_SQUARE_ENABLED', false),
            'razorpay' => env('PAYMENT_RAZORPAY_ENABLED', false),
        ],
        'settings' => [
            'currency' => env('ECOMMERCE_CURRENCY', 'USD'),
            'tax_rate' => env('ECOMMERCE_TAX_RATE', 8.5),
            'shipping_cost' => env('ECOMMERCE_SHIPPING_COST', 9.99),
            'free_shipping_threshold' => env('ECOMMERCE_FREE_SHIPPING', 100),
            'low_stock_threshold' => env('ECOMMERCE_LOW_STOCK', 10),
            'require_shipping' => env('ECOMMERCE_REQUIRE_SHIPPING', true),
        ],
    ],

    'lms' => [
        'enabled' => env('MODULE_LMS_ENABLED', true),
        'features' => [
            'courses' => env('LMS_COURSES', true),
            'lessons' => env('LMS_LESSONS', true),
            'quizzes' => env('LMS_QUIZZES', true),
            'certificates' => env('LMS_CERTIFICATES', true),
            'enrollments' => env('LMS_ENROLLMENTS', true),
            'progress_tracking' => env('LMS_PROGRESS', true),
            'discussions' => env('LMS_DISCUSSIONS', true),
            'assignments' => env('LMS_ASSIGNMENTS', true),
            'live_streaming' => env('LMS_LIVE_STREAMING', false),
            'mobile_app' => env('LMS_MOBILE_APP', false),
        ],
        'settings' => [
            'default_currency' => env('LMS_CURRENCY', 'USD'),
            'certificate_template' => env('LMS_CERTIFICATE_TEMPLATE', 'default'),
            'allow_guest_enrollment' => env('LMS_GUEST_ENROLLMENT', false),
            'require_approval' => env('LMS_REQUIRE_APPROVAL', false),
            'max_file_size' => env('LMS_MAX_FILE_SIZE', 104857600), // 100MB
            'supported_formats' => env('LMS_SUPPORTED_FORMATS', 'mp4,mp3,pdf,doc,docx'),
        ],
    ],

    'crm' => [
        'enabled' => env('MODULE_CRM_ENABLED', true),
        'features' => [
            'clients' => env('CRM_CLIENTS', true),
            'deals' => env('CRM_DEALS', true),
            'contacts' => env('CRM_CONTACTS', true),
            'activities' => env('CRM_ACTIVITIES', true),
            'tasks' => env('CRM_TASKS', true),
            'notes' => env('CRM_NOTES', true),
            'documents' => env('CRM_DOCUMENTS', true),
            'pipeline' => env('CRM_PIPELINE', true),
            'reports' => env('CRM_REPORTS', true),
            'automation' => env('CRM_AUTOMATION', false),
            'integrations' => env('CRM_INTEGRATIONS', true),
        ],
        'settings' => [
            'default_currency' => env('CRM_CURRENCY', 'USD'),
            'deal_stages' => env('CRM_DEAL_STAGES', 'lead,qualified,proposal,negotiation,closed'),
            'activity_reminders' => env('CRM_ACTIVITY_REMINDERS', true),
            'auto_assignment' => env('CRM_AUTO_ASSIGNMENT', false),
            'lead_scoring' => env('CRM_LEAD_SCORING', true),
        ],
    ],

    'forms' => [
        'enabled' => env('MODULE_FORMS_ENABLED', true),
        'features' => [
            'form_builder' => env('FORMS_BUILDER', true),
            'drag_drop' => env('FORMS_DRAG_DROP', true),
            'conditional_logic' => env('FORMS_CONDITIONAL', true),
            'file_uploads' => env('FORMS_FILE_UPLOADS', true),
            'email_notifications' => env('FORMS_EMAIL_NOTIFICATIONS', true),
            'spam_protection' => env('FORMS_SPAM_PROTECTION', true),
            'analytics' => env('FORMS_ANALYTICS', true),
            'integrations' => env('FORMS_INTEGRATIONS', true),
        ],
        'settings' => [
            'max_file_size' => env('FORMS_MAX_FILE_SIZE', 10485760), // 10MB
            'allowed_file_types' => env('FORMS_ALLOWED_TYPES', 'jpg,jpeg,png,pdf,doc,docx'),
            'spam_threshold' => env('FORMS_SPAM_THRESHOLD', 5),
            'auto_save' => env('FORMS_AUTO_SAVE', true),
        ],
    ],

    'ai' => [
        'enabled' => env('MODULE_AI_ENABLED', true),
        'features' => [
            'content_generation' => env('AI_CONTENT_GENERATION', true),
            'seo_optimization' => env('AI_SEO_OPTIMIZATION', true),
            'chatbot' => env('AI_CHATBOT', true),
            'image_generation' => env('AI_IMAGE_GENERATION', false),
            'translation' => env('AI_TRANSLATION', false),
            'sentiment_analysis' => env('AI_SENTIMENT_ANALYSIS', false),
        ],
        'settings' => [
            'provider' => env('AI_PROVIDER', 'openai'),
            'api_key' => env('AI_API_KEY'),
            'model' => env('AI_MODEL', 'gpt-3.5-turbo'),
            'max_tokens' => env('AI_MAX_TOKENS', 1000),
            'temperature' => env('AI_TEMPERATURE', 0.7),
            'cache_enabled' => env('AI_CACHE_ENABLED', true),
            'cache_ttl' => env('AI_CACHE_TTL', 3600),
        ],
    ],

    'analytics' => [
        'enabled' => env('MODULE_ANALYTICS_ENABLED', true),
        'features' => [
            'page_views' => env('ANALYTICS_PAGE_VIEWS', true),
            'user_tracking' => env('ANALYTICS_USER_TRACKING', true),
            'conversion_tracking' => env('ANALYTICS_CONVERSIONS', true),
            'custom_events' => env('ANALYTICS_CUSTOM_EVENTS', true),
            'reports' => env('ANALYTICS_REPORTS', true),
            'dashboards' => env('ANALYTICS_DASHBOARDS', true),
            'real_time' => env('ANALYTICS_REAL_TIME', true),
        ],
        'settings' => [
            'retention_days' => env('ANALYTICS_RETENTION_DAYS', 365),
            'sample_rate' => env('ANALYTICS_SAMPLE_RATE', 100),
            'privacy_mode' => env('ANALYTICS_PRIVACY_MODE', false),
            'gdpr_compliant' => env('ANALYTICS_GDPR_COMPLIANT', true),
        ],
    ],

    'notifications' => [
        'enabled' => env('MODULE_NOTIFICATIONS_ENABLED', true),
        'features' => [
            'in_app' => env('NOTIFICATIONS_IN_APP', true),
            'email' => env('NOTIFICATIONS_EMAIL', true),
            'sms' => env('NOTIFICATIONS_SMS', false),
            'push' => env('NOTIFICATIONS_PUSH', false),
            'webhooks' => env('NOTIFICATIONS_WEBHOOKS', true),
            'templates' => env('NOTIFICATIONS_TEMPLATES', true),
            'scheduling' => env('NOTIFICATIONS_SCHEDULING', true),
        ],
        'settings' => [
            'email_from' => env('NOTIFICATIONS_EMAIL_FROM', 'noreply@example.com'),
            'sms_provider' => env('NOTIFICATIONS_SMS_PROVIDER', 'twilio'),
            'push_provider' => env('NOTIFICATIONS_PUSH_PROVIDER', 'firebase'),
            'batch_size' => env('NOTIFICATIONS_BATCH_SIZE', 100),
            'retry_attempts' => env('NOTIFICATIONS_RETRY_ATTEMPTS', 3),
        ],
    ],

    'backup' => [
        'enabled' => env('MODULE_BACKUP_ENABLED', true),
        'features' => [
            'database' => env('BACKUP_DATABASE', true),
            'files' => env('BACKUP_FILES', true),
            'scheduled' => env('BACKUP_SCHEDULED', true),
            'cloud_storage' => env('BACKUP_CLOUD_STORAGE', true),
            'encryption' => env('BACKUP_ENCRYPTION', true),
            'compression' => env('BACKUP_COMPRESSION', true),
        ],
        'settings' => [
            'retention_days' => env('BACKUP_RETENTION_DAYS', 30),
            'max_backups' => env('BACKUP_MAX_BACKUPS', 10),
            'storage_disk' => env('BACKUP_STORAGE_DISK', 'local'),
            'encryption_key' => env('BACKUP_ENCRYPTION_KEY'),
            'cloud_provider' => env('BACKUP_CLOUD_PROVIDER', 's3'),
        ],
    ],

    'multi_tenant' => [
        'enabled' => env('MODULE_MULTI_TENANT_ENABLED', true),
        'features' => [
            'tenant_isolation' => env('TENANT_ISOLATION', true),
            'custom_domains' => env('TENANT_CUSTOM_DOMAINS', true),
            'tenant_settings' => env('TENANT_SETTINGS', true),
            'tenant_billing' => env('TENANT_BILLING', false),
            'tenant_analytics' => env('TENANT_ANALYTICS', true),
        ],
        'settings' => [
            'tenant_model' => env('TENANT_MODEL', 'App\\Models\\Tenant'),
            'domain_model' => env('DOMAIN_MODEL', 'App\\Models\\Domain'),
            'central_domains' => env('CENTRAL_DOMAINS', 'localhost,127.0.0.1'),
            'tenant_connection' => env('TENANT_CONNECTION', 'tenant'),
            'cache_tenant_resolution' => env('CACHE_TENANT_RESOLUTION', true),
        ],
    ],

    'dependencies' => [
        'ecommerce' => ['blog'],
        'lms' => ['blog'],
        'crm' => ['blog'],
        'forms' => ['blog'],
        'analytics' => ['blog'],
        'notifications' => ['blog'],
        'backup' => [],
        'ai' => [],
        'multi_tenant' => [],
    ],

    'load_order' => [
        'multi_tenant',
        'blog',
        'ai',
        'forms',
        'ecommerce',
        'lms',
        'crm',
        'analytics',
        'notifications',
        'backup',
    ],
];