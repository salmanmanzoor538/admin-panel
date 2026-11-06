{{-- Enhanced Navigation Controls --}}
<div class="menu-toggle-btn" onclick="toggleMenu()">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</div>

<div class="nav-type-toggle" onclick="toggleNavigationType()">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</div>

<script>
    // Enhanced Navigation JavaScript
    let menuState = localStorage.getItem('filament.menu.state') || 'expanded';
    let navigationType = localStorage.getItem('filament.navigation.type') || 'vertical';
    
    // Initialize menu state
    document.addEventListener('DOMContentLoaded', function() {
        applyMenuState();
        applyNavigationType();
    });
    
    function toggleMenu() {
        menuState = menuState === 'expanded' ? 'collapsed' : 'expanded';
        localStorage.setItem('filament.menu.state', menuState);
        applyMenuState();
        
        // Send to server for persistence
        fetch('/admin/menu-state', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ state: menuState })
        });
    }
    
    function toggleNavigationType() {
        navigationType = navigationType === 'vertical' ? 'horizontal' : 'vertical';
        localStorage.setItem('filament.navigation.type', navigationType);
        applyNavigationType();
        
        // Send to server for persistence
        fetch('/admin/navigation-type', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ type: navigationType })
        });
    }
    
    function applyMenuState() {
        const sidebar = document.querySelector('.filament-sidebar');
        if (sidebar) {
            sidebar.classList.remove('expanded', 'collapsed');
            sidebar.classList.add(menuState);
        }
    }
    
    function applyNavigationType() {
        const body = document.body;
        body.classList.remove('nav-vertical', 'nav-horizontal');
        body.classList.add('nav-' + navigationType);
    }
    
    // Hover functionality for desktop
    if (window.innerWidth > 768) {
        const sidebar = document.querySelector('.filament-sidebar');
        if (sidebar) {
            sidebar.addEventListener('mouseenter', function() {
                if (menuState === 'collapsed') {
                    this.classList.add('hover-expanded');
                }
            });
            
            sidebar.addEventListener('mouseleave', function() {
                this.classList.remove('hover-expanded');
            });
        }
    }
    
    // Mobile menu functionality
    function toggleMobileMenu() {
        const sidebar = document.querySelector('.filament-sidebar');
        if (sidebar) {
            sidebar.classList.toggle('mobile-open');
        }
    }
    
    // Chart.js configuration
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#6b7280';
    Chart.defaults.borderColor = '#e5e7eb';
    Chart.defaults.backgroundColor = 'rgba(59, 130, 246, 0.1)';
    
    // Grid.js configuration
    window.GridJS = GridJS;
    
    // Filepond configuration
    if (typeof FilePond !== 'undefined') {
        FilePond.setOptions({
            allowMultiple: true,
            maxFiles: 10,
            maxFileSize: '10MB',
            acceptedFileTypes: ['image/*', 'application/pdf', 'text/*'],
            server: {
                process: '/admin/upload',
                revert: '/admin/upload/revert',
                load: '/admin/upload/load/',
            }
        });
    }
    
    // Dropzone configuration
    if (typeof Dropzone !== 'undefined') {
        Dropzone.autoDiscover = false;
    }
</script>