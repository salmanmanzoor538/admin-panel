<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;

/**
 * Grid.js Table Widget for advanced data display
 * Features: Sorting, searching, pagination, responsive design
 */
class GridTableWidget extends Widget
{
    protected static string $view = 'filament.widgets.grid-table-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 4;
    
    public ?string $tableType = 'users';
    
    protected function getViewData(): array
    {
        return [
            'tableType' => $this->tableType,
            'data' => $this->getTableData(),
            'columns' => $this->getTableColumns(),
        ];
    }
    
    protected function getTableData(): array
    {
        return match ($this->tableType) {
            'users' => $this->getUsersData(),
            'posts' => $this->getPostsData(),
            'orders' => $this->getOrdersData(),
            default => [],
        };
    }
    
    protected function getTableColumns(): array
    {
        return match ($this->tableType) {
            'users' => [
                ['name' => 'ID', 'id' => 'id', 'sortable' => true],
                ['name' => 'Name', 'id' => 'name', 'sortable' => true],
                ['name' => 'Email', 'id' => 'email', 'sortable' => true],
                ['name' => 'Role', 'id' => 'role', 'sortable' => true],
                ['name' => 'Created', 'id' => 'created_at', 'sortable' => true],
                ['name' => 'Actions', 'id' => 'actions', 'sortable' => false],
            ],
            'posts' => [
                ['name' => 'ID', 'id' => 'id', 'sortable' => true],
                ['name' => 'Title', 'id' => 'title', 'sortable' => true],
                ['name' => 'Category', 'id' => 'category', 'sortable' => true],
                ['name' => 'Status', 'id' => 'status', 'sortable' => true],
                ['name' => 'Author', 'id' => 'author', 'sortable' => true],
                ['name' => 'Created', 'id' => 'created_at', 'sortable' => true],
                ['name' => 'Actions', 'id' => 'actions', 'sortable' => false],
            ],
            'orders' => [
                ['name' => 'ID', 'id' => 'id', 'sortable' => true],
                ['name' => 'Customer', 'id' => 'customer', 'sortable' => true],
                ['name' => 'Total', 'id' => 'total', 'sortable' => true],
                ['name' => 'Status', 'id' => 'status', 'sortable' => true],
                ['name' => 'Date', 'id' => 'created_at', 'sortable' => true],
                ['name' => 'Actions', 'id' => 'actions', 'sortable' => false],
            ],
            default => [],
        };
    }
    
    protected function getUsersData(): array
    {
        return User::with('roles')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()?->name ?? 'User',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'actions' => $this->getActionButtons('users', $user->id),
            ];
        })->toArray();
    }
    
    protected function getPostsData(): array
    {
        return Post::with(['category', 'user'])->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'category' => $post->category?->name ?? 'Uncategorized',
                'status' => ucfirst($post->status),
                'author' => $post->user?->name ?? 'Unknown',
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'actions' => $this->getActionButtons('posts', $post->id),
            ];
        })->toArray();
    }
    
    protected function getOrdersData(): array
    {
        // Mock data for orders since we don't have an Order model yet
        return [
            [
                'id' => 1,
                'customer' => 'John Doe',
                'total' => '$99.99',
                'status' => 'Completed',
                'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
                'actions' => $this->getActionButtons('orders', 1),
            ],
            [
                'id' => 2,
                'customer' => 'Jane Smith',
                'total' => '$149.99',
                'status' => 'Pending',
                'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
                'actions' => $this->getActionButtons('orders', 2),
            ],
            [
                'id' => 3,
                'customer' => 'Bob Johnson',
                'total' => '$79.99',
                'status' => 'Shipped',
                'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
                'actions' => $this->getActionButtons('orders', 3),
            ],
        ];
    }
    
    protected function getActionButtons(string $type, int $id): string
    {
        return "
            <div class='flex space-x-2'>
                <button class='px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600' onclick='view{$type}($id)'>
                    View
                </button>
                <button class='px-2 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600' onclick='edit{$type}($id)'>
                    Edit
                </button>
                <button class='px-2 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600' onclick='delete{$type}($id)'>
                    Delete
                </button>
            </div>
        ";
    }
    
    public function getTableTypeOptions(): array
    {
        return [
            'users' => 'Users',
            'posts' => 'Posts',
            'orders' => 'Orders',
        ];
    }
}