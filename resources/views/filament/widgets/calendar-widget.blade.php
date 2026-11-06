<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Calendar Events</span>
                <div class="flex items-center space-x-2">
                    <select wire:model="viewType" class="text-sm border-gray-300 rounded-md">
                        @foreach($this->getViewTypeOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600" onclick="addEvent()">
                        <i class="fas fa-plus"></i> Add Event
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-4">
            <!-- Calendar Controls -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button onclick="previousPeriod()" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="today()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                        Today
                    </button>
                    <button onclick="nextPeriod()" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="toggleWeekends()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                        <i class="fas fa-calendar-week"></i> Weekends
                    </button>
                    <button onclick="exportCalendar()" class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Calendar Container -->
            <div id="calendar" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4"></div>

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
                        
                        <form id="event-form" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" id="event-title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                    <input type="date" id="event-start-date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                    <input type="time" id="event-start-time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                    <input type="date" id="event-end-date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                    <input type="time" id="event-end-time" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                <select id="event-color" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="#3b82f6">Blue</option>
                                    <option value="#ef4444">Red</option>
                                    <option value="#10b981">Green</option>
                                    <option value="#f59e0b">Yellow</option>
                                    <option value="#8b5cf6">Purple</option>
                                    <option value="#f97316">Orange</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="event-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                            </div>
                            
                            <div class="flex items-center justify-end space-x-3 pt-4">
                                <button type="button" onclick="closeEventModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                    Save Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        let calendar;
        let currentEventId = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar();
        });
        
        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            const events = @json($events);
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: '{{ $viewType }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: events,
                editable: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                weekends: true,
                eventClick: function(info) {
                    editEvent(info.event);
                },
                select: function(info) {
                    createEvent(info.start, info.end);
                },
                eventDrop: function(info) {
                    updateEvent(info.event);
                },
                eventResize: function(info) {
                    updateEvent(info.event);
                },
                eventDidMount: function(info) {
                    // Add tooltip
                    info.el.setAttribute('title', info.event.extendedProps.description || info.event.title);
                }
            });
            
            calendar.render();
        }
        
        function addEvent() {
            openEventModal();
        }
        
        function createEvent(start, end) {
            openEventModal();
            if (start) {
                document.getElementById('event-start-date').value = start.toISOString().split('T')[0];
                document.getElementById('event-start-time').value = start.toTimeString().slice(0, 5);
            }
            if (end) {
                document.getElementById('event-end-date').value = end.toISOString().split('T')[0];
                document.getElementById('event-end-time').value = end.toTimeString().slice(0, 5);
            }
        }
        
        function editEvent(event) {
            currentEventId = event.id;
            openEventModal();
            
            document.getElementById('event-title').value = event.title;
            document.getElementById('event-start-date').value = event.start.toISOString().split('T')[0];
            document.getElementById('event-start-time').value = event.start.toTimeString().slice(0, 5);
            
            if (event.end) {
                document.getElementById('event-end-date').value = event.end.toISOString().split('T')[0];
                document.getElementById('event-end-time').value = event.end.toTimeString().slice(0, 5);
            }
            
            document.getElementById('event-color').value = event.color;
            document.getElementById('event-description').value = event.extendedProps.description || '';
        }
        
        function openEventModal() {
            document.getElementById('event-modal').classList.remove('hidden');
        }
        
        function closeEventModal() {
            document.getElementById('event-modal').classList.add('hidden');
            document.getElementById('event-form').reset();
            currentEventId = null;
        }
        
        function updateEvent(event) {
            fetch('/admin/calendar/events/' + event.id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    start: event.start.toISOString(),
                    end: event.end ? event.end.toISOString() : null
                })
            }).then(response => {
                if (!response.ok) {
                    showNotification('Error updating event', 'error');
                }
            });
        }
        
        function previousPeriod() {
            calendar.prev();
        }
        
        function nextPeriod() {
            calendar.next();
        }
        
        function today() {
            calendar.today();
        }
        
        function toggleWeekends() {
            calendar.setOption('weekends', !calendar.getOption('weekends'));
        }
        
        function exportCalendar() {
            const events = calendar.getEvents();
            const data = events.map(event => ({
                title: event.title,
                start: event.start.toISOString(),
                end: event.end ? event.end.toISOString() : null,
                description: event.extendedProps.description || ''
            }));
            
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'calendar-events.json';
            a.click();
            URL.revokeObjectURL(url);
        }
        
        // Handle form submission
        document.getElementById('event-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('event-title').value;
            const startDate = document.getElementById('event-start-date').value;
            const startTime = document.getElementById('event-start-time').value;
            const endDate = document.getElementById('event-end-date').value;
            const endTime = document.getElementById('event-end-time').value;
            const color = document.getElementById('event-color').value;
            const description = document.getElementById('event-description').value;
            
            const start = new Date(startDate + (startTime ? 'T' + startTime : ''));
            const end = endDate ? new Date(endDate + (endTime ? 'T' + endTime : '')) : null;
            
            if (currentEventId) {
                // Update existing event
                const event = calendar.getEventById(currentEventId);
                event.setStart(start);
                if (end) event.setEnd(end);
                event.setTitle(title);
                event.setProp('color', color);
                event.setExtendedProp('description', description);
            } else {
                // Create new event
                calendar.addEvent({
                    title: title,
                    start: start,
                    end: end,
                    color: color,
                    description: description
                });
            }
            
            closeEventModal();
            showNotification('Event saved successfully', 'success');
        });
    </script>
</x-filament-widgets::widget>