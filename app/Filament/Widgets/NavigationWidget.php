<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Navigation Widget - Advanced menu system with multiple variations
 * Features: Vertical/Horizontal menus, two-panel menu, RTL/LTR support, menu state persistence
 */
class NavigationWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.navigation-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 11;
    
    public ?string $menuType = 'vertical';
    public ?string $menuStyle = 'default';
    public ?bool $twoPanelMenu = false;
    public ?string $textDirection = 'ltr';
    public ?bool $menuCollapsed = false;
    public ?string $menuBehavior = 'click';
    
    protected function getViewData(): array
    {
        return [
            'menuType' => $this->menuType,
            'menuStyle' => $this->menuStyle,
            'twoPanelMenu' => $this->twoPanelMenu,
            'textDirection' => $this->textDirection,
            'menuCollapsed' => $this->menuCollapsed,
            'menuBehavior' => $this->menuBehavior,
            'menuTypes' => $this->getMenuTypes(),
            'menuStyles' => $this->getMenuStyles(),
            'textDirections' => $this->getTextDirections(),
            'menuBehaviors' => $this->getMenuBehaviors(),
            'menuItems' => $this->getMenuItems(),
        ];
    }
    
    protected function getMenuTypes(): array
    {
        return [
            'vertical' => [
                'name' => 'Vertical Menu',
                'description' => 'Traditional sidebar navigation',
                'icon' => 'fas fa-bars',
            ],
            'horizontal' => [
                'name' => 'Horizontal Menu',
                'description' => 'Top navigation bar',
                'icon' => 'fas fa-grip-lines',
            ],
            'hybrid' => [
                'name' => 'Hybrid Menu',
                'description' => 'Combination of vertical and horizontal',
                'icon' => 'fas fa-th-large',
            ],
        ];
    }
    
    protected function getMenuStyles(): array
    {
        return [
            'default' => [
                'name' => 'Default',
                'description' => 'Clean and minimal design',
                'preview' => 'bg-gray-100',
            ],
            'modern' => [
                'name' => 'Modern',
                'description' => 'Contemporary with shadows',
                'preview' => 'bg-blue-100',
            ],
            'glass' => [
                'name' => 'Glass',
                'description' => 'Glassmorphism effect',
                'preview' => 'bg-gradient-to-r from-blue-100 to-purple-100',
            ],
            'dark' => [
                'name' => 'Dark',
                'description' => 'Dark theme navigation',
                'preview' => 'bg-gray-800',
            ],
        ];
    }
    
    protected function getTextDirections(): array
    {
        return [
            'ltr' => [
                'name' => 'Left to Right',
                'description' => 'Standard left-to-right layout',
                'icon' => 'fas fa-arrow-right',
            ],
            'rtl' => [
                'name' => 'Right to Left',
                'description' => 'Right-to-left layout for Arabic/Hebrew',
                'icon' => 'fas fa-arrow-left',
            ],
        ];
    }
    
    protected function getMenuBehaviors(): array
    {
        return [
            'click' => [
                'name' => 'Click to Open',
                'description' => 'Click to expand/collapse menus',
                'icon' => 'fas fa-mouse-pointer',
            ],
            'hover' => [
                'name' => 'Hover to Open',
                'description' => 'Hover to expand menus',
                'icon' => 'fas fa-hand-pointer',
            ],
            'icon-click' => [
                'name' => 'Icon Click',
                'description' => 'Click icon to toggle menu',
                'icon' => 'fas fa-icons',
            ],
            'icon-hover' => [
                'name' => 'Icon Hover',
                'description' => 'Hover icon to expand menu',
                'icon' => 'fas fa-magic',
            ],
        ];
    }
    
    protected function getMenuItems(): array
    {
        return [
            [
                'id' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/admin',
                'children' => [
                    [
                        'id' => 'analytics',
                        'label' => 'Analytics',
                        'icon' => 'fas fa-chart-line',
                        'url' => '/admin/analytics',
                    ],
                    [
                        'id' => 'ecommerce',
                        'label' => 'E-commerce',
                        'icon' => 'fas fa-shopping-cart',
                        'url' => '/admin/ecommerce',
                    ],
                    [
                        'id' => 'crypto',
                        'label' => 'Crypto',
                        'icon' => 'fas fa-coins',
                        'url' => '/admin/crypto',
                    ],
                ],
            ],
            [
                'id' => 'users',
                'label' => 'Users',
                'icon' => 'fas fa-users',
                'url' => '/admin/users',
                'children' => [
                    [
                        'id' => 'all-users',
                        'label' => 'All Users',
                        'icon' => 'fas fa-list',
                        'url' => '/admin/users',
                    ],
                    [
                        'id' => 'roles',
                        'label' => 'Roles & Permissions',
                        'icon' => 'fas fa-shield-alt',
                        'url' => '/admin/roles',
                    ],
                ],
            ],
            [
                'id' => 'content',
                'label' => 'Content',
                'icon' => 'fas fa-file-alt',
                'url' => '/admin/content',
                'children' => [
                    [
                        'id' => 'posts',
                        'label' => 'Posts',
                        'icon' => 'fas fa-newspaper',
                        'url' => '/admin/posts',
                    ],
                    [
                        'id' => 'pages',
                        'label' => 'Pages',
                        'icon' => 'fas fa-file',
                        'url' => '/admin/pages',
                    ],
                    [
                        'id' => 'media',
                        'label' => 'Media',
                        'icon' => 'fas fa-images',
                        'url' => '/admin/media',
                    ],
                ],
            ],
            [
                'id' => 'communication',
                'label' => 'Communication',
                'icon' => 'fas fa-comments',
                'url' => '/admin/communication',
                'children' => [
                    [
                        'id' => 'mailbox',
                        'label' => 'Mailbox',
                        'icon' => 'fas fa-envelope',
                        'url' => '/admin/mailbox',
                    ],
                    [
                        'id' => 'chat',
                        'label' => 'Chat',
                        'icon' => 'fas fa-comment-dots',
                        'url' => '/admin/chat',
                    ],
                ],
            ],
            [
                'id' => 'settings',
                'label' => 'Settings',
                'icon' => 'fas fa-cog',
                'url' => '/admin/settings',
                'children' => [
                    [
                        'id' => 'general',
                        'label' => 'General',
                        'icon' => 'fas fa-sliders-h',
                        'url' => '/admin/settings/general',
                    ],
                    [
                        'id' => 'themes',
                        'label' => 'Themes',
                        'icon' => 'fas fa-palette',
                        'url' => '/admin/settings/themes',
                    ],
                ],
            ],
        ];
    }
    
    public function getFormSchema(): array
    {
        return [
            Select::make('menuType')
                ->label('Menu Type')
                ->options(collect($this->getMenuTypes())->mapWithKeys(fn($type, $key) => [$key => $type['name']]))
                ->live()
                ->afterStateUpdated(fn() => $this->applyMenuType()),
                
            Select::make('menuStyle')
                ->label('Menu Style')
                ->options(collect($this->getMenuStyles())->mapWithKeys(fn($style, $key) => [$key => $style['name']]))
                ->live()
                ->afterStateUpdated(fn() => $this->applyMenuStyle()),
                
            Select::make('textDirection')
                ->label('Text Direction')
                ->options(collect($this->getTextDirections())->mapWithKeys(fn($dir, $key) => [$key => $dir['name']]))
                ->live()
                ->afterStateUpdated(fn() => $this->applyTextDirection()),
                
            Select::make('menuBehavior')
                ->label('Menu Behavior')
                ->options(collect($this->getMenuBehaviors())->mapWithKeys(fn($behavior, $key) => [$key => $behavior['name']]))
                ->live()
                ->afterStateUpdated(fn() => $this->applyMenuBehavior()),
                
            Toggle::make('twoPanelMenu')
                ->label('Two Panel Menu')
                ->live()
                ->afterStateUpdated(fn() => $this->applyTwoPanelMenu()),
                
            Toggle::make('menuCollapsed')
                ->label('Menu Collapsed')
                ->live()
                ->afterStateUpdated(fn() => $this->applyMenuCollapsed()),
        ];
    }
    
    public function applyMenuType(): void
    {
        session(['menu_type' => $this->menuType]);
        $this->dispatch('menu-type-changed', $this->menuType);
        
        Notification::make()
            ->title('Menu type updated')
            ->success()
            ->send();
    }
    
    public function applyMenuStyle(): void
    {
        session(['menu_style' => $this->menuStyle]);
        $this->dispatch('menu-style-changed', $this->menuStyle);
        
        Notification::make()
            ->title('Menu style updated')
            ->success()
            ->send();
    }
    
    public function applyTextDirection(): void
    {
        session(['text_direction' => $this->textDirection]);
        $this->dispatch('text-direction-changed', $this->textDirection);
        
        Notification::make()
            ->title('Text direction updated')
            ->success()
            ->send();
    }
    
    public function applyMenuBehavior(): void
    {
        session(['menu_behavior' => $this->menuBehavior]);
        $this->dispatch('menu-behavior-changed', $this->menuBehavior);
        
        Notification::make()
            ->title('Menu behavior updated')
            ->success()
            ->send();
    }
    
    public function applyTwoPanelMenu(): void
    {
        session(['two_panel_menu' => $this->twoPanelMenu]);
        $this->dispatch('two-panel-menu-changed', $this->twoPanelMenu);
        
        Notification::make()
            ->title('Two panel menu updated')
            ->success()
            ->send();
    }
    
    public function applyMenuCollapsed(): void
    {
        session(['menu_collapsed' => $this->menuCollapsed]);
        $this->dispatch('menu-collapsed-changed', $this->menuCollapsed);
        
        Notification::make()
            ->title('Menu collapsed state updated')
            ->success()
            ->send();
    }
    
    public function resetToDefault(): void
    {
        $this->menuType = 'vertical';
        $this->menuStyle = 'default';
        $this->twoPanelMenu = false;
        $this->textDirection = 'ltr';
        $this->menuCollapsed = false;
        $this->menuBehavior = 'click';
        
        $this->applyMenuType();
        $this->applyMenuStyle();
        $this->applyTextDirection();
        $this->applyMenuBehavior();
        $this->applyTwoPanelMenu();
        $this->applyMenuCollapsed();
    }
}