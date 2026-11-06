<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Chat Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Team Chat</h1>
                    <p class="text-gray-600 mt-1">Real-time communication with your team</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">{{ count($onlineUsers) }} online</span>
                    </div>
                    <button onclick="toggleNotifications()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-bell mr-2"></i>Notifications
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar - Users List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Team Members</h3>
                    <div class="space-y-3">
                        @foreach($users as $user)
                            <button 
                                wire:click="selectUser({{ $user['id'] }})"
                                class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ $selectedUser == $user['id'] ? 'bg-blue-50 border border-blue-200' : '' }}"
                            >
                                <div class="relative">
                                    <img src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}" class="w-10 h-10 rounded-full object-cover">
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white
                                        {{ $user['status'] === 'online' ? 'bg-green-500' : 
                                           ($user['status'] === 'away' ? 'bg-yellow-500' : 'bg-gray-400') }}">
                                    </div>
                                </div>
                                <div class="flex-1 text-left">
                                    <p class="text-sm font-medium text-gray-900">{{ $user['name'] }}</p>
                                    <p class="text-xs text-gray-500 capitalize">{{ $user['status'] }}</p>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content - Chat Area -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col h-96">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">General Chat</h3>
                                    <p class="text-sm text-gray-600">{{ count($onlineUsers) }} members online</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="toggleEmojiPicker()" class="p-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-smile"></i>
                                </button>
                                <button onclick="toggleFileUpload()" class="p-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                <button onclick="toggleVideoCall()" class="p-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-video"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4">
                        @foreach($messages as $message)
                            <div class="flex items-start space-x-3 {{ $message['user_id'] == auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                <img src="{{ $message['user_avatar'] }}" alt="{{ $message['user_name'] }}" class="w-8 h-8 rounded-full object-cover">
                                <div class="flex-1 max-w-xs lg:max-w-md">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="text-sm font-medium text-gray-900">{{ $message['user_name'] }}</span>
                                        <span class="text-xs text-gray-500">{{ $message['timestamp']->format('H:i') }}</span>
                                    </div>
                                    <div class="bg-gray-100 rounded-lg p-3 {{ $message['user_id'] == auth()->id() ? 'bg-blue-500 text-white' : '' }}">
                                        <p class="text-sm">{{ $message['message'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t border-gray-200">
                        <form wire:submit="sendMessage" class="flex items-center space-x-3">
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    wire:model="message"
                                    placeholder="Type your message..." 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    wire:keydown.enter="sendMessage"
                                >
                            </div>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
                                {{ empty($message) ? 'disabled' : '' }}
                            >
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Emoji Picker Modal -->
    <div id="emoji-picker" class="fixed bottom-20 right-4 bg-white rounded-lg shadow-xl border border-gray-200 p-4 hidden z-50">
        <div class="grid grid-cols-8 gap-2">
            <button onclick="insertEmoji('😀')" class="p-2 hover:bg-gray-100 rounded">😀</button>
            <button onclick="insertEmoji('😃')" class="p-2 hover:bg-gray-100 rounded">😃</button>
            <button onclick="insertEmoji('😄')" class="p-2 hover:bg-gray-100 rounded">😄</button>
            <button onclick="insertEmoji('😁')" class="p-2 hover:bg-gray-100 rounded">😁</button>
            <button onclick="insertEmoji('😆')" class="p-2 hover:bg-gray-100 rounded">😆</button>
            <button onclick="insertEmoji('😅')" class="p-2 hover:bg-gray-100 rounded">😅</button>
            <button onclick="insertEmoji('😂')" class="p-2 hover:bg-gray-100 rounded">😂</button>
            <button onclick="insertEmoji('🤣')" class="p-2 hover:bg-gray-100 rounded">🤣</button>
            <button onclick="insertEmoji('😊')" class="p-2 hover:bg-gray-100 rounded">😊</button>
            <button onclick="insertEmoji('😇')" class="p-2 hover:bg-gray-100 rounded">😇</button>
            <button onclick="insertEmoji('🙂')" class="p-2 hover:bg-gray-100 rounded">🙂</button>
            <button onclick="insertEmoji('🙃')" class="p-2 hover:bg-gray-100 rounded">🙃</button>
            <button onclick="insertEmoji('😉')" class="p-2 hover:bg-gray-100 rounded">😉</button>
            <button onclick="insertEmoji('😌')" class="p-2 hover:bg-gray-100 rounded">😌</button>
            <button onclick="insertEmoji('😍')" class="p-2 hover:bg-gray-100 rounded">😍</button>
            <button onclick="insertEmoji('🥰')" class="p-2 hover:bg-gray-100 rounded">🥰</button>
        </div>
    </div>

    <!-- File Upload Modal -->
    <div id="file-upload-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Upload File</h3>
                    <button onclick="closeFileUploadModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 mb-2">Drag and drop files here or click to browse</p>
                        <input type="file" multiple class="hidden" id="file-input">
                        <button onclick="document.getElementById('file-input').click()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Choose Files
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3">
                        <button onclick="closeFileUploadModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button onclick="uploadFiles()" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chat functionality
        document.addEventListener('DOMContentLoaded', function() {
            scrollToBottom();
            startRealTimeUpdates();
        });
        
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }
        
        function startRealTimeUpdates() {
            // Simulate real-time message updates
            setInterval(() => {
                // In a real application, this would listen for new messages via WebSockets
                // For demo purposes, we'll just scroll to bottom periodically
                scrollToBottom();
            }, 1000);
        }
        
        function toggleEmojiPicker() {
            const picker = document.getElementById('emoji-picker');
            picker.classList.toggle('hidden');
        }
        
        function insertEmoji(emoji) {
            const messageInput = document.querySelector('input[wire\\:model="message"]');
            if (messageInput) {
                messageInput.value += emoji;
                messageInput.dispatchEvent(new Event('input'));
            }
            document.getElementById('emoji-picker').classList.add('hidden');
        }
        
        function toggleFileUpload() {
            document.getElementById('file-upload-modal').classList.remove('hidden');
        }
        
        function closeFileUploadModal() {
            document.getElementById('file-upload-modal').classList.add('hidden');
        }
        
        function uploadFiles() {
            // In a real application, this would upload files
            showNotification('Files uploaded successfully', 'success');
            closeFileUploadModal();
        }
        
        function toggleVideoCall() {
            // In a real application, this would start a video call
            showNotification('Video call functionality would be implemented here', 'info');
        }
        
        function toggleNotifications() {
            // In a real application, this would toggle notification settings
            showNotification('Notification settings updated', 'success');
        }
        
        // Listen for new messages
        window.addEventListener('message-sent', function(event) {
            scrollToBottom();
        });
        
        // Auto-scroll when new messages arrive
        window.addEventListener('message-received', function(event) {
            scrollToBottom();
        });
        
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