<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Advanced Tables Widget - Integration with multiple table libraries
 * Features: DataTables, JsGrid, GridJS with advanced functionality
 */
class AdvancedTablesWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.advanced-tables-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 13;
    
    public ?string $tableLibrary = 'datatables';
    public ?string $tableType = 'users';
    public ?bool $serverSide = true;
    public ?bool $pagination = true;
    public ?bool $searching = true;
    public ?bool $sorting = true;
    public ?bool $exporting = true;
    public ?string $pageLength = '10';
    public ?string $theme = 'default';
    
    protected function getViewData(): array
    {
        return [
            'tableLibrary' => $this->tableLibrary,
            'tableType' => $this->tableType,
            'serverSide' => $this->serverSide,
            'pagination' => $this->pagination,
            'searching' => $this->searching,
            'sorting' => $this->sorting,
            'exporting' => $this->exporting,
            'pageLength' => $this->pageLength,
            'theme' => $this->theme,
            'tableLibraries' => $this->getTableLibraries(),
            'tableTypes' => $this->getTableTypes(),
            'themes' => $this->getThemes(),
            'sampleData' => $this->getSampleData(),
        ];
    }
    
    protected function getTableLibraries(): array
    {
        return [
            'datatables' => [
                'name' => 'DataTables',
                'description' => 'Advanced table control with extensive features',
                'icon' => 'fas fa-table',
                'features' => ['Sorting', 'Searching', 'Pagination', 'Export', 'Server-side'],
            ],
            'jsgrid' => [
                'name' => 'JsGrid',
                'description' => 'Lightweight data grid with inline editing',
                'icon' => 'fas fa-edit',
                'features' => ['Inline Edit', 'CRUD', 'Filtering', 'Paging', 'Sorting'],
            ],
            'gridjs' => [
                'name' => 'Grid.js',
                'description' => 'Modern table library with React-like API',
                'icon' => 'fas fa-th',
                'features' => ['Modern API', 'React-like', 'Lightweight', 'Customizable'],
            ],
        ];
    }
    
    protected function getTableTypes(): array
    {
        return [
            'users' => [
                'name' => 'Users Table',
                'description' => 'User management with roles and permissions',
                'icon' => 'fas fa-users',
                'columns' => ['ID', 'Name', 'Email', 'Role', 'Status', 'Created'],
            ],
            'orders' => [
                'name' => 'Orders Table',
                'description' => 'E-commerce orders with status tracking',
                'icon' => 'fas fa-shopping-cart',
                'columns' => ['ID', 'Customer', 'Product', 'Amount', 'Status', 'Date'],
            ],
            'products' => [
                'name' => 'Products Table',
                'description' => 'Product catalog with inventory management',
                'icon' => 'fas fa-box',
                'columns' => ['ID', 'Name', 'Category', 'Price', 'Stock', 'Status'],
            ],
            'transactions' => [
                'name' => 'Transactions Table',
                'description' => 'Financial transactions with crypto support',
                'icon' => 'fas fa-coins',
                'columns' => ['ID', 'Type', 'Amount', 'Currency', 'Status', 'Date'],
            ],
        ];
    }
    
    protected function getThemes(): array
    {
        return [
            'default' => [
                'name' => 'Default',
                'description' => 'Clean and minimal design',
                'preview' => 'bg-gray-100',
            ],
            'bootstrap' => [
                'name' => 'Bootstrap',
                'description' => 'Bootstrap-styled table',
                'preview' => 'bg-blue-100',
            ],
            'material' => [
                'name' => 'Material Design',
                'description' => 'Google Material Design',
                'preview' => 'bg-green-100',
            ],
            'dark' => [
                'name' => 'Dark Theme',
                'description' => 'Dark mode table',
                'preview' => 'bg-gray-800',
            ],
        ];
    }
    
    protected function getSampleData(): array
    {
        return [
            'users' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin', 'status' => 'Active', 'created' => '2024-01-15'],
                ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'User', 'status' => 'Active', 'created' => '2024-01-16'],
                ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'role' => 'Editor', 'status' => 'Inactive', 'created' => '2024-01-17'],
                ['id' => 4, 'name' => 'Sarah Wilson', 'email' => 'sarah@example.com', 'role' => 'User', 'status' => 'Active', 'created' => '2024-01-18'],
                ['id' => 5, 'name' => 'David Brown', 'email' => 'david@example.com', 'role' => 'Admin', 'status' => 'Active', 'created' => '2024-01-19'],
            ],
            'orders' => [
                ['id' => 1, 'customer' => 'John Doe', 'product' => 'Laptop', 'amount' => '$1,299', 'status' => 'Completed', 'date' => '2024-01-15'],
                ['id' => 2, 'customer' => 'Jane Smith', 'product' => 'Phone', 'amount' => '$699', 'status' => 'Processing', 'date' => '2024-01-16'],
                ['id' => 3, 'customer' => 'Mike Johnson', 'product' => 'Tablet', 'amount' => '$499', 'status' => 'Shipped', 'date' => '2024-01-17'],
                ['id' => 4, 'customer' => 'Sarah Wilson', 'product' => 'Headphones', 'amount' => '$199', 'status' => 'Completed', 'date' => '2024-01-18'],
                ['id' => 5, 'customer' => 'David Brown', 'product' => 'Watch', 'amount' => '$299', 'status' => 'Pending', 'date' => '2024-01-19'],
            ],
            'products' => [
                ['id' => 1, 'name' => 'MacBook Pro', 'category' => 'Electronics', 'price' => '$1,999', 'stock' => '15', 'status' => 'Active'],
                ['id' => 2, 'name' => 'iPhone 15', 'category' => 'Electronics', 'price' => '$999', 'stock' => '25', 'status' => 'Active'],
                ['id' => 3, 'name' => 'iPad Air', 'category' => 'Electronics', 'price' => '$599', 'stock' => '10', 'status' => 'Active'],
                ['id' => 4, 'name' => 'AirPods Pro', 'category' => 'Accessories', 'price' => '$249', 'stock' => '50', 'status' => 'Active'],
                ['id' => 5, 'name' => 'Apple Watch', 'category' => 'Wearables', 'price' => '$399', 'stock' => '20', 'status' => 'Active'],
            ],
            'transactions' => [
                ['id' => 1, 'type' => 'Buy', 'amount' => '0.5 BTC', 'currency' => 'Bitcoin', 'status' => 'Completed', 'date' => '2024-01-15'],
                ['id' => 2, 'type' => 'Sell', 'amount' => '10 ETH', 'currency' => 'Ethereum', 'status' => 'Completed', 'date' => '2024-01-16'],
                ['id' => 3, 'type' => 'Buy', 'amount' => '1000 ADA', 'currency' => 'Cardano', 'status' => 'Pending', 'date' => '2024-01-17'],
                ['id' => 4, 'type' => 'Sell', 'amount' => '50 SOL', 'currency' => 'Solana', 'status' => 'Completed', 'date' => '2024-01-18'],
                ['id' => 5, 'type' => 'Buy', 'amount' => '500 DOT', 'currency' => 'Polkadot', 'status' => 'Processing', 'date' => '2024-01-19'],
            ],
        ];
    }
    
    public function getFormSchema(): array
    {
        return [
            Section::make('Table Configuration')
                ->schema([
                    Select::make('tableLibrary')
                        ->label('Table Library')
                        ->options(collect($this->getTableLibraries())->mapWithKeys(fn($lib, $key) => [$key => $lib['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateTable()),
                        
                    Select::make('tableType')
                        ->label('Table Type')
                        ->options(collect($this->getTableTypes())->mapWithKeys(fn($type, $key) => [$key => $type['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateTable()),
                        
                    Select::make('theme')
                        ->label('Theme')
                        ->options(collect($this->getThemes())->mapWithKeys(fn($theme, $key) => [$key => $theme['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateTable()),
                ])
                ->columns(3),
                
            Section::make('Table Options')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Toggle::make('serverSide')
                                ->label('Server-side Processing')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTable()),
                                
                            Toggle::make('pagination')
                                ->label('Enable Pagination')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTable()),
                                
                            Toggle::make('searching')
                                ->label('Enable Searching')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTable()),
                                
                            Toggle::make('sorting')
                                ->label('Enable Sorting')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTable()),
                                
                            Toggle::make('exporting')
                                ->label('Enable Export')
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTable()),
                                
                            Select::make('pageLength')
                                ->label('Page Length')
                                ->options([
                                    '5' => '5 rows',
                                    '10' => '10 rows',
                                    '25' => '25 rows',
                                    '50' => '50 rows',
                                    '100' => '100 rows',
                                ])
                                ->live()
                                ->afterStateUpdated(fn() => $this->updateTable()),
                        ]),
                ]),
        ];
    }
    
    public function updateTable(): void
    {
        $this->dispatch('table-updated', [
            'library' => $this->tableLibrary,
            'type' => $this->tableType,
            'theme' => $this->theme,
            'serverSide' => $this->serverSide,
            'pagination' => $this->pagination,
            'searching' => $this->searching,
            'sorting' => $this->sorting,
            'exporting' => $this->exporting,
            'pageLength' => $this->pageLength,
        ]);
        
        Notification::make()
            ->title('Table updated')
            ->success()
            ->send();
    }
    
    public function exportTable(): void
    {
        $this->dispatch('export-table');
        
        Notification::make()
            ->title('Table exported successfully')
            ->success()
            ->send();
    }
    
    public function refreshTable(): void
    {
        $this->dispatch('refresh-table');
        
        Notification::make()
            ->title('Table data refreshed')
            ->success()
            ->send();
    }
}