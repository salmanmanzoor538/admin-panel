<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

/**
 * Activity Feed Widget for displaying real-time user activities
 * Features: Real-time updates, activity filtering, user interactions
 */
class ActivityFeedWidget extends Widget
{
    protected static string $view = 'filament.widgets.activity-feed-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 9;
    
    public ?string $filter = 'all';
    
    protected function getViewData(): array
    {
        return [
            'filter' => $this->filter,
            'activities' => $this->getActivities(),
            'filterOptions' => $this->getFilterOptions(),
        ];
    }
    
    protected function getActivities(): array
    {
        // Mock activities data - in a real application, this would come from a database
        return [
            [
                'id' => 1,
                'user' => [
                    'name' => 'John Doe',
                    'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face',
                    'role' => 'Admin'
                ],
                'action' => 'created',
                'target' => 'new post',
                'description' => 'Created a new blog post titled "Getting Started with Laravel"',
                'time' => now()->subMinutes(5)->format('Y-m-d H:i:s'),
                'type' => 'post',
                'icon' => 'fas fa-file-alt',
                'color' => '#3b82f6',
            ],
            [
                'id' => 2,
                'user' => [
                    'name' => 'Jane Smith',
                    'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=40&h=40&fit=crop&crop=face',
                    'role' => 'Editor'
                ],
                'action' => 'updated',
                'target' => 'user profile',
                'description' => 'Updated profile information and added new profile picture',
                'time' => now()->subMinutes(15)->format('Y-m-d H:i:s'),
                'type' => 'user',
                'icon' => 'fas fa-user-edit',
                'color' => '#10b981',
            ],
            [
                'id' => 3,
                'user' => [
                    'name' => 'Mike Johnson',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face',
                    'role' => 'User'
                ],
                'action' => 'commented',
                'target' => 'post',
                'description' => 'Left a comment on "Laravel Best Practices" post',
                'time' => now()->subMinutes(30)->format('Y-m-d H:i:s'),
                'type' => 'comment',
                'icon' => 'fas fa-comment',
                'color' => '#f59e0b',
            ],
            [
                'id' => 4,
                'user' => [
                    'name' => 'Sarah Wilson',
                    'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop&crop=face',
                    'role' => 'Moderator'
                ],
                'action' => 'deleted',
                'target' => 'spam comment',
                'description' => 'Removed a spam comment from the discussion forum',
                'time' => now()->subMinutes(45)->format('Y-m-d H:i:s'),
                'type' => 'moderation',
                'icon' => 'fas fa-trash',
                'color' => '#ef4444',
            ],
            [
                'id' => 5,
                'user' => [
                    'name' => 'David Brown',
                    'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=40&h=40&fit=crop&crop=face',
                    'role' => 'Admin'
                ],
                'action' => 'uploaded',
                'target' => 'file',
                'description' => 'Uploaded a new document: "Project Requirements.pdf"',
                'time' => now()->subHours(1)->format('Y-m-d H:i:s'),
                'type' => 'file',
                'icon' => 'fas fa-upload',
                'color' => '#8b5cf6',
            ],
            [
                'id' => 6,
                'user' => [
                    'name' => 'Lisa Davis',
                    'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=40&h=40&fit=crop&crop=face',
                    'role' => 'User'
                ],
                'action' => 'liked',
                'target' => 'post',
                'description' => 'Liked the post "Advanced Laravel Techniques"',
                'time' => now()->subHours(2)->format('Y-m-d H:i:s'),
                'type' => 'like',
                'icon' => 'fas fa-heart',
                'color' => '#ec4899',
            ],
            [
                'id' => 7,
                'user' => [
                    'name' => 'Tom Wilson',
                    'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=40&h=40&fit=crop&crop=face',
                    'role' => 'Editor'
                ],
                'action' => 'published',
                'target' => 'article',
                'description' => 'Published the article "Laravel 11 New Features"',
                'time' => now()->subHours(3)->format('Y-m-d H:i:s'),
                'type' => 'publish',
                'icon' => 'fas fa-globe',
                'color' => '#06b6d4',
            ],
            [
                'id' => 8,
                'user' => [
                    'name' => 'Emma Taylor',
                    'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=40&h=40&fit=crop&crop=face',
                    'role' => 'User'
                ],
                'action' => 'registered',
                'target' => 'account',
                'description' => 'Created a new account and completed profile setup',
                'time' => now()->subHours(4)->format('Y-m-d H:i:s'),
                'type' => 'registration',
                'icon' => 'fas fa-user-plus',
                'color' => '#10b981',
            ],
        ];
    }
    
    protected function getFilterOptions(): array
    {
        return [
            'all' => 'All Activities',
            'post' => 'Posts',
            'user' => 'Users',
            'comment' => 'Comments',
            'moderation' => 'Moderation',
            'file' => 'Files',
            'like' => 'Likes',
            'publish' => 'Publishing',
            'registration' => 'Registrations',
        ];
    }
    
    public function getFilterOptions(): array
    {
        return $this->getFilterOptions();
    }
}