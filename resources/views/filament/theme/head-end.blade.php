{{-- Custom CSS and JavaScript for enhanced navigation --}}
<style>
    /* Enhanced Navigation Styles */
    .filament-sidebar {
        transition: all 0.3s ease;
    }
    
    .filament-sidebar.collapsed {
        width: 4rem;
    }
    
    .filament-sidebar.expanded {
        width: 16rem;
    }
    
    /* Hover effects for menu items */
    .filament-sidebar-nav-item {
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        margin: 0.25rem 0.5rem;
    }
    
    .filament-sidebar-nav-item:hover {
        background-color: rgba(59, 130, 246, 0.1);
        transform: translateX(2px);
    }
    
    /* Menu toggle button */
    .menu-toggle-btn {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .menu-toggle-btn:hover {
        background: #f9fafb;
        transform: scale(1.05);
    }
    
    /* Navigation type toggle */
    .nav-type-toggle {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1000;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .filament-sidebar {
            transform: translateX(-100%);
        }
        
        .filament-sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .menu-toggle-btn {
            display: block;
        }
    }
    
    @media (min-width: 769px) {
        .menu-toggle-btn {
            display: none;
        }
    }
    
    /* Chart container styles */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    /* Grid.js table styles */
    .gridjs-container {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    /* File upload styles */
    .filepond--root {
        margin-bottom: 1rem;
    }
    
    .filepond--panel-root {
        border-radius: 0.5rem;
        border: 2px dashed #d1d5db;
        background-color: #f9fafb;
    }
    
    .filepond--drop-label {
        color: #6b7280;
    }
</style>

{{-- Include Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>

{{-- Include Grid.js --}}
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
<link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

{{-- Include Filepond --}}
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

{{-- Include Dropzone --}}
<link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet">
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

{{-- Include FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

{{-- Include Leaflet for maps --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

{{-- Include FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Include Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">