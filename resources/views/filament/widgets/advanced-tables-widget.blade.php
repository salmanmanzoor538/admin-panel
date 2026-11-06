<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Advanced Tables Integration</span>
                <div class="flex items-center space-x-2">
                    <button onclick="refreshTable()" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                        <i class="fas fa-sync-alt mr-1"></i>Refresh
                    </button>
                    <button onclick="exportTable()" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200">
                        <i class="fas fa-download mr-1"></i>Export
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-6">
            <!-- Table Library Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Library</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($tableLibraries as $libKey => $library)
                        <button 
                            onclick="setTableLibrary('{{ $libKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $tableLibrary === $libKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $library['icon'] }} text-2xl {{ $tableLibrary === $libKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
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

            <!-- Table Type Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Type</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($tableTypes as $typeKey => $type)
                        <button 
                            onclick="setTableType('{{ $typeKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $tableType === $typeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $type['icon'] }} text-2xl {{ $tableType === $typeKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900">{{ $type['name'] }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $type['description'] }}</p>
                                <div class="text-xs text-gray-500">
                                    Columns: {{ implode(', ', $type['columns']) }}
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Theme Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Theme</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($themes as $themeKey => $theme)
                        <button 
                            onclick="setTableTheme('{{ $themeKey }}')"
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

            <!-- Table Display Area -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Preview</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div id="table-container" class="overflow-x-auto">
                        <!-- Table will be rendered here -->
                        <div class="flex items-center justify-center h-64 bg-gray-50 rounded-lg">
                            <div class="text-center">
                                <i class="fas fa-table text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600">Select a table library and type to see the preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Controls -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Controls</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $serverSide ? 'checked' : '' }}
                                onchange="toggleServerSide(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Server-side Processing</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $pagination ? 'checked' : '' }}
                                onchange="togglePagination(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Enable Pagination</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $searching ? 'checked' : '' }}
                                onchange="toggleSearching(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Enable Searching</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $sorting ? 'checked' : '' }}
                                onchange="toggleSorting(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Enable Sorting</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $exporting ? 'checked' : '' }}
                                onchange="toggleExporting(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Enable Export</span>
                        </label>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <label class="text-sm text-gray-700">Page Length:</label>
                        <select onchange="setPageLength(this.value)" class="text-sm border-gray-300 rounded-md">
                            <option value="5" {{ $pageLength === '5' ? 'selected' : '' }}>5 rows</option>
                            <option value="10" {{ $pageLength === '10' ? 'selected' : '' }}>10 rows</option>
                            <option value="25" {{ $pageLength === '25' ? 'selected' : '' }}>25 rows</option>
                            <option value="50" {{ $pageLength === '50' ? 'selected' : '' }}>50 rows</option>
                            <option value="100" {{ $pageLength === '100' ? 'selected' : '' }}>100 rows</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Data Preview -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Data</h3>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach($tableTypes[$tableType]['columns'] as $column)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sampleData[$tableType] as $row)
                                    <tr>
                                        @foreach($row as $key => $value)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $value }}</td>
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

    <!-- Table Libraries Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css">
    
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

    <script>
        // Advanced Tables functionality
        let currentTable = null;
        let currentData = @json($sampleData);
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeTables();
        });
        
        function initializeTables() {
            const tableLibrary = '{{ $tableLibrary }}';
            const tableType = '{{ $tableType }}';
            renderTable(tableLibrary, tableType);
        }
        
        function setTableLibrary(library) {
            const tableType = '{{ $tableType }}';
            renderTable(library, tableType);
            showNotification(`Table library changed to ${library}`, 'success');
        }
        
        function setTableType(type) {
            const tableLibrary = '{{ $tableLibrary }}';
            renderTable(tableLibrary, type);
            showNotification(`Table type changed to ${type}`, 'success');
        }
        
        function setTableTheme(theme) {
            // Update table theme
            showNotification(`Table theme changed to ${theme}`, 'success');
        }
        
        function renderTable(library, type) {
            const container = document.getElementById('table-container');
            container.innerHTML = '';
            
            const data = currentData[type];
            const columns = getTableColumns(type);
            
            switch (library) {
                case 'datatables':
                    renderDataTable(columns, data);
                    break;
                case 'jsgrid':
                    renderJsGrid(columns, data);
                    break;
                case 'gridjs':
                    renderGridJS(columns, data);
                    break;
            }
        }
        
        function getTableColumns(type) {
            const columnMap = {
                'users': ['ID', 'Name', 'Email', 'Role', 'Status', 'Created'],
                'orders': ['ID', 'Customer', 'Product', 'Amount', 'Status', 'Date'],
                'products': ['ID', 'Name', 'Category', 'Price', 'Stock', 'Status'],
                'transactions': ['ID', 'Type', 'Amount', 'Currency', 'Status', 'Date'],
            };
            return columnMap[type] || [];
        }
        
        function renderDataTable(columns, data) {
            const container = document.getElementById('table-container');
            
            // Create table element
            const table = document.createElement('table');
            table.id = 'datatable';
            table.className = 'table table-striped table-hover';
            
            // Create header
            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            columns.forEach(column => {
                const th = document.createElement('th');
                th.textContent = column;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            table.appendChild(thead);
            
            // Create body
            const tbody = document.createElement('tbody');
            data.forEach(row => {
                const tr = document.createElement('tr');
                Object.values(row).forEach(value => {
                    const td = document.createElement('td');
                    td.textContent = value;
                    tr.appendChild(td);
                });
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            
            container.appendChild(table);
            
            // Initialize DataTable
            currentTable = $(table).DataTable({
                responsive: true,
                pageLength: parseInt('{{ $pageLength }}'),
                paging: {{ $pagination ? 'true' : 'false' }},
                searching: {{ $searching ? 'true' : 'false' }},
                ordering: {{ $sorting ? 'true' : 'false' }},
                info: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: {{ $exporting ? "['copy', 'csv', 'excel', 'pdf', 'print']" : '[]' }},
            });
        }
        
        function renderJsGrid(columns, data) {
            const container = document.getElementById('table-container');
            
            const fields = columns.map(column => ({
                name: column.toLowerCase().replace(/\s+/g, '_'),
                title: column,
                type: 'text',
                width: 100
            }));
            
            currentTable = $(container).jsGrid({
                width: "100%",
                height: "400px",
                inserting: true,
                editing: true,
                sorting: {{ $sorting ? 'true' : 'false' }},
                paging: {{ $pagination ? 'true' : 'false' }},
                pageSize: parseInt('{{ $pageLength }}'),
                data: data,
                fields: fields
            });
        }
        
        function renderGridJS(columns, data) {
            const container = document.getElementById('table-container');
            
            const gridColumns = columns.map(column => ({
                name: column.toLowerCase().replace(/\s+/g, '_'),
                title: column
            }));
            
            currentTable = new gridjs.Grid({
                columns: gridColumns,
                data: data,
                search: {{ $searching ? 'true' : 'false' }},
                sort: {{ $sorting ? 'true' : 'false' }},
                pagination: {
                    enabled: {{ $pagination ? 'true' : 'false' }},
                    limit: parseInt('{{ $pageLength }}')
                },
                style: {
                    table: {
                        'font-size': '14px'
                    },
                    th: {
                        'background-color': '#f3f4f6',
                        'color': '#1f2937',
                        'border-bottom': '2px solid #e5e7eb',
                        'padding': '12px 16px',
                        'text-align': 'left'
                    },
                    td: {
                        'padding': '12px 16px',
                        'border-bottom': '1px solid #e5e7eb'
                    }
                }
            }).render(container);
        }
        
        function toggleServerSide(enabled) {
            showNotification(`Server-side processing ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function togglePagination(enabled) {
            showNotification(`Pagination ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function toggleSearching(enabled) {
            showNotification(`Searching ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function toggleSorting(enabled) {
            showNotification(`Sorting ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function toggleExporting(enabled) {
            showNotification(`Exporting ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function setPageLength(length) {
            showNotification(`Page length changed to ${length}`, 'success');
        }
        
        function refreshTable() {
            // Refresh table data
            showNotification('Table data refreshed', 'success');
        }
        
        function exportTable() {
            if (currentTable && currentTable.buttons) {
                // DataTables export
                currentTable.buttons.export();
            } else {
                showNotification('Table export not available for this library', 'warning');
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