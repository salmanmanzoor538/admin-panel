<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Mailbox Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Mailbox</h1>
                    <p class="text-gray-600 mt-1">Manage your emails and communications</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model="searchQuery"
                            placeholder="Search emails..." 
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button onclick="refreshEmails()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar - Folders -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Folders</h3>
                    <div class="space-y-2">
                        @foreach($this->getFolders() as $folderKey => $folder)
                            <button 
                                wire:click="setActiveFolder('{{ $folderKey }}')"
                                class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors {{ $activeFolder === $folderKey ? 'bg-blue-50 border border-blue-200' : '' }}"
                            >
                                <div class="flex items-center space-x-3">
                                    <x-heroicon-o-inbox class="w-5 h-5 text-gray-400" />
                                    <span class="text-sm font-medium text-gray-900">{{ $folder['name'] }}</span>
                                </div>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $folder['count'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content - Email List -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <!-- Email List Header -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <input 
                                    type="checkbox" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    onchange="toggleSelectAll(this.checked)"
                                >
                                <button onclick="markSelectedAsRead()" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-envelope-open mr-1"></i>Mark as Read
                                </button>
                                <button onclick="deleteSelected()" class="text-sm text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ count($this->getEmails()) }} emails
                            </div>
                        </div>
                    </div>

                    <!-- Email List -->
                    <div class="divide-y divide-gray-200">
                        @forelse($this->getEmails() as $email)
                            <div class="p-4 hover:bg-gray-50 transition-colors cursor-pointer {{ !$email['read'] ? 'bg-blue-50' : '' }}"
                                 onclick="openEmail({{ $email['id'] }})">
                                <div class="flex items-start space-x-4">
                                    <input 
                                        type="checkbox" 
                                        class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        onclick="event.stopPropagation(); toggleEmailSelection({{ $email['id'] }})"
                                    >
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                @if($activeFolder === 'inbox')
                                                    <span class="text-sm font-medium text-gray-900">{{ $email['from_name'] }}</span>
                                                    <span class="text-sm text-gray-500">&lt;{{ $email['from'] }}&gt;</span>
                                                @else
                                                    <span class="text-sm font-medium text-gray-900">{{ $email['to_name'] }}</span>
                                                    <span class="text-sm text-gray-500">&lt;{{ $email['to'] }}&gt;</span>
                                                @endif
                                                
                                                @if($email['important'])
                                                    <i class="fas fa-exclamation text-red-500 text-xs"></i>
                                                @endif
                                                
                                                @if($email['attachments'] > 0)
                                                    <i class="fas fa-paperclip text-gray-400 text-xs"></i>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $email['date']->diffForHumans() }}
                                            </div>
                                        </div>
                                        
                                        <h3 class="text-sm font-medium text-gray-900 mt-1 {{ !$email['read'] ? 'font-bold' : '' }}">
                                            {{ $email['subject'] }}
                                        </h3>
                                        
                                        <p class="text-sm text-gray-600 mt-1 truncate">
                                            {{ $email['preview'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No emails found</h3>
                                <p class="text-gray-600">Your {{ $activeFolder }} folder is empty.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compose Email Modal -->
    <div id="compose-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Compose Email</h3>
                    <button onclick="closeComposeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                            <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CC</label>
                            <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea rows="8" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Attachments</label>
                        <input type="file" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeComposeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="button" onclick="saveDraft()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Save Draft
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Email View Modal -->
    <div id="email-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Email Details</h3>
                    <button onclick="closeEmailModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="email-content">
                    <!-- Email content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mailbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for compose modal events
            window.addEventListener('open-compose-modal', function() {
                document.getElementById('compose-modal').classList.remove('hidden');
            });
        });
        
        function openComposeModal() {
            document.getElementById('compose-modal').classList.remove('hidden');
        }
        
        function closeComposeModal() {
            document.getElementById('compose-modal').classList.add('hidden');
        }
        
        function openEmail(emailId) {
            // In a real application, this would fetch email details
            document.getElementById('email-content').innerHTML = `
                <div class="space-y-4">
                    <div class="border-b border-gray-200 pb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Email Subject</h2>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                            <span>From: sender@example.com</span>
                            <span>To: recipient@example.com</span>
                            <span>Date: ${new Date().toLocaleString()}</span>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <p>Email content would be displayed here...</p>
                    </div>
                </div>
            `;
            document.getElementById('email-modal').classList.remove('hidden');
        }
        
        function closeEmailModal() {
            document.getElementById('email-modal').classList.add('hidden');
        }
        
        function refreshEmails() {
            // In a real application, this would refresh emails from server
            showNotification('Emails refreshed', 'success');
        }
        
        function toggleSelectAll(checked) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (checkbox !== event.target) {
                    checkbox.checked = checked;
                }
            });
        }
        
        function markSelectedAsRead() {
            // In a real application, this would mark selected emails as read
            showNotification('Selected emails marked as read', 'success');
        }
        
        function deleteSelected() {
            if (confirm('Are you sure you want to delete the selected emails?')) {
                // In a real application, this would delete selected emails
                showNotification('Selected emails deleted', 'success');
            }
        }
        
        function saveDraft() {
            // In a real application, this would save email as draft
            showNotification('Email saved as draft', 'success');
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