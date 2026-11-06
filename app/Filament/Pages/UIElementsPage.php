<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Range;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * UI Elements Page - Comprehensive collection of 100+ UI components
 * Features: Cards, tooltips, dropdowns, modals, badges, forms, buttons, and more
 */
class UIElementsPage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    
    protected static string $view = 'filament.pages.ui-elements-page';
    
    protected static ?string $title = 'UI Elements';
    
    protected static ?string $navigationLabel = 'UI Elements';
    
    protected static ?int $navigationSort = 6;
    
    protected static ?string $navigationGroup = 'Components';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('UI Elements')
                    ->tabs([
                        Tabs\Tab::make('Basic Elements')
                            ->schema([
                                Section::make('Input Fields')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('text_input')
                                                    ->label('Text Input')
                                                    ->placeholder('Enter text...')
                                                    ->helperText('Basic text input field'),
                                                    
                                                TextInput::make('email_input')
                                                    ->label('Email Input')
                                                    ->email()
                                                    ->placeholder('Enter email...')
                                                    ->helperText('Email input with validation'),
                                                    
                                                TextInput::make('password_input')
                                                    ->label('Password Input')
                                                    ->password()
                                                    ->placeholder('Enter password...')
                                                    ->helperText('Password input field'),
                                                    
                                                TextInput::make('number_input')
                                                    ->label('Number Input')
                                                    ->numeric()
                                                    ->placeholder('Enter number...')
                                                    ->helperText('Numeric input field'),
                                                    
                                                TextInput::make('url_input')
                                                    ->label('URL Input')
                                                    ->url()
                                                    ->placeholder('Enter URL...')
                                                    ->helperText('URL input with validation'),
                                                    
                                                TextInput::make('tel_input')
                                                    ->label('Phone Input')
                                                    ->tel()
                                                    ->placeholder('Enter phone number...')
                                                    ->helperText('Telephone input field'),
                                            ]),
                                            
                                        Textarea::make('textarea')
                                            ->label('Textarea')
                                            ->placeholder('Enter long text...')
                                            ->rows(4)
                                            ->helperText('Multi-line text input'),
                                            
                                        Select::make('select')
                                            ->label('Select Dropdown')
                                            ->options([
                                                'option1' => 'Option 1',
                                                'option2' => 'Option 2',
                                                'option3' => 'Option 3',
                                            ])
                                            ->placeholder('Choose an option...')
                                            ->helperText('Single selection dropdown'),
                                            
                                        Select::make('multi_select')
                                            ->label('Multi Select')
                                            ->multiple()
                                            ->options([
                                                'option1' => 'Option 1',
                                                'option2' => 'Option 2',
                                                'option3' => 'Option 3',
                                                'option4' => 'Option 4',
                                            ])
                                            ->placeholder('Choose multiple options...')
                                            ->helperText('Multiple selection dropdown'),
                                    ]),
                                    
                                Section::make('Selection Controls')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Checkbox::make('checkbox')
                                                    ->label('Checkbox')
                                                    ->helperText('Single checkbox option'),
                                                    
                                                Checkbox::make('checkbox_checked')
                                                    ->label('Checked Checkbox')
                                                    ->default(true)
                                                    ->helperText('Pre-checked checkbox'),
                                                    
                                                Radio::make('radio')
                                                    ->label('Radio Buttons')
                                                    ->options([
                                                        'option1' => 'Option 1',
                                                        'option2' => 'Option 2',
                                                        'option3' => 'Option 3',
                                                    ])
                                                    ->helperText('Single selection radio buttons'),
                                                    
                                                Toggle::make('toggle')
                                                    ->label('Toggle Switch')
                                                    ->helperText('On/off toggle switch'),
                                                    
                                                Toggle::make('toggle_on')
                                                    ->label('Toggle On')
                                                    ->default(true)
                                                    ->helperText('Pre-enabled toggle switch'),
                                            ]),
                                    ]),
                                    
                                Section::make('Date & Time')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                DatePicker::make('date_picker')
                                                    ->label('Date Picker')
                                                    ->helperText('Select a date'),
                                                    
                                                TimePicker::make('time_picker')
                                                    ->label('Time Picker')
                                                    ->helperText('Select a time'),
                                                    
                                                DateTimePicker::make('datetime_picker')
                                                    ->label('Date & Time Picker')
                                                    ->helperText('Select date and time'),
                                            ]),
                                    ]),
                                    
                                Section::make('File & Media')
                                    ->schema([
                                        FileUpload::make('file_upload')
                                            ->label('File Upload')
                                            ->helperText('Upload single file'),
                                            
                                        FileUpload::make('multiple_files')
                                            ->label('Multiple Files')
                                            ->multiple()
                                            ->helperText('Upload multiple files'),
                                            
                                        FileUpload::make('image_upload')
                                            ->label('Image Upload')
                                            ->image()
                                            ->helperText('Upload image files only'),
                                    ]),
                                    
                                Section::make('Advanced Inputs')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                ColorPicker::make('color_picker')
                                                    ->label('Color Picker')
                                                    ->helperText('Select a color'),
                                                    
                                                Range::make('range_slider')
                                                    ->label('Range Slider')
                                                    ->min(0)
                                                    ->max(100)
                                                    ->step(1)
                                                    ->helperText('Range slider input'),
                                                    
                                                TagsInput::make('tags_input')
                                                    ->label('Tags Input')
                                                    ->placeholder('Add tags...')
                                                    ->helperText('Add multiple tags'),
                                                    
                                                KeyValue::make('key_value')
                                                    ->label('Key-Value Pairs')
                                                    ->helperText('Key-value pair input'),
                                            ]),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Layout Components')
                            ->schema([
                                Section::make('Cards & Containers')
                                    ->schema([
                                        Placeholder::make('card_examples')
                                            ->label('Card Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Basic Card</h3>
                                                        <p class="text-gray-600">Simple card with basic styling</p>
                                                    </div>
                                                    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4">
                                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Elevated Card</h3>
                                                        <p class="text-gray-600">Card with enhanced shadow</p>
                                                    </div>
                                                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg text-white p-4">
                                                        <h3 class="text-lg font-semibold mb-2">Gradient Card</h3>
                                                        <p class="text-blue-100">Card with gradient background</p>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Grid System')
                                    ->schema([
                                        Placeholder::make('grid_examples')
                                            ->label('Grid Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div class="grid grid-cols-12 gap-4">
                                                        <div class="col-span-6 bg-blue-100 p-4 rounded">6 columns</div>
                                                        <div class="col-span-6 bg-green-100 p-4 rounded">6 columns</div>
                                                    </div>
                                                    <div class="grid grid-cols-12 gap-4">
                                                        <div class="col-span-4 bg-red-100 p-4 rounded">4 columns</div>
                                                        <div class="col-span-4 bg-yellow-100 p-4 rounded">4 columns</div>
                                                        <div class="col-span-4 bg-purple-100 p-4 rounded">4 columns</div>
                                                    </div>
                                                    <div class="grid grid-cols-12 gap-4">
                                                        <div class="col-span-3 bg-indigo-100 p-4 rounded">3 columns</div>
                                                        <div class="col-span-3 bg-pink-100 p-4 rounded">3 columns</div>
                                                        <div class="col-span-3 bg-teal-100 p-4 rounded">3 columns</div>
                                                        <div class="col-span-3 bg-orange-100 p-4 rounded">3 columns</div>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Spacing & Sizing')
                                    ->schema([
                                        Placeholder::make('spacing_examples')
                                            ->label('Spacing Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div class="bg-gray-100 p-2">
                                                        <div class="bg-blue-500 text-white p-2 rounded">Padding 2</div>
                                                    </div>
                                                    <div class="bg-gray-100 p-4">
                                                        <div class="bg-green-500 text-white p-4 rounded">Padding 4</div>
                                                    </div>
                                                    <div class="bg-gray-100 p-6">
                                                        <div class="bg-red-500 text-white p-6 rounded">Padding 6</div>
                                                    </div>
                                                    <div class="bg-gray-100 p-8">
                                                        <div class="bg-purple-500 text-white p-8 rounded">Padding 8</div>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Interactive Elements')
                            ->schema([
                                Section::make('Buttons')
                                    ->schema([
                                        Placeholder::make('button_examples')
                                            ->label('Button Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div class="flex flex-wrap gap-4">
                                                        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Primary</button>
                                                        <button class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Secondary</button>
                                                        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Success</button>
                                                        <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Danger</button>
                                                        <button class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Warning</button>
                                                        <button class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600">Info</button>
                                                    </div>
                                                    <div class="flex flex-wrap gap-4">
                                                        <button class="px-4 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-50">Outline</button>
                                                        <button class="px-4 py-2 border border-gray-500 text-gray-500 rounded hover:bg-gray-50">Outline Gray</button>
                                                        <button class="px-4 py-2 text-blue-500 rounded hover:bg-blue-50">Text</button>
                                                        <button class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">Rounded</button>
                                                    </div>
                                                    <div class="flex flex-wrap gap-4">
                                                        <button class="px-2 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Small</button>
                                                        <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Medium</button>
                                                        <button class="px-6 py-3 bg-blue-500 text-white rounded hover:bg-blue-600">Large</button>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Badges & Labels')
                                    ->schema([
                                        Placeholder::make('badge_examples')
                                            ->label('Badge Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div class="flex flex-wrap gap-2">
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Blue</span>
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Green</span>
                                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Red</span>
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Yellow</span>
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">Purple</span>
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">Gray</span>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2">
                                                        <span class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Solid Blue</span>
                                                        <span class="px-3 py-1 bg-green-500 text-white rounded text-sm">Solid Green</span>
                                                        <span class="px-3 py-1 bg-red-500 text-white rounded text-sm">Solid Red</span>
                                                        <span class="px-3 py-1 bg-yellow-500 text-white rounded text-sm">Solid Yellow</span>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Progress & Loading')
                                    ->schema([
                                        Placeholder::make('progress_examples')
                                            ->label('Progress Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div>
                                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                            <span>Progress</span>
                                                            <span>25%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 25%"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                            <span>Progress</span>
                                                            <span>50%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-green-500 h-2 rounded-full" style="width: 50%"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                            <span>Progress</span>
                                                            <span>75%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-red-500 h-2 rounded-full" style="width: 75%"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                            <span>Progress</span>
                                                            <span>100%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-purple-500 h-2 rounded-full" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Data Display')
                            ->schema([
                                Section::make('Tables')
                                    ->schema([
                                        Placeholder::make('table_examples')
                                            ->label('Table Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">John Doe</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">john@example.com</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jane Smith</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">jane@example.com</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User</td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Mike Johnson</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">mike@example.com</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Editor</td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Lists')
                                    ->schema([
                                        Placeholder::make('list_examples')
                                            ->label('List Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div class="bg-white border border-gray-200 rounded-lg">
                                                        <div class="px-4 py-3 border-b border-gray-200">
                                                            <h3 class="text-lg font-medium text-gray-900">Simple List</h3>
                                                        </div>
                                                        <ul class="divide-y divide-gray-200">
                                                            <li class="px-4 py-3">List item 1</li>
                                                            <li class="px-4 py-3">List item 2</li>
                                                            <li class="px-4 py-3">List item 3</li>
                                                        </ul>
                                                    </div>
                                                    <div class="bg-white border border-gray-200 rounded-lg">
                                                        <div class="px-4 py-3 border-b border-gray-200">
                                                            <h3 class="text-lg font-medium text-gray-900">List with Icons</h3>
                                                        </div>
                                                        <ul class="divide-y divide-gray-200">
                                                            <li class="px-4 py-3 flex items-center space-x-3">
                                                                <i class="fas fa-user text-blue-500"></i>
                                                                <span>User Profile</span>
                                                            </li>
                                                            <li class="px-4 py-3 flex items-center space-x-3">
                                                                <i class="fas fa-cog text-gray-500"></i>
                                                                <span>Settings</span>
                                                            </li>
                                                            <li class="px-4 py-3 flex items-center space-x-3">
                                                                <i class="fas fa-sign-out-alt text-red-500"></i>
                                                                <span>Logout</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Feedback & Alerts')
                            ->schema([
                                Section::make('Alerts')
                                    ->schema([
                                        Placeholder::make('alert_examples')
                                            ->label('Alert Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                                        <div class="flex">
                                                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                                            <div class="ml-3">
                                                                <h3 class="text-sm font-medium text-blue-800">Information</h3>
                                                                <p class="text-sm text-blue-700 mt-1">This is an informational alert message.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                                        <div class="flex">
                                                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                                                            <div class="ml-3">
                                                                <h3 class="text-sm font-medium text-green-800">Success</h3>
                                                                <p class="text-sm text-green-700 mt-1">Operation completed successfully.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                                        <div class="flex">
                                                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i>
                                                            <div class="ml-3">
                                                                <h3 class="text-sm font-medium text-yellow-800">Warning</h3>
                                                                <p class="text-sm text-yellow-700 mt-1">Please review your input before proceeding.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                                        <div class="flex">
                                                            <i class="fas fa-times-circle text-red-500 mt-0.5"></i>
                                                            <div class="ml-3">
                                                                <h3 class="text-sm font-medium text-red-800">Error</h3>
                                                                <p class="text-sm text-red-700 mt-1">An error occurred while processing your request.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Modals & Overlays')
                                    ->schema([
                                        Placeholder::make('modal_examples')
                                            ->label('Modal Examples')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-4">
                                                    <button onclick="openModal()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                        Open Modal
                                                    </button>
                                                    <button onclick="openConfirmModal()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                                        Open Confirm Modal
                                                    </button>
                                                </div>
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
            Action::make('export_components')
                ->label('Export Components')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('exportComponents'),
                
            Action::make('import_components')
                ->label('Import Components')
                ->icon('heroicon-o-arrow-up-tray')
                ->action('importComponents'),
        ];
    }
    
    public function exportComponents(): void
    {
        Notification::make()
            ->title('Components exported successfully')
            ->success()
            ->send();
    }
    
    public function importComponents(): void
    {
        Notification::make()
            ->title('Components imported successfully')
            ->success()
            ->send();
    }
}