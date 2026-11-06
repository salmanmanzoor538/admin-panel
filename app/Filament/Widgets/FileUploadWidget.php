<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;

/**
 * File Upload Widget with Filepond and Dropzone integration
 * Features: Drag & drop, file previews, validation, multiple file types
 */
class FileUploadWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.file-upload-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 5;
    
    public ?string $uploadType = 'filepond';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('File Upload Configuration')
                    ->schema([
                        Select::make('uploadType')
                            ->label('Upload Type')
                            ->options([
                                'filepond' => 'Filepond (Modern)',
                                'dropzone' => 'Dropzone (Classic)',
                            ])
                            ->default('filepond')
                            ->live()
                            ->required(),
                            
                        Select::make('fileTypes')
                            ->label('Allowed File Types')
                            ->options([
                                'images' => 'Images Only',
                                'documents' => 'Documents Only',
                                'all' => 'All Files',
                                'custom' => 'Custom Types',
                            ])
                            ->default('all')
                            ->required(),
                            
                        TextInput::make('maxFileSize')
                            ->label('Max File Size (MB)')
                            ->numeric()
                            ->default(10)
                            ->required(),
                            
                        TextInput::make('maxFiles')
                            ->label('Max Number of Files')
                            ->numeric()
                            ->default(5)
                            ->required(),
                            
                        Textarea::make('description')
                            ->label('Upload Description')
                            ->placeholder('Describe what files are expected...')
                            ->rows(3),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
    
    public function getUploadTypeOptions(): array
    {
        return [
            'filepond' => 'Filepond (Modern)',
            'dropzone' => 'Dropzone (Classic)',
        ];
    }
    
    public function getFileTypeOptions(): array
    {
        return [
            'images' => 'Images Only',
            'documents' => 'Documents Only',
            'all' => 'All Files',
            'custom' => 'Custom Types',
        ];
    }
    
    public function getAcceptedFileTypes(): array
    {
        return match ($this->data['fileTypes'] ?? 'all') {
            'images' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'documents' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'all' => ['*/*'],
            'custom' => ['image/*', 'application/pdf', 'text/*'],
            default => ['*/*'],
        };
    }
    
    public function getMaxFileSize(): int
    {
        return ($this->data['maxFileSize'] ?? 10) * 1024 * 1024; // Convert MB to bytes
    }
    
    public function getMaxFiles(): int
    {
        return $this->data['maxFiles'] ?? 5;
    }
}