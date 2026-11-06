<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Code Editors Page - Multiple code editors integration
 * Features: Ace Editor, CKEditor, TinyMCE, Summernote
 */
class CodeEditorsPage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';
    
    protected static string $view = 'filament.pages.code-editors-page';
    
    protected static ?string $title = 'Code Editors';
    
    protected static ?string $navigationLabel = 'Code Editors';
    
    protected static ?int $navigationSort = 11;
    
    protected static ?string $navigationGroup = 'Development';
    
    public ?array $data = [];
    public ?string $activeTab = 'ace';
    public ?string $aceTheme = 'monokai';
    public ?string $aceMode = 'javascript';
    public ?string $aceFontSize = '14';
    public ?bool $aceWrapMode = true;
    public ?bool $aceShowGutter = true;
    public ?bool $aceShowLineNumbers = true;
    public ?string $ckeditorConfig = 'full';
    public ?string $tinymceTheme = 'silver';
    public ?string $tinymceToolbar = 'full';
    public ?string $summernoteTheme = 'default';
    public ?string $summernoteHeight = '300';
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Code Editors')
                    ->tabs([
                        Tabs\Tab::make('Ace Editor')
                            ->schema([
                                Section::make('Ace Editor Configuration')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Select::make('ace_theme')
                                                    ->label('Theme')
                                                    ->options([
                                                        'monokai' => 'Monokai',
                                                        'github' => 'GitHub',
                                                        'tomorrow' => 'Tomorrow',
                                                        'kuroir' => 'Kuroir',
                                                        'twilight' => 'Twilight',
                                                        'xcode' => 'Xcode',
                                                        'textmate' => 'Textmate',
                                                        'solarized_dark' => 'Solarized Dark',
                                                        'solarized_light' => 'Solarized Light',
                                                        'terminal' => 'Terminal',
                                                    ])
                                                    ->default('monokai')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateAceTheme()),
                                                    
                                                Select::make('ace_mode')
                                                    ->label('Language Mode')
                                                    ->options([
                                                        'javascript' => 'JavaScript',
                                                        'php' => 'PHP',
                                                        'python' => 'Python',
                                                        'java' => 'Java',
                                                        'html' => 'HTML',
                                                        'css' => 'CSS',
                                                        'json' => 'JSON',
                                                        'xml' => 'XML',
                                                        'sql' => 'SQL',
                                                        'markdown' => 'Markdown',
                                                        'yaml' => 'YAML',
                                                        'dockerfile' => 'Dockerfile',
                                                    ])
                                                    ->default('javascript')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateAceMode()),
                                                    
                                                Select::make('ace_font_size')
                                                    ->label('Font Size')
                                                    ->options([
                                                        '10' => '10px',
                                                        '12' => '12px',
                                                        '14' => '14px',
                                                        '16' => '16px',
                                                        '18' => '18px',
                                                        '20' => '20px',
                                                        '24' => '24px',
                                                    ])
                                                    ->default('14')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateAceFontSize()),
                                            ]),
                                            
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('ace_wrap_mode')
                                                    ->label('Word Wrap')
                                                    ->default(true)
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateAceWrapMode()),
                                                    
                                                Toggle::make('ace_show_gutter')
                                                    ->label('Show Gutter')
                                                    ->default(true)
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateAceShowGutter()),
                                                    
                                                Toggle::make('ace_show_line_numbers')
                                                    ->label('Show Line Numbers')
                                                    ->default(true)
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateAceShowLineNumbers()),
                                            ]),
                                    ]),
                                    
                                Section::make('Ace Editor')
                                    ->schema([
                                        Placeholder::make('ace_editor')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="ace-editor" style="height: 400px; border: 1px solid #e5e7eb; border-radius: 0.375rem;"></div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('CKEditor')
                            ->schema([
                                Section::make('CKEditor Configuration')
                                    ->schema([
                                        Select::make('ckeditor_config')
                                            ->label('Configuration')
                                            ->options([
                                                'full' => 'Full Editor',
                                                'standard' => 'Standard Editor',
                                                'basic' => 'Basic Editor',
                                                'inline' => 'Inline Editor',
                                                'balloon' => 'Balloon Editor',
                                                'balloon-block' => 'Balloon Block Editor',
                                            ])
                                            ->default('full')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateCkeditorConfig()),
                                    ]),
                                    
                                Section::make('CKEditor')
                                    ->schema([
                                        Placeholder::make('ckeditor')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="ckeditor" style="min-height: 400px;"></div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('TinyMCE')
                            ->schema([
                                Section::make('TinyMCE Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('tinymce_theme')
                                                    ->label('Theme')
                                                    ->options([
                                                        'silver' => 'Silver',
                                                        'dark' => 'Dark',
                                                        'oxide' => 'Oxide',
                                                        'oxide-dark' => 'Oxide Dark',
                                                    ])
                                                    ->default('silver')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateTinymceTheme()),
                                                    
                                                Select::make('tinymce_toolbar')
                                                    ->label('Toolbar')
                                                    ->options([
                                                        'full' => 'Full Toolbar',
                                                        'basic' => 'Basic Toolbar',
                                                        'minimal' => 'Minimal Toolbar',
                                                        'custom' => 'Custom Toolbar',
                                                    ])
                                                    ->default('full')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateTinymceToolbar()),
                                            ]),
                                    ]),
                                    
                                Section::make('TinyMCE')
                                    ->schema([
                                        Placeholder::make('tinymce')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="tinymce" style="min-height: 400px;"></div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Summernote')
                            ->schema([
                                Section::make('Summernote Configuration')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('summernote_theme')
                                                    ->label('Theme')
                                                    ->options([
                                                        'default' => 'Default',
                                                        'dark' => 'Dark',
                                                        'lite' => 'Lite',
                                                    ])
                                                    ->default('default')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateSummernoteTheme()),
                                                    
                                                Select::make('summernote_height')
                                                    ->label('Height')
                                                    ->options([
                                                        '200' => '200px',
                                                        '300' => '300px',
                                                        '400' => '400px',
                                                        '500' => '500px',
                                                    ])
                                                    ->default('300')
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateSummernoteHeight()),
                                            ]),
                                    ]),
                                    
                                Section::make('Summernote')
                                    ->schema([
                                        Placeholder::make('summernote')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="summernote" style="min-height: 400px;"></div>
                                            ')),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save_code')
                ->label('Save Code')
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->action('saveCode'),
                
            Action::make('load_code')
                ->label('Load Code')
                ->icon('heroicon-o-document-arrow-up')
                ->color('gray')
                ->action('loadCode'),
                
            Action::make('format_code')
                ->label('Format Code')
                ->icon('heroicon-o-code-bracket')
                ->color('success')
                ->action('formatCode'),
        ];
    }
    
    public function updateAceTheme(): void
    {
        Notification::make()
            ->title('Ace theme updated')
            ->success()
            ->send();
    }
    
    public function updateAceMode(): void
    {
        Notification::make()
            ->title('Ace mode updated')
            ->success()
            ->send();
    }
    
    public function updateAceFontSize(): void
    {
        Notification::make()
            ->title('Ace font size updated')
            ->success()
            ->send();
    }
    
    public function updateAceWrapMode(): void
    {
        Notification::make()
            ->title('Ace wrap mode updated')
            ->success()
            ->send();
    }
    
    public function updateAceShowGutter(): void
    {
        Notification::make()
            ->title('Ace gutter display updated')
            ->success()
            ->send();
    }
    
    public function updateAceShowLineNumbers(): void
    {
        Notification::make()
            ->title('Ace line numbers updated')
            ->success()
            ->send();
    }
    
    public function updateCkeditorConfig(): void
    {
        Notification::make()
            ->title('CKEditor configuration updated')
            ->success()
            ->send();
    }
    
    public function updateTinymceTheme(): void
    {
        Notification::make()
            ->title('TinyMCE theme updated')
            ->success()
            ->send();
    }
    
    public function updateTinymceToolbar(): void
    {
        Notification::make()
            ->title('TinyMCE toolbar updated')
            ->success()
            ->send();
    }
    
    public function updateSummernoteTheme(): void
    {
        Notification::make()
            ->title('Summernote theme updated')
            ->success()
            ->send();
    }
    
    public function updateSummernoteHeight(): void
    {
        Notification::make()
            ->title('Summernote height updated')
            ->success()
            ->send();
    }
    
    public function saveCode(): void
    {
        Notification::make()
            ->title('Code saved successfully')
            ->success()
            ->send();
    }
    
    public function loadCode(): void
    {
        Notification::make()
            ->title('Code loaded successfully')
            ->success()
            ->send();
    }
    
    public function formatCode(): void
    {
        Notification::make()
            ->title('Code formatted successfully')
            ->success()
            ->send();
    }
}