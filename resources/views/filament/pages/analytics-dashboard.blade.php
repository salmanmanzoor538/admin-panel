<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Analytics Dashboard</h1>
                    <p class="text-gray-600 mt-1">Comprehensive analytics and insights for your application</p>
                </div>
                <div class="flex items-center space-x-3">
                    <select class="text-sm border-gray-300 rounded-md" onchange="changeTimeRange(this.value)">
                        <option value="7d">Last 7 days</option>
                        <option value="30d" selected>Last 30 days</option>
                        <option value="90d">Last 90 days</option>
                        <option value="1y">Last year</option>
                    </select>
                    <button onclick="exportAnalytics()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Analytics Stats Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-users">12,345</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>12.5%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Page Views</p>
                        <p class="text-2xl font-bold text-gray-900" id="page-views">89,432</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>8.2%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mouse-pointer text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Bounce Rate</p>
                        <p class="text-2xl font-bold text-gray-900" id="bounce-rate">42.3%</p>
                        <p class="text-sm text-red-600">
                            <i class="fas fa-arrow-down mr-1"></i>2.1%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg. Session</p>
                        <p class="text-2xl font-bold text-gray-900" id="avg-session">3m 24s</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>5.7%
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Traffic Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Traffic Overview</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Views</span>
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="traffic-chart"></canvas>
                </div>
            </div>

            <!-- Device Analytics -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Device Analytics</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Users</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="device-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Pages and Referrers -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Pages -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Pages</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                <i class="fas fa-home text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">/</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">12,345 views</span>
                            <span class="text-sm text-green-600">+12.5%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-green-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">/products</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">8,432 views</span>
                            <span class="text-sm text-green-600">+8.2%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded flex items-center justify-center">
                                <i class="fas fa-blog text-yellow-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">/blog</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">5,678 views</span>
                            <span class="text-sm text-red-600">-2.1%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Referrers -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Referrers</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                <i class="fab fa-google text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">Google</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">45.2%</span>
                            <span class="text-sm text-green-600">+5.7%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                <i class="fab fa-facebook text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">Facebook</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">23.8%</span>
                            <span class="text-sm text-green-600">+3.2%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                <i class="fab fa-twitter text-blue-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-900">Twitter</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">12.4%</span>
                            <span class="text-sm text-red-600">-1.8%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Analytics Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeTrafficChart();
            initializeDeviceChart();
            startRealTimeUpdates();
        });

        function initializeTrafficChart() {
            const ctx = document.getElementById('traffic-chart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Page Views',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
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

        function initializeDeviceChart() {
            const ctx = document.getElementById('device-chart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Desktop', 'Mobile', 'Tablet'],
                    datasets: [{
                        data: [65, 25, 10],
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(245, 158, 11)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        function changeTimeRange(range) {
            // In a real application, this would fetch new data based on the time range
            showNotification(`Analytics updated for ${range}`, 'success');
        }

        function exportAnalytics() {
            // In a real application, this would export analytics data
            showNotification('Analytics data exported successfully', 'success');
        }

        function startRealTimeUpdates() {
            // Simulate real-time updates
            setInterval(() => {
                updateStats();
            }, 30000); // Update every 30 seconds
        }

        function updateStats() {
            // Simulate real-time stat updates
            const totalUsers = document.getElementById('total-users');
            const pageViews = document.getElementById('page-views');
            
            if (totalUsers && pageViews) {
                const currentUsers = parseInt(totalUsers.textContent.replace(/,/g, ''));
                const currentViews = parseInt(pageViews.textContent.replace(/,/g, ''));
                
                totalUsers.textContent = (currentUsers + Math.floor(Math.random() * 10)).toLocaleString();
                pageViews.textContent = (currentViews + Math.floor(Math.random() * 50)).toLocaleString();
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