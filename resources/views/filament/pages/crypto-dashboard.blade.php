<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Crypto Dashboard</h1>
                    <p class="text-gray-600 mt-1">Track your cryptocurrency portfolio and market trends</p>
                </div>
                <div class="flex items-center space-x-3">
                    <select class="text-sm border-gray-300 rounded-md" onchange="changeTimeRange(this.value)">
                        <option value="1h">1 Hour</option>
                        <option value="24h" selected>24 Hours</option>
                        <option value="7d">7 Days</option>
                        <option value="30d">30 Days</option>
                    </select>
                    <button onclick="refreshPrices()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Portfolio Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fab fa-bitcoin text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Portfolio Value</p>
                        <p class="text-2xl font-bold text-gray-900" id="portfolio-value">$45,678</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+12.5%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">24h Change</p>
                        <p class="text-2xl font-bold text-gray-900" id="daily-change">+$2,345</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>+5.4%
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-coins text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Coins</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-coins">12</p>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>Active
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
                        <p class="text-sm font-medium text-gray-600">ROI</p>
                        <p class="text-2xl font-bold text-gray-900" id="roi">+24.8%</p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i>All Time
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Market Overview and Portfolio Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Portfolio Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Portfolio Distribution</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Allocation</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="portfolio-chart"></canvas>
                </div>
            </div>

            <!-- Market Overview -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Market Overview</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">24h Change</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="market-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Cryptocurrencies and Trading History -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Cryptocurrencies -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Top Cryptocurrencies</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="fab fa-bitcoin text-orange-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Bitcoin</p>
                                <p class="text-xs text-gray-600">BTC</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$43,250.00</p>
                            <span class="text-sm text-green-600">+2.5%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fab fa-ethereum text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Ethereum</p>
                                <p class="text-xs text-gray-600">ETH</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$2,650.00</p>
                            <span class="text-sm text-green-600">+1.8%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-coins text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Cardano</p>
                                <p class="text-xs text-gray-600">ADA</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$0.45</p>
                            <span class="text-sm text-red-600">-0.8%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trading History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Trades</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-arrow-up text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Buy BTC</p>
                                <p class="text-xs text-gray-600">0.05 BTC</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$2,162.50</p>
                            <p class="text-xs text-gray-600">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-arrow-down text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Sell ETH</p>
                                <p class="text-xs text-gray-600">1.2 ETH</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$3,180.00</p>
                            <p class="text-xs text-gray-600">5 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-arrow-up text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Buy ADA</p>
                                <p class="text-xs text-gray-600">1000 ADA</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">$450.00</p>
                            <p class="text-xs text-gray-600">1 day ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <button onclick="buyCrypto()" class="flex items-center justify-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-plus text-green-600 text-xl mr-3"></i>
                    <span class="text-green-800 font-medium">Buy Crypto</span>
                </button>
                <button onclick="sellCrypto()" class="flex items-center justify-center p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                    <i class="fas fa-minus text-red-600 text-xl mr-3"></i>
                    <span class="text-red-800 font-medium">Sell Crypto</span>
                </button>
                <button onclick="depositFunds()" class="flex items-center justify-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-arrow-down text-blue-600 text-xl mr-3"></i>
                    <span class="text-blue-800 font-medium">Deposit</span>
                </button>
                <button onclick="withdrawFunds()" class="flex items-center justify-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-arrow-up text-yellow-600 text-xl mr-3"></i>
                    <span class="text-yellow-800 font-medium">Withdraw</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Initialize Crypto Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializePortfolioChart();
            initializeMarketChart();
            startRealTimeUpdates();
        });

        function initializePortfolioChart() {
            const ctx = document.getElementById('portfolio-chart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Bitcoin', 'Ethereum', 'Cardano', 'Others'],
                    datasets: [{
                        data: [45, 30, 15, 10],
                        backgroundColor: [
                            'rgb(245, 158, 11)',
                            'rgb(59, 130, 246)',
                            'rgb(168, 85, 247)',
                            'rgb(156, 163, 175)'
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

        function initializeMarketChart() {
            const ctx = document.getElementById('market-chart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
                    datasets: [{
                        label: 'Portfolio Value',
                        data: [42000, 43500, 42800, 44500, 45200, 44800, 45678],
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
                            beginAtZero: false,
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
            showNotification(`Crypto data updated for ${range}`, 'success');
        }

        function refreshPrices() {
            // In a real application, this would fetch latest crypto prices
            showNotification('Crypto prices refreshed', 'success');
        }

        function buyCrypto() {
            // In a real application, this would open a buy crypto modal
            showNotification('Buy crypto functionality would be implemented here', 'info');
        }

        function sellCrypto() {
            // In a real application, this would open a sell crypto modal
            showNotification('Sell crypto functionality would be implemented here', 'info');
        }

        function depositFunds() {
            // In a real application, this would open a deposit modal
            showNotification('Deposit functionality would be implemented here', 'info');
        }

        function withdrawFunds() {
            // In a real application, this would open a withdraw modal
            showNotification('Withdraw functionality would be implemented here', 'info');
        }

        function startRealTimeUpdates() {
            // Simulate real-time updates
            setInterval(() => {
                updateCryptoStats();
            }, 30000); // Update every 30 seconds
        }

        function updateCryptoStats() {
            // Simulate real-time crypto price updates
            const portfolioValue = document.getElementById('portfolio-value');
            const dailyChange = document.getElementById('daily-change');
            
            if (portfolioValue && dailyChange) {
                const currentValue = parseInt(portfolioValue.textContent.replace(/[$,]/g, ''));
                const newValue = currentValue + Math.floor(Math.random() * 1000 - 500);
                const change = newValue - currentValue;
                
                portfolioValue.textContent = '$' + newValue.toLocaleString();
                dailyChange.textContent = (change >= 0 ? '+' : '') + '$' + Math.abs(change).toLocaleString();
                dailyChange.className = change >= 0 ? 'text-sm text-green-600' : 'text-sm text-red-600';
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