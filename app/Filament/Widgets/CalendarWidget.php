<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

/**
 * Calendar Widget with FullCalendar integration
 * Features: Drag & drop events, multiple views, event management
 */
class CalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.calendar-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 6;
    
    public ?string $viewType = 'dayGridMonth';
    
    protected function getViewData(): array
    {
        return [
            'viewType' => $this->viewType,
            'events' => $this->getEvents(),
            'viewOptions' => $this->getViewOptions(),
        ];
    }
    
    protected function getEvents(): array
    {
        // Mock events data - in a real application, this would come from a database
        return [
            [
                'id' => 1,
                'title' => 'Team Meeting',
                'start' => now()->addDays(1)->format('Y-m-d') . 'T10:00:00',
                'end' => now()->addDays(1)->format('Y-m-d') . 'T11:00:00',
                'color' => '#3b82f6',
                'description' => 'Weekly team standup meeting',
            ],
            [
                'id' => 2,
                'title' => 'Project Deadline',
                'start' => now()->addDays(3)->format('Y-m-d'),
                'color' => '#ef4444',
                'description' => 'Final project submission deadline',
            ],
            [
                'id' => 3,
                'title' => 'Client Presentation',
                'start' => now()->addDays(5)->format('Y-m-d') . 'T14:00:00',
                'end' => now()->addDays(5)->format('Y-m-d') . 'T15:30:00',
                'color' => '#10b981',
                'description' => 'Present project progress to client',
            ],
            [
                'id' => 4,
                'title' => 'Training Session',
                'start' => now()->addDays(7)->format('Y-m-d') . 'T09:00:00',
                'end' => now()->addDays(7)->format('Y-m-d') . 'T17:00:00',
                'color' => '#f59e0b',
                'description' => 'New technology training workshop',
            ],
            [
                'id' => 5,
                'title' => 'Review Meeting',
                'start' => now()->addDays(10)->format('Y-m-d') . 'T13:00:00',
                'end' => now()->addDays(10)->format('Y-m-d') . 'T14:00:00',
                'color' => '#8b5cf6',
                'description' => 'Monthly performance review',
            ],
        ];
    }
    
    protected function getViewOptions(): array
    {
        return [
            'dayGridMonth' => 'Month View',
            'timeGridWeek' => 'Week View',
            'timeGridDay' => 'Day View',
            'listWeek' => 'List View',
        ];
    }
    
    public function getViewTypeOptions(): array
    {
        return $this->getViewOptions();
    }
}