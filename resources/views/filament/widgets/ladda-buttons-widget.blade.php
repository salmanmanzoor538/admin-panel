<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Ladda Loading Buttons</span>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Enhanced UX with loading animations</span>
                </div>
            </div>
        </x-slot>
        
        <div class="space-y-6">
            <!-- Form Content -->
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                {{ $this->form }}
            </div>
            
            <!-- Button Examples -->
            <div class="space-y-6">
                <!-- Basic Buttons -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Buttons</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="s" onclick="testLaddaButton(this, 'expand-left')">
                            <span class="ladda-label">Expand Left</span>
                        </button>
                        <button class="ladda-button btn btn-success" data-style="expand-right" data-size="s" onclick="testLaddaButton(this, 'expand-right')">
                            <span class="ladda-label">Expand Right</span>
                        </button>
                        <button class="ladda-button btn btn-warning" data-style="expand-up" data-size="s" onclick="testLaddaButton(this, 'expand-up')">
                            <span class="ladda-label">Expand Up</span>
                        </button>
                        <button class="ladda-button btn btn-danger" data-style="expand-down" data-size="s" onclick="testLaddaButton(this, 'expand-down')">
                            <span class="ladda-label">Expand Down</span>
                        </button>
                    </div>
                </div>
                
                <!-- Contract Buttons -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contract Buttons</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button class="ladda-button btn btn-info" data-style="contract" data-size="s" onclick="testLaddaButton(this, 'contract')">
                            <span class="ladda-label">Contract</span>
                        </button>
                        <button class="ladda-button btn btn-secondary" data-style="contract-overlay" data-size="s" onclick="testLaddaButton(this, 'contract-overlay')">
                            <span class="ladda-label">Contract Overlay</span>
                        </button>
                        <button class="ladda-button btn btn-dark" data-style="zoom-in" data-size="s" onclick="testLaddaButton(this, 'zoom-in')">
                            <span class="ladda-label">Zoom In</span>
                        </button>
                        <button class="ladda-button btn btn-light" data-style="zoom-out" data-size="s" onclick="testLaddaButton(this, 'zoom-out')">
                            <span class="ladda-label">Zoom Out</span>
                        </button>
                    </div>
                </div>
                
                <!-- Slide Buttons -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Slide Buttons</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button class="ladda-button btn btn-primary" data-style="slide-left" data-size="s" onclick="testLaddaButton(this, 'slide-left')">
                            <span class="ladda-label">Slide Left</span>
                        </button>
                        <button class="ladda-button btn btn-success" data-style="slide-right" data-size="s" onclick="testLaddaButton(this, 'slide-right')">
                            <span class="ladda-label">Slide Right</span>
                        </button>
                        <button class="ladda-button btn btn-warning" data-style="slide-up" data-size="s" onclick="testLaddaButton(this, 'slide-up')">
                            <span class="ladda-label">Slide Up</span>
                        </button>
                        <button class="ladda-button btn btn-danger" data-style="slide-down" data-size="s" onclick="testLaddaButton(this, 'slide-down')">
                            <span class="ladda-label">Slide Down</span>
                        </button>
                    </div>
                </div>
                
                <!-- Different Sizes -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Different Sizes</h3>
                    <div class="flex items-center space-x-4">
                        <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="xs" onclick="testLaddaButton(this, 'xs')">
                            <span class="ladda-label">XS</span>
                        </button>
                        <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="s" onclick="testLaddaButton(this, 's')">
                            <span class="ladda-label">Small</span>
                        </button>
                        <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="m" onclick="testLaddaButton(this, 'm')">
                            <span class="ladda-label">Medium</span>
                        </button>
                        <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="l" onclick="testLaddaButton(this, 'l')">
                            <span class="ladda-label">Large</span>
                        </button>
                        <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="xl" onclick="testLaddaButton(this, 'xl')">
                            <span class="ladda-label">XL</span>
                        </button>
                    </div>
                </div>
                
                <!-- Real-world Examples -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Real-world Examples</h3>
                    <div class="space-y-4">
                        <!-- Form Submit -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Form Submit</h4>
                            <div class="flex items-center space-x-4">
                                <button class="ladda-button btn btn-success" data-style="expand-right" data-size="m" onclick="simulateFormSubmit(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-save mr-2"></i>Save Changes
                                    </span>
                                </button>
                                <button class="ladda-button btn btn-primary" data-style="contract" data-size="m" onclick="simulateFormSubmit(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-paper-plane mr-2"></i>Submit Form
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- File Upload -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">File Upload</h4>
                            <div class="flex items-center space-x-4">
                                <button class="ladda-button btn btn-info" data-style="expand-up" data-size="m" onclick="simulateFileUpload(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-upload mr-2"></i>Upload File
                                    </span>
                                </button>
                                <button class="ladda-button btn btn-warning" data-style="slide-right" data-size="m" onclick="simulateFileUpload(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i>Upload to Cloud
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- API Calls -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">API Calls</h4>
                            <div class="flex items-center space-x-4">
                                <button class="ladda-button btn btn-primary" data-style="zoom-in" data-size="m" onclick="simulateApiCall(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-sync mr-2"></i>Refresh Data
                                    </span>
                                </button>
                                <button class="ladda-button btn btn-danger" data-style="contract-overlay" data-size="m" onclick="simulateApiCall(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-trash mr-2"></i>Delete Item
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Navigation -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Navigation</h4>
                            <div class="flex items-center space-x-4">
                                <button class="ladda-button btn btn-secondary" data-style="slide-left" data-size="m" onclick="simulateNavigation(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-arrow-left mr-2"></i>Go Back
                                    </span>
                                </button>
                                <button class="ladda-button btn btn-success" data-style="slide-right" data-size="m" onclick="simulateNavigation(this)">
                                    <span class="ladda-label">
                                        <i class="fas fa-arrow-right mr-2"></i>Continue
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Buttons -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress Buttons</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <button class="ladda-button btn btn-primary" data-style="expand-left" data-size="m" onclick="simulateProgress(this, 25)">
                                <span class="ladda-label">25% Progress</span>
                            </button>
                            <button class="ladda-button btn btn-success" data-style="expand-right" data-size="m" onclick="simulateProgress(this, 50)">
                                <span class="ladda-label">50% Progress</span>
                            </button>
                            <button class="ladda-button btn btn-warning" data-style="expand-up" data-size="m" onclick="simulateProgress(this, 75)">
                                <span class="ladda-label">75% Progress</span>
                            </button>
                            <button class="ladda-button btn btn-info" data-style="expand-down" data-size="m" onclick="simulateProgress(this, 100)">
                                <span class="ladda-label">100% Progress</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
    
    <!-- Ladda CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ladda@2.0.1/dist/ladda.min.css">
    
    <!-- Ladda JS -->
    <script src="https://cdn.jsdelivr.net/npm/ladda@2.0.1/dist/ladda.min.js"></script>
    
    <style>
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-secondary {
            color: #fff;
            background-color: #6b7280;
            border-color: #6b7280;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
            border-color: #4b5563;
        }
        
        .btn-success {
            color: #fff;
            background-color: #10b981;
            border-color: #10b981;
        }
        
        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }
        
        .btn-danger {
            color: #fff;
            background-color: #ef4444;
            border-color: #ef4444;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
        }
        
        .btn-warning {
            color: #000;
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        
        .btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
        }
        
        .btn-info {
            color: #fff;
            background-color: #06b6d4;
            border-color: #06b6d4;
        }
        
        .btn-info:hover {
            background-color: #0891b2;
            border-color: #0891b2;
        }
        
        .btn-light {
            color: #000;
            background-color: #f3f4f6;
            border-color: #f3f4f6;
        }
        
        .btn-light:hover {
            background-color: #e5e7eb;
            border-color: #e5e7eb;
        }
        
        .btn-dark {
            color: #fff;
            background-color: #1f2937;
            border-color: #1f2937;
        }
        
        .btn-dark:hover {
            background-color: #111827;
            border-color: #111827;
        }
        
        .ladda-button {
            position: relative;
        }
        
        .ladda-button .ladda-spinner {
            position: absolute;
            z-index: 2;
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: ladda-spinner-rotate 0.8s linear infinite;
        }
        
        @keyframes ladda-spinner-rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .ladda-button[data-loading] .ladda-label {
            opacity: 0.7;
        }
        
        .ladda-button[data-loading] .ladda-spinner {
            opacity: 1;
        }
    </style>
    
    <script>
        // Ladda Buttons functionality
        let selectedStyle = @json($selectedStyle);
        let selectedSize = @json($selectedSize);
        let selectedColor = @json($selectedColor);
        let loadingDuration = @json($loadingDuration);
        let showProgress = @json($showProgress);
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeLaddaButtons();
        });
        
        function initializeLaddaButtons() {
            // Initialize all Ladda buttons
            const buttons = document.querySelectorAll('.ladda-button');
            buttons.forEach(button => {
                Ladda.bind(button);
            });
        }
        
        function testLaddaButton(button, style) {
            const ladda = Ladda.create(button);
            ladda.start();
            
            setTimeout(() => {
                ladda.stop();
                showNotification(`Button style "${style}" tested`, 'success');
            }, loadingDuration);
        }
        
        function simulateFormSubmit(button) {
            const ladda = Ladda.create(button);
            ladda.start();
            
            // Simulate form submission
            setTimeout(() => {
                ladda.stop();
                showNotification('Form submitted successfully', 'success');
            }, 2000);
        }
        
        function simulateFileUpload(button) {
            const ladda = Ladda.create(button);
            ladda.start();
            
            // Simulate file upload with progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                if (showProgress) {
                    ladda.setProgress(progress / 100);
                }
                
                if (progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        ladda.stop();
                        showNotification('File uploaded successfully', 'success');
                    }, 500);
                }
            }, 200);
        }
        
        function simulateApiCall(button) {
            const ladda = Ladda.create(button);
            ladda.start();
            
            // Simulate API call
            setTimeout(() => {
                ladda.stop();
                showNotification('API call completed', 'success');
            }, 1500);
        }
        
        function simulateNavigation(button) {
            const ladda = Ladda.create(button);
            ladda.start();
            
            // Simulate navigation
            setTimeout(() => {
                ladda.stop();
                showNotification('Navigation completed', 'success');
            }, 1000);
        }
        
        function simulateProgress(button, targetProgress) {
            const ladda = Ladda.create(button);
            ladda.start();
            
            // Simulate progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += 5;
                ladda.setProgress(progress / 100);
                
                if (progress >= targetProgress) {
                    clearInterval(interval);
                    setTimeout(() => {
                        ladda.stop();
                        showNotification(`Progress completed: ${targetProgress}%`, 'success');
                    }, 500);
                }
            }, 100);
        }
        
        function updateButtonStyle(style) {
            selectedStyle = style;
            showNotification(`Button style updated to: ${style}`, 'info');
        }
        
        function updateButtonSize(size) {
            selectedSize = size;
            showNotification(`Button size updated to: ${size}`, 'info');
        }
        
        function updateButtonColor(color) {
            selectedColor = color;
            showNotification(`Button color updated to: ${color}`, 'info');
        }
        
        function updateLoadingDuration(duration) {
            loadingDuration = duration;
            showNotification(`Loading duration updated to: ${duration}ms`, 'info');
        }
        
        function updateProgressDisplay(enabled) {
            showProgress = enabled;
            showNotification(`Progress display ${enabled ? 'enabled' : 'disabled'}`, 'info');
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
        
        // Global Ladda button functions
        window.testLaddaButton = testLaddaButton;
        window.simulateFormSubmit = simulateFormSubmit;
        window.simulateFileUpload = simulateFileUpload;
        window.simulateApiCall = simulateApiCall;
        window.simulateNavigation = simulateNavigation;
        window.simulateProgress = simulateProgress;
    </script>
</x-filament-widgets::widget>