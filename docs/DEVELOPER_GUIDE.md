# 🚀 Admin Panel Developer Guide

## Table of Contents
1. [Overview](#overview)
2. [Installation](#installation)
3. [Project Structure](#project-structure)
4. [Customization](#customization)
5. [Components](#components)
6. [Themes](#themes)
7. [API Documentation](#api-documentation)
8. [Best Practices](#best-practices)
9. [Troubleshooting](#troubleshooting)

## Overview

This Admin Panel is built with Laravel 11, Filament 3, Livewire, Alpine.js, and TailwindCSS. It provides a comprehensive, modern, and professional admin interface with extensive customization options.

### Key Features
- **3 Dashboard Versions**: Analytics, E-commerce, Crypto
- **Multiple Menu Types**: Vertical, horizontal, click, hover, two-panel
- **Advanced Charts**: Chart.js, ApexCharts, Recharts, C3, AmCharts
- **Data Tables**: GridJS, JsGrid, DataTables
- **File Management**: FilePond, DropzoneJS, Cropper
- **Code Editors**: Ace, CKEditor, TinyMCE, Summernote
- **Media Player**: Audio/video with context menu
- **Crypto Exchange**: Live trading interface
- **Keyboard Shortcuts**: Global navigation shortcuts
- **Loading Buttons**: Ladda animations
- **SCSS Setup**: Easy customization

## Installation

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 16+
- MySQL/PostgreSQL
- Redis (optional, for caching)

### Step 1: Clone and Install
```bash
git clone <repository-url>
cd admin-panel
composer install
npm install
```

### Step 2: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

Configure your `.env` file:
```env
APP_NAME="Admin Panel"
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_panel
DB_USERNAME=root
DB_PASSWORD=

FILAMENT_FILESYSTEM_DISK=public
```

### Step 3: Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### Step 4: Storage Setup
```bash
php artisan storage:link
```

### Step 5: Build Assets
```bash
npm run dev
# or for production
npm run build
```

### Step 6: Start Development Server
```bash
php artisan serve
```

## Project Structure

```
admin-panel/
├── app/
│   ├── Filament/
│   │   ├── Pages/           # Custom Filament pages
│   │   ├── Widgets/         # Dashboard widgets
│   │   ├── Resources/       # Filament resources
│   │   └── Theme.php        # Custom theme
│   ├── Http/
│   │   ├── Controllers/     # Custom controllers
│   │   └── Middleware/      # Custom middleware
│   └── Models/              # Eloquent models
├── resources/
│   ├── views/
│   │   ├── filament/        # Filament views
│   │   ├── admin/           # Admin views
│   │   └── auth/            # Authentication views
│   ├── scss/                # SCSS files
│   └── js/                  # JavaScript files
├── public/
│   ├── css/                 # Compiled CSS
│   ├── js/                  # Compiled JS
│   └── storage/             # Storage symlink
├── docs/                    # Documentation
└── tests/                   # Test files
```

## Customization

### SCSS Customization

The admin panel uses SCSS for easy customization. Main file: `resources/scss/admin-panel.scss`

#### Color Scheme
```scss
// Primary colors
$primary-color: #3b82f6;
$secondary-color: #6b7280;
$success-color: #10b981;
$danger-color: #ef4444;
$warning-color: #f59e0b;
$info-color: #06b6d4;

// Custom color scheme
$custom-colors: (
  "brand": #your-brand-color,
  "accent": #your-accent-color
);
```

#### Typography
```scss
$font-family-base: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
$font-size-base: 0.875rem;
$font-weight-base: 400;
```

#### Spacing
```scss
$spacer: 1rem;
$spacers: (
  0: 0,
  1: $spacer * 0.25,
  2: $spacer * 0.5,
  3: $spacer,
  4: $spacer * 1.5,
  5: $spacer * 3
);
```

### Theme Customization

#### Custom Filament Theme
```php
// app/Filament/Theme.php
class Theme extends BaseTheme
{
    public function getName(): string
    {
        return 'custom-theme';
    }
    
    public function getColors(): array
    {
        return [
            'primary' => [
                50 => '#eff6ff',
                500 => '#3b82f6',
                900 => '#1e3a8a',
            ],
        ];
    }
}
```

#### Dark Mode
```scss
[data-theme="dark"] {
  $dark-bg: #1a1a1a;
  $dark-text: #e5e5e5;
  
  body {
    background-color: $dark-bg;
    color: $dark-text;
  }
}
```

## Components

### Dashboard Widgets

#### Creating a Custom Widget
```php
// app/Filament/Widgets/CustomWidget.php
class CustomWidget extends Widget
{
    protected static string $view = 'filament.widgets.custom-widget';
    protected static ?int $sort = 1;
    
    public function getHeading(): string
    {
        return 'Custom Widget';
    }
}
```

#### Widget View
```blade
{{-- resources/views/filament/widgets/custom-widget.blade.php --}}
<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getHeading() }}
        </x-slot>
        
        <div class="space-y-4">
            <!-- Widget content -->
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### Custom Pages

#### Creating a Custom Page
```php
// app/Filament/Pages/CustomPage.php
class CustomPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $view = 'filament.pages.custom-page';
    protected static ?string $title = 'Custom Page';
    protected static ?int $navigationSort = 1;
}
```

### Charts Integration

#### Chart.js Widget
```php
class ChartWidget extends Widget
{
    protected static string $view = 'filament.widgets.chart-widget';
    
    protected function getData(): array
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [12, 19, 3, 5, 2],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                ]
            ]
        ];
    }
}
```

#### Chart View
```blade
<div class="chart-container">
    <canvas id="chart-{{ $this->getId() }}"></canvas>
</div>

<script>
    const ctx = document.getElementById('chart-{{ $this->getId() }}').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: @json($this->getData()),
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
```

### Data Tables

#### GridJS Integration
```php
class GridTableWidget extends Widget
{
    protected static string $view = 'filament.widgets.grid-table-widget';
    
    protected function getData(): array
    {
        return [
            ['Name', 'Email', 'Role'],
            ['John Doe', 'john@example.com', 'Admin'],
            ['Jane Smith', 'jane@example.com', 'User'],
        ];
    }
}
```

### File Upload

#### FilePond Integration
```php
class FileUploadWidget extends Widget
{
    protected static string $view = 'filament.widgets.file-upload-widget';
    
    public function uploadFile($file)
    {
        $path = $file->store('uploads', 'public');
        return response()->json(['path' => $path]);
    }
}
```

## Themes

### Available Themes
1. **Default Theme**: Clean, professional design
2. **Dark Theme**: Dark mode with light text
3. **Minimal Theme**: Simplified interface
4. **Corporate Theme**: Business-focused design

### Switching Themes
```php
// In your Filament panel provider
public function panel(Panel $panel): Panel
{
    return $panel
        ->theme(Theme::class)
        ->colors([
            'primary' => Color::Blue,
        ]);
}
```

### Custom Theme Creation
```php
class CustomTheme extends BaseTheme
{
    public function getName(): string
    {
        return 'custom';
    }
    
    public function getColors(): array
    {
        return [
            'primary' => [
                50 => '#eff6ff',
                500 => '#3b82f6',
                900 => '#1e3a8a',
            ],
        ];
    }
    
    public function getFonts(): array
    {
        return [
            'sans' => ['Inter', 'sans-serif'],
        ];
    }
}
```

## API Documentation

### Authentication Endpoints

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

#### Register
```http
POST /api/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Admin Endpoints

#### Get Dashboard Data
```http
GET /api/admin/dashboard
Authorization: Bearer {token}
```

#### Get Users
```http
GET /api/admin/users
Authorization: Bearer {token}
```

#### Create User
```http
POST /api/admin/users
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Doe",
    "email": "user@example.com",
    "password": "password"
}
```

### File Upload Endpoints

#### Upload File
```http
POST /api/admin/upload
Authorization: Bearer {token}
Content-Type: multipart/form-data

file: [file]
```

### Calendar Endpoints

#### Get Events
```http
GET /api/admin/calendar/events
Authorization: Bearer {token}
```

#### Create Event
```http
POST /api/admin/calendar/events
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Meeting",
    "start": "2024-01-15T10:00:00Z",
    "end": "2024-01-15T11:00:00Z"
}
```

## Best Practices

### Code Organization
1. **Use Filament Resources** for CRUD operations
2. **Create Custom Widgets** for dashboard components
3. **Use Livewire Components** for interactive features
4. **Follow PSR-12** coding standards
5. **Write Tests** for critical functionality

### Performance Optimization
1. **Use Eager Loading** for relationships
2. **Implement Caching** for expensive operations
3. **Optimize Images** before upload
4. **Use CDN** for static assets
5. **Enable Gzip** compression

### Security Best Practices
1. **Validate All Input** data
2. **Use CSRF Protection** for forms
3. **Implement Rate Limiting** for APIs
4. **Use HTTPS** in production
5. **Regular Security Updates**

### Database Optimization
1. **Use Indexes** for frequently queried columns
2. **Optimize Queries** to avoid N+1 problems
3. **Use Database Transactions** for multiple operations
4. **Regular Database Maintenance**

### Frontend Best Practices
1. **Use Alpine.js** for interactivity
2. **Minimize JavaScript** bundle size
3. **Use TailwindCSS** utility classes
4. **Implement Lazy Loading** for images
5. **Optimize for Mobile** devices

## Troubleshooting

### Common Issues

#### 1. Filament Not Loading
**Problem**: Filament admin panel not accessible
**Solution**: 
```bash
php artisan filament:install --panels
php artisan optimize:clear
```

#### 2. Assets Not Loading
**Problem**: CSS/JS files not found
**Solution**:
```bash
npm run build
php artisan storage:link
```

#### 3. Database Connection Issues
**Problem**: Database connection failed
**Solution**: Check `.env` file database configuration

#### 4. Permission Issues
**Problem**: File uploads failing
**Solution**:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### 5. Memory Issues
**Problem**: PHP memory limit exceeded
**Solution**: Increase memory limit in `php.ini`
```ini
memory_limit = 512M
```

### Debug Mode
Enable debug mode in `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Log Files
Check log files for errors:
```bash
tail -f storage/logs/laravel.log
```

### Performance Monitoring
Use Laravel Telescope for debugging:
```bash
composer require laravel/telescope --dev
php artisan telescope:install
```

## Support

### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)

### Community
- [Laravel Discord](https://discord.gg/laravel)
- [Filament Discord](https://discord.gg/filament)
- [GitHub Issues](https://github.com/your-repo/issues)

### Professional Support
For professional support and customization services, contact:
- Email: support@yourcompany.com
- Website: https://yourcompany.com

---

**Version**: 1.0.0  
**Last Updated**: January 2024  
**License**: MIT