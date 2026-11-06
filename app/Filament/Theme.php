<?php

namespace App\Filament;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;

/**
 * Custom Filament Theme with enhanced navigation and UI features
 * Features: Vertical & Horizontal menus, hover/click toggle, state persistence
 */
class Theme extends \Filament\View\Theme
{
    public function getName(): string
    {
        return 'admin-panel-theme';
    }

    public function getViewHooks(): array
    {
        return [
            PanelsRenderHook::HEAD_END => 'filament.theme.head-end',
            PanelsRenderHook::BODY_START => 'filament.theme.body-start',
            PanelsRenderHook::BODY_END => 'filament.theme.body-end',
        ];
    }

    public function getViewHookData(): array
    {
        return [
            'menuState' => $this->getMenuState(),
            'navigationType' => $this->getNavigationType(),
        ];
    }

    /**
     * Get the current menu state (collapsed/expanded)
     */
    private function getMenuState(): string
    {
        return session('filament.menu.state', 'expanded');
    }

    /**
     * Get the navigation type (vertical/horizontal)
     */
    private function getNavigationType(): string
    {
        return session('filament.navigation.type', 'vertical');
    }
}