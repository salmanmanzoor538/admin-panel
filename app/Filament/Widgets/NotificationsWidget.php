<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Range;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Notifications Widget - Integration with SweetAlert2 and Toastr
 * Features: Advanced notifications, alerts, confirmations, and toast messages
 */
class NotificationsWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.notifications-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 14;
    
    public ?string $notificationType = 'sweetalert';
    public ?string $alertType = 'success';
    public ?string $toastPosition = 'top-right';
    public ?string $toastType = 'success';
    public ?string $title = 'Notification Title';
    public ?string $message = 'This is a notification message';
    public ?string $icon = 'success';
    public ?string $confirmButtonText = 'OK';
    public ?string $cancelButtonText = 'Cancel';
    public ?string $confirmButtonColor = '#3085d6';
    public ?string $cancelButtonColor = '#d33';
    public ?int $timer = 0;
    public ?bool $showConfirmButton = true;
    public ?bool $showCancelButton = false;
    public ?bool $allowOutsideClick = true;
    public ?bool $allowEscapeKey = true;
    public ?bool $showCloseButton = true;
    public ?int $toastDuration = 3000;
    public ?bool $toastProgressBar = true;
    public ?bool $toastCloseButton = true;
    public ?string $toastTheme = 'light';
    
    protected function getViewData(): array
    {
        return [
            'notificationType' => $this->notificationType,
            'alertType' => $this->alertType,
            'toastPosition' => $this->toastPosition,
            'toastType' => $this->toastType,
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'confirmButtonText' => $this->confirmButtonText,
            'cancelButtonText' => $this->cancelButtonText,
            'confirmButtonColor' => $this->confirmButtonColor,
            'cancelButtonColor' => $this->cancelButtonColor,
            'timer' => $this->timer,
            'showConfirmButton' => $this->showConfirmButton,
            'showCancelButton' => $this->showCancelButton,
            'allowOutsideClick' => $this->allowOutsideClick,
            'allowEscapeKey' => $this->allowEscapeKey,
            'showCloseButton' => $this->showCloseButton,
            'toastDuration' => $this->toastDuration,
            'toastProgressBar' => $this->toastProgressBar,
            'toastCloseButton' => $this->toastCloseButton,
            'toastTheme' => $this->toastTheme,
            'notificationTypes' => $this->getNotificationTypes(),
            'alertTypes' => $this->getAlertTypes(),
            'toastPositions' => $this->getToastPositions(),
            'toastTypes' => $this->getToastTypes(),
            'icons' => $this->getIcons(),
            'themes' => $this->getThemes(),
        ];
    }
    
    protected function getNotificationTypes(): array
    {
        return [
            'sweetalert' => [
                'name' => 'SweetAlert2',
                'description' => 'Beautiful, responsive, customizable alerts',
                'icon' => 'fas fa-exclamation-triangle',
                'features' => ['Modals', 'Confirmations', 'Custom HTML', 'Animations'],
            ],
            'toastr' => [
                'name' => 'Toastr',
                'description' => 'Simple toast notifications',
                'icon' => 'fas fa-bell',
                'features' => ['Toasts', 'Positions', 'Themes', 'Progress Bar'],
            ],
            'native' => [
                'name' => 'Native Notifications',
                'description' => 'Browser native notifications',
                'icon' => 'fas fa-desktop',
                'features' => ['Browser API', 'System Notifications', 'Permissions'],
            ],
        ];
    }
    
    protected function getAlertTypes(): array
    {
        return [
            'success' => [
                'name' => 'Success',
                'description' => 'Success message',
                'color' => '#10b981',
                'icon' => 'success',
            ],
            'error' => [
                'name' => 'Error',
                'description' => 'Error message',
                'color' => '#ef4444',
                'icon' => 'error',
            ],
            'warning' => [
                'name' => 'Warning',
                'description' => 'Warning message',
                'color' => '#f59e0b',
                'icon' => 'warning',
            ],
            'info' => [
                'name' => 'Info',
                'description' => 'Information message',
                'color' => '#3b82f6',
                'icon' => 'info',
            ],
            'question' => [
                'name' => 'Question',
                'description' => 'Question dialog',
                'color' => '#8b5cf6',
                'icon' => 'question',
            ],
        ];
    }
    
    protected function getToastPositions(): array
    {
        return [
            'top-right' => 'Top Right',
            'top-left' => 'Top Left',
            'top-center' => 'Top Center',
            'bottom-right' => 'Bottom Right',
            'bottom-left' => 'Bottom Left',
            'bottom-center' => 'Bottom Center',
        ];
    }
    
    protected function getToastTypes(): array
    {
        return [
            'success' => 'Success',
            'error' => 'Error',
            'warning' => 'Warning',
            'info' => 'Info',
        ];
    }
    
    protected function getIcons(): array
    {
        return [
            'success' => 'Success',
            'error' => 'Error',
            'warning' => 'Warning',
            'info' => 'Info',
            'question' => 'Question',
        ];
    }
    
    protected function getThemes(): array
    {
        return [
            'light' => 'Light',
            'dark' => 'Dark',
        ];
    }
    
    public function getFormSchema(): array
    {
        return [
            Section::make('Notification Configuration')
                ->schema([
                    Select::make('notificationType')
                        ->label('Notification Type')
                        ->options(collect($this->getNotificationTypes())->mapWithKeys(fn($type, $key) => [$key => $type['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateNotificationType()),
                        
                    Select::make('alertType')
                        ->label('Alert Type')
                        ->options(collect($this->getAlertTypes())->mapWithKeys(fn($type, $key) => [$key => $type['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateAlertType()),
                        
                    Select::make('toastPosition')
                        ->label('Toast Position')
                        ->options($this->getToastPositions())
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateToastPosition()),
                ])
                ->columns(3),
                
            Section::make('Message Content')
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->placeholder('Enter notification title...')
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateTitle()),
                        
                    Textarea::make('message')
                        ->label('Message')
                        ->placeholder('Enter notification message...')
                        ->rows(3)
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateMessage()),
                        
                    Select::make('icon')
                        ->label('Icon')
                        ->options($this->getIcons())
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateIcon()),
                ])
                ->columns(1),
                
            Section::make('Button Configuration')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('confirmButtonText')
                                ->label('Confirm Button Text')
                                ->placeholder('OK')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateConfirmButtonText()),
                                
                            TextInput::make('cancelButtonText')
                                ->label('Cancel Button Text')
                                ->placeholder('Cancel')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateCancelButtonText()),
                                
                            ColorPicker::make('confirmButtonColor')
                                ->label('Confirm Button Color')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateConfirmButtonColor()),
                                
                            ColorPicker::make('cancelButtonColor')
                                ->label('Cancel Button Color')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateCancelButtonColor()),
                        ]),
                ]),
                
            Section::make('Advanced Options')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Toggle::make('showConfirmButton')
                                ->label('Show Confirm Button')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateShowConfirmButton()),
                                
                            Toggle::make('showCancelButton')
                                ->label('Show Cancel Button')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateShowCancelButton()),
                                
                            Toggle::make('allowOutsideClick')
                                ->label('Allow Outside Click')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateAllowOutsideClick()),
                                
                            Toggle::make('allowEscapeKey')
                                ->label('Allow Escape Key')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateAllowEscapeKey()),
                                
                            Toggle::make('showCloseButton')
                                ->label('Show Close Button')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateShowCloseButton()),
                                
                            Range::make('timer')
                                ->label('Auto Close Timer (ms)')
                                ->min(0)
                                ->max(10000)
                                ->step(1000)
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTimer()),
                        ]),
                ]),
                
            Section::make('Toast Options')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Range::make('toastDuration')
                                ->label('Toast Duration (ms)')
                                ->min(1000)
                                ->max(10000)
                                ->step(1000)
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateToastDuration()),
                                
                            Toggle::make('toastProgressBar')
                                ->label('Show Progress Bar')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateToastProgressBar()),
                                
                            Toggle::make('toastCloseButton')
                                ->label('Show Close Button')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateToastCloseButton()),
                                
                            Select::make('toastTheme')
                                ->label('Toast Theme')
                                ->options($this->getThemes())
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateToastTheme()),
                        ]),
                ]),
        ];
    }
    
    public function updateNotificationType(): void
    {
        $this->dispatch('notification-type-updated', $this->notificationType);
        
        Notification::make()
            ->title('Notification type updated')
            ->success()
            ->send();
    }
    
    public function updateAlertType(): void
    {
        $this->dispatch('alert-type-updated', $this->alertType);
        
        Notification::make()
            ->title('Alert type updated')
            ->success()
            ->send();
    }
    
    public function updateToastPosition(): void
    {
        $this->dispatch('toast-position-updated', $this->toastPosition);
        
        Notification::make()
            ->title('Toast position updated')
            ->success()
            ->send();
    }
    
    public function updateTitle(): void
    {
        $this->dispatch('title-updated', $this->title);
    }
    
    public function updateMessage(): void
    {
        $this->dispatch('message-updated', $this->message);
    }
    
    public function updateIcon(): void
    {
        $this->dispatch('icon-updated', $this->icon);
    }
    
    public function updateConfirmButtonText(): void
    {
        $this->dispatch('confirm-button-text-updated', $this->confirmButtonText);
    }
    
    public function updateCancelButtonText(): void
    {
        $this->dispatch('cancel-button-text-updated', $this->cancelButtonText);
    }
    
    public function updateConfirmButtonColor(): void
    {
        $this->dispatch('confirm-button-color-updated', $this->confirmButtonColor);
    }
    
    public function updateCancelButtonColor(): void
    {
        $this->dispatch('cancel-button-color-updated', $this->cancelButtonColor);
    }
    
    public function updateShowConfirmButton(): void
    {
        $this->dispatch('show-confirm-button-updated', $this->showConfirmButton);
    }
    
    public function updateShowCancelButton(): void
    {
        $this->dispatch('show-cancel-button-updated', $this->showCancelButton);
    }
    
    public function updateAllowOutsideClick(): void
    {
        $this->dispatch('allow-outside-click-updated', $this->allowOutsideClick);
    }
    
    public function updateAllowEscapeKey(): void
    {
        $this->dispatch('allow-escape-key-updated', $this->allowEscapeKey);
    }
    
    public function updateShowCloseButton(): void
    {
        $this->dispatch('show-close-button-updated', $this->showCloseButton);
    }
    
    public function updateTimer(): void
    {
        $this->dispatch('timer-updated', $this->timer);
    }
    
    public function updateToastDuration(): void
    {
        $this->dispatch('toast-duration-updated', $this->toastDuration);
    }
    
    public function updateToastProgressBar(): void
    {
        $this->dispatch('toast-progress-bar-updated', $this->toastProgressBar);
    }
    
    public function updateToastCloseButton(): void
    {
        $this->dispatch('toast-close-button-updated', $this->toastCloseButton);
    }
    
    public function updateToastTheme(): void
    {
        $this->dispatch('toast-theme-updated', $this->toastTheme);
    }
    
    public function showNotification(): void
    {
        $this->dispatch('show-notification', [
            'type' => $this->notificationType,
            'alertType' => $this->alertType,
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'confirmButtonText' => $this->confirmButtonText,
            'cancelButtonText' => $this->cancelButtonText,
            'confirmButtonColor' => $this->confirmButtonColor,
            'cancelButtonColor' => $this->cancelButtonColor,
            'timer' => $this->timer,
            'showConfirmButton' => $this->showConfirmButton,
            'showCancelButton' => $this->showCancelButton,
            'allowOutsideClick' => $this->allowOutsideClick,
            'allowEscapeKey' => $this->allowEscapeKey,
            'showCloseButton' => $this->showCloseButton,
            'toastPosition' => $this->toastPosition,
            'toastType' => $this->toastType,
            'toastDuration' => $this->toastDuration,
            'toastProgressBar' => $this->toastProgressBar,
            'toastCloseButton' => $this->toastCloseButton,
            'toastTheme' => $this->toastTheme,
        ]);
    }
    
    public function showConfirmation(): void
    {
        $this->dispatch('show-confirmation', [
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'confirmButtonText' => $this->confirmButtonText,
            'cancelButtonText' => $this->cancelButtonText,
            'confirmButtonColor' => $this->confirmButtonColor,
            'cancelButtonColor' => $this->cancelButtonColor,
        ]);
    }
    
    public function showToast(): void
    {
        $this->dispatch('show-toast', [
            'type' => $this->toastType,
            'title' => $this->title,
            'message' => $this->message,
            'position' => $this->toastPosition,
            'duration' => $this->toastDuration,
            'progressBar' => $this->toastProgressBar,
            'closeButton' => $this->toastCloseButton,
            'theme' => $this->toastTheme,
        ]);
    }
}