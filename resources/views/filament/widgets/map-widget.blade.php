<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>Interactive Maps</span>
                <div class="flex items-center space-x-2">
                    <select wire:model="mapType" class="text-sm border-gray-300 rounded-md">
                        @foreach($this->getMapTypeOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600" onclick="addMarker()">
                        <i class="fas fa-map-marker-alt"></i> Add Marker
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="space-y-4">
            <!-- Map Controls -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button onclick="centerMap()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                        <i class="fas fa-crosshairs"></i> Center
                    </button>
                    <button onclick="toggleFullscreen()" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                        <i class="fas fa-expand"></i> Fullscreen
                    </button>
                    <button onclick="exportMap()" class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Zoom:</span>
                    <input type="range" id="zoom-slider" min="1" max="18" value="10" class="w-20" onchange="setZoom(this.value)">
                    <span id="zoom-value" class="text-sm text-gray-600">10</span>
                </div>
            </div>

            <!-- Map Container -->
            <div class="relative">
                <div id="map" class="w-full h-96 bg-gray-100 rounded-lg border border-gray-200"></div>
                
                <!-- Map Loading Overlay -->
                <div id="map-loading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-500 mb-2"></i>
                        <p class="text-gray-600">Loading map...</p>
                    </div>
                </div>
            </div>

            <!-- Map Info Panel -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Total Markers</p>
                            <p class="text-2xl font-bold text-blue-900" id="marker-count">{{ count($markers) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-globe text-green-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-green-800">Map Type</p>
                            <p class="text-lg font-bold text-green-900" id="current-map-type">{{ ucfirst($mapType) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-layer-group text-purple-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-purple-800">Layers</p>
                            <p class="text-lg font-bold text-purple-900" id="layer-count">3</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Marker Modal -->
            <div id="marker-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Add Marker</h3>
                            <button onclick="closeMarkerModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <form id="marker-form" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" id="marker-title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="marker-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                                    <input type="number" id="marker-lat" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                                    <input type="number" id="marker-lng" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                                <select id="marker-icon" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="fas fa-map-marker-alt">Default</option>
                                    <option value="fas fa-building">Building</option>
                                    <option value="fas fa-home">Home</option>
                                    <option value="fas fa-car">Car</option>
                                    <option value="fas fa-plane">Plane</option>
                                    <option value="fas fa-ship">Ship</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                <select id="marker-color" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="#3b82f6">Blue</option>
                                    <option value="#ef4444">Red</option>
                                    <option value="#10b981">Green</option>
                                    <option value="#f59e0b">Yellow</option>
                                    <option value="#8b5cf6">Purple</option>
                                    <option value="#f97316">Orange</option>
                                </select>
                            </div>
                            
                            <div class="flex items-center justify-end space-x-3 pt-4">
                                <button type="button" onclick="closeMarkerModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                    Add Marker
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        let map;
        let markers = [];
        let currentMapType = '{{ $mapType }}';
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeMap();
        });
        
        function initializeMap() {
            const mapType = '{{ $mapType }}';
            const mapEl = document.getElementById('map');
            
            // Hide loading overlay
            document.getElementById('map-loading').classList.add('hidden');
            
            if (mapType === 'leaflet') {
                initializeLeafletMap();
            } else if (mapType === 'google') {
                initializeGoogleMap();
            } else if (mapType === 'vector') {
                initializeVectorMap();
            }
        }
        
        function initializeLeafletMap() {
            // Initialize Leaflet map
            map = L.map('map').setView([39.8283, -98.5795], 4);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Add markers
            addMarkersToMap();
            
            // Add click event to map
            map.on('click', function(e) {
                addMarkerAtPosition(e.latlng.lat, e.latlng.lng);
            });
        }
        
        function initializeGoogleMap() {
            // Initialize Google Maps (requires API key)
            if (typeof google === 'undefined') {
                showNotification('Google Maps API key required', 'error');
                return;
            }
            
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 39.8283, lng: -98.5795 },
                zoom: 4
            });
            
            // Add markers
            addMarkersToMap();
        }
        
        function initializeVectorMap() {
            // Initialize Vector Map (using jVectorMap)
            if (typeof jQuery === 'undefined') {
                showNotification('jQuery required for vector maps', 'error');
                return;
            }
            
            $('#map').vectorMap({
                map: 'world_mill',
                backgroundColor: '#f8f9fa',
                regionStyle: {
                    initial: {
                        fill: '#e9ecef',
                        'fill-opacity': 1,
                        stroke: '#dee2e6',
                        'stroke-width': 1,
                        'stroke-opacity': 1
                    },
                    hover: {
                        fill: '#dee2e6',
                        'fill-opacity': 0.8
                    }
            });
            
            // Add markers
            addMarkersToMap();
        }
        
        function addMarkersToMap() {
            const markersData = @json($markers);
            
            markersData.forEach(markerData => {
                addMarkerToMap(markerData);
            });
        }
        
        function addMarkerToMap(markerData) {
            if (currentMapType === 'leaflet') {
                const marker = L.marker([markerData.lat, markerData.lng])
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-2">
                            <h3 class="font-semibold text-gray-900">${markerData.title}</h3>
                            <p class="text-sm text-gray-600">${markerData.description}</p>
                        </div>
                    `);
                markers.push(marker);
            } else if (currentMapType === 'google') {
                const marker = new google.maps.Marker({
                    position: { lat: markerData.lat, lng: markerData.lng },
                    map: map,
                    title: markerData.title
                });
                
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div class="p-2">
                            <h3 class="font-semibold text-gray-900">${markerData.title}</h3>
                            <p class="text-sm text-gray-600">${markerData.description}</p>
                        </div>
                    `
                });
                
                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
                
                markers.push(marker);
            }
        }
        
        function addMarker() {
            openMarkerModal();
        }
        
        function addMarkerAtPosition(lat, lng) {
            document.getElementById('marker-lat').value = lat.toFixed(6);
            document.getElementById('marker-lng').value = lng.toFixed(6);
            openMarkerModal();
        }
        
        function openMarkerModal() {
            document.getElementById('marker-modal').classList.remove('hidden');
        }
        
        function closeMarkerModal() {
            document.getElementById('marker-modal').classList.add('hidden');
            document.getElementById('marker-form').reset();
        }
        
        function centerMap() {
            if (currentMapType === 'leaflet' && map) {
                map.setView([39.8283, -98.5795], 4);
            } else if (currentMapType === 'google' && map) {
                map.setCenter({ lat: 39.8283, lng: -98.5795 });
                map.setZoom(4);
            }
        }
        
        function toggleFullscreen() {
            const mapEl = document.getElementById('map');
            if (!document.fullscreenElement) {
                mapEl.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }
        
        function setZoom(zoom) {
            document.getElementById('zoom-value').textContent = zoom;
            if (currentMapType === 'leaflet' && map) {
                map.setZoom(parseInt(zoom));
            } else if (currentMapType === 'google' && map) {
                map.setZoom(parseInt(zoom));
            }
        }
        
        function exportMap() {
            // Export map as image (simplified)
            const mapEl = document.getElementById('map');
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = mapEl.offsetWidth;
            canvas.height = mapEl.offsetHeight;
            
            // This is a simplified export - in a real application, you'd use proper map export APIs
            ctx.fillStyle = '#f8f9fa';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            const link = document.createElement('a');
            link.download = 'map-export.png';
            link.href = canvas.toDataURL();
            link.click();
        }
        
        // Handle form submission
        document.getElementById('marker-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('marker-title').value;
            const description = document.getElementById('marker-description').value;
            const lat = parseFloat(document.getElementById('marker-lat').value);
            const lng = parseFloat(document.getElementById('marker-lng').value);
            const icon = document.getElementById('marker-icon').value;
            const color = document.getElementById('marker-color').value;
            
            const markerData = {
                id: Date.now(),
                title: title,
                description: description,
                lat: lat,
                lng: lng,
                icon: icon,
                color: color
            };
            
            addMarkerToMap(markerData);
            updateMarkerCount();
            closeMarkerModal();
            showNotification('Marker added successfully', 'success');
        });
        
        function updateMarkerCount() {
            document.getElementById('marker-count').textContent = markers.length;
        }
    </script>
</x-filament-widgets::widget>