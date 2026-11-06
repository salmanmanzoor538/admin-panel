<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Advanced Charts Integration</span>
                <div class="flex items-center space-x-2">
                    <button onclick="refreshData()" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh
                    </button>
                    <button onclick="exportChart()" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200">
                        <i class="fas fa-download mr-1"></i>Export
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-6">
            <!-- Chart Library Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Chart Library</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($chartLibraries as $libKey => $library)
                        <button 
                            onclick="setChartLibrary('{{ $libKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $chartLibrary === $libKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $library['icon'] }} text-2xl {{ $chartLibrary === $libKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900">{{ $library['name'] }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $library['description'] }}</p>
                                <div class="flex flex-wrap justify-center gap-1">
                                    @foreach($library['features'] as $feature)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">{{ $feature }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Chart Type Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Chart Type</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                    @foreach($chartTypes as $typeKey => $type)
                        <button 
                            onclick="setChartType('{{ $typeKey }}')"
                            class="p-3 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $chartType === $typeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $type['icon'] }} text-xl {{ $chartType === $typeKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $type['name'] }}</h4>
                                <p class="text-xs text-gray-600">{{ $type['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Theme Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Chart Theme</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($themes as $themeKey => $theme)
                        <button 
                            onclick="setChartTheme('{{ $themeKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $theme === $themeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <div class="w-12 h-12 {{ $theme['preview'] }} rounded-lg mx-auto mb-2 shadow-lg"></div>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $theme['name'] }}</h4>
                                <p class="text-xs text-gray-600">{{ $theme['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Chart Display Area -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Chart Preview</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div id="chart-container" class="h-96">
                        <!-- Chart will be rendered here -->
                        <div class="flex items-center justify-center h-full bg-gray-50 rounded-lg">
                            <div class="text-center">
                                <i class="fas fa-chart-line text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600">Select a chart library and type to see the preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Controls -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Chart Controls</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $realTime ? 'checked' : '' }}
                                onchange="toggleRealTime(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Real-time Updates</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $animations ? 'checked' : '' }}
                                onchange="toggleAnimations(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Enable Animations</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="text-sm text-gray-700">Update Interval:</label>
                        <select onchange="setUpdateInterval(this.value)" class="text-sm border-gray-300 rounded-md">
                            <option value="1000">1 second</option>
                            <option value="5000" selected>5 seconds</option>
                            <option value="10000">10 seconds</option>
                            <option value="30000">30 seconds</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Chart Data Table -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Chart Data</h3>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                    @foreach($sampleData['datasets'] as $dataset)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $dataset['name'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sampleData['labels'] as $index => $label)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $label }}</td>
                                        @foreach($sampleData['datasets'] as $dataset)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($dataset['data'][$index]) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <!-- Chart Libraries Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/c3@0.7.20/c3.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/c3@0.7.20/c3.min.css" rel="stylesheet">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        // Advanced Charts functionality
        let currentChart = null;
        let realTimeInterval = null;
        let updateInterval = 5000;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });
        
        function initializeCharts() {
            const chartLibrary = '{{ $chartLibrary }}';
            const chartType = '{{ $chartType }}';
            renderChart(chartLibrary, chartType);
        }
        
        function setChartLibrary(library) {
            const chartType = '{{ $chartType }}';
            renderChart(library, chartType);
            showNotification(`Chart library changed to ${library}`, 'success');
        }
        
        function setChartType(type) {
            const chartLibrary = '{{ $chartLibrary }}';
            renderChart(chartLibrary, type);
            showNotification(`Chart type changed to ${type}`, 'success');
        }
        
        function setChartTheme(theme) {
            // Update chart theme
            showNotification(`Chart theme changed to ${theme}`, 'success');
        }
        
        function renderChart(library, type) {
            const container = document.getElementById('chart-container');
            container.innerHTML = '';
            
            const sampleData = @json($sampleData);
            
            switch (library) {
                case 'apexcharts':
                    renderApexChart(type, sampleData);
                    break;
                case 'c3':
                    renderC3Chart(type, sampleData);
                    break;
                case 'amcharts':
                    renderAmChart(type, sampleData);
                    break;
                case 'recharts':
                    renderRecharts(type, sampleData);
                    break;
            }
        }
        
        function renderApexChart(type, data) {
            const container = document.getElementById('chart-container');
            
            let options = {
                series: data.datasets.map(dataset => ({
                    name: dataset.name,
                    data: dataset.data
                })),
                chart: {
                    type: type,
                    height: 350,
                    animations: {
                        enabled: {{ $animations ? 'true' : 'false' }},
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                xaxis: {
                    categories: data.labels
                },
                colors: data.datasets.map(dataset => dataset.color),
                theme: {
                    mode: '{{ $theme }}'
                }
            };
            
            // Customize options based on chart type
            if (type === 'pie' || type === 'donut') {
                options.series = data.datasets[0].data;
                options.labels = data.labels;
            }
            
            currentChart = new ApexCharts(container, options);
            currentChart.render();
        }
        
        function renderC3Chart(type, data) {
            const container = document.getElementById('chart-container');
            
            let chartData = {
                columns: data.datasets.map(dataset => [
                    dataset.name,
                    ...dataset.data
                ]),
                type: type
            };
            
            if (type === 'pie') {
                chartData.columns = data.datasets[0].data.map((value, index) => [
                    data.labels[index],
                    value
                ]);
            }
            
            currentChart = c3.generate({
                bindto: container,
                data: chartData,
                axis: {
                    x: {
                        type: 'category',
                        categories: data.labels
                    }
                },
                color: {
                    pattern: data.datasets.map(dataset => dataset.color)
                }
            });
        }
        
        function renderAmChart(type, data) {
            const container = document.getElementById('chart-container');
            
            // AmCharts configuration
            let chartConfig = {
                type: type === 'line' ? 'XYChart' : type === 'bar' ? 'XYChart' : 'PieChart',
                data: data.datasets[0].data.map((value, index) => ({
                    category: data.labels[index],
                    value: value
                })),
                theme: '{{ $theme }}'
            };
            
            currentChart = am5.create(container, chartConfig);
        }
        
        function renderRecharts(type, data) {
            // Recharts would require React, so we'll show a placeholder
            const container = document.getElementById('chart-container');
            container.innerHTML = `
                <div class="flex items-center justify-center h-full bg-blue-50 rounded-lg">
                    <div class="text-center">
                        <i class="fas fa-chart-bar text-4xl text-blue-500 mb-4"></i>
                        <p class="text-blue-700 font-medium">Recharts Integration</p>
                        <p class="text-blue-600 text-sm">Requires React environment</p>
                    </div>
                </div>
            `;
        }
        
        function toggleRealTime(enabled) {
            if (enabled) {
                startRealTimeUpdates();
            } else {
                stopRealTimeUpdates();
            }
        }
        
        function toggleAnimations(enabled) {
            // Update chart animations
            showNotification(`Animations ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function setUpdateInterval(interval) {
            updateInterval = parseInt(interval);
            if (realTimeInterval) {
                stopRealTimeUpdates();
                startRealTimeUpdates();
            }
        }
        
        function startRealTimeUpdates() {
            realTimeInterval = setInterval(() => {
                updateChartData();
            }, updateInterval);
            showNotification('Real-time updates started', 'success');
        }
        
        function stopRealTimeUpdates() {
            if (realTimeInterval) {
                clearInterval(realTimeInterval);
                realTimeInterval = null;
                showNotification('Real-time updates stopped', 'info');
            }
        }
        
        function updateChartData() {
            // Simulate real-time data updates
            if (currentChart && currentChart.updateSeries) {
                const newData = generateRandomData();
                currentChart.updateSeries(newData);
            }
        }
        
        function generateRandomData() {
            const sampleData = @json($sampleData);
            return sampleData.datasets.map(dataset => ({
                name: dataset.name,
                data: dataset.data.map(value => value + Math.floor(Math.random() * 1000 - 500))
            }));
        }
        
        function refreshData() {
            updateChartData();
            showNotification('Chart data refreshed', 'success');
        }
        
        function exportChart() {
            if (currentChart && currentChart.dataURI) {
                const uri = currentChart.dataURI();
                const link = document.createElement('a');
                link.download = 'chart.png';
                link.href = uri;
                link.click();
            } else {
                showNotification('Chart export not available for this library', 'warning');
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
</x-filament-widgets::widget>