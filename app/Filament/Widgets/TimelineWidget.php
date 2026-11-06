<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

/**
 * Timeline Widget for displaying chronological events
 * Features: Interactive timeline, event filtering, responsive design
 */
class TimelineWidget extends Widget
{
    protected static string $view = 'filament.widgets.timeline-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 8;
    
    public ?string $filter = 'all';
    
    protected function getViewData(): array
    {
        return [
            'filter' => $this->filter,
            'events' => $this->getTimelineEvents(),
            'filterOptions' => $this->getFilterOptions(),
        ];
    }
    
    protected function getTimelineEvents(): array
    {
        // Mock timeline events - in a real application, this would come from a database
        return [
            [
                'id' => 1,
                'title' => 'Project Launch',
                'description' => 'Successfully launched the new admin panel with enhanced UI features',
                'date' => now()->subDays(1)->format('Y-m-d H:i:s'),
                'type' => 'success',
                'icon' => 'fas fa-rocket',
                'color' => '#10b981',
            ],
            [
                'id' => 2,
                'title' => 'User Registration',
                'description' => 'New user John Doe registered on the platform',
                'date' => now()->subDays(2)->format('Y-m-d H:i:s'),
                'type' => 'info',
                'icon' => 'fas fa-user-plus',
                'color' => '#3b82f6',
            ],
            [
                'id' => 3,
                'title' => 'System Update',
                'description' => 'Applied security patches and performance improvements',
                'date' => now()->subDays(3)->format('Y-m-d H:i:s'),
                'type' => 'warning',
                'icon' => 'fas fa-tools',
                'color' => '#f59e0b',
            ],
            [
                'id' => 4,
                'title' => 'Database Backup',
                'description' => 'Scheduled database backup completed successfully',
                'date' => now()->subDays(4)->format('Y-m-d H:i:s'),
                'type' => 'info',
                'icon' => 'fas fa-database',
                'color' => '#3b82f6',
            ],
            [
                'id' => 5,
                'title' => 'Payment Received',
                'description' => 'Payment of $299.99 received from customer #12345',
                'date' => now()->subDays(5)->format('Y-m-d H:i:s'),
                'type' => 'success',
                'icon' => 'fas fa-credit-card',
                'color' => '#10b981',
            ],
            [
                'id' => 6,
                'title' => 'Server Maintenance',
                'description' => 'Scheduled server maintenance completed',
                'date' => now()->subDays(6)->format('Y-m-d H:i:s'),
                'type' => 'warning',
                'icon' => 'fas fa-server',
                'color' => '#f59e0b',
            ],
            [
                'id' => 7,
                'title' => 'New Feature Added',
                'description' => 'Added advanced chart widgets to the dashboard',
                'date' => now()->subDays(7)->format('Y-m-d H:i:s'),
                'type' => 'success',
                'icon' => 'fas fa-chart-line',
                'color' => '#10b981',
            ],
            [
                'id' => 8,
                'title' => 'Error Report',
                'description' => 'Minor error in user authentication system resolved',
                'date' => now()->subDays(8)->format('Y-m-d H:i:s'),
                'type' => 'error',
                'icon' => 'fas fa-exclamation-triangle',
                'color' => '#ef4444',
            ],
        ];
    }
    
    protected function getFilterOptions(): array
    {
        return [
            'all' => 'All Events',
            'success' => 'Success',
            'info' => 'Information',
            'warning' => 'Warning',
            'error' => 'Error',
        ];
    }
    
    public function getFilterOptions(): array
    {
        return $this->getFilterOptions();
    }
}