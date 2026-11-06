<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">UI Elements Collection</h1>
                    <p class="text-gray-600 mt-1">Comprehensive collection of 100+ UI components and elements</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="toggleDarkMode()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-moon mr-2"></i>Dark Mode
                    </button>
                    <button onclick="exportComponents()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Component Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer" onclick="scrollToSection('basic-elements')">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Basic Elements</h3>
                        <p class="text-sm text-gray-600">Inputs, selects, checkboxes</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer" onclick="scrollToSection('layout-components')">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-th-large text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Layout</h3>
                        <p class="text-sm text-gray-600">Cards, grids, spacing</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer" onclick="scrollToSection('interactive-elements')">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-mouse-pointer text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Interactive</h3>
                        <p class="text-sm text-gray-600">Buttons, badges, progress</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer" onclick="scrollToSection('data-display')">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-table text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Data Display</h3>
                        <p class="text-sm text-gray-600">Tables, lists, charts</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{ $this->form }}
        </div>

        <!-- Additional Components Showcase -->
        <div class="space-y-6">
            <!-- Tooltips Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tooltips & Popovers</h2>
                <div class="flex flex-wrap gap-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" data-tooltip="This is a tooltip">Hover for Tooltip</button>
                    <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" data-tooltip="Tooltip on the right" data-tooltip-position="right">Right Tooltip</button>
                    <button class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600" data-tooltip="Tooltip on the left" data-tooltip-position="left">Left Tooltip</button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" data-tooltip="Tooltip on the bottom" data-tooltip-position="bottom">Bottom Tooltip</button>
                </div>
            </div>

            <!-- Dropdowns Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Dropdowns & Menus</h2>
                <div class="flex flex-wrap gap-4">
                    <div class="relative inline-block text-left">
                        <button onclick="toggleDropdown('dropdown1')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                            Basic Dropdown <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <div id="dropdown1" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-10">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Option 1</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Option 2</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Option 3</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative inline-block text-left">
                        <button onclick="toggleDropdown('dropdown2')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Action Menu <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <div id="dropdown2" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-10">
                            <div class="py-1">
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-copy mr-2"></i>Duplicate
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-trash mr-2"></i>Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accordion Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Accordion & Collapse</h2>
                <div class="space-y-2">
                    <div class="border border-gray-200 rounded-lg">
                        <button onclick="toggleAccordion('accordion1')" class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Accordion Item 1</span>
                            <i class="fas fa-chevron-down transform transition-transform" id="accordion1-icon"></i>
                        </button>
                        <div id="accordion1" class="hidden px-4 pb-3">
                            <p class="text-gray-600">This is the content of the first accordion item. It can contain any HTML content.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg">
                        <button onclick="toggleAccordion('accordion2')" class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Accordion Item 2</span>
                            <i class="fas fa-chevron-down transform transition-transform" id="accordion2-icon"></i>
                        </button>
                        <div id="accordion2" class="hidden px-4 pb-3">
                            <p class="text-gray-600">This is the content of the second accordion item. It can contain any HTML content.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Pagination</h2>
                <div class="flex items-center justify-center space-x-2">
                    <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-2 bg-blue-500 text-white rounded">1</button>
                    <button class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded">2</button>
                    <button class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded">3</button>
                    <span class="px-3 py-2 text-gray-500">...</span>
                    <button class="px-3 py-2 text-gray-700 hover:bg-gray-100 rounded">10</button>
                    <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Breadcrumbs Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Breadcrumbs</h2>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="#" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </li>
                        <li>
                            <a href="#" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </li>
                        <li>
                            <a href="#" class="text-gray-500 hover:text-gray-700">Components</a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </li>
                        <li>
                            <span class="text-gray-900 font-medium">UI Elements</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Tabs Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tabs</h2>
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="switchTab('tab1')" class="tab-button active py-2 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm">
                            Tab 1
                        </button>
                        <button onclick="switchTab('tab2')" class="tab-button py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                            Tab 2
                        </button>
                        <button onclick="switchTab('tab3')" class="tab-button py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm">
                            Tab 3
                        </button>
                    </nav>
                </div>
                <div class="mt-4">
                    <div id="tab1" class="tab-content">
                        <p class="text-gray-600">Content for Tab 1</p>
                    </div>
                    <div id="tab2" class="tab-content hidden">
                        <p class="text-gray-600">Content for Tab 2</p>
                    </div>
                    <div id="tab3" class="tab-content hidden">
                        <p class="text-gray-600">Content for Tab 3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Modal Title</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-gray-600 mb-6">This is a modal dialog example. You can put any content here.</p>
                <div class="flex items-center justify-end space-x-3">
                    <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // UI Elements functionality
        document.addEventListener('DOMContentLoaded', function() {
            initializeTooltips();
            initializeComponents();
        });
        
        function initializeTooltips() {
            // Initialize tooltips
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', showTooltip);
                element.addEventListener('mouseleave', hideTooltip);
            });
        }
        
        function showTooltip(event) {
            const element = event.target;
            const text = element.getAttribute('data-tooltip');
            const position = element.getAttribute('data-tooltip-position') || 'top';
            
            const tooltip = document.createElement('div');
            tooltip.className = `fixed z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg tooltip-${position}`;
            tooltip.textContent = text;
            tooltip.id = 'tooltip';
            
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            let top, left;
            switch (position) {
                case 'top':
                    top = rect.top - tooltipRect.height - 8;
                    left = rect.left + (rect.width - tooltipRect.width) / 2;
                    break;
                case 'bottom':
                    top = rect.bottom + 8;
                    left = rect.left + (rect.width - tooltipRect.width) / 2;
                    break;
                case 'left':
                    top = rect.top + (rect.height - tooltipRect.height) / 2;
                    left = rect.left - tooltipRect.width - 8;
                    break;
                case 'right':
                    top = rect.top + (rect.height - tooltipRect.height) / 2;
                    left = rect.right + 8;
                    break;
            }
            
            tooltip.style.top = top + 'px';
            tooltip.style.left = left + 'px';
        }
        
        function hideTooltip() {
            const tooltip = document.getElementById('tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        }
        
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const isHidden = dropdown.classList.contains('hidden');
            
            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown"]').forEach(dd => {
                if (dd.id !== dropdownId) {
                    dd.classList.add('hidden');
                }
            });
            
            if (isHidden) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }
        
        function toggleAccordion(accordionId) {
            const accordion = document.getElementById(accordionId);
            const icon = document.getElementById(accordionId + '-icon');
            const isHidden = accordion.classList.contains('hidden');
            
            if (isHidden) {
                accordion.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                accordion.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
        
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabId).classList.remove('hidden');
            
            // Add active class to clicked tab button
            const activeButton = event.target;
            activeButton.classList.add('active', 'border-blue-500', 'text-blue-600');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }
        
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        
        function openConfirmModal() {
            if (confirm('Are you sure you want to perform this action?')) {
                showNotification('Action confirmed', 'success');
            } else {
                showNotification('Action cancelled', 'info');
            }
        }
        
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
        
        function scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
        
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            showNotification(`Dark mode ${isDark ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function exportComponents() {
            showNotification('Components exported successfully', 'success');
        }
        
        function initializeComponents() {
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('[onclick*="toggleDropdown"]')) {
                    document.querySelectorAll('[id^="dropdown"]').forEach(dropdown => {
                        dropdown.classList.add('hidden');
                    });
                }
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
    </script>
</x-filament-panels::page>