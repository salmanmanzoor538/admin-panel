<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- 404 Icon -->
            <div class="floating mb-6">
                <div class="w-24 h-24 mx-auto bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                </div>
            </div>
            
            <!-- Error Code -->
            <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
            
            <!-- Error Message -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
            <p class="text-gray-600 mb-8">
                Sorry, the page you are looking for doesn't exist or has been moved.
            </p>
            
            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ url('/admin') }}" 
                   class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-6 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-home mr-2"></i>
                    Go to Dashboard
                </a>
                
                <button onclick="history.back()" 
                        class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-200 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Go Back
                </button>
            </div>
            
            <!-- Help Text -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    If you believe this is an error, please contact support.
                </p>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <div class="flex justify-center space-x-6 text-white">
                <a href="{{ url('/') }}" class="hover:text-blue-200 transition-colors">
                    <i class="fas fa-globe mr-1"></i> Home
                </a>
                <a href="{{ url('/admin') }}" class="hover:text-blue-200 transition-colors">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <a href="mailto:support@example.com" class="hover:text-blue-200 transition-colors">
                    <i class="fas fa-envelope mr-1"></i> Support
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to buttons
            document.querySelectorAll('button, a').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
    
    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>