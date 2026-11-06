<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Theme Customization</span>
                <button onclick="resetTheme()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                    <i class="fas fa-undo mr-1"></i>Reset
                </button>
            </div>
        </x-slot>

        <div class="space-y-6">
            <!-- Theme Mode Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Theme Mode</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($themeModes as $modeKey => $mode)
                        <button 
                            onclick="setThemeMode('{{ $modeKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $themeMode === $modeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $mode['icon'] }} text-2xl {{ $themeMode === $modeKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900">{{ $mode['name'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $mode['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Color Scheme Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Color Scheme</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($colorSchemes as $schemeKey => $scheme)
                        <button 
                            onclick="setColorScheme('{{ $schemeKey }}')"
                            class="relative p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $colorScheme === $schemeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <div class="w-12 h-12 {{ $scheme['preview'] }} rounded-full mx-auto mb-2 shadow-lg"></div>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $scheme['name'] }}</h4>
                                @if($colorScheme === $schemeKey)
                                    <div class="absolute top-2 right-2">
                                        <i class="fas fa-check-circle text-blue-600"></i>
                                    </div>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Live Preview -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Live Preview</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Primary Color Preview -->
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-500 rounded-lg mx-auto mb-2 shadow-lg"></div>
                            <p class="text-sm font-medium text-gray-900">Primary</p>
                            <p class="text-xs text-gray-600">#3b82f6</p>
                        </div>
                        
                        <!-- Secondary Color Preview -->
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-700 rounded-lg mx-auto mb-2 shadow-lg"></div>
                            <p class="text-sm font-medium text-gray-900">Secondary</p>
                            <p class="text-xs text-gray-600">#1e40af</p>
                        </div>
                        
                        <!-- Accent Color Preview -->
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-300 rounded-lg mx-auto mb-2 shadow-lg"></div>
                            <p class="text-sm font-medium text-gray-900">Accent</p>
                            <p class="text-xs text-gray-600">#60a5fa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customization Options -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Advanced Options</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Typography</h4>
                        <div class="space-y-2">
                            <select class="w-full text-sm border-gray-300 rounded-md">
                                <option>Inter (Default)</option>
                                <option>Roboto</option>
                                <option>Open Sans</option>
                                <option>Lato</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Layout</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Compact Mode</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Sidebar Collapsed</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export/Import Settings -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <button onclick="exportTheme()" class="px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-download mr-2"></i>Export Theme
                    </button>
                    <button onclick="importTheme()" class="px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-upload mr-2"></i>Import Theme
                    </button>
                </div>
                <div class="text-sm text-gray-600">
                    <span id="theme-status">Theme saved</span>
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        // Theme customization functionality
        document.addEventListener('DOMContentLoaded', function() {
            loadCurrentTheme();
        });
        
        function loadCurrentTheme() {
            // Load current theme from localStorage or session
            const savedColorScheme = localStorage.getItem('colorScheme') || 'blue';
            const savedThemeMode = localStorage.getItem('themeMode') || 'light';
            
            setColorScheme(savedColorScheme);
            setThemeMode(savedThemeMode);
        }
        
        function setColorScheme(scheme) {
            const colorSchemes = @json($colorSchemes);
            const selectedScheme = colorSchemes[scheme];
            
            if (selectedScheme) {
                // Update CSS variables
                document.documentElement.style.setProperty('--primary-color', selectedScheme.primary);
                document.documentElement.style.setProperty('--secondary-color', selectedScheme.secondary);
                document.documentElement.style.setProperty('--accent-color', selectedScheme.accent);
                
                // Update preview colors
                updatePreviewColors(selectedScheme);
                
                // Save to localStorage
                localStorage.setItem('colorScheme', scheme);
                
                // Update status
                document.getElementById('theme-status').textContent = 'Color scheme updated';
                
                showNotification(`Color scheme changed to ${selectedScheme.name}`, 'success');
            }
        }
        
        function setThemeMode(mode) {
            const themeModes = @json($themeModes);
            const selectedMode = themeModes[mode];
            
            if (selectedMode) {
                // Apply theme mode
                if (mode === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (mode === 'light') {
                    document.documentElement.classList.remove('dark');
                } else if (mode === 'auto') {
                    // Follow system preference
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
                
                // Save to localStorage
                localStorage.setItem('themeMode', mode);
                
                // Update status
                document.getElementById('theme-status').textContent = 'Theme mode updated';
                
                showNotification(`Theme mode changed to ${selectedMode.name}`, 'success');
            }
        }
        
        function updatePreviewColors(scheme) {
            // Update the preview colors in the live preview section
            const primaryPreview = document.querySelector('.bg-blue-500');
            const secondaryPreview = document.querySelector('.bg-blue-700');
            const accentPreview = document.querySelector('.bg-blue-300');
            
            if (primaryPreview) {
                primaryPreview.className = primaryPreview.className.replace('bg-blue-500', 'bg-blue-500');
                primaryPreview.style.backgroundColor = scheme.primary;
            }
            
            if (secondaryPreview) {
                secondaryPreview.className = secondaryPreview.className.replace('bg-blue-700', 'bg-blue-700');
                secondaryPreview.style.backgroundColor = scheme.secondary;
            }
            
            if (accentPreview) {
                accentPreview.className = accentPreview.className.replace('bg-blue-300', 'bg-blue-300');
                accentPreview.style.backgroundColor = scheme.accent;
            }
        }
        
        function resetTheme() {
            if (confirm('Are you sure you want to reset the theme to default settings?')) {
                setColorScheme('blue');
                setThemeMode('light');
                document.getElementById('theme-status').textContent = 'Theme reset to default';
                showNotification('Theme reset to default settings', 'success');
            }
        }
        
        function exportTheme() {
            const theme = {
                colorScheme: localStorage.getItem('colorScheme') || 'blue',
                themeMode: localStorage.getItem('themeMode') || 'light',
                timestamp: new Date().toISOString()
            };
            
            const blob = new Blob([JSON.stringify(theme, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'theme-settings.json';
            a.click();
            URL.revokeObjectURL(url);
            
            showNotification('Theme settings exported', 'success');
        }
        
        function importTheme() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.json';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        try {
                            const theme = JSON.parse(e.target.result);
                            if (theme.colorScheme) setColorScheme(theme.colorScheme);
                            if (theme.themeMode) setThemeMode(theme.themeMode);
                            showNotification('Theme settings imported', 'success');
                        } catch (error) {
                            showNotification('Invalid theme file', 'error');
                        }
                    };
                    reader.readAsText(file);
                }
            };
            input.click();
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