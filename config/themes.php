<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the advanced theme system including glassmorphism,
    | custom themes, and theme switching capabilities.
    |
    */

    'default_theme' => env('DEFAULT_THEME', 'light'),

    'available_themes' => [
        'light' => [
            'name' => 'Light',
            'description' => 'Clean and modern light theme',
            'colors' => [
                'primary' => '#3B82F6',
                'secondary' => '#64748B',
                'accent' => '#F59E0B',
                'background' => '#FFFFFF',
                'surface' => '#F8FAFC',
                'text' => '#1E293B',
                'text_secondary' => '#64748B',
                'border' => '#E2E8F0',
                'success' => '#10B981',
                'warning' => '#F59E0B',
                'error' => '#EF4444',
                'info' => '#06B6D4',
            ],
            'effects' => [
                'glassmorphism' => false,
                'blur' => false,
                'shadow' => 'medium',
                'border_radius' => 'medium',
            ],
        ],

        'dark' => [
            'name' => 'Dark',
            'description' => 'Elegant dark theme',
            'colors' => [
                'primary' => '#60A5FA',
                'secondary' => '#94A3B8',
                'accent' => '#FBBF24',
                'background' => '#0F172A',
                'surface' => '#1E293B',
                'text' => '#F1F5F9',
                'text_secondary' => '#94A3B8',
                'border' => '#334155',
                'success' => '#34D399',
                'warning' => '#FBBF24',
                'error' => '#F87171',
                'info' => '#22D3EE',
            ],
            'effects' => [
                'glassmorphism' => false,
                'blur' => false,
                'shadow' => 'medium',
                'border_radius' => 'medium',
            ],
        ],

        'glassmorphism' => [
            'name' => 'Glassmorphism',
            'description' => 'Modern glassmorphism design',
            'colors' => [
                'primary' => '#3B82F6',
                'secondary' => '#64748B',
                'accent' => '#F59E0B',
                'background' => 'rgba(255, 255, 255, 0.1)',
                'surface' => 'rgba(255, 255, 255, 0.2)',
                'text' => '#FFFFFF',
                'text_secondary' => 'rgba(255, 255, 255, 0.8)',
                'border' => 'rgba(255, 255, 255, 0.3)',
                'success' => '#10B981',
                'warning' => '#F59E0B',
                'error' => '#EF4444',
                'info' => '#06B6D4',
            ],
            'effects' => [
                'glassmorphism' => true,
                'blur' => true,
                'shadow' => 'large',
                'border_radius' => 'large',
                'backdrop_blur' => '20px',
                'background_image' => 'gradient',
            ],
        ],

        'cyberpunk' => [
            'name' => 'Cyberpunk',
            'description' => 'Futuristic cyberpunk theme',
            'colors' => [
                'primary' => '#00FFFF',
                'secondary' => '#FF00FF',
                'accent' => '#FFFF00',
                'background' => '#0A0A0A',
                'surface' => '#1A1A1A',
                'text' => '#00FF00',
                'text_secondary' => '#FFFF00',
                'border' => '#00FFFF',
                'success' => '#00FF00',
                'warning' => '#FFFF00',
                'error' => '#FF0000',
                'info' => '#00FFFF',
            ],
            'effects' => [
                'glassmorphism' => false,
                'blur' => false,
                'shadow' => 'large',
                'border_radius' => 'small',
                'neon_glow' => true,
                'scanlines' => true,
            ],
        ],

        'minimal' => [
            'name' => 'Minimal',
            'description' => 'Clean minimal design',
            'colors' => [
                'primary' => '#000000',
                'secondary' => '#666666',
                'accent' => '#000000',
                'background' => '#FFFFFF',
                'surface' => '#FFFFFF',
                'text' => '#000000',
                'text_secondary' => '#666666',
                'border' => '#E5E5E5',
                'success' => '#000000',
                'warning' => '#000000',
                'error' => '#000000',
                'info' => '#000000',
            ],
            'effects' => [
                'glassmorphism' => false,
                'blur' => false,
                'shadow' => 'none',
                'border_radius' => 'none',
                'minimal' => true,
            ],
        ],

        'nature' => [
            'name' => 'Nature',
            'description' => 'Inspired by nature colors',
            'colors' => [
                'primary' => '#059669',
                'secondary' => '#6B7280',
                'accent' => '#D97706',
                'background' => '#F0FDF4',
                'surface' => '#FFFFFF',
                'text' => '#064E3B',
                'text_secondary' => '#6B7280',
                'border' => '#D1FAE5',
                'success' => '#059669',
                'warning' => '#D97706',
                'error' => '#DC2626',
                'info' => '#0891B2',
            ],
            'effects' => [
                'glassmorphism' => false,
                'blur' => false,
                'shadow' => 'soft',
                'border_radius' => 'large',
                'nature_inspired' => true,
            ],
        ],
    ],

    'custom_themes' => [
        // Users can create custom themes that will be stored here
    ],

    'theme_switcher' => [
        'enabled' => env('THEME_SWITCHER_ENABLED', true),
        'show_preview' => true,
        'allow_custom' => true,
        'auto_save' => true,
    ],

    'css_variables' => [
        'enabled' => true,
        'prefix' => '--theme-',
    ],

    'effects' => [
        'glassmorphism' => [
            'backdrop_filter' => 'blur(20px)',
            'background' => 'rgba(255, 255, 255, 0.1)',
            'border' => '1px solid rgba(255, 255, 255, 0.2)',
            'box_shadow' => '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
        ],
        'blur' => [
            'backdrop_filter' => 'blur(10px)',
        ],
        'shadows' => [
            'none' => 'none',
            'small' => '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
            'medium' => '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            'large' => '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            'soft' => '0 2px 8px 0 rgba(0, 0, 0, 0.1)',
        ],
        'border_radius' => [
            'none' => '0px',
            'small' => '0.25rem',
            'medium' => '0.5rem',
            'large' => '1rem',
        ],
    ],

    'animations' => [
        'enabled' => env('THEME_ANIMATIONS_ENABLED', true),
        'duration' => '0.3s',
        'easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
        'transitions' => [
            'theme_switch' => 'all 0.3s ease-in-out',
            'hover' => 'all 0.2s ease-in-out',
            'focus' => 'all 0.15s ease-in-out',
        ],
    ],

    'responsive' => [
        'mobile_optimized' => true,
        'tablet_optimized' => true,
        'desktop_optimized' => true,
    ],

    'accessibility' => [
        'high_contrast_mode' => true,
        'reduced_motion' => true,
        'focus_indicators' => true,
        'color_blind_friendly' => true,
    ],
];