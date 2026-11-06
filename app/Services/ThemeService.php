<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ThemeService
{
    protected $currentTheme;
    protected $availableThemes;

    public function __construct()
    {
        $this->availableThemes = config('themes.available_themes', []);
        $this->currentTheme = $this->getCurrentTheme();
    }

    /**
     * Get the current active theme
     */
    public function getCurrentTheme(): string
    {
        if (auth()->check()) {
            return auth()->user()->theme_preference ?? config('themes.default_theme', 'light');
        }

        return session('theme', config('themes.default_theme', 'light'));
    }

    /**
     * Set the current theme
     */
    public function setTheme(string $themeName): bool
    {
        if (!$this->isThemeAvailable($themeName)) {
            return false;
        }

        $this->currentTheme = $themeName;

        if (auth()->check()) {
            auth()->user()->update(['theme_preference' => $themeName]);
        } else {
            session(['theme' => $themeName]);
        }

        $this->generateThemeCSS();
        
        return true;
    }

    /**
     * Get all available themes
     */
    public function getAvailableThemes(): array
    {
        $themes = config('themes.available_themes', []);
        $customThemes = config('themes.custom_themes', []);

        return array_merge($themes, $customThemes);
    }

    /**
     * Get theme configuration
     */
    public function getThemeConfig(string $themeName = null): array
    {
        $themeName = $themeName ?? $this->currentTheme;
        $themes = $this->getAvailableThemes();

        return $themes[$themeName] ?? $themes['light'];
    }

    /**
     * Check if theme is available
     */
    public function isThemeAvailable(string $themeName): bool
    {
        $themes = $this->getAvailableThemes();
        return array_key_exists($themeName, $themes);
    }

    /**
     * Get theme colors as CSS variables
     */
    public function getThemeColors(string $themeName = null): array
    {
        $config = $this->getThemeConfig($themeName);
        $colors = $config['colors'] ?? [];

        $cssVariables = [];
        foreach ($colors as $key => $value) {
            $cssVariables["--theme-{$key}"] = $value;
        }

        return $cssVariables;
    }

    /**
     * Get theme effects
     */
    public function getThemeEffects(string $themeName = null): array
    {
        $config = $this->getThemeConfig($themeName);
        return $config['effects'] ?? [];
    }

    /**
     * Generate CSS for the current theme
     */
    public function generateThemeCSS(): string
    {
        $themeName = $this->currentTheme;
        $cacheKey = "theme_css_{$themeName}";

        return Cache::remember($cacheKey, 3600, function () use ($themeName) {
            $config = $this->getThemeConfig($themeName);
            $colors = $config['colors'] ?? [];
            $effects = $config['effects'] ?? [];

            $css = ":root {\n";
            
            // Generate color variables
            foreach ($colors as $key => $value) {
                $css .= "  --theme-{$key}: {$value};\n";
            }

            // Generate effect variables
            if ($effects['glassmorphism'] ?? false) {
                $css .= "  --theme-glassmorphism: true;\n";
                $css .= "  --theme-backdrop-blur: {$effects['backdrop_blur'] ?? '20px'};\n";
            }

            if ($effects['blur'] ?? false) {
                $css .= "  --theme-blur: true;\n";
            }

            $css .= "  --theme-shadow: " . ($this->getShadowValue($effects['shadow'] ?? 'medium')) . ";\n";
            $css .= "  --theme-border-radius: " . ($this->getBorderRadiusValue($effects['border_radius'] ?? 'medium')) . ";\n";

            $css .= "}\n\n";

            // Generate theme-specific styles
            $css .= $this->generateThemeSpecificStyles($themeName, $effects);

            return $css;
        });
    }

    /**
     * Generate theme-specific styles
     */
    protected function generateThemeSpecificStyles(string $themeName, array $effects): string
    {
        $css = '';

        // Glassmorphism styles
        if ($effects['glassmorphism'] ?? false) {
            $css .= "
.glassmorphism {
    background: var(--theme-surface);
    backdrop-filter: blur(var(--theme-backdrop-blur));
    border: 1px solid var(--theme-border);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

.glassmorphism-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--theme-border-radius);
    box-shadow: var(--theme-shadow);
}
";
        }

        // Cyberpunk styles
        if ($themeName === 'cyberpunk') {
            $css .= "
.cyberpunk-glow {
    box-shadow: 0 0 20px var(--theme-primary);
    animation: cyberpunk-glow 2s ease-in-out infinite alternate;
}

@keyframes cyberpunk-glow {
    from { box-shadow: 0 0 20px var(--theme-primary); }
    to { box-shadow: 0 0 30px var(--theme-primary), 0 0 40px var(--theme-secondary); }
}

.cyberpunk-text {
    text-shadow: 0 0 10px var(--theme-primary);
}

.scanlines {
    position: relative;
    overflow: hidden;
}

.scanlines::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 2px,
        rgba(0, 255, 255, 0.03) 2px,
        rgba(0, 255, 255, 0.03) 4px
    );
    pointer-events: none;
}
";
        }

        // Minimal styles
        if ($themeName === 'minimal') {
            $css .= "
.minimal-card {
    background: var(--theme-surface);
    border: 1px solid var(--theme-border);
    box-shadow: none;
}

.minimal-button {
    background: transparent;
    border: 1px solid var(--theme-primary);
    color: var(--theme-primary);
    transition: all 0.2s ease;
}

.minimal-button:hover {
    background: var(--theme-primary);
    color: var(--theme-background);
}
";
        }

        // Nature styles
        if ($themeName === 'nature') {
            $css .= "
.nature-gradient {
    background: linear-gradient(135deg, var(--theme-background) 0%, #D1FAE5 100%);
}

.nature-card {
    background: var(--theme-surface);
    border: 1px solid var(--theme-border);
    border-radius: var(--theme-border-radius);
    box-shadow: var(--theme-shadow);
    position: relative;
    overflow: hidden;
}

.nature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--theme-success), var(--theme-accent));
}
";
        }

        return $css;
    }

    /**
     * Get shadow value
     */
    protected function getShadowValue(string $shadowType): string
    {
        $shadows = config('themes.effects.shadows', []);
        return $shadows[$shadowType] ?? $shadows['medium'];
    }

    /**
     * Get border radius value
     */
    protected function getBorderRadiusValue(string $radiusType): string
    {
        $radiuses = config('themes.effects.border_radius', []);
        return $radiuses[$radiusType] ?? $radiuses['medium'];
    }

    /**
     * Create custom theme
     */
    public function createCustomTheme(string $name, array $config): bool
    {
        $customThemes = config('themes.custom_themes', []);
        $customThemes[$name] = $config;

        // Save to config file
        $configPath = config_path('themes.php');
        $configContent = File::get($configPath);
        
        $customThemesJson = json_encode($customThemes, JSON_PRETTY_PRINT);
        $newConfigContent = preg_replace(
            '/\'custom_themes\' => \[[^\]]*\]/s',
            "'custom_themes' => {$customThemesJson}",
            $configContent
        );

        File::put($configPath, $newConfigContent);
        
        // Clear cache
        Cache::forget("theme_css_{$name}");
        
        return true;
    }

    /**
     * Delete custom theme
     */
    public function deleteCustomTheme(string $name): bool
    {
        if (!$this->isCustomTheme($name)) {
            return false;
        }

        $customThemes = config('themes.custom_themes', []);
        unset($customThemes[$name]);

        // Save to config file
        $configPath = config_path('themes.php');
        $configContent = File::get($configPath);
        
        $customThemesJson = json_encode($customThemes, JSON_PRETTY_PRINT);
        $newConfigContent = preg_replace(
            '/\'custom_themes\' => \[[^\]]*\]/s',
            "'custom_themes' => {$customThemesJson}",
            $configContent
        );

        File::put($configPath, $newConfigContent);
        
        // Clear cache
        Cache::forget("theme_css_{$name}");
        
        return true;
    }

    /**
     * Check if theme is custom
     */
    public function isCustomTheme(string $name): bool
    {
        $customThemes = config('themes.custom_themes', []);
        return array_key_exists($name, $customThemes);
    }

    /**
     * Get theme preview data
     */
    public function getThemePreview(string $themeName): array
    {
        $config = $this->getThemeConfig($themeName);
        
        return [
            'name' => $config['name'] ?? $themeName,
            'description' => $config['description'] ?? '',
            'colors' => $config['colors'] ?? [],
            'effects' => $config['effects'] ?? [],
            'preview_url' => route('themes.preview', $themeName),
        ];
    }

    /**
     * Clear theme cache
     */
    public function clearThemeCache(): void
    {
        $themes = $this->getAvailableThemes();
        
        foreach (array_keys($themes) as $themeName) {
            Cache::forget("theme_css_{$themeName}");
        }
    }

    /**
     * Get theme switcher configuration
     */
    public function getThemeSwitcherConfig(): array
    {
        return config('themes.theme_switcher', []);
    }

    /**
     * Is theme switcher enabled
     */
    public function isThemeSwitcherEnabled(): bool
    {
        return config('themes.theme_switcher.enabled', true);
    }
}