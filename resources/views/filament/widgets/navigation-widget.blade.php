<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Navigation Settings</span>
                <button onclick="resetNavigation()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                    <i class="fas fa-undo mr-1"></i>Reset
                </button>
            </div>
        </x-slot>

        <div class="space-y-6">
            <!-- Menu Type Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Type</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($menuTypes as $typeKey => $type)
                        <button 
                            onclick="setMenuType('{{ $typeKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $menuType === $typeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $type['icon'] }} text-2xl {{ $menuType === $typeKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900">{{ $type['name'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $type['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Menu Style Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Style</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($menuStyles as $styleKey => $style)
                        <button 
                            onclick="setMenuStyle('{{ $styleKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $menuStyle === $styleKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <div class="w-12 h-12 {{ $style['preview'] }} rounded-lg mx-auto mb-2 shadow-lg"></div>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $style['name'] }}</h4>
                                <p class="text-xs text-gray-600">{{ $style['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Text Direction Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Text Direction</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($textDirections as $dirKey => $dir)
                        <button 
                            onclick="setTextDirection('{{ $dirKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $textDirection === $dirKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $dir['icon'] }} text-2xl {{ $textDirection === $dirKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900">{{ $dir['name'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $dir['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Menu Behavior Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Behavior</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($menuBehaviors as $behaviorKey => $behavior)
                        <button 
                            onclick="setMenuBehavior('{{ $behaviorKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $menuBehavior === $behaviorKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $behavior['icon'] }} text-2xl {{ $menuBehavior === $behaviorKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $behavior['name'] }}</h4>
                                <p class="text-xs text-gray-600">{{ $behavior['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Advanced Options -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Advanced Options</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $twoPanelMenu ? 'checked' : '' }}
                                onchange="setTwoPanelMenu(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Two Panel Menu</span>
                        </label>
                        <p class="text-xs text-gray-600 mt-1">Enable dual-panel navigation layout</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                {{ $menuCollapsed ? 'checked' : '' }}
                                onchange="setMenuCollapsed(this.checked)"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Menu Collapsed</span>
                        </label>
                        <p class="text-xs text-gray-600 mt-1">Start with collapsed menu state</p>
                    </div>
                </div>
            </div>

            <!-- Live Preview -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Live Preview</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div id="navigation-preview" class="relative">
                        <!-- Navigation preview will be rendered here -->
                        <div class="flex items-center justify-center h-32 bg-gray-100 rounded-lg">
                            <p class="text-gray-600">Navigation preview will appear here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Items Preview -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Items Preview</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="space-y-2">
                        @foreach($menuItems as $item)
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded">
                                <i class="{{ $item['icon'] }} text-gray-400 w-5"></i>
                                <span class="text-sm text-gray-900">{{ $item['label'] }}</span>
                                @if(isset($item['children']))
                                    <i class="fas fa-chevron-down text-gray-400 text-xs ml-auto"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            loadCurrentNavigationSettings();
            renderNavigationPreview();
        });
        
        function loadCurrentNavigationSettings() {
            // Load current settings from localStorage or session
            const savedMenuType = localStorage.getItem('menuType') || '{{ $menuType }}';
            const savedMenuStyle = localStorage.getItem('menuStyle') || '{{ $menuStyle }}';
            const savedTextDirection = localStorage.getItem('textDirection') || '{{ $textDirection }}';
            const savedMenuBehavior = localStorage.getItem('menuBehavior') || '{{ $menuBehavior }}';
            const savedTwoPanelMenu = localStorage.getItem('twoPanelMenu') === 'true' || {{ $twoPanelMenu ? 'true' : 'false' }};
            const savedMenuCollapsed = localStorage.getItem('menuCollapsed') === 'true' || {{ $menuCollapsed ? 'true' : 'false' }};
            
            setMenuType(savedMenuType);
            setMenuStyle(savedMenuStyle);
            setTextDirection(savedTextDirection);
            setMenuBehavior(savedMenuBehavior);
            setTwoPanelMenu(savedTwoPanelMenu);
            setMenuCollapsed(savedMenuCollapsed);
        }
        
        function setMenuType(type) {
            localStorage.setItem('menuType', type);
            applyNavigationSettings();
            renderNavigationPreview();
            showNotification(`Menu type changed to ${type}`, 'success');
        }
        
        function setMenuStyle(style) {
            localStorage.setItem('menuStyle', style);
            applyNavigationSettings();
            renderNavigationPreview();
            showNotification(`Menu style changed to ${style}`, 'success');
        }
        
        function setTextDirection(direction) {
            localStorage.setItem('textDirection', direction);
            applyNavigationSettings();
            renderNavigationPreview();
            showNotification(`Text direction changed to ${direction}`, 'success');
        }
        
        function setMenuBehavior(behavior) {
            localStorage.setItem('menuBehavior', behavior);
            applyNavigationSettings();
            renderNavigationPreview();
            showNotification(`Menu behavior changed to ${behavior}`, 'success');
        }
        
        function setTwoPanelMenu(enabled) {
            localStorage.setItem('twoPanelMenu', enabled);
            applyNavigationSettings();
            renderNavigationPreview();
            showNotification(`Two panel menu ${enabled ? 'enabled' : 'disabled'}`, 'success');
        }
        
        function setMenuCollapsed(collapsed) {
            localStorage.setItem('menuCollapsed', collapsed);
            applyNavigationSettings();
            renderNavigationPreview();
            showNotification(`Menu ${collapsed ? 'collapsed' : 'expanded'}`, 'success');
        }
        
        function applyNavigationSettings() {
            const menuType = localStorage.getItem('menuType') || 'vertical';
            const menuStyle = localStorage.getItem('menuStyle') || 'default';
            const textDirection = localStorage.getItem('textDirection') || 'ltr';
            const menuBehavior = localStorage.getItem('menuBehavior') || 'click';
            const twoPanelMenu = localStorage.getItem('twoPanelMenu') === 'true';
            const menuCollapsed = localStorage.getItem('menuCollapsed') === 'true';
            
            // Apply text direction
            document.documentElement.setAttribute('dir', textDirection);
            document.documentElement.setAttribute('lang', textDirection === 'rtl' ? 'ar' : 'en');
            
            // Apply menu type classes
            document.body.classList.remove('menu-vertical', 'menu-horizontal', 'menu-hybrid');
            document.body.classList.add(`menu-${menuType}`);
            
            // Apply menu style classes
            document.body.classList.remove('menu-default', 'menu-modern', 'menu-glass', 'menu-dark');
            document.body.classList.add(`menu-${menuStyle}`);
            
            // Apply menu behavior classes
            document.body.classList.remove('menu-click', 'menu-hover', 'menu-icon-click', 'menu-icon-hover');
            document.body.classList.add(`menu-${menuBehavior}`);
            
            // Apply two panel menu
            if (twoPanelMenu) {
                document.body.classList.add('two-panel-menu');
            } else {
                document.body.classList.remove('two-panel-menu');
            }
            
            // Apply menu collapsed state
            if (menuCollapsed) {
                document.body.classList.add('menu-collapsed');
            } else {
                document.body.classList.remove('menu-collapsed');
            }
        }
        
        function renderNavigationPreview() {
            const preview = document.getElementById('navigation-preview');
            const menuType = localStorage.getItem('menuType') || 'vertical';
            const menuStyle = localStorage.getItem('menuStyle') || 'default';
            const textDirection = localStorage.getItem('textDirection') || 'ltr';
            
            let previewHTML = '';
            
            if (menuType === 'vertical') {
                previewHTML = `
                    <div class="flex h-32">
                        <div class="w-16 bg-gray-200 rounded-l-lg flex flex-col items-center py-2 space-y-2">
                            <div class="w-8 h-8 bg-blue-500 rounded"></div>
                            <div class="w-8 h-8 bg-gray-400 rounded"></div>
                            <div class="w-8 h-8 bg-gray-400 rounded"></div>
                        </div>
                        <div class="flex-1 bg-white rounded-r-lg p-4">
                            <div class="text-sm text-gray-600">Vertical Menu Preview</div>
                        </div>
                    </div>
                `;
            } else if (menuType === 'horizontal') {
                previewHTML = `
                    <div class="h-16 bg-gray-200 rounded-lg flex items-center px-4 space-x-4">
                        <div class="w-8 h-8 bg-blue-500 rounded"></div>
                        <div class="w-8 h-8 bg-gray-400 rounded"></div>
                        <div class="w-8 h-8 bg-gray-400 rounded"></div>
                        <div class="w-8 h-8 bg-gray-400 rounded"></div>
                    </div>
                `;
            } else if (menuType === 'hybrid') {
                previewHTML = `
                    <div class="space-y-2">
                        <div class="h-8 bg-gray-200 rounded flex items-center px-4 space-x-4">
                            <div class="w-6 h-6 bg-blue-500 rounded"></div>
                            <div class="w-6 h-6 bg-gray-400 rounded"></div>
                            <div class="w-6 h-6 bg-gray-400 rounded"></div>
                        </div>
                        <div class="flex h-16">
                            <div class="w-12 bg-gray-200 rounded-l-lg flex flex-col items-center py-2 space-y-1">
                                <div class="w-6 h-6 bg-gray-400 rounded"></div>
                                <div class="w-6 h-6 bg-gray-400 rounded"></div>
                            </div>
                            <div class="flex-1 bg-white rounded-r-lg p-2">
                                <div class="text-xs text-gray-600">Hybrid Menu Preview</div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            preview.innerHTML = previewHTML;
        }
        
        function resetNavigation() {
            if (confirm('Are you sure you want to reset navigation settings to default?')) {
                localStorage.removeItem('menuType');
                localStorage.removeItem('menuStyle');
                localStorage.removeItem('textDirection');
                localStorage.removeItem('menuBehavior');
                localStorage.removeItem('twoPanelMenu');
                localStorage.removeItem('menuCollapsed');
                
                loadCurrentNavigationSettings();
                showNotification('Navigation settings reset to default', 'success');
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