<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Screen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
        }
        .lock-animation {
            animation: lock 2s ease-in-out infinite;
        }
        @keyframes lock {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .time-display {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- Lock Icon -->
            <div class="lock-animation mb-6">
                <div class="w-20 h-20 mx-auto bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
            </div>
            
            <!-- User Info -->
            <div class="mb-6">
                <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user text-gray-500 text-xl"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ auth()->user()->name ?? 'Admin User' }}</h2>
                <p class="text-sm text-gray-600">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
            </div>
            
            <!-- Time Display -->
            <div class="mb-8">
                <div class="time-display text-3xl font-bold text-gray-800 mb-2" id="current-time">
                    {{ now()->format('H:i') }}
                </div>
                <div class="text-sm text-gray-600" id="current-date">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </div>
            
            <!-- Password Form -->
            <form method="POST" action="{{ route('admin.unlock') }}" class="space-y-4">
                @csrf
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           placeholder="Enter your password to unlock"
                           class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required
                           autofocus>
                    <i class="fas fa-key absolute right-4 top-4 text-gray-400"></i>
                </div>
                
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-unlock mr-2"></i>
                    Unlock
                </button>
            </form>
            
            <!-- Additional Options -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('logout') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Sign Out
                    </a>
                    <a href="{{ url('/') }}" 
                       class="text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Background Pattern -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white opacity-10 rounded-full"></div>
        </div>
    </div>
    
    <script>
        // Update time every second
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            const dateElement = document.getElementById('current-date');
            
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('en-US', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
            
            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        }
        
        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);
        
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on password input
            const passwordInput = document.querySelector('input[type="password"]');
            if (passwordInput) {
                passwordInput.focus();
            }
            
            // Add enter key support
            passwordInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.closest('form').submit();
                }
            });
            
            // Add visual feedback for form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('button[type="submit"]');
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Unlocking...';
                    button.disabled = true;
                });
            }
        });
    </script>
</body>
</html>