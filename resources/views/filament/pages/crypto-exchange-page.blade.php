<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Crypto Exchange</h1>
                    <p class="text-gray-600 mt-1">Professional cryptocurrency trading platform with live charts and real-time data</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Portfolio Value:</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">${{ number_format(array_sum(array_column($wallet, 'value')), 2) }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">24h Change:</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">+2.45%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Crypto Market Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <i class="fab fa-bitcoin text-2xl text-orange-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Bitcoin (BTC)</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($cryptoData['BTC']['price'], 2) }}</p>
                        <p class="text-sm {{ $cryptoData['BTC']['change_24h'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cryptoData['BTC']['change_24h'] >= 0 ? '+' : '' }}{{ $cryptoData['BTC']['change_24h'] }}%
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fab fa-ethereum text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Ethereum (ETH)</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($cryptoData['ETH']['price'], 2) }}</p>
                        <p class="text-sm {{ $cryptoData['ETH']['change_24h'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cryptoData['ETH']['change_24h'] >= 0 ? '+' : '' }}{{ $cryptoData['ETH']['change_24h'] }}%
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-coins text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Binance Coin (BNB)</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($cryptoData['BNB']['price'], 2) }}</p>
                        <p class="text-sm {{ $cryptoData['BNB']['change_24h'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cryptoData['BNB']['change_24h'] >= 0 ? '+' : '' }}{{ $cryptoData['BNB']['change_24h'] }}%
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-chart-line text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Market Cap</p>
                        <p class="text-2xl font-bold text-gray-900">$1.2T</p>
                        <p class="text-sm text-green-600">+1.23%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{ $this->form }}
        </div>

        <!-- Additional Crypto Components -->
        <div class="space-y-6">
            <!-- Live Price Ticker -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Live Price Ticker</h2>
                <div class="overflow-x-auto">
                    <div class="flex space-x-8 animate-pulse">
                        @foreach([
                            ['symbol' => 'BTC/USD', 'price' => 43250.00, 'change' => 2.45],
                            ['symbol' => 'ETH/USD', 'price' => 2650.00, 'change' => -1.23],
                            ['symbol' => 'BNB/USD', 'price' => 315.00, 'change' => 0.87],
                            ['symbol' => 'ADA/USD', 'price' => 0.45, 'change' => 3.21],
                            ['symbol' => 'SOL/USD', 'price' => 98.50, 'change' => -0.56],
                            ['symbol' => 'DOT/USD', 'price' => 6.75, 'change' => 1.89],
                            ['symbol' => 'MATIC/USD', 'price' => 0.85, 'change' => -2.34],
                            ['symbol' => 'AVAX/USD', 'price' => 35.20, 'change' => 0.45],
                        ] as $ticker)
                            <div class="flex-shrink-0 text-center">
                                <p class="text-sm font-medium text-gray-900">{{ $ticker['symbol'] }}</p>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($ticker['price'], 2) }}</p>
                                <p class="text-sm {{ $ticker['change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $ticker['change'] >= 0 ? '+' : '' }}{{ $ticker['change'] }}%
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Trading Pairs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Popular Trading Pairs</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach([
                        ['pair' => 'BTC/USD', 'price' => 43250.00, 'change' => 2.45, 'volume' => '28.5B'],
                        ['pair' => 'ETH/USD', 'price' => 2650.00, 'change' => -1.23, 'volume' => '15.0B'],
                        ['pair' => 'BNB/USD', 'price' => 315.00, 'change' => 0.87, 'volume' => '1.2B'],
                        ['pair' => 'ADA/USD', 'price' => 0.45, 'change' => 3.21, 'volume' => '800M'],
                    ] as $pair)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer" onclick="selectTradingPair('{{ $pair['pair'] }}')">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-medium text-gray-900">{{ $pair['pair'] }}</h3>
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $pair['change'] >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $pair['change'] >= 0 ? '+' : '' }}{{ $pair['change'] }}%
                                </span>
                            </div>
                            <p class="text-2xl font-bold text-gray-900 mb-1">${{ number_format($pair['price'], 2) }}</p>
                            <p class="text-sm text-gray-500">Vol: {{ $pair['volume'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Market News -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Market News</h2>
                <div class="space-y-4">
                    @foreach([
                        ['title' => 'Bitcoin Reaches New All-Time High', 'summary' => 'Bitcoin has reached a new all-time high of $43,250, driven by institutional adoption and positive market sentiment.', 'time' => '2 hours ago', 'impact' => 'positive'],
                        ['title' => 'Ethereum 2.0 Upgrade Complete', 'summary' => 'The Ethereum network has successfully completed its 2.0 upgrade, improving scalability and reducing energy consumption.', 'time' => '4 hours ago', 'impact' => 'positive'],
                        ['title' => 'Regulatory Clarity for Crypto', 'summary' => 'New regulatory guidelines provide clarity for cryptocurrency trading and investment in major markets.', 'time' => '6 hours ago', 'impact' => 'neutral'],
                        ['title' => 'DeFi Protocol Launches', 'summary' => 'A new decentralized finance protocol has launched with innovative yield farming opportunities.', 'time' => '8 hours ago', 'impact' => 'positive'],
                    ] as $news)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $news['impact'] === 'positive' ? 'bg-green-100' : ($news['impact'] === 'negative' ? 'bg-red-100' : 'bg-gray-100') }}">
                                    <i class="fas fa-{{ $news['impact'] === 'positive' ? 'arrow-up' : ($news['impact'] === 'negative' ? 'arrow-down' : 'minus') }} text-{{ $news['impact'] === 'positive' ? 'green' : ($news['impact'] === 'negative' ? 'red' : 'gray') }}-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 mb-1">{{ $news['title'] }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $news['summary'] }}</p>
                                <p class="text-xs text-gray-500">{{ $news['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Trading Tools -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Trading Tools</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Price Calculator</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Amount</label>
                                <input type="number" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Price</label>
                                <input type="number" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Total</label>
                                <input type="number" placeholder="0.00" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Portfolio Tracker</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Total Value</span>
                                <span class="font-medium">${{ number_format(array_sum(array_column($wallet, 'value')), 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">24h Change</span>
                                <span class="font-medium text-green-600">+$125.50</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">7d Change</span>
                                <span class="font-medium text-green-600">+$1,250.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">30d Change</span>
                                <span class="font-medium text-red-600">-$500.00</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Market Sentiment</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600">Fear & Greed Index</span>
                                    <span class="text-sm font-medium">65</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Greed</p>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600">Market Cap Dominance</span>
                                    <span class="text-sm font-medium">42.5%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 42.5%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Bitcoin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TradingView Widget -->
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    
    <!-- Chart.js for additional charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Crypto Exchange functionality
        let currentTradingPair = 'BTC/USD';
        let currentChart = null;
        let priceUpdateInterval = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCryptoExchange();
        });
        
        function initializeCryptoExchange() {
            renderMarketOverview();
            renderTradingChart();
            renderOrderBook();
            renderWalletBalance();
            renderDepositAddress();
            renderDepositQR();
            renderOpenOrders();
            renderOrderHistory();
            renderTransactionHistory();
            renderPortfolioOverview();
            renderAssetAllocation();
            startPriceUpdates();
        }
        
        function renderMarketOverview() {
            const container = document.getElementById('market-overview');
            const cryptoData = @json($cryptoData);
            
            let html = '<div class="grid grid-cols-1 md:grid-cols-3 gap-4">';
            Object.values(cryptoData).forEach(crypto => {
                html += `
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium text-gray-900">${crypto.name}</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full ${crypto.change_24h >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${crypto.change_24h >= 0 ? '+' : ''}${crypto.change_24h}%
                            </span>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">$${crypto.price.toLocaleString()}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>24h Vol: $${(crypto.volume_24h / 1000000000).toFixed(1)}B</p>
                            <p>Market Cap: $${(crypto.market_cap / 1000000000).toFixed(1)}B</p>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderTradingChart() {
            const container = document.getElementById('trading-chart');
            
            // Create TradingView widget
            container.innerHTML = `
                <div class="tradingview-widget-container">
                    <div id="tradingview_chart" style="height: 400px;"></div>
                </div>
            `;
            
            // Initialize TradingView chart
            new TradingView.widget({
                "autosize": true,
                "symbol": "BINANCE:BTCUSDT",
                "interval": "1",
                "timezone": "Etc/UTC",
                "theme": "light",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "hide_top_toolbar": false,
                "hide_legend": false,
                "save_image": false,
                "container_id": "tradingview_chart"
            });
        }
        
        function renderOrderBook() {
            const container = document.getElementById('order-book');
            
            container.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Buy Orders</h3>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">0.5 BTC</span>
                                <span class="text-green-600">$43,200</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">0.3 BTC</span>
                                <span class="text-green-600">$43,150</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">0.8 BTC</span>
                                <span class="text-green-600">$43,100</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Sell Orders</h3>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">0.2 BTC</span>
                                <span class="text-red-600">$43,300</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">0.4 BTC</span>
                                <span class="text-red-600">$43,350</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">0.6 BTC</span>
                                <span class="text-red-600">$43,400</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        function renderWalletBalance() {
            const container = document.getElementById('wallet-balance');
            const wallet = @json($wallet);
            
            let html = '<div class="space-y-4">';
            Object.entries(wallet).forEach(([crypto, data]) => {
                html += `
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-coins text-gray-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">${crypto}</h3>
                                <p class="text-sm text-gray-500">${data.balance.toFixed(8)} ${crypto}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">$${data.value.toLocaleString()}</p>
                            <p class="text-sm text-gray-500">USD Value</p>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderDepositAddress() {
            const container = document.getElementById('deposit-address');
            
            container.innerHTML = `
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Deposit Address</span>
                        <button onclick="copyAddress('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa')" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <p class="font-mono text-sm bg-white p-2 rounded border break-all">1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa</p>
                    <p class="text-xs text-gray-500 mt-2">Only send BTC to this address. Sending other cryptocurrencies may result in permanent loss.</p>
                </div>
            `;
        }
        
        function renderDepositQR() {
            const container = document.getElementById('deposit-qr');
            
            container.innerHTML = `
                <div class="text-center">
                    <div class="w-32 h-32 bg-gray-200 rounded-lg mx-auto mb-2 flex items-center justify-center">
                        <i class="fas fa-qrcode text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-sm text-gray-600">Scan QR code to deposit</p>
                </div>
            `;
        }
        
        function renderOpenOrders() {
            const container = document.getElementById('open-orders');
            const orders = @json($orders);
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">No open orders</p>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="space-y-4">';
            orders.forEach(order => {
                html += `
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="font-medium text-gray-900">${order.pair}</h3>
                                <p class="text-sm text-gray-500">${order.type.toUpperCase()} • ${order.amount} ${order.pair.split('/')[0]}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">$${order.price.toLocaleString()}</p>
                                <span class="px-2 py-1 text-xs font-medium rounded-full ${order.status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'}">
                                    ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="cancelOrder('${order.id}')" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
                                Cancel
                            </button>
                            <button onclick="viewOrder('${order.id}')" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                View Details
                            </button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderOrderHistory() {
            const container = document.getElementById('order-history');
            
            container.innerHTML = `
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pair</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">BTC/USD</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Buy</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0.1 BTC</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$43,000</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Filled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-15 10:30</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `;
        }
        
        function renderTransactionHistory() {
            const container = document.getElementById('transaction-history');
            const transactions = @json($transactions);
            
            let html = '<div class="space-y-4">';
            transactions.forEach(transaction => {
                html += `
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center ${transaction.type === 'deposit' ? 'bg-green-100' : 'bg-red-100'}">
                                <i class="fas fa-${transaction.type === 'deposit' ? 'arrow-down' : 'arrow-up'} text-${transaction.type === 'deposit' ? 'green' : 'red'}-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">${transaction.type.charAt(0).toUpperCase() + transaction.type.slice(1)}</h3>
                                <p class="text-sm text-gray-500">${transaction.amount} ${transaction.crypto}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-medium rounded-full ${transaction.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">${transaction.created_at}</p>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function renderPortfolioOverview() {
            const container = document.getElementById('portfolio-overview');
            const wallet = @json($wallet);
            
            const totalValue = Object.values(wallet).reduce((sum, data) => sum + data.value, 0);
            const totalChange = 125.50; // Mock data
            
            container.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Total Portfolio Value</h3>
                        <p class="text-3xl font-bold text-gray-900">$${totalValue.toLocaleString()}</p>
                        <p class="text-sm text-green-600">+$${totalChange} (24h)</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Total Return</h3>
                        <p class="text-3xl font-bold text-green-600">+12.5%</p>
                        <p class="text-sm text-gray-500">All time</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Best Performer</h3>
                        <p class="text-3xl font-bold text-gray-900">BTC</p>
                        <p class="text-sm text-green-600">+25.3%</p>
                    </div>
                </div>
            `;
        }
        
        function renderAssetAllocation() {
            const container = document.getElementById('asset-allocation');
            const wallet = @json($wallet);
            
            const totalValue = Object.values(wallet).reduce((sum, data) => sum + data.value, 0);
            
            let html = '<div class="space-y-4">';
            Object.entries(wallet).forEach(([crypto, data]) => {
                const percentage = (data.value / totalValue) * 100;
                html += `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-coins text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">${crypto}</h3>
                                <p class="text-sm text-gray-500">${data.balance.toFixed(8)} ${crypto}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">$${data.value.toLocaleString()}</p>
                            <p class="text-sm text-gray-500">${percentage.toFixed(1)}%</p>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }
        
        function selectTradingPair(pair) {
            currentTradingPair = pair;
            showNotification(`Trading pair changed to ${pair}`, 'success');
        }
        
        function startPriceUpdates() {
            // Simulate real-time price updates
            priceUpdateInterval = setInterval(() => {
                updatePrices();
            }, 5000);
        }
        
        function updatePrices() {
            // Update prices with random changes
            const cryptoData = @json($cryptoData);
            Object.keys(cryptoData).forEach(symbol => {
                const change = (Math.random() - 0.5) * 0.1; // Random change between -0.05% and +0.05%
                cryptoData[symbol].price *= (1 + change);
                cryptoData[symbol].change_24h += change;
            });
            
            // Re-render market overview
            renderMarketOverview();
        }
        
        function cancelOrder(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                showNotification(`Order ${orderId} cancelled`, 'success');
            }
        }
        
        function viewOrder(orderId) {
            showNotification(`Viewing order ${orderId}`, 'info');
        }
        
        function copyAddress(address) {
            navigator.clipboard.writeText(address).then(() => {
                showNotification('Address copied to clipboard', 'success');
            });
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
        
        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (priceUpdateInterval) {
                clearInterval(priceUpdateInterval);
            }
        });
    </script>
</x-filament-panels::page>