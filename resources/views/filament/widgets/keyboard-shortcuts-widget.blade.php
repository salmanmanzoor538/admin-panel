<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Keyboard Shortcuts</span>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Press</span>
                    <kbd class="px-2 py-1 bg-gray-100 border border-gray-300 rounded text-sm font-mono">Ctrl + /</kbd>
                    <span class="text-sm text-gray-500">for help</span>
                </div>
            </div>
        </x-slot>
        
        <div class="space-y-6">
            <!-- Quick Shortcuts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-home text-blue-600"></i>
                        <span class="font-medium text-blue-900">Home</span>
                    </div>
                    <kbd class="px-2 py-1 bg-blue-100 border border-blue-300 rounded text-sm font-mono">Alt + H</kbd>
                </div>
                
                <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-plus text-green-600"></i>
                        <span class="font-medium text-green-900">New Item</span>
                    </div>
                    <kbd class="px-2 py-1 bg-green-100 border border-green-300 rounded text-sm font-mono">Ctrl + N</kbd>
                </div>
                
                <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-search text-purple-600"></i>
                        <span class="font-medium text-purple-900">Search</span>
                    </div>
                    <kbd class="px-2 py-1 bg-purple-100 border border-purple-300 rounded text-sm font-mono">Ctrl + F</kbd>
                </div>
                
                <div class="p-4 bg-orange-50 rounded-lg border border-orange-200">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-cog text-orange-600"></i>
                        <span class="font-medium text-orange-900">Settings</span>
                    </div>
                    <kbd class="px-2 py-1 bg-orange-100 border border-orange-300 rounded text-sm font-mono">Ctrl + ,</kbd>
                </div>
            </div>
            
            <!-- Form Content -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                {{ $this->form }}
            </div>
            
            <!-- Shortcuts Categories -->
            <div class="space-y-6" id="shortcuts-categories">
                @foreach($shortcuts as $category)
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-{{ $category['title'] === 'Navigation' ? 'compass' : ($category['title'] === 'Actions' ? 'bolt' : ($category['title'] === 'Media Player' ? 'play' : ($category['title'] === 'System' ? 'cog' : 'coins'))) }} text-blue-600 mr-2"></i>
                            {{ $category['title'] }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($category['shortcuts'] as $shortcut)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $shortcut['action'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $shortcut['description'] }}</div>
                                    </div>
                                    <kbd class="px-3 py-1 bg-white border border-gray-300 rounded text-sm font-mono text-gray-700 ml-4">
                                        {{ $shortcut['key'] }}
                                    </kbd>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Active Shortcut Indicator -->
            @if($activeShortcut)
                <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50" id="shortcut-indicator">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check"></i>
                        <span>Shortcut executed: {{ $activeShortcut }}</span>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
    
    <!-- Shortcuts Help Modal -->
    <div id="shortcuts-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">Keyboard Shortcuts</h2>
                        <button onclick="closeShortcutsModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($shortcuts as $category)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $category['title'] }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($category['shortcuts'] as $shortcut)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $shortcut['action'] }}</div>
                                                <div class="text-sm text-gray-500">{{ $shortcut['description'] }}</div>
                                            </div>
                                            <kbd class="px-3 py-1 bg-white border border-gray-300 rounded text-sm font-mono text-gray-700">
                                                {{ $shortcut['key'] }}
                                            </kbd>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Press <kbd class="px-2 py-1 bg-white border border-gray-300 rounded text-sm font-mono">Escape</kbd> to close this modal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        kbd {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            white-space: nowrap;
        }
        
        .shortcut-active {
            animation: pulse 0.5s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
    
    <script>
        // Keyboard Shortcuts functionality
        let shortcutsEnabled = @json($shortcutsEnabled);
        let activeShortcut = @json($activeShortcut);
        let shortcuts = @json($shortcuts);
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeKeyboardShortcuts();
        });
        
        function initializeKeyboardShortcuts() {
            if (shortcutsEnabled) {
                setupGlobalShortcuts();
                setupShortcutIndicators();
            }
        }
        
        function setupGlobalShortcuts() {
            document.addEventListener('keydown', function(e) {
                if (!shortcutsEnabled) return;
                
                const key = getKeyCombination(e);
                const shortcut = findShortcut(key);
                
                if (shortcut) {
                    e.preventDefault();
                    executeShortcut(shortcut);
                }
            });
        }
        
        function getKeyCombination(e) {
            let key = '';
            
            if (e.ctrlKey) key += 'Ctrl + ';
            if (e.altKey) key += 'Alt + ';
            if (e.shiftKey) key += 'Shift + ';
            if (e.metaKey) key += 'Cmd + ';
            
            // Handle special keys
            switch(e.code) {
                case 'Space':
                    key += 'Space';
                    break;
                case 'ArrowLeft':
                    key += '←';
                    break;
                case 'ArrowRight':
                    key += '→';
                    break;
                case 'ArrowUp':
                    key += '↑';
                    break;
                case 'ArrowDown':
                    key += '↓';
                    break;
                case 'Escape':
                    key += 'Escape';
                    break;
                case 'F11':
                    key += 'F11';
                    break;
                case 'Delete':
                    key += 'Delete';
                    break;
                default:
                    key += e.key.toUpperCase();
            }
            
            return key.trim();
        }
        
        function findShortcut(key) {
            for (const category of Object.values(shortcuts)) {
                for (const shortcut of category.shortcuts) {
                    if (shortcut.key === key) {
                        return shortcut;
                    }
                }
            }
            return null;
        }
        
        function executeShortcut(shortcut) {
            // Show visual feedback
            showShortcutFeedback(shortcut);
            
            // Execute the shortcut action
            switch(shortcut.action) {
                case 'Show/Hide Shortcuts Help':
                    toggleShortcutsModal();
                    break;
                case 'Command Palette':
                    openCommandPalette();
                    break;
                case 'Settings':
                    navigateToSettings();
                    break;
                case 'Home Dashboard':
                    navigateToHome();
                    break;
                case 'Users':
                    navigateToUsers();
                    break;
                case 'Posts':
                    navigateToPosts();
                    break;
                case 'Categories':
                    navigateToCategories();
                    break;
                case 'Media':
                    navigateToMedia();
                    break;
                case 'New Item':
                    createNewItem();
                    break;
                case 'Save':
                    saveCurrentForm();
                    break;
                case 'Search':
                    openSearch();
                    break;
                case 'Dark Mode':
                    toggleDarkMode();
                    break;
                case 'Fullscreen':
                    toggleFullscreen();
                    break;
                case 'Close Modal':
                    closeModals();
                    break;
                default:
                    showNotification(`Shortcut executed: ${shortcut.action}`, 'info');
            }
        }
        
        function showShortcutFeedback(shortcut) {
            // Find the shortcut element and highlight it
            const shortcutElements = document.querySelectorAll('[data-shortcut]');
            shortcutElements.forEach(element => {
                if (element.dataset.shortcut === shortcut.key) {
                    element.classList.add('shortcut-active');
                    setTimeout(() => {
                        element.classList.remove('shortcut-active');
                    }, 500);
                }
            });
            
            // Show notification
            showNotification(`Shortcut: ${shortcut.action}`, 'success');
        }
        
        function setupShortcutIndicators() {
            // Add data attributes to shortcut elements
            const shortcutElements = document.querySelectorAll('kbd');
            shortcutElements.forEach(element => {
                element.setAttribute('data-shortcut', element.textContent);
            });
        }
        
        function toggleShortcutsModal() {
            const modal = document.getElementById('shortcuts-modal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
        
        function closeShortcutsModal() {
            const modal = document.getElementById('shortcuts-modal');
            modal.classList.add('hidden');
        }
        
        function openCommandPalette() {
            showNotification('Command palette opened', 'info');
        }
        
        function navigateToSettings() {
            showNotification('Navigating to settings', 'info');
        }
        
        function navigateToHome() {
            showNotification('Navigating to home', 'info');
        }
        
        function navigateToUsers() {
            showNotification('Navigating to users', 'info');
        }
        
        function navigateToPosts() {
            showNotification('Navigating to posts', 'info');
        }
        
        function navigateToCategories() {
            showNotification('Navigating to categories', 'info');
        }
        
        function navigateToMedia() {
            showNotification('Navigating to media', 'info');
        }
        
        function createNewItem() {
            showNotification('Creating new item', 'info');
        }
        
        function saveCurrentForm() {
            showNotification('Saving form', 'success');
        }
        
        function openSearch() {
            showNotification('Opening search', 'info');
        }
        
        function toggleDarkMode() {
            showNotification('Toggling dark mode', 'info');
        }
        
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }
        
        function closeModals() {
            const modals = document.querySelectorAll('[id$="-modal"]');
            modals.forEach(modal => {
                modal.classList.add('hidden');
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
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeShortcutsModal();
            }
        });
        
        // Close modal on outside click
        document.getElementById('shortcuts-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeShortcutsModal();
            }
        });
    </script>
</x-filament-widgets::widget>