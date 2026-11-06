<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">E-commerce Dashboard</h1>
                    <p class="text-gray-600 mt-1">Complete e-commerce functionality with cart, checkout, orders, and more</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Cart:</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ count($cartItems) }} items</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Wishlist:</span>
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">{{ count($wishlistItems) }} items</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- E-commerce Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($orders) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-dollar-sign text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Spent</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format(array_sum(array_column($orders, 'total')), 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-heart text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Wishlist Items</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($wishlistItems) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-box text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Cart Value</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems)), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{ $this->form }}
        </div>

        <!-- Additional E-commerce Components -->
        <div class="space-y-6">
            <!-- Product Recommendations -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recommended Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach([
                        ['name' => 'MacBook Air M2', 'price' => 1199, 'image' => 'https://via.placeholder.com/200x200?text=MacBook+Air', 'rating' => 4.8],
                        ['name' => 'iPhone 15', 'price' => 799, 'image' => 'https://via.placeholder.com/200x200?text=iPhone+15', 'rating' => 4.9],
                        ['name' => 'iPad Air', 'price' => 599, 'image' => 'https://via.placeholder.com/200x200?text=iPad+Air', 'rating' => 4.7],
                        ['name' => 'Apple Watch SE', 'price' => 249, 'image' => 'https://via.placeholder.com/200x200?text=Watch+SE', 'rating' => 4.6],
                    ] as $product)
                        <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $product['name'] }}</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">({{ $product['rating'] }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-gray-900">${{ number_format($product['price'], 2) }}</span>
                                    <div class="flex items-center space-x-2">
                                        <button onclick="addToWishlist({{ $loop->index + 6 }})" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button onclick="addToCart({{ $loop->index + 6 }})" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Status Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Order Status</h2>
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-box text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Order {{ $order['id'] }}</p>
                                <p class="text-sm text-gray-500">{{ $order['date'] }} • {{ $order['items'] }} items • ${{ number_format($order['total'], 2) }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $order['status'] === 'completed' ? 'bg-green-100 text-green-800' :
                                       ($order['status'] === 'shipped' ? 'bg-blue-100 text-blue-800' :
                                       ($order['status'] === 'processing' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Methods</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 border border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer">
                        <i class="fab fa-cc-visa text-3xl text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Visa</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer">
                        <i class="fab fa-cc-mastercard text-3xl text-red-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Mastercard</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer">
                        <i class="fab fa-paypal text-3xl text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">PayPal</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer">
                        <i class="fab fa-apple-pay text-3xl text-gray-900 mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Apple Pay</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Options -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Options</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <input type="radio" name="shipping" value="standard" class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <p class="font-medium text-gray-900">Standard Shipping</p>
                                <p class="text-sm text-gray-500">5-7 business days</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-gray-900">$9.99</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <input type="radio" name="shipping" value="express" class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <p class="font-medium text-gray-900">Express Shipping</p>
                                <p class="text-sm text-gray-500">2-3 business days</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-gray-900">$19.99</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <input type="radio" name="shipping" value="overnight" class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <p class="font-medium text-gray-900">Overnight Shipping</p>
                                <p class="text-sm text-gray-500">Next business day</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-gray-900">$39.99</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // E-commerce functionality
        document.addEventListener('DOMContentLoaded', function() {
            initializeEcommerce();
        });
        
        function initializeEcommerce() {
            renderCartItems();
            renderWishlistItems();
            renderOrderHistory();
            renderOrderSummary();
            renderInvoiceContent();
        }
        
        function renderCartItems() {
            const cartItems = @json($cartItems);
            const container = document.getElementById('cart-items');
            
            if (cartItems.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">Your cart is empty</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="space-y-4">';
            cartItems.forEach(item => {
                html += `
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">${item.name}</h3>
                            <p class="text-sm text-gray-500">${item.category}</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <button onclick="updateQuantity(${item.id}, -1)" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="px-3 py-1 bg-white rounded border">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 1)" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">$${(item.price * item.quantity).toFixed(2)}</p>
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 mt-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderWishlistItems() {
            const wishlistItems = @json($wishlistItems);
            const container = document.getElementById('wishlist-items');
            
            if (wishlistItems.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-heart text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">Your wishlist is empty</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
            wishlistItems.forEach(item => {
                html += `
                    <div class="bg-gray-50 rounded-lg p-4">
                        <img src="${item.image}" alt="${item.name}" class="w-full h-32 object-cover rounded mb-3">
                        <h3 class="font-medium text-gray-900 mb-2">${item.name}</h3>
                        <p class="text-sm text-gray-500 mb-2">${item.category}</p>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-900">$${item.price.toFixed(2)}</span>
                            <div class="flex items-center space-x-2">
                                <button onclick="addToCart(${item.id})" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                    <i class="fas fa-shopping-cart mr-1"></i>Add to Cart
                                </button>
                                <button onclick="removeFromWishlist(${item.id})" class="p-1 text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderOrderHistory() {
            const orders = @json($orders);
            const container = document.getElementById('order-history');
            
            let html = '<div class="space-y-4">';
            orders.forEach(order => {
                html += `
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="font-medium text-gray-900">Order ${order.id}</h3>
                                <p class="text-sm text-gray-500">${order.date} • ${order.items} items</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">$${order.total.toFixed(2)}</p>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    ${order.status === 'completed' ? 'bg-green-100 text-green-800' :
                                       (order.status === 'shipped' ? 'bg-blue-100 text-blue-800' :
                                       (order.status === 'processing' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-gray-100 text-gray-800'))}">
                                    ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="viewOrder('${order.id}')" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                View Details
                            </button>
                            <button onclick="trackOrder('${order.id}')" class="px-3 py-1 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">
                                Track Order
                            </button>
                            <button onclick="reorder('${order.id}')" class="px-3 py-1 bg-green-500 text-white rounded text-sm hover:bg-green-600">
                                Reorder
                            </button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderOrderSummary() {
            const cartItems = @json($cartItems);
            const container = document.getElementById('order-summary');
            
            const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.08; // 8% tax
            const shipping = 9.99;
            const total = subtotal + tax + shipping;
            
            container.innerHTML = `
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">$${subtotal.toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium">$${tax.toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">$${shipping.toFixed(2)}</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">$${total.toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        function renderInvoiceContent() {
            const container = document.getElementById('invoice-content');
            
            container.innerHTML = `
                <div class="space-y-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Invoice</h2>
                            <p class="text-gray-600">Invoice #INV-2024-001</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">Date: ${new Date().toLocaleDateString()}</p>
                            <p class="text-gray-600">Due: ${new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toLocaleDateString()}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Bill To:</h3>
                            <p class="text-gray-600">John Doe<br>123 Main Street<br>New York, NY 10001</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-2">Ship To:</h3>
                            <p class="text-gray-600">John Doe<br>123 Main Street<br>New York, NY 10001</p>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">MacBook Pro 16"</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$2,499.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$2,499.00</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">iPhone 15 Pro</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$999.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$1,998.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="flex justify-end">
                        <div class="w-64">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">$4,497.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="font-medium">$359.76</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">$9.99</span>
                                </div>
                                <div class="border-t pt-2">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-bold text-gray-900">Total</span>
                                        <span class="text-lg font-bold text-gray-900">$4,866.75</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        function updateQuantity(productId, change) {
            // Update quantity logic
            showNotification('Quantity updated', 'success');
        }
        
        function removeFromCart(productId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                showNotification('Item removed from cart', 'success');
            }
        }
        
        function addToCart(productId) {
            showNotification('Product added to cart', 'success');
        }
        
        function addToWishlist(productId) {
            showNotification('Product added to wishlist', 'success');
        }
        
        function removeFromWishlist(productId) {
            if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                showNotification('Item removed from wishlist', 'success');
            }
        }
        
        function viewOrder(orderId) {
            showNotification(`Viewing order ${orderId}`, 'info');
        }
        
        function trackOrder(orderId) {
            showNotification(`Tracking order ${orderId}`, 'info');
        }
        
        function reorder(orderId) {
            showNotification(`Reordering ${orderId}`, 'success');
        }
        
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                type === 'warning' ? 'bg-yellow-500' :
                'bg-blue-500'
            } text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-filament-panels::page>