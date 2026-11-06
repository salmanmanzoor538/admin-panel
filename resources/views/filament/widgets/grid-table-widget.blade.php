<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Advanced Data Table - {{ ucfirst($tableType) }}</span>
                <div class="flex space-x-2">
                    <select wire:model="tableType" class="text-sm border-gray-300 rounded-md">
                        @foreach($this->getTableTypeOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600" onclick="refreshTable()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-4">
            <!-- Table Controls -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="tableSearch" 
                            placeholder="Search..." 
                            class="pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <i class="fas fa-search absolute left-2 top-3 text-gray-400"></i>
                    </div>
                    <select id="pageSize" class="border border-gray-300 rounded-md px-3 py-2">
                        <option value="10">10 per page</option>
                        <option value="25" selected>25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-2 text-sm bg-green-500 text-white rounded hover:bg-green-600" onclick="exportTable()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button class="px-3 py-2 text-sm bg-purple-500 text-white rounded hover:bg-purple-600" onclick="printTable()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

            <!-- Grid.js Table Container -->
            <div id="gridjs-table-{{ $tableType }}" class="gridjs-container"></div>

            <!-- Table Info -->
            <div class="flex items-center justify-between text-sm text-gray-600">
                <span id="tableInfo">Loading...</span>
                <div class="flex items-center space-x-4">
                    <span>Total: <span id="totalRecords">0</span></span>
                    <span>Filtered: <span id="filteredRecords">0</span></span>
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        let grid{{ ucfirst($tableType) }};
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeGrid{{ ucfirst($tableType) }}();
        });
        
        function initializeGrid{{ ucfirst($tableType) }}() {
            const data = @json($data);
            const columns = @json($columns);
            
            // Configure Grid.js
            const config = {
                data: data,
                columns: columns.map(col => ({
                    name: col.name,
                    id: col.id,
                    sort: col.sortable,
                    formatter: (cell, row) => {
                        if (col.id === 'actions') {
                            return GridJS.html(cell);
                        }
                        return cell;
                    }
                })),
                search: {
                    enabled: true,
                    placeholder: 'Search...',
                },
                pagination: {
                    enabled: true,
                    limit: 25,
                    summary: true,
                },
                sort: true,
                resizable: true,
                fixedHeader: true,
                height: '400px',
                style: {
                    table: {
                        'white-space': 'nowrap'
                    }
                },
                language: {
                    search: {
                        placeholder: 'Search...'
                    },
                    pagination: {
                        previous: '⬅️',
                        next: '➡️',
                        navigate: (page, pages) => `Page ${page} of ${pages}`,
                        page: (page) => `Page ${page}`,
                        showing: 'Showing',
                        of: 'of',
                        to: 'to',
                        results: 'results',
                    },
                    loading: 'Loading...',
                    noRecordsFound: 'No records found',
                    error: 'Error loading data',
                }
            };
            
            // Initialize Grid.js
            grid{{ ucfirst($tableType) }} = new GridJS(config);
            grid{{ ucfirst($tableType) }}.render(document.getElementById('gridjs-table-{{ $tableType }}'));
            
            // Update table info
            updateTableInfo();
            
            // Bind search input
            document.getElementById('tableSearch').addEventListener('input', function(e) {
                grid{{ ucfirst($tableType) }}.search(e.target.value);
            });
            
            // Bind page size selector
            document.getElementById('pageSize').addEventListener('change', function(e) {
                grid{{ ucfirst($tableType) }}.config.pagination.limit = parseInt(e.target.value);
                grid{{ ucfirst($tableType) }}.forceRender();
            });
        }
        
        function updateTableInfo() {
            const totalRecords = @json(count($data));
            document.getElementById('totalRecords').textContent = totalRecords;
            document.getElementById('filteredRecords').textContent = totalRecords;
            document.getElementById('tableInfo').textContent = `Showing ${totalRecords} records`;
        }
        
        function refreshTable() {
            if (grid{{ ucfirst($tableType) }}) {
                grid{{ ucfirst($tableType) }}.forceRender();
                updateTableInfo();
            }
        }
        
        function exportTable() {
            if (grid{{ ucfirst($tableType) }}) {
                grid{{ ucfirst($tableType) }}.export('csv', '{{ $tableType }}_export.csv');
            }
        }
        
        function printTable() {
            window.print();
        }
        
        // Action button functions
        function view{{ ucfirst($tableType) }}(id) {
            window.open('/admin/{{ $tableType }}/' + id, '_blank');
        }
        
        function edit{{ ucfirst($tableType) }}(id) {
            window.open('/admin/{{ $tableType }}/' + id + '/edit', '_blank');
        }
        
        function delete{{ ucfirst($tableType) }}(id) {
            if (confirm('Are you sure you want to delete this {{ $tableType }}?')) {
                fetch('/admin/{{ $tableType }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        refreshTable();
                        showNotification('{{ ucfirst($tableType) }} deleted successfully', 'success');
                    } else {
                        showNotification('Error deleting {{ $tableType }}', 'error');
                    }
                });
            }
        }
    </script>
</x-filament-widgets::widget>