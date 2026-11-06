<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Activity Feed</span>
                <div class="flex items-center space-x-2">
                    <select wire:model="filter" class="text-sm border-gray-300 rounded-md">
                        @foreach($this->getFilterOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600" onclick="refreshFeed()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-4">
            <!-- Activity Feed Controls -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button onclick="toggleAutoRefresh()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                        <i class="fas fa-play" id="auto-refresh-icon"></i> Auto Refresh
                    </button>
                    <button onclick="markAllAsRead()" class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                        <i class="fas fa-check-double"></i> Mark All Read
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Show:</span>
                    <select id="time-filter" class="text-sm border-gray-300 rounded-md" onchange="filterByTime()">
                        <option value="all">All Time</option>
                        <option value="hour">Last Hour</option>
                        <option value="day">Last 24 Hours</option>
                        <option value="week">Last Week</option>
                    </select>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                </div>
                
                <div id="activity-feed" class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @foreach($activities as $activity)
                        <div class="activity-item p-4 hover:bg-gray-50 transition-colors" data-type="{{ $activity['type'] }}">
                            <div class="flex items-start space-x-3">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $activity['user']['avatar'] }}" 
                                         alt="{{ $activity['user']['name'] }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                </div>
                                
                                <!-- Activity Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium text-gray-900">{{ $activity['user']['name'] }}</span>
                                        <span class="text-sm text-gray-500">{{ $activity['user']['role'] }}</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                              style="background-color: {{ $activity['color'] }}20; color: {{ $activity['color'] }}">
                                            <i class="{{ $activity['icon'] }} mr-1"></i>
                                            {{ ucfirst($activity['action']) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-700 mt-1">{{ $activity['description'] }}</p>
                                    
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                                        </span>
                                        
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewActivityDetails({{ $activity['id'] }})" 
                                                    class="text-xs text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </button>
                                            <button onclick="likeActivity({{ $activity['id'] }})" 
                                                    class="text-xs text-gray-500 hover:text-red-500">
                                                <i class="fas fa-heart mr-1"></i>Like
                                            </button>
                                            <button onclick="shareActivity({{ $activity['id'] }})" 
                                                    class="text-xs text-gray-500 hover:text-blue-500">
                                                <i class="fas fa-share mr-1"></i>Share
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Load More Button -->
                <div class="p-4 border-t border-gray-200 text-center">
                    <button onclick="loadMoreActivities()" class="px-4 py-2 text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-plus mr-1"></i>
                        Load More Activities
                    </button>
                </div>
            </div>

            <!-- Activity Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-users text-blue-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Active Users</p>
                            <p class="text-2xl font-bold text-blue-900" id="active-users">{{ count($activities) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-green-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-green-800">Activities Today</p>
                            <p class="text-2xl font-bold text-green-900" id="today-activities">{{ count($activities) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-comments text-yellow-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Comments</p>
                            <p class="text-2xl font-bold text-yellow-900" id="total-comments">{{ count(array_filter($activities, fn($a) => $a['type'] === 'comment')) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt text-purple-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-purple-800">Posts Created</p>
                            <p class="text-2xl font-bold text-purple-900" id="total-posts">{{ count(array_filter($activities, fn($a) => $a['type'] === 'post')) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <!-- Activity Details Modal -->
    <div id="activity-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Activity Details</h3>
                    <button onclick="closeActivityModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="activity-details">
                    <!-- Activity details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let autoRefreshInterval;
        let isAutoRefreshEnabled = false;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeActivityFeed();
        });
        
        function initializeActivityFeed() {
            // Add animation to activity items
            const activities = document.querySelectorAll('.activity-item');
            activities.forEach((activity, index) => {
                activity.style.opacity = '0';
                activity.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    activity.style.transition = 'all 0.3s ease';
                    activity.style.opacity = '1';
                    activity.style.transform = 'translateX(0)';
                }, index * 50);
            });
        }
        
        function toggleAutoRefresh() {
            const icon = document.getElementById('auto-refresh-icon');
            
            if (isAutoRefreshEnabled) {
                clearInterval(autoRefreshInterval);
                icon.className = 'fas fa-play';
                isAutoRefreshEnabled = false;
                showNotification('Auto refresh disabled', 'info');
            } else {
                autoRefreshInterval = setInterval(refreshFeed, 30000); // Refresh every 30 seconds
                icon.className = 'fas fa-pause';
                isAutoRefreshEnabled = true;
                showNotification('Auto refresh enabled', 'success');
            }
        }
        
        function refreshFeed() {
            // In a real application, this would fetch new activities from the server
            showNotification('Activity feed refreshed', 'success');
        }
        
        function markAllAsRead() {
            const activities = document.querySelectorAll('.activity-item');
            activities.forEach(activity => {
                activity.classList.add('opacity-50');
            });
            showNotification('All activities marked as read', 'success');
        }
        
        function filterByTime() {
            const timeFilter = document.getElementById('time-filter').value;
            const activities = document.querySelectorAll('.activity-item');
            const now = new Date();
            
            activities.forEach(activity => {
                const timeText = activity.querySelector('.fa-clock').parentElement.textContent.trim();
                let show = true;
                
                switch (timeFilter) {
                    case 'hour':
                        show = timeText.includes('minute') || timeText.includes('second');
                        break;
                    case 'day':
                        show = !timeText.includes('week') && !timeText.includes('month') && !timeText.includes('year');
                        break;
                    case 'week':
                        show = !timeText.includes('month') && !timeText.includes('year');
                        break;
                }
                
                activity.style.display = show ? 'block' : 'none';
            });
        }
        
        function loadMoreActivities() {
            // In a real application, this would load more activities from the server
            showNotification('Loading more activities...', 'info');
        }
        
        function viewActivityDetails(activityId) {
            // In a real application, this would fetch activity details from the server
            const activity = document.querySelector(`[data-activity-id="${activityId}"]`);
            if (activity) {
                const user = activity.querySelector('.font-medium').textContent;
                const description = activity.querySelector('.text-gray-700').textContent;
                const time = activity.querySelector('.fa-clock').parentElement.textContent.trim();
                
                document.getElementById('activity-details').innerHTML = `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                            <p class="text-gray-900">${user}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Activity</label>
                            <p class="text-gray-900">${description}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <p class="text-gray-900">${time}</p>
                        </div>
                    </div>
                `;
                
                document.getElementById('activity-modal').classList.remove('hidden');
            }
        }
        
        function likeActivity(activityId) {
            // In a real application, this would send a like request to the server
            showNotification('Activity liked!', 'success');
        }
        
        function shareActivity(activityId) {
            // In a real application, this would open a share dialog
            if (navigator.share) {
                navigator.share({
                    title: 'Activity',
                    text: 'Check out this activity',
                    url: window.location.href
                });
            } else {
                showNotification('Share functionality would be implemented here', 'info');
            }
        }
        
        function closeActivityModal() {
            document.getElementById('activity-modal').classList.add('hidden');
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