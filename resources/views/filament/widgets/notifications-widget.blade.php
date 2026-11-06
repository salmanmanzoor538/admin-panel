<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Advanced Notifications System</span>
                <div class="flex items-center space-x-2">
                    <button onclick="showNotification()" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                        <i class="fas fa-bell mr-1"></i>Test
                    </button>
                    <button onclick="showConfirmation()" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded hover:bg-green-200">
                        <i class="fas fa-question-circle mr-1"></i>Confirm
                    </button>
                    <button onclick="showToast()" class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded hover:bg-purple-200">
                        <i class="fas fa-toast mr-1"></i>Toast
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-6">
            <!-- Notification Type Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Type</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($notificationTypes as $typeKey => $type)
                        <button 
                            onclick="setNotificationType('{{ $typeKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $notificationType === $typeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <i class="{{ $type['icon'] }} text-2xl {{ $notificationType === $typeKey ? 'text-blue-600' : 'text-gray-400' }} mb-2"></i>
                                <h4 class="font-medium text-gray-900">{{ $type['name'] }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $type['description'] }}</p>
                                <div class="flex flex-wrap justify-center gap-1">
                                    @foreach($type['features'] as $feature)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">{{ $feature }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Alert Type Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Alert Type</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach($alertTypes as $typeKey => $type)
                        <button 
                            onclick="setAlertType('{{ $typeKey }}')"
                            class="p-4 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $alertType === $typeKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <div class="w-12 h-12 rounded-full mx-auto mb-2 flex items-center justify-center" style="background-color: {{ $type['color'] }}20; color: {{ $type['color'] }}">
                                    <i class="fas fa-{{ $typeKey === 'success' ? 'check' : ($typeKey === 'error' ? 'times' : ($typeKey === 'warning' ? 'exclamation-triangle' : ($typeKey === 'info' ? 'info-circle' : 'question-circle'))) }}"></i>
                                </div>
                                <h4 class="font-medium text-gray-900 text-sm">{{ $type['name'] }}</h4>
                                <p class="text-xs text-gray-600">{{ $type['description'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Toast Position Selection -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Toast Position</h3>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
                    @foreach($toastPositions as $posKey => $position)
                        <button 
                            onclick="setToastPosition('{{ $posKey }}')"
                            class="p-3 border-2 rounded-lg transition-all duration-200 hover:shadow-md {{ $toastPosition === $posKey ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="text-center">
                                <div class="w-8 h-8 bg-gray-200 rounded mx-auto mb-2 flex items-center justify-center">
                                    <i class="fas fa-{{ str_contains($posKey, 'top') ? 'arrow-up' : 'arrow-down' }} text-gray-600"></i>
                                </div>
                                <h4 class="font-medium text-gray-900 text-xs">{{ $position }}</h4>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Form Content -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                {{ $this->form }}
            </div>

            <!-- Quick Actions -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <button onclick="showSuccessAlert()" class="p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="text-center">
                            <i class="fas fa-check-circle text-2xl text-green-600 mb-2"></i>
                            <h4 class="font-medium text-green-900">Success Alert</h4>
                            <p class="text-sm text-green-700">Show success message</p>
                        </div>
                    </button>
                    
                    <button onclick="showErrorAlert()" class="p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                        <div class="text-center">
                            <i class="fas fa-times-circle text-2xl text-red-600 mb-2"></i>
                            <h4 class="font-medium text-red-900">Error Alert</h4>
                            <p class="text-sm text-red-700">Show error message</p>
                        </div>
                    </button>
                    
                    <button onclick="showWarningAlert()" class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle text-2xl text-yellow-600 mb-2"></i>
                            <h4 class="font-medium text-yellow-900">Warning Alert</h4>
                            <p class="text-sm text-yellow-700">Show warning message</p>
                        </div>
                    </button>
                    
                    <button onclick="showInfoAlert()" class="p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="text-center">
                            <i class="fas fa-info-circle text-2xl text-blue-600 mb-2"></i>
                            <h4 class="font-medium text-blue-900">Info Alert</h4>
                            <p class="text-sm text-blue-700">Show info message</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Notification Examples -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Examples</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">SweetAlert2 Examples</h4>
                            <div class="space-y-2">
                                <button onclick="showSweetAlert('success')" class="w-full px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                    Success Alert
                                </button>
                                <button onclick="showSweetAlert('error')" class="w-full px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    Error Alert
                                </button>
                                <button onclick="showSweetAlert('warning')" class="w-full px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Warning Alert
                                </button>
                                <button onclick="showSweetAlert('info')" class="w-full px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                    Info Alert
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Toastr Examples</h4>
                            <div class="space-y-2">
                                <button onclick="showToastr('success')" class="w-full px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                    Success Toast
                                </button>
                                <button onclick="showToastr('error')" class="w-full px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    Error Toast
                                </button>
                                <button onclick="showToastr('warning')" class="w-full px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Warning Toast
                                </button>
                                <button onclick="showToastr('info')" class="w-full px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                    Info Toast
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        // Notifications functionality
        let currentNotificationType = '{{ $notificationType }}';
        let currentAlertType = '{{ $alertType }}';
        let currentToastPosition = '{{ $toastPosition }}';
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeNotifications();
        });
        
        function initializeNotifications() {
            // Initialize toastr with default settings
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        }
        
        function setNotificationType(type) {
            currentNotificationType = type;
            showNotification(`Notification type changed to ${type}`, 'success');
        }
        
        function setAlertType(type) {
            currentAlertType = type;
            showNotification(`Alert type changed to ${type}`, 'success');
        }
        
        function setToastPosition(position) {
            currentToastPosition = position;
            toastr.options.positionClass = `toast-${position}`;
            showNotification(`Toast position changed to ${position}`, 'success');
        }
        
        function showNotification() {
            if (currentNotificationType === 'sweetalert') {
                showSweetAlert(currentAlertType);
            } else if (currentNotificationType === 'toastr') {
                showToastr(currentAlertType);
            } else if (currentNotificationType === 'native') {
                showNativeNotification();
            }
        }
        
        function showConfirmation() {
            Swal.fire({
                title: '{{ $title }}',
                text: '{{ $message }}',
                icon: '{{ $icon }}',
                showCancelButton: {{ $showCancelButton ? 'true' : 'false' }},
                confirmButtonColor: '{{ $confirmButtonColor }}',
                cancelButtonColor: '{{ $cancelButtonColor }}',
                confirmButtonText: '{{ $confirmButtonText }}',
                cancelButtonText: '{{ $cancelButtonText }}',
                allowOutsideClick: {{ $allowOutsideClick ? 'true' : 'false' }},
                allowEscapeKey: {{ $allowEscapeKey ? 'true' : 'false' }},
                showCloseButton: {{ $showCloseButton ? 'true' : 'false' }},
                timer: {{ $timer }},
                timerProgressBar: true
            }).then((result) => {
                if (result.isConfirmed) {
                    showNotification('Action confirmed!', 'success');
                } else if (result.isDismissed) {
                    showNotification('Action cancelled!', 'info');
                }
            });
        }
        
        function showToast() {
            showToastr(currentAlertType);
        }
        
        function showSweetAlert(type) {
            const config = {
                title: '{{ $title }}',
                text: '{{ $message }}',
                icon: type,
                confirmButtonColor: '{{ $confirmButtonColor }}',
                confirmButtonText: '{{ $confirmButtonText }}',
                allowOutsideClick: {{ $allowOutsideClick ? 'true' : 'false' }},
                allowEscapeKey: {{ $allowEscapeKey ? 'true' : 'false' }},
                showCloseButton: {{ $showCloseButton ? 'true' : 'false' }},
                timer: {{ $timer }},
                timerProgressBar: true
            };
            
            if (type === 'question') {
                config.showCancelButton = true;
                config.cancelButtonColor = '{{ $cancelButtonColor }}';
                config.cancelButtonText = '{{ $cancelButtonText }}';
            }
            
            Swal.fire(config);
        }
        
        function showToastr(type) {
            const message = '{{ $message }}';
            const title = '{{ $title }}';
            
            switch (type) {
                case 'success':
                    toastr.success(message, title);
                    break;
                case 'error':
                    toastr.error(message, title);
                    break;
                case 'warning':
                    toastr.warning(message, title);
                    break;
                case 'info':
                    toastr.info(message, title);
                    break;
                default:
                    toastr.info(message, title);
            }
        }
        
        function showNativeNotification() {
            if ('Notification' in window) {
                if (Notification.permission === 'granted') {
                    new Notification('{{ $title }}', {
                        body: '{{ $message }}',
                        icon: '/favicon.ico'
                    });
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission().then(function (permission) {
                        if (permission === 'granted') {
                            new Notification('{{ $title }}', {
                                body: '{{ $message }}',
                                icon: '/favicon.ico'
                            });
                        }
                    });
                }
            } else {
                showNotification('This browser does not support notifications', 'error');
            }
        }
        
        function showSuccessAlert() {
            Swal.fire({
                title: 'Success!',
                text: 'Operation completed successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
        
        function showErrorAlert() {
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
        
        function showWarningAlert() {
            Swal.fire({
                title: 'Warning!',
                text: 'Please check your input.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
        
        function showInfoAlert() {
            Swal.fire({
                title: 'Info',
                text: 'Here is some information.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
        
        function showNotification(message, type) {
            // Simple notification for internal use
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