<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Activity Timeline</span>
                <div class="flex items-center space-x-2">
                    <select wire:model="filter" class="text-sm border-gray-300 rounded-md">
                        @foreach($this->getFilterOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600" onclick="refreshTimeline()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-4">
            <!-- Timeline Controls -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button onclick="toggleView()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                        <i class="fas fa-list" id="view-toggle-icon"></i> List View
                    </button>
                    <button onclick="exportTimeline()" class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Show:</span>
                    <select id="time-range" class="text-sm border-gray-300 rounded-md" onchange="filterByTimeRange()">
                        <option value="all">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
            </div>

            <!-- Timeline Container -->
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                
                <!-- Timeline Events -->
                <div id="timeline-events" class="space-y-6">
                    @foreach($events as $event)
                        <div class="timeline-event relative flex items-start space-x-4" data-type="{{ $event['type'] }}">
                            <!-- Timeline Dot -->
                            <div class="flex-shrink-0 w-16 h-16 bg-white rounded-full border-4 border-gray-200 flex items-center justify-center relative z-10"
                                 style="border-color: {{ $event['color'] }}">
                                <i class="{{ $event['icon'] }} text-lg" style="color: {{ $event['color'] }}"></i>
                            </div>
                            
                            <!-- Event Content -->
                            <div class="flex-1 min-w-0">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $event['title'] }}</h3>
                                            <p class="text-gray-600 mb-3">{{ $event['description'] }}</p>
                                            
                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span class="flex items-center">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($event['date'])->diffForHumans() }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($event['date'])->format('M j, Y') }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ ucfirst($event['type']) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2 ml-4">
                                            <button onclick="viewEventDetails({{ $event['id'] }})" 
                                                    class="p-2 text-gray-400 hover:text-blue-500 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="editEvent({{ $event['id'] }})" 
                                                    class="p-2 text-gray-400 hover:text-green-500 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteEvent({{ $event['id'] }})" 
                                                    class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center pt-6">
                <button onclick="loadMoreEvents()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Load More Events
                </button>
            </div>
        </div>
    </x-filament::section>

    <!-- Event Details Modal -->
    <div id="event-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Event Details</h3>
                    <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="event-details">
                    <!-- Event details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let isListView = false;
        let currentTimeRange = 'all';
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeTimeline();
        });
        
        function initializeTimeline() {
            // Add animation to timeline events
            const events = document.querySelectorAll('.timeline-event');
            events.forEach((event, index) => {
                event.style.opacity = '0';
                event.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    event.style.transition = 'all 0.5s ease';
                    event.style.opacity = '1';
                    event.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }
        
        function toggleView() {
            isListView = !isListView;
            const container = document.getElementById('timeline-events');
            const toggleIcon = document.getElementById('view-toggle-icon');
            
            if (isListView) {
                container.classList.add('space-y-2');
                container.classList.remove('space-y-6');
                toggleIcon.className = 'fas fa-th';
                toggleIcon.parentElement.innerHTML = '<i class="fas fa-th"></i> Grid View';
            } else {
                container.classList.remove('space-y-2');
                container.classList.add('space-y-6');
                toggleIcon.className = 'fas fa-list';
                toggleIcon.parentElement.innerHTML = '<i class="fas fa-list"></i> List View';
            }
        }
        
        function filterByTimeRange() {
            currentTimeRange = document.getElementById('time-range').value;
            const events = document.querySelectorAll('.timeline-event');
            
            events.forEach(event => {
                const eventDate = new Date(event.querySelector('.fa-calendar').parentElement.textContent.trim());
                const now = new Date();
                let show = true;
                
                switch (currentTimeRange) {
                    case 'today':
                        show = eventDate.toDateString() === now.toDateString();
                        break;
                    case 'week':
                        const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                        show = eventDate >= weekAgo;
                        break;
                    case 'month':
                        const monthAgo = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                        show = eventDate >= monthAgo;
                        break;
                }
                
                event.style.display = show ? 'flex' : 'none';
            });
        }
        
        function refreshTimeline() {
            // In a real application, this would fetch new events from the server
            showNotification('Timeline refreshed', 'success');
        }
        
        function exportTimeline() {
            const events = document.querySelectorAll('.timeline-event');
            const data = Array.from(events).map(event => {
                const title = event.querySelector('h3').textContent;
                const description = event.querySelector('p').textContent;
                const date = event.querySelector('.fa-calendar').parentElement.textContent.trim();
                const type = event.querySelector('.fa-tag').parentElement.textContent.trim();
                
                return { title, description, date, type };
            });
            
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'timeline-events.json';
            a.click();
            URL.revokeObjectURL(url);
        }
        
        function loadMoreEvents() {
            // In a real application, this would load more events from the server
            showNotification('Loading more events...', 'info');
        }
        
        function viewEventDetails(eventId) {
            const event = document.querySelector(`[data-event-id="${eventId}"]`);
            if (event) {
                const title = event.querySelector('h3').textContent;
                const description = event.querySelector('p').textContent;
                const date = event.querySelector('.fa-calendar').parentElement.textContent.trim();
                const type = event.querySelector('.fa-tag').parentElement.textContent.trim();
                
                document.getElementById('event-details').innerHTML = `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <p class="text-gray-900">${title}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <p class="text-gray-900">${description}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <p class="text-gray-900">${date}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <p class="text-gray-900">${type}</p>
                        </div>
                    </div>
                `;
                
                document.getElementById('event-modal').classList.remove('hidden');
            }
        }
        
        function editEvent(eventId) {
            // In a real application, this would open an edit form
            showNotification('Edit event functionality would be implemented here', 'info');
        }
        
        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                // In a real application, this would delete the event from the server
                showNotification('Event deleted successfully', 'success');
            }
        }
        
        function closeEventModal() {
            document.getElementById('event-modal').classList.add('hidden');
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