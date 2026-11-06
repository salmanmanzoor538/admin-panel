<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            font-family: 'Inter', sans-serif;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
            <!-- 500 Icon -->
            <div class="pulse mb-6">
                <div class="w-24 h-24 mx-auto bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-server text-white text-3xl"></i>
                </div>
            </div>
            
            <!-- Error Code -->
            <h1 class="text-6xl font-bold text-gray-800 mb-4">500</h1>
            
            <!-- Error Message -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Internal Server Error</h2>
            <p class="text-gray-600 mb-8">
                Something went wrong on our end. We're working to fix this issue.
            </p>
            
            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ url('/admin') }}" 
                   class="block w-full bg-gradient-to-r from-red-500 to-orange-500 text-white py-3 px-6 rounded-lg font-medium hover:from-red-600 hover:to-orange-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-home mr-2"></i>
                    Go to Dashboard
                </a>
                
                <button onclick="location.reload()" 
                        class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-200 transition-all duration-300">
                    <i class="fas fa-redo mr-2"></i>
                    Try Again
                </button>
            </div>
            
            <!-- Help Text -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    If the problem persists, please contact our support team.
                </p>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <div class="flex justify-center space-x-6 text-white">
                <a href="{{ url('/') }}" class="hover:text-red-200 transition-colors">
                    <i class="fas fa-globe mr-1"></i> Home
                </a>
                <a href="{{ url('/admin') }}" class="hover:text-red-200 transition-colors">
                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                </a>
                <a href="mailto:support@example.com" class="hover:text-red-200 transition-colors">
                    <i class="fas fa-envelope mr-1"></i> Support
                </a>
            </div>
        </div>
    </div>
</body>
</html>