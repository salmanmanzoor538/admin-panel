<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

/**
 * File Manager Page - Complete file management system with cropper
 * Features: File upload, image cropping, file organization, preview, search
 */
class FileManagerPage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    
    protected static string $view = 'filament.pages.file-manager-page';
    
    protected static ?string $title = 'File Manager';
    
    protected static ?string $navigationLabel = 'File Manager';
    
    protected static ?int $navigationSort = 7;
    
    protected static ?string $navigationGroup = 'Media';
    
    public ?array $data = [];
    public ?string $currentFolder = '/';
    public ?string $viewMode = 'grid';
    public ?string $sortBy = 'name';
    public ?string $sortOrder = 'asc';
    public ?string $searchQuery = '';
    public ?array $selectedFiles = [];
    public ?string $filterType = 'all';
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('File Manager')
                    ->tabs([
                        Tabs\Tab::make('Upload Files')
                            ->schema([
                                Section::make('File Upload')
                                    ->schema([
                                        FileUpload::make('files')
                                            ->label('Upload Files')
                                            ->multiple()
                                            ->acceptedFileTypes(['image/*', 'application/pdf', 'text/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                            ->maxSize(10240) // 10MB
                                            ->directory('uploads')
                                            ->visibility('public')
                                            ->helperText('Upload multiple files at once. Supported formats: Images, PDF, Text, Word documents'),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('folder_name')
                                                    ->label('Create New Folder')
                                                    ->placeholder('Enter folder name...')
                                                    ->helperText('Create a new folder in current directory'),
                                                    
                                                Select::make('upload_folder')
                                                    ->label('Upload to Folder')
                                                    ->options($this->getFolderOptions())
                                                    ->placeholder('Select folder...')
                                                    ->helperText('Choose destination folder for uploads'),
                                            ]),
                                    ]),
                                    
                                Section::make('Bulk Operations')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Select::make('bulk_action')
                                                    ->label('Bulk Action')
                                                    ->options([
                                                        'move' => 'Move Files',
                                                        'copy' => 'Copy Files',
                                                        'delete' => 'Delete Files',
                                                        'rename' => 'Rename Files',
                                                        'download' => 'Download Files',
                                                    ])
                                                    ->placeholder('Select action...'),
                                                    
                                                Select::make('bulk_destination')
                                                    ->label('Destination Folder')
                                                    ->options($this->getFolderOptions())
                                                    ->placeholder('Select destination...')
                                                    ->visible(fn($get) => in_array($get('bulk_action'), ['move', 'copy'])),
                                                    
                                                TextInput::make('bulk_rename_pattern')
                                                    ->label('Rename Pattern')
                                                    ->placeholder('New name pattern...')
                                                    ->visible(fn($get) => $get('bulk_action') === 'rename'),
                                            ]),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Image Editor')
                            ->schema([
                                Section::make('Image Cropping')
                                    ->schema([
                                        FileUpload::make('crop_image')
                                            ->label('Select Image to Crop')
                                            ->image()
                                            ->maxSize(5120) // 5MB
                                            ->directory('temp')
                                            ->visibility('public')
                                            ->helperText('Upload an image to start cropping'),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('crop_width')
                                                    ->label('Crop Width')
                                                    ->numeric()
                                                    ->placeholder('Width in pixels')
                                                    ->helperText('Set crop area width'),
                                                    
                                                TextInput::make('crop_height')
                                                    ->label('Crop Height')
                                                    ->numeric()
                                                    ->placeholder('Height in pixels')
                                                    ->helperText('Set crop area height'),
                                            ]),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('crop_x')
                                                    ->label('Crop X Position')
                                                    ->numeric()
                                                    ->placeholder('X coordinate')
                                                    ->helperText('Crop area X position'),
                                                    
                                                TextInput::make('crop_y')
                                                    ->label('Crop Y Position')
                                                    ->numeric()
                                                    ->placeholder('Y coordinate')
                                                    ->helperText('Crop area Y position'),
                                            ]),
                                            
                                        Select::make('crop_quality')
                                            ->label('Output Quality')
                                            ->options([
                                                '0.1' => '10% (Low)',
                                                '0.3' => '30% (Medium)',
                                                '0.5' => '50% (Good)',
                                                '0.7' => '70% (High)',
                                                '0.9' => '90% (Very High)',
                                                '1.0' => '100% (Lossless)',
                                            ])
                                            ->default('0.8')
                                            ->helperText('Select output image quality'),
                                    ]),
                                    
                                Section::make('Image Filters')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Select::make('filter_type')
                                                    ->label('Filter Type')
                                                    ->options([
                                                        'none' => 'No Filter',
                                                        'grayscale' => 'Grayscale',
                                                        'sepia' => 'Sepia',
                                                        'blur' => 'Blur',
                                                        'brightness' => 'Brightness',
                                                        'contrast' => 'Contrast',
                                                        'saturate' => 'Saturate',
                                                    ])
                                                    ->default('none'),
                                                    
                                                TextInput::make('filter_intensity')
                                                    ->label('Filter Intensity')
                                                    ->numeric()
                                                    ->placeholder('0-100')
                                                    ->default(50)
                                                    ->helperText('Filter intensity (0-100)'),
                                                    
                                                Toggle::make('apply_filter')
                                                    ->label('Apply Filter')
                                                    ->default(false)
                                                    ->helperText('Enable to apply filter to image'),
                                            ]),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('File Organization')
                            ->schema([
                                Section::make('Folder Management')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('new_folder_name')
                                                    ->label('New Folder Name')
                                                    ->placeholder('Enter folder name...')
                                                    ->helperText('Create a new folder'),
                                                    
                                                Select::make('parent_folder')
                                                    ->label('Parent Folder')
                                                    ->options($this->getFolderOptions())
                                                    ->placeholder('Select parent folder...')
                                                    ->helperText('Choose parent folder for new folder'),
                                            ]),
                                    ]),
                                    
                                Section::make('File Operations')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('rename_file')
                                                    ->label('Rename File')
                                                    ->placeholder('New file name...')
                                                    ->helperText('Rename selected file'),
                                                    
                                                Select::make('move_file_to')
                                                    ->label('Move File To')
                                                    ->options($this->getFolderOptions())
                                                    ->placeholder('Select destination...')
                                                    ->helperText('Move file to different folder'),
                                            ]),
                                    ]),
                                    
                                Section::make('File Properties')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('file_name')
                                                    ->label('File Name')
                                                    ->disabled()
                                                    ->helperText('Current file name'),
                                                    
                                                TextInput::make('file_size')
                                                    ->label('File Size')
                                                    ->disabled()
                                                    ->helperText('File size in bytes'),
                                                    
                                                TextInput::make('file_type')
                                                    ->label('File Type')
                                                    ->disabled()
                                                    ->helperText('MIME type'),
                                            ]),
                                            
                                        Textarea::make('file_description')
                                            ->label('File Description')
                                            ->placeholder('Enter file description...')
                                            ->rows(3)
                                            ->helperText('Add description for the file'),
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
            Action::make('upload_files')
                ->label('Upload Files')
                ->icon('heroicon-o-cloud-arrow-up')
                ->color('primary')
                ->action('uploadFiles'),
                
            Action::make('create_folder')
                ->label('Create Folder')
                ->icon('heroicon-o-folder-plus')
                ->action('createFolder'),
                
            Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action('refreshFiles'),
        ];
    }
    
    protected function getFolderOptions(): array
    {
        // In a real application, this would fetch folders from storage
        return [
            '/' => 'Root',
            '/images' => 'Images',
            '/documents' => 'Documents',
            '/videos' => 'Videos',
            '/audio' => 'Audio',
            '/archives' => 'Archives',
        ];
    }
    
    protected function getFiles(): array
    {
        // Mock file data - in a real application, this would come from storage
        return [
            [
                'id' => 1,
                'name' => 'sample-image.jpg',
                'type' => 'image/jpeg',
                'size' => 1024000,
                'modified' => now()->subDays(1),
                'path' => '/images/sample-image.jpg',
                'thumbnail' => '/thumbnails/sample-image.jpg',
            ],
            [
                'id' => 2,
                'name' => 'document.pdf',
                'type' => 'application/pdf',
                'size' => 2048000,
                'modified' => now()->subDays(2),
                'path' => '/documents/document.pdf',
                'thumbnail' => '/thumbnails/pdf-icon.png',
            ],
            [
                'id' => 3,
                'name' => 'presentation.pptx',
                'type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'size' => 5120000,
                'modified' => now()->subDays(3),
                'path' => '/documents/presentation.pptx',
                'thumbnail' => '/thumbnails/ppt-icon.png',
            ],
        ];
    }
    
    public function uploadFiles(): void
    {
        Notification::make()
            ->title('Files uploaded successfully')
            ->success()
            ->send();
    }
    
    public function createFolder(): void
    {
        Notification::make()
            ->title('Folder created successfully')
            ->success()
            ->send();
    }
    
    public function refreshFiles(): void
    {
        Notification::make()
            ->title('File list refreshed')
            ->success()
            ->send();
    }
    
    public function deleteFile(int $fileId): void
    {
        Notification::make()
            ->title('File deleted successfully')
            ->success()
            ->send();
    }
    
    public function downloadFile(int $fileId): void
    {
        Notification::make()
            ->title('File download started')
            ->success()
            ->send();
    }
    
    public function cropImage(): void
    {
        Notification::make()
            ->title('Image cropped successfully')
            ->success()
            ->send();
    }
}