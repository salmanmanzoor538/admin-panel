{{-- Additional JavaScript for enhanced functionality --}}
<script>
    // Enhanced UI functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        initializeTooltips();
        
        // Initialize charts
        initializeCharts();
        
        // Initialize tables
        initializeTables();
        
        // Initialize file uploads
        initializeFileUploads();
        
        // Initialize calendar
        initializeCalendar();
        
        // Initialize maps
        initializeMaps();
    });
    
    function initializeTooltips() {
        // Add tooltip functionality to elements with data-tooltip attribute
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', showTooltip);
            element.addEventListener('mouseleave', hideTooltip);
        });
    }
    
    function showTooltip(event) {
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg';
        tooltip.textContent = event.target.getAttribute('data-tooltip');
        tooltip.style.top = event.target.offsetTop - 30 + 'px';
        tooltip.style.left = event.target.offsetLeft + 'px';
        document.body.appendChild(tooltip);
    }
    
    function hideTooltip() {
        const tooltip = document.querySelector('.absolute.z-50');
        if (tooltip) {
            tooltip.remove();
        }
    }
    
    function initializeCharts() {
        // Initialize any custom charts
        const chartElements = document.querySelectorAll('[data-chart]');
        chartElements.forEach(element => {
            const chartType = element.getAttribute('data-chart-type');
            const chartData = JSON.parse(element.getAttribute('data-chart-data'));
            
            new Chart(element, {
                type: chartType,
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    },
                },
            });
        });
    }
    
    function initializeTables() {
        // Initialize Grid.js tables
        const tableElements = document.querySelectorAll('[data-gridjs]');
        tableElements.forEach(element => {
            const config = JSON.parse(element.getAttribute('data-gridjs-config'));
            new GridJS(config).render(element);
        });
    }
    
    function initializeFileUploads() {
        // Initialize Filepond
        const filepondElements = document.querySelectorAll('.filepond');
        filepondElements.forEach(element => {
            FilePond.create(element);
        });
        
        // Initialize Dropzone
        const dropzoneElements = document.querySelectorAll('.dropzone');
        dropzoneElements.forEach(element => {
            new Dropzone(element, {
                url: '/admin/upload',
                maxFilesize: 10,
                acceptedFiles: 'image/*,application/pdf,text/*',
                addRemoveLinks: true,
                dictDefaultMessage: 'Drop files here or click to upload',
                dictRemoveFile: 'Remove file',
                dictCancelUpload: 'Cancel upload',
            });
        });
    }
    
    function initializeCalendar() {
        // Initialize FullCalendar
        const calendarElements = document.querySelectorAll('.fullcalendar');
        calendarElements.forEach(element => {
            const calendar = new FullCalendar.Calendar(element, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: '/admin/calendar/events',
                editable: true,
                droppable: true,
                eventDrop: function(info) {
                    // Handle event drop
                    updateEventPosition(info.event);
                },
                eventResize: function(info) {
                    // Handle event resize
                    updateEventDuration(info.event);
                },
            });
            calendar.render();
        });
    }
    
    function initializeMaps() {
        // Initialize Leaflet maps
        const mapElements = document.querySelectorAll('.leaflet-map');
        mapElements.forEach(element => {
            const map = L.map(element).setView([51.505, -0.09], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Add markers if data is provided
            const markers = JSON.parse(element.getAttribute('data-markers') || '[]');
            markers.forEach(marker => {
                L.marker([marker.lat, marker.lng])
                    .addTo(map)
                    .bindPopup(marker.popup);
            });
        });
    }
    
    // Utility functions
    function updateEventPosition(event) {
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
        });
    }
    
    function updateEventDuration(event) {
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
        });
    }
    
    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded shadow-lg ${
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
    
    // Global error handler
    window.addEventListener('error', function(event) {
        console.error('JavaScript error:', event.error);
        showNotification('An error occurred. Please check the console for details.', 'error');
    });
    
    // AJAX error handler
    document.addEventListener('ajaxError', function(event) {
        showNotification('Request failed. Please try again.', 'error');
    });
</script>