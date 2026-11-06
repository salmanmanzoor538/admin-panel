<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for AI-powered features including OpenAI integration
    | and content generation capabilities.
    |
    */

    'enabled' => env('AI_ENABLED', false),

    'openai_api_key' => env('OPENAI_API_KEY'),
    'openai_base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
    'default_model' => env('AI_DEFAULT_MODEL', 'gpt-3.5-turbo'),

    'cache_ttl' => env('AI_CACHE_TTL', 3600), // Cache AI responses for 1 hour

    'rate_limits' => [
        'requests_per_minute' => env('AI_RATE_LIMIT', 60),
        'tokens_per_minute' => env('AI_TOKEN_LIMIT', 90000),
    ],

    'content_generation' => [
        'blog_post' => [
            'max_tokens' => 2000,
            'temperature' => 0.7,
        ],
        'seo_description' => [
            'max_tokens' => 200,
            'temperature' => 0.5,
        ],
        'page_content' => [
            'max_tokens' => 1500,
            'temperature' => 0.6,
        ],
        'chatbot' => [
            'max_tokens' => 500,
            'temperature' => 0.3,
        ],
    ],

    'supported_models' => [
        'gpt-3.5-turbo' => [
            'name' => 'GPT-3.5 Turbo',
            'description' => 'Fast and cost-effective',
            'max_tokens' => 4096,
        ],
        'gpt-4' => [
            'name' => 'GPT-4',
            'description' => 'High quality responses',
            'max_tokens' => 8192,
        ],
        'gpt-4-turbo' => [
            'name' => 'GPT-4 Turbo',
            'description' => 'Latest model with best quality',
            'max_tokens' => 128000,
        ],
    ],

    'fallback_responses' => [
        'error' => 'I apologize, but I\'m experiencing technical difficulties. Please try again later.',
        'rate_limit' => 'I\'ve reached my usage limit. Please wait a moment before trying again.',
        'unavailable' => 'AI services are temporarily unavailable. Please try again later.',
    ],
];