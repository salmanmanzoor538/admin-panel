<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Mailbox Page - Complete email management system
 * Features: Inbox, sent, draft, compose with real-time updates
 */
class MailboxPage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static string $view = 'filament.pages.mailbox-page';
    
    protected static ?string $title = 'Mailbox';
    
    protected static ?string $navigationLabel = 'Mailbox';
    
    protected static ?int $navigationSort = 4;
    
    protected static ?string $navigationGroup = 'Communication';
    
    public ?string $activeFolder = 'inbox';
    public ?array $selectedEmails = [];
    public ?string $searchQuery = '';
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('compose')
                ->label('Compose')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->action('openComposeModal'),
        ];
    }
    
    public function openComposeModal(): void
    {
        $this->dispatch('open-compose-modal');
    }
    
    public function getEmails(): array
    {
        // Mock email data - in a real application, this would come from a database
        $emails = [
            'inbox' => [
                [
                    'id' => 1,
                    'from' => 'john.doe@example.com',
                    'from_name' => 'John Doe',
                    'subject' => 'Project Update - Q4 2024',
                    'preview' => 'Hi there, I wanted to update you on the progress of our Q4 project...',
                    'date' => now()->subHours(2),
                    'read' => false,
                    'important' => true,
                    'attachments' => 2,
                ],
                [
                    'id' => 2,
                    'from' => 'sarah.wilson@company.com',
                    'from_name' => 'Sarah Wilson',
                    'subject' => 'Meeting Tomorrow at 2 PM',
                    'preview' => 'Don\'t forget about our meeting tomorrow at 2 PM in the conference room...',
                    'date' => now()->subHours(5),
                    'read' => true,
                    'important' => false,
                    'attachments' => 0,
                ],
                [
                    'id' => 3,
                    'from' => 'support@service.com',
                    'from_name' => 'Support Team',
                    'subject' => 'Your subscription is expiring soon',
                    'preview' => 'Your premium subscription will expire in 7 days. Renew now to continue...',
                    'date' => now()->subDays(1),
                    'read' => false,
                    'important' => false,
                    'attachments' => 0,
                ],
            ],
            'sent' => [
                [
                    'id' => 4,
                    'to' => 'client@business.com',
                    'to_name' => 'Business Client',
                    'subject' => 'Proposal for Website Redesign',
                    'preview' => 'Thank you for considering our services. Please find attached our proposal...',
                    'date' => now()->subHours(1),
                    'read' => true,
                    'important' => false,
                    'attachments' => 1,
                ],
            ],
            'draft' => [
                [
                    'id' => 5,
                    'to' => 'team@company.com',
                    'to_name' => 'Team Members',
                    'subject' => 'Weekly Team Update',
                    'preview' => 'Here\'s what we accomplished this week and our plans for next week...',
                    'date' => now()->subDays(2),
                    'read' => true,
                    'important' => false,
                    'attachments' => 0,
                ],
            ],
        ];
        
        return $emails[$this->activeFolder] ?? [];
    }
    
    public function getFolders(): array
    {
        return [
            'inbox' => ['name' => 'Inbox', 'count' => 3, 'icon' => 'heroicon-o-inbox'],
            'sent' => ['name' => 'Sent', 'count' => 1, 'icon' => 'heroicon-o-paper-airplane'],
            'draft' => ['name' => 'Draft', 'count' => 1, 'icon' => 'heroicon-o-document-text'],
            'trash' => ['name' => 'Trash', 'count' => 0, 'icon' => 'heroicon-o-trash'],
        ];
    }
    
    public function setActiveFolder(string $folder): void
    {
        $this->activeFolder = $folder;
        $this->selectedEmails = [];
    }
    
    public function toggleEmailSelection(int $emailId): void
    {
        if (in_array($emailId, $this->selectedEmails)) {
            $this->selectedEmails = array_filter($this->selectedEmails, fn($id) => $id !== $emailId);
        } else {
            $this->selectedEmails[] = $emailId;
        }
    }
    
    public function markAsRead(int $emailId): void
    {
        // In a real application, this would update the database
        Notification::make()
            ->title('Email marked as read')
            ->success()
            ->send();
    }
    
    public function deleteEmails(): void
    {
        if (empty($this->selectedEmails)) {
            Notification::make()
                ->title('No emails selected')
                ->warning()
                ->send();
            return;
        }
        
        // In a real application, this would delete emails from database
        Notification::make()
            ->title(count($this->selectedEmails) . ' emails deleted')
            ->success()
            ->send();
            
        $this->selectedEmails = [];
    }
}