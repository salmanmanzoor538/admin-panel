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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * E-commerce Page - Complete e-commerce functionality
 * Features: Shopping cart, checkout, orders, wishlist, invoice, profile
 */
class EcommercePage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static string $view = 'filament.pages.ecommerce-page';
    
    protected static ?string $title = 'E-commerce';
    
    protected static ?string $navigationLabel = 'E-commerce';
    
    protected static ?int $navigationSort = 8;
    
    protected static ?string $navigationGroup = 'E-commerce';
    
    public ?array $data = [];
    public ?string $activeTab = 'cart';
    public ?array $cartItems = [];
    public ?array $wishlistItems = [];
    public ?array $orders = [];
    public ?array $profile = [];
    
    public function mount(): void
    {
        $this->form->fill();
        $this->loadSampleData();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('E-commerce')
                    ->tabs([
                        Tabs\Tab::make('Shopping Cart')
                            ->schema([
                                Section::make('Cart Items')
                                    ->schema([
                                        Placeholder::make('cart_items')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="cart-items">
                                                    <!-- Cart items will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Cart Summary')
                                    ->schema([
                                        Placeholder::make('cart_summary')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="cart-summary">
                                                    <!-- Cart summary will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Checkout')
                            ->schema([
                                Section::make('Billing Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('billing_first_name')
                                                    ->label('First Name')
                                                    ->required()
                                                    ->placeholder('Enter first name'),
                                                    
                                                TextInput::make('billing_last_name')
                                                    ->label('Last Name')
                                                    ->required()
                                                    ->placeholder('Enter last name'),
                                                    
                                                TextInput::make('billing_email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->required()
                                                    ->placeholder('Enter email address'),
                                                    
                                                TextInput::make('billing_phone')
                                                    ->label('Phone')
                                                    ->tel()
                                                    ->required()
                                                    ->placeholder('Enter phone number'),
                                                    
                                                TextInput::make('billing_address')
                                                    ->label('Address')
                                                    ->required()
                                                    ->placeholder('Enter street address'),
                                                    
                                                TextInput::make('billing_city')
                                                    ->label('City')
                                                    ->required()
                                                    ->placeholder('Enter city'),
                                                    
                                                TextInput::make('billing_state')
                                                    ->label('State/Province')
                                                    ->required()
                                                    ->placeholder('Enter state or province'),
                                                    
                                                TextInput::make('billing_zip')
                                                    ->label('ZIP/Postal Code')
                                                    ->required()
                                                    ->placeholder('Enter ZIP or postal code'),
                                                    
                                                Select::make('billing_country')
                                                    ->label('Country')
                                                    ->options([
                                                        'US' => 'United States',
                                                        'CA' => 'Canada',
                                                        'GB' => 'United Kingdom',
                                                        'DE' => 'Germany',
                                                        'FR' => 'France',
                                                        'IT' => 'Italy',
                                                        'ES' => 'Spain',
                                                        'AU' => 'Australia',
                                                        'JP' => 'Japan',
                                                        'CN' => 'China',
                                                    ])
                                                    ->required()
                                                    ->placeholder('Select country'),
                                            ]),
                                    ]),
                                    
                                Section::make('Shipping Information')
                                    ->schema([
                                        Checkbox::make('same_as_billing')
                                            ->label('Same as billing address')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateShippingAddress()),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('shipping_first_name')
                                                    ->label('First Name')
                                                    ->placeholder('Enter first name'),
                                                    
                                                TextInput::make('shipping_last_name')
                                                    ->label('Last Name')
                                                    ->placeholder('Enter last name'),
                                                    
                                                TextInput::make('shipping_address')
                                                    ->label('Address')
                                                    ->placeholder('Enter street address'),
                                                    
                                                TextInput::make('shipping_city')
                                                    ->label('City')
                                                    ->placeholder('Enter city'),
                                                    
                                                TextInput::make('shipping_state')
                                                    ->label('State/Province')
                                                    ->placeholder('Enter state or province'),
                                                    
                                                TextInput::make('shipping_zip')
                                                    ->label('ZIP/Postal Code')
                                                    ->placeholder('Enter ZIP or postal code'),
                                                    
                                                Select::make('shipping_country')
                                                    ->label('Country')
                                                    ->options([
                                                        'US' => 'United States',
                                                        'CA' => 'Canada',
                                                        'GB' => 'United Kingdom',
                                                        'DE' => 'Germany',
                                                        'FR' => 'France',
                                                        'IT' => 'Italy',
                                                        'ES' => 'Spain',
                                                        'AU' => 'Australia',
                                                        'JP' => 'Japan',
                                                        'CN' => 'China',
                                                    ])
                                                    ->placeholder('Select country'),
                                            ]),
                                    ]),
                                    
                                Section::make('Payment Information')
                                    ->schema([
                                        Select::make('payment_method')
                                            ->label('Payment Method')
                                            ->options([
                                                'credit_card' => 'Credit Card',
                                                'debit_card' => 'Debit Card',
                                                'paypal' => 'PayPal',
                                                'apple_pay' => 'Apple Pay',
                                                'google_pay' => 'Google Pay',
                                                'bank_transfer' => 'Bank Transfer',
                                                'crypto' => 'Cryptocurrency',
                                            ])
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updatePaymentMethod()),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('card_number')
                                                    ->label('Card Number')
                                                    ->placeholder('1234 5678 9012 3456')
                                                    ->visible(fn($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),
                                                    
                                                TextInput::make('card_holder')
                                                    ->label('Card Holder Name')
                                                    ->placeholder('John Doe')
                                                    ->visible(fn($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),
                                                    
                                                TextInput::make('expiry_date')
                                                    ->label('Expiry Date')
                                                    ->placeholder('MM/YY')
                                                    ->visible(fn($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),
                                                    
                                                TextInput::make('cvv')
                                                    ->label('CVV')
                                                    ->placeholder('123')
                                                    ->visible(fn($get) => in_array($get('payment_method'), ['credit_card', 'debit_card'])),
                                            ]),
                                    ]),
                                    
                                Section::make('Order Summary')
                                    ->schema([
                                        Placeholder::make('order_summary')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="order-summary">
                                                    <!-- Order summary will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Orders')
                            ->schema([
                                Section::make('Order History')
                                    ->schema([
                                        Placeholder::make('order_history')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="order-history">
                                                    <!-- Order history will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Wishlist')
                            ->schema([
                                Section::make('Wishlist Items')
                                    ->schema([
                                        Placeholder::make('wishlist_items')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="wishlist-items">
                                                    <!-- Wishlist items will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Invoice')
                            ->schema([
                                Section::make('Invoice Details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('invoice_number')
                                                    ->label('Invoice Number')
                                                    ->default('INV-2024-001')
                                                    ->disabled(),
                                                    
                                                DatePicker::make('invoice_date')
                                                    ->label('Invoice Date')
                                                    ->default(now())
                                                    ->disabled(),
                                                    
                                                TextInput::make('due_date')
                                                    ->label('Due Date')
                                                    ->default(now()->addDays(30))
                                                    ->disabled(),
                                                    
                                                Select::make('invoice_status')
                                                    ->label('Status')
                                                    ->options([
                                                        'draft' => 'Draft',
                                                        'sent' => 'Sent',
                                                        'paid' => 'Paid',
                                                        'overdue' => 'Overdue',
                                                        'cancelled' => 'Cancelled',
                                                    ])
                                                    ->default('sent'),
                                            ]),
                                            
                                        Placeholder::make('invoice_content')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="invoice-content">
                                                    <!-- Invoice content will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Profile')
                            ->schema([
                                Section::make('Personal Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('profile_first_name')
                                                    ->label('First Name')
                                                    ->placeholder('Enter first name'),
                                                    
                                                TextInput::make('profile_last_name')
                                                    ->label('Last Name')
                                                    ->placeholder('Enter last name'),
                                                    
                                                TextInput::make('profile_email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->placeholder('Enter email address'),
                                                    
                                                TextInput::make('profile_phone')
                                                    ->label('Phone')
                                                    ->tel()
                                                    ->placeholder('Enter phone number'),
                                                    
                                                DatePicker::make('profile_birth_date')
                                                    ->label('Birth Date')
                                                    ->placeholder('Select birth date'),
                                                    
                                                Select::make('profile_gender')
                                                    ->label('Gender')
                                                    ->options([
                                                        'male' => 'Male',
                                                        'female' => 'Female',
                                                        'other' => 'Other',
                                                        'prefer_not_to_say' => 'Prefer not to say',
                                                    ])
                                                    ->placeholder('Select gender'),
                                            ]),
                                    ]),
                                    
                                Section::make('Address Information')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('profile_address')
                                                    ->label('Address')
                                                    ->placeholder('Enter street address'),
                                                    
                                                TextInput::make('profile_city')
                                                    ->label('City')
                                                    ->placeholder('Enter city'),
                                                    
                                                TextInput::make('profile_state')
                                                    ->label('State/Province')
                                                    ->placeholder('Enter state or province'),
                                                    
                                                TextInput::make('profile_zip')
                                                    ->label('ZIP/Postal Code')
                                                    ->placeholder('Enter ZIP or postal code'),
                                                    
                                                Select::make('profile_country')
                                                    ->label('Country')
                                                    ->options([
                                                        'US' => 'United States',
                                                        'CA' => 'Canada',
                                                        'GB' => 'United Kingdom',
                                                        'DE' => 'Germany',
                                                        'FR' => 'France',
                                                        'IT' => 'Italy',
                                                        'ES' => 'Spain',
                                                        'AU' => 'Australia',
                                                        'JP' => 'Japan',
                                                        'CN' => 'China',
                                                    ])
                                                    ->placeholder('Select country'),
                                            ]),
                                    ]),
                                    
                                Section::make('Preferences')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('profile_language')
                                                    ->label('Language')
                                                    ->options([
                                                        'en' => 'English',
                                                        'es' => 'Spanish',
                                                        'fr' => 'French',
                                                        'de' => 'German',
                                                        'it' => 'Italian',
                                                        'pt' => 'Portuguese',
                                                        'ru' => 'Russian',
                                                        'zh' => 'Chinese',
                                                        'ja' => 'Japanese',
                                                        'ko' => 'Korean',
                                                    ])
                                                    ->default('en'),
                                                    
                                                Select::make('profile_currency')
                                                    ->label('Currency')
                                                    ->options([
                                                        'USD' => 'US Dollar',
                                                        'EUR' => 'Euro',
                                                        'GBP' => 'British Pound',
                                                        'JPY' => 'Japanese Yen',
                                                        'CAD' => 'Canadian Dollar',
                                                        'AUD' => 'Australian Dollar',
                                                        'CHF' => 'Swiss Franc',
                                                        'CNY' => 'Chinese Yuan',
                                                    ])
                                                    ->default('USD'),
                                                    
                                                Toggle::make('profile_newsletter')
                                                    ->label('Subscribe to Newsletter')
                                                    ->default(true),
                                                    
                                                Toggle::make('profile_sms_notifications')
                                                    ->label('SMS Notifications')
                                                    ->default(false),
                                            ]),
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
            Action::make('place_order')
                ->label('Place Order')
                ->icon('heroicon-o-shopping-bag')
                ->color('success')
                ->action('placeOrder')
                ->visible(fn() => $this->activeTab === 'checkout'),
                
            Action::make('download_invoice')
                ->label('Download Invoice')
                ->icon('heroicon-o-arrow-down-tray')
                ->action('downloadInvoice')
                ->visible(fn() => $this->activeTab === 'invoice'),
                
            Action::make('save_profile')
                ->label('Save Profile')
                ->icon('heroicon-o-user')
                ->action('saveProfile')
                ->visible(fn() => $this->activeTab === 'profile'),
        ];
    }
    
    protected function loadSampleData(): void
    {
        $this->cartItems = [
            [
                'id' => 1,
                'name' => 'MacBook Pro 16"',
                'price' => 2499.00,
                'quantity' => 1,
                'image' => 'https://via.placeholder.com/100x100?text=MacBook',
                'category' => 'Electronics',
            ],
            [
                'id' => 2,
                'name' => 'iPhone 15 Pro',
                'price' => 999.00,
                'quantity' => 2,
                'image' => 'https://via.placeholder.com/100x100?text=iPhone',
                'category' => 'Electronics',
            ],
            [
                'id' => 3,
                'name' => 'AirPods Pro',
                'price' => 249.00,
                'quantity' => 1,
                'image' => 'https://via.placeholder.com/100x100?text=AirPods',
                'category' => 'Accessories',
            ],
        ];
        
        $this->wishlistItems = [
            [
                'id' => 4,
                'name' => 'iPad Pro 12.9"',
                'price' => 1099.00,
                'image' => 'https://via.placeholder.com/100x100?text=iPad',
                'category' => 'Electronics',
            ],
            [
                'id' => 5,
                'name' => 'Apple Watch Series 9',
                'price' => 399.00,
                'image' => 'https://via.placeholder.com/100x100?text=Watch',
                'category' => 'Wearables',
            ],
        ];
        
        $this->orders = [
            [
                'id' => 'ORD-2024-001',
                'date' => '2024-01-15',
                'status' => 'completed',
                'total' => 1249.00,
                'items' => 2,
            ],
            [
                'id' => 'ORD-2024-002',
                'date' => '2024-01-10',
                'status' => 'shipped',
                'total' => 599.00,
                'items' => 1,
            ],
            [
                'id' => 'ORD-2024-003',
                'date' => '2024-01-05',
                'status' => 'processing',
                'total' => 199.00,
                'items' => 1,
            ],
        ];
        
        $this->profile = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1 (555) 123-4567',
            'birth_date' => '1990-05-15',
            'gender' => 'male',
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'country' => 'US',
            'language' => 'en',
            'currency' => 'USD',
            'newsletter' => true,
            'sms_notifications' => false,
        ];
    }
    
    public function updateShippingAddress(): void
    {
        // Copy billing address to shipping address
        Notification::make()
            ->title('Shipping address updated')
            ->success()
            ->send();
    }
    
    public function updatePaymentMethod(): void
    {
        Notification::make()
            ->title('Payment method updated')
            ->success()
            ->send();
    }
    
    public function placeOrder(): void
    {
        Notification::make()
            ->title('Order placed successfully')
            ->success()
            ->send();
    }
    
    public function downloadInvoice(): void
    {
        Notification::make()
            ->title('Invoice downloaded')
            ->success()
            ->send();
    }
    
    public function saveProfile(): void
    {
        Notification::make()
            ->title('Profile saved successfully')
            ->success()
            ->send();
    }
    
    public function addToCart(int $productId): void
    {
        Notification::make()
            ->title('Product added to cart')
            ->success()
            ->send();
    }
    
    public function removeFromCart(int $productId): void
    {
        Notification::make()
            ->title('Product removed from cart')
            ->success()
            ->send();
    }
    
    public function addToWishlist(int $productId): void
    {
        Notification::make()
            ->title('Product added to wishlist')
            ->success()
            ->send();
    }
    
    public function removeFromWishlist(int $productId): void
    {
        Notification::make()
            ->title('Product removed from wishlist')
            ->success()
            ->send();
    }
}