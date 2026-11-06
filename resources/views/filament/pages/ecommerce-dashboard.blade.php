<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">E-commerce Dashboard</h1>
                    <p class="text-gray-600 mt-1">Track your sales, revenue, and customer insights</p>
                </div>
                <div class="flex items-center space-x-3">
                    <select class="text-sm border-gray-300 rounded-md" onchange="changeTimeRange(this.value)">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month" selected>This Month</option>
                        <option value="year">This Year</option>
                    </select>
                    <button onclick="exportSalesData()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-download mr-2"></i>Export Sales
                    </button>
                </div>
            </div>
        </div>

        <!-- E-commerce Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-revenue">$45,678</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>15.3%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-orders">1,234</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>8.7%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Customers</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-customers">8,765</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>12.1%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-percentage text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Conversion Rate</p>
                        <p class="text-2xl font-bold text-gray-900" id="conversion-rate">3.24%</p>
                        <p class="text-sm text-red-600">
                            <i class="fas fa-arrow-down mr-1"></i>0.8%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sales Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Sales Overview</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Revenue</span>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="sales-chart"></canvas>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Top Products</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Sales</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="products-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders and Customer Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">#ORD-001</p>
                                <p class="text-xs text-gray-600">John Doe</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$299.99</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Completed
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">#ORD-002</p>
                                <p class="text-xs text-gray-600">Jane Smith</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$149.99</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Processing
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">#ORD-003</p>
                                <p class="text-xs text-gray-600">Mike Johnson</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$89.99</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Pending
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Insights -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Customer Insights</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View Details</a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-plus text-green-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">New Customers</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">234</span>
                            <span class="text-sm text-green-600">+12.5%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">Avg. Order Value</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">$89.50</span>
                            <span class="text-sm text-green-600">+5.2%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-redo text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">Repeat Customers</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">45.2%</span>
                            <span class="text-sm text-green-600">+2.8%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-yellow-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">Customer Satisfaction</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">4.8/5</span>
                            <span class="text-sm text-green-600">+0.3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize E-commerce Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeSalesChart();
            initializeProductsChart();
            startRealTimeUpdates();
        });

        function initializeSalesChart() {
            const ctx = document.getElementById('sales-chart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [12000, 19000, 15000, 25000, 22000, 30000],
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function initializeProductsChart() {
            const ctx = document.getElementById('products-chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
                    datasets: [{
                        label: 'Sales',
                        data: [120, 190, 150, 250, 220],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(168, 85, 247, 0.8)'
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(245, 158, 11)',
                            'rgb(239, 68, 68)',
                            'rgb(168, 85, 247)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function changeTimeRange(range) {
            // In a real application, this would fetch new data based on the time range
            showNotification(`E-commerce data updated for ${range}`, 'success');
        }

        function exportSalesData() {
            // In a real application, this would export sales data
            showNotification('Sales data exported successfully', 'success');
        }

        function startRealTimeUpdates() {
            // Simulate real-time updates
            setInterval(() => {
                updateStats();
            }, 30000); // Update every 30 seconds
        }

        function updateStats() {
            // Simulate real-time stat updates
            const totalRevenue = document.getElementById('total-revenue');
            const totalOrders = document.getElementById('total-orders');
            
            if (totalRevenue && totalOrders) {
                const currentRevenue = parseInt(totalRevenue.textContent.replace(/[$,]/g, ''));
                const currentOrders = parseInt(totalOrders.textContent.replace(/,/g, ''));
                
                totalRevenue.textContent = '$' + (currentRevenue + Math.floor(Math.random() * 100)).toLocaleString();
                totalOrders.textContent = (currentOrders + Math.floor(Math.random() * 5)).toLocaleString();
            }
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