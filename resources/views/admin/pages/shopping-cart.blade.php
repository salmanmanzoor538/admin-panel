<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .cart-item {
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .quantity-btn {
            transition: all 0.2s ease;
        }
        .quantity-btn:hover {
            transform: scale(1.1);
        }
        .remove-btn {
            transition: all 0.2s ease;
        }
        .remove-btn:hover {
            transform: scale(1.1);
            color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-900">Shopping Cart</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-shopping-cart mr-1"></i>
                            <span id="cart-count">0</span> items
                        </span>
                        <button onclick="clearCart()" class="text-sm text-red-600 hover:text-red-800">
                            <i class="fas fa-trash mr-1"></i>
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Cart Items</h2>
                        </div>
                        
                        <div id="cart-items" class="divide-y divide-gray-200">
                            <!-- Cart items will be loaded here -->
                        </div>
                        
                        <!-- Empty Cart State -->
                        <div id="empty-cart" class="p-12 text-center hidden">
                            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                            <p class="text-gray-500 mb-6">Add some items to get started</p>
                            <a href="{{ url('/admin') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm sticky top-8">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" id="subtotal">$0.00</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium" id="shipping">$0.00</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium" id="tax">$0.00</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-lg font-semibold text-gray-900" id="total">$0.00</span>
                                </div>
                            </div>
                            
                            <button onclick="proceedToCheckout()" 
                                    class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors">
                                <i class="fas fa-credit-card mr-2"></i>
                                Proceed to Checkout
                            </button>
                            
                            <button onclick="saveForLater()" 
                                    class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-bookmark mr-2"></i>
                                Save for Later
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="success-notification" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hidden z-50">
        <i class="fas fa-check mr-2"></i>
        <span id="success-message">Item updated successfully!</span>
    </div>

    <script>
        // Mock cart data - in a real application, this would come from a database or API
        let cartItems = [
            {
                id: 1,
                name: 'Premium Wireless Headphones',
                price: 199.99,
                quantity: 1,
                image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&h=300&fit=crop',
                description: 'High-quality wireless headphones with noise cancellation'
            },
            {
                id: 2,
                name: 'Smart Watch Series 5',
                price: 299.99,
                quantity: 2,
                image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=300&fit=crop',
                description: 'Advanced smartwatch with health monitoring features'
            },
            {
                id: 3,
                name: 'Wireless Charging Pad',
                price: 49.99,
                quantity: 1,
                image: 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=300&fit=crop',
                description: 'Fast wireless charging pad for multiple devices'
            }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            renderCartItems();
            updateOrderSummary();
        });

        function renderCartItems() {
            const container = document.getElementById('cart-items');
            const emptyCart = document.getElementById('empty-cart');
            
            if (cartItems.length === 0) {
                container.innerHTML = '';
                emptyCart.classList.remove('hidden');
                return;
            }
            
            emptyCart.classList.add('hidden');
            
            container.innerHTML = cartItems.map(item => `
                <div class="cart-item p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded-lg">
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-medium text-gray-900 truncate">${item.name}</h3>
                            <p class="text-sm text-gray-500 mt-1">${item.description}</p>
                            <div class="flex items-center mt-2">
                                <span class="text-lg font-semibold text-gray-900">$${item.price.toFixed(2)}</span>
                                <span class="text-sm text-gray-500 ml-2">each</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button onclick="updateQuantity(${item.id}, -1)" 
                                        class="quantity-btn px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="px-4 py-2 text-gray-900 font-medium">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 1)" 
                                        class="quantity-btn px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">
                                    $${(item.price * item.quantity).toFixed(2)}
                                </div>
                            </div>
                            
                            <button onclick="removeItem(${item.id})" 
                                    class="remove-btn p-2 text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function updateQuantity(itemId, change) {
            const item = cartItems.find(item => item.id === itemId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeItem(itemId);
                    return;
                }
                renderCartItems();
                updateOrderSummary();
                showSuccessNotification('Quantity updated');
            }
        }

        function removeItem(itemId) {
            cartItems = cartItems.filter(item => item.id !== itemId);
            renderCartItems();
            updateOrderSummary();
            showSuccessNotification('Item removed from cart');
        }

        function updateOrderSummary() {
            const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const shipping = subtotal > 100 ? 0 : 9.99;
            const tax = subtotal * 0.08; // 8% tax
            const total = subtotal + shipping + tax;
            
            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('shipping').textContent = `$${shipping.toFixed(2)}`;
            document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;
            document.getElementById('cart-count').textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                cartItems = [];
                renderCartItems();
                updateOrderSummary();
                showSuccessNotification('Cart cleared');
            }
        }

        function proceedToCheckout() {
            if (cartItems.length === 0) {
                alert('Your cart is empty');
                return;
            }
            
            // In a real application, this would redirect to checkout page
            alert('Redirecting to checkout...');
        }

        function saveForLater() {
            if (cartItems.length === 0) {
                alert('Your cart is empty');
                return;
            }
            
            // In a real application, this would save cart items for later
            showSuccessNotification('Cart saved for later');
        }

        function showSuccessNotification(message) {
            const notification = document.getElementById('success-notification');
            const messageEl = document.getElementById('success-message');
            
            messageEl.textContent = message;
            notification.classList.remove('hidden');
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>