<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Range;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Ladda Buttons Widget - Loading buttons with animations
 * Features: Various Ladda button styles, loading states, and animations
 */
class LaddaButtonsWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.ladda-buttons-widget';
    
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    
    public ?array $data = [];
    public ?string $selectedStyle = 'expand-left';
    public ?string $selectedSize = 'medium';
    public ?string $selectedColor = 'primary';
    public ?int $loadingDuration = 3000;
    public ?bool $showProgress = true;
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ladda Button Configuration')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('selected_style')
                                    ->label('Button Style')
                                    ->options([
                                        'expand-left' => 'Expand Left',
                                        'expand-right' => 'Expand Right',
                                        'expand-up' => 'Expand Up',
                                        'expand-down' => 'Expand Down',
                                        'contract' => 'Contract',
                                        'contract-overlay' => 'Contract Overlay',
                                        'zoom-in' => 'Zoom In',
                                        'zoom-out' => 'Zoom Out',
                                        'slide-left' => 'Slide Left',
                                        'slide-right' => 'Slide Right',
                                        'slide-up' => 'Slide Up',
                                        'slide-down' => 'Slide Down',
                                    ])
                                    ->default('expand-left')
                                    ->live()
                                    ->afterStateUpdated(fn() => $this->updateStyle()),
                                    
                                Select::make('selected_size')
                                    ->label('Button Size')
                                    ->options([
                                        'xs' => 'Extra Small',
                                        's' => 'Small',
                                        'medium' => 'Medium',
                                        'l' => 'Large',
                                        'xl' => 'Extra Large',
                                    ])
                                    ->default('medium')
                                    ->live()
                                    ->afterStateUpdated(fn() => $this->updateSize()),
                                    
                                Select::make('selected_color')
                                    ->label('Button Color')
                                    ->options([
                                        'primary' => 'Primary',
                                        'secondary' => 'Secondary',
                                        'success' => 'Success',
                                        'danger' => 'Danger',
                                        'warning' => 'Warning',
                                        'info' => 'Info',
                                        'light' => 'Light',
                                        'dark' => 'Dark',
                                    ])
                                    ->default('primary')
                                    ->live()
                                    ->afterStateUpdated(fn() => $this->updateColor()),
                            ]),
                            
                        Grid::make(2)
                            ->schema([
                                Range::make('loading_duration')
                                    ->label('Loading Duration')
                                    ->min(1000)
                                    ->max(10000)
                                    ->step(500)
                                    ->default(3000)
                                    ->suffix('ms')
                                    ->live()
                                    ->afterStateUpdated(fn() => $this->updateDuration()),
                                    
                                Toggle::make('show_progress')
                                    ->label('Show Progress')
                                    ->default(true)
                                    ->live()
                                    ->afterStateUpdated(fn() => $this->updateProgress()),
                            ]),
                    ]),
                    
                Section::make('Button Examples')
                    ->schema([
                        Placeholder::make('button_examples')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div id="button-examples">
                                    <!-- Button examples will be rendered here -->
                                </div>
                            ')),
                    ]),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('test_loading')
                ->label('Test Loading')
                ->icon('heroicon-o-play')
                ->color('primary')
                ->action('testLoading'),
                
            Action::make('reset_settings')
                ->label('Reset Settings')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action('resetSettings'),
        ];
    }
    
    public function updateStyle(): void
    {
        Notification::make()
            ->title('Button style updated')
            ->success()
            ->send();
    }
    
    public function updateSize(): void
    {
        Notification::make()
            ->title('Button size updated')
            ->success()
            ->send();
    }
    
    public function updateColor(): void
    {
        Notification::make()
            ->title('Button color updated')
            ->success()
            ->send();
    }
    
    public function updateDuration(): void
    {
        Notification::make()
            ->title('Loading duration updated')
            ->success()
            ->send();
    }
    
    public function updateProgress(): void
    {
        Notification::make()
            ->title('Progress display updated')
            ->success()
            ->send();
    }
    
    public function testLoading(): void
    {
        Notification::make()
            ->title('Testing loading animation')
            ->success()
            ->send();
    }
    
    public function resetSettings(): void
    {
        $this->selectedStyle = 'expand-left';
        $this->selectedSize = 'medium';
        $this->selectedColor = 'primary';
        $this->loadingDuration = 3000;
        $this->showProgress = true;
        
        Notification::make()
            ->title('Settings reset to default')
            ->success()
            ->send();
    }
    
    public function simulateAction(string $action): void
    {
        Notification::make()
            ->title('Action executed: ' . $action)
            ->success()
            ->send();
    }
}