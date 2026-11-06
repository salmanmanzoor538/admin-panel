<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Icons Gallery - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/line-awesome@1.3.0/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/eva-icons@1.1.3/style/eva-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-line-icons@2.5.5/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@2.40.0/icons-sprite.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/phosphor-icons@1.4.2/src/regular/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@0.292.0/dist/lucide.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .icon-card {
            transition: all 0.3s ease;
        }
        .icon-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .icon-preview {
            font-size: 2rem;
            color: #6b7280;
            transition: color 0.3s ease;
        }
        .icon-card:hover .icon-preview {
            color: #3b82f6;
        }
        .copy-success {
            animation: copySuccess 0.5s ease;
        }
        @keyframes copySuccess {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-900">Icons Gallery</h1>
                    <div class="text-sm text-gray-500">
                        <span id="total-icons">0</span> icons available
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input 
                                type="text" 
                                id="search-input" 
                                placeholder="Search icons..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <select id="icon-set-filter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all">All Icon Sets</option>
                            <option value="fontawesome">FontAwesome</option>
                            <option value="material">Material Icons</option>
                            <option value="feather">Feather Icons</option>
                            <option value="bootstrap">Bootstrap Icons</option>
                            <option value="boxicons">BoxIcons</option>
                            <option value="remix">Remix Icons</option>
                            <option value="heroicons">Heroicons</option>
                            <option value="ionicons">Ionicons</option>
                            <option value="lineawesome">Line Awesome</option>
                            <option value="eva">Eva Icons</option>
                            <option value="simpleline">Simple Line Icons</option>
                            <option value="tabler">Tabler Icons</option>
                            <option value="phosphor">Phosphor Icons</option>
                            <option value="lucide">Lucide Icons</option>
                        </select>
                        <button onclick="toggleView()" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-th" id="view-toggle-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Icons Grid -->
            <div id="icons-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                <!-- Icons will be loaded here -->
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-8">
                <button id="load-more" onclick="loadMoreIcons()" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Load More Icons
                </button>
            </div>
        </div>
    </div>

    <!-- Copy Notification -->
    <div id="copy-notification" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hidden z-50">
        <i class="fas fa-check mr-2"></i>
        <span id="copy-message">Icon copied to clipboard!</span>
    </div>

    <script>
        let currentIconSet = 'all';
        let currentSearch = '';
        let currentPage = 1;
        let iconsPerPage = 48;
        let allIcons = [];
        let filteredIcons = [];
        let isGridView = true;

        // Icon sets configuration
        const iconSets = {
            fontawesome: {
                name: 'FontAwesome',
                prefix: 'fas fa-',
                icons: [
                    'home', 'user', 'cog', 'search', 'heart', 'star', 'bell', 'envelope',
                    'phone', 'calendar', 'clock', 'map-marker-alt', 'shopping-cart', 'credit-card',
                    'lock', 'unlock', 'eye', 'eye-slash', 'edit', 'trash', 'save', 'download',
                    'upload', 'print', 'share', 'link', 'external-link-alt', 'copy', 'cut',
                    'paste', 'undo', 'redo', 'plus', 'minus', 'times', 'check', 'arrow-left',
                    'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left', 'chevron-right',
                    'chevron-up', 'chevron-down', 'caret-left', 'caret-right', 'caret-up', 'caret-down'
                ]
            },
            material: {
                name: 'Material Icons',
                prefix: 'material-symbols-outlined',
                icons: [
                    'home', 'person', 'settings', 'search', 'favorite', 'star', 'notifications',
                    'mail', 'phone', 'event', 'schedule', 'place', 'shopping_cart', 'credit_card',
                    'lock', 'lock_open', 'visibility', 'visibility_off', 'edit', 'delete',
                    'save', 'download', 'upload', 'print', 'share', 'link', 'open_in_new',
                    'content_copy', 'content_cut', 'content_paste', 'undo', 'redo', 'add',
                    'remove', 'close', 'check', 'arrow_back', 'arrow_forward', 'arrow_upward',
                    'arrow_downward', 'chevron_left', 'chevron_right', 'chevron_up', 'chevron_down',
                    'keyboard_arrow_left', 'keyboard_arrow_right', 'keyboard_arrow_up', 'keyboard_arrow_down'
                ]
            },
            feather: {
                name: 'Feather Icons',
                prefix: 'feather feather-',
                icons: [
                    'home', 'user', 'settings', 'search', 'heart', 'star', 'bell', 'mail',
                    'phone', 'calendar', 'clock', 'map-pin', 'shopping-cart', 'credit-card',
                    'lock', 'unlock', 'eye', 'eye-off', 'edit', 'trash', 'save', 'download',
                    'upload', 'printer', 'share', 'link', 'external-link', 'copy', 'scissors',
                    'clipboard', 'undo', 'redo', 'plus', 'minus', 'x', 'check', 'arrow-left',
                    'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left', 'chevron-right',
                    'chevron-up', 'chevron-down', 'chevrons-left', 'chevrons-right', 'chevrons-up', 'chevrons-down'
                ]
            },
            bootstrap: {
                name: 'Bootstrap Icons',
                prefix: 'bi bi-',
                icons: [
                    'house', 'person', 'gear', 'search', 'heart', 'star', 'bell', 'envelope',
                    'telephone', 'calendar', 'clock', 'geo-alt', 'cart', 'credit-card',
                    'lock', 'unlock', 'eye', 'eye-slash', 'pencil', 'trash', 'save', 'download',
                    'upload', 'printer', 'share', 'link', 'box-arrow-up-right', 'copy', 'scissors',
                    'clipboard', 'arrow-counterclockwise', 'arrow-clockwise', 'plus', 'dash', 'x',
                    'check', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left',
                    'chevron-right', 'chevron-up', 'chevron-down', 'caret-left', 'caret-right', 'caret-up', 'caret-down'
                ]
            },
            boxicons: {
                name: 'BoxIcons',
                prefix: 'bx bx-',
                icons: [
                    'home', 'user', 'cog', 'search', 'heart', 'star', 'bell', 'envelope',
                    'phone', 'calendar', 'time', 'map', 'cart', 'credit-card',
                    'lock', 'lock-open', 'show', 'hide', 'edit', 'trash', 'save', 'download',
                    'upload', 'printer', 'share', 'link', 'link-external', 'copy', 'cut',
                    'paste', 'undo', 'redo', 'plus', 'minus', 'x', 'check', 'left-arrow',
                    'right-arrow', 'up-arrow', 'down-arrow', 'chevron-left', 'chevron-right',
                    'chevron-up', 'chevron-down', 'caret-left', 'caret-right', 'caret-up', 'caret-down'
                ]
            },
            remix: {
                name: 'Remix Icons',
                prefix: 'ri-',
                icons: [
                    'home-line', 'user-line', 'settings-line', 'search-line', 'heart-line', 'star-line',
                    'notification-line', 'mail-line', 'phone-line', 'calendar-line', 'time-line',
                    'map-pin-line', 'shopping-cart-line', 'bank-card-line', 'lock-line', 'lock-unlock-line',
                    'eye-line', 'eye-off-line', 'edit-line', 'delete-bin-line', 'save-line', 'download-line',
                    'upload-line', 'printer-line', 'share-line', 'links-line', 'external-link-line',
                    'file-copy-line', 'scissors-line', 'clipboard-line', 'arrow-go-back-line', 'arrow-go-forward-line',
                    'add-line', 'subtract-line', 'close-line', 'check-line', 'arrow-left-line', 'arrow-right-line',
                    'arrow-up-line', 'arrow-down-line', 'arrow-left-s-line', 'arrow-right-s-line', 'arrow-up-s-line', 'arrow-down-s-line'
                ]
            },
            heroicons: {
                name: 'Heroicons',
                prefix: 'heroicons-outline',
                icons: [
                    'home', 'user', 'cog', 'magnifying-glass', 'heart', 'star', 'bell', 'envelope',
                    'phone', 'calendar', 'clock', 'map-pin', 'shopping-cart', 'credit-card',
                    'lock-closed', 'lock-open', 'eye', 'eye-slash', 'pencil', 'trash', 'document-arrow-down',
                    'document-arrow-up', 'printer', 'share', 'link', 'arrow-top-right-on-square', 'clipboard-document',
                    'scissors', 'clipboard', 'arrow-uturn-left', 'arrow-uturn-right', 'plus', 'minus', 'x-mark',
                    'check', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left',
                    'chevron-right', 'chevron-up', 'chevron-down'
                ]
            },
            ionicons: {
                name: 'Ionicons',
                prefix: 'ion-',
                icons: [
                    'home-outline', 'person-outline', 'settings-outline', 'search-outline', 'heart-outline',
                    'star-outline', 'notifications-outline', 'mail-outline', 'call-outline', 'calendar-outline',
                    'time-outline', 'location-outline', 'cart-outline', 'card-outline', 'lock-closed-outline',
                    'lock-open-outline', 'eye-outline', 'eye-off-outline', 'create-outline', 'trash-outline',
                    'save-outline', 'download-outline', 'cloud-upload-outline', 'print-outline', 'share-outline',
                    'link-outline', 'open-outline', 'copy-outline', 'cut-outline', 'clipboard-outline',
                    'arrow-undo-outline', 'arrow-redo-outline', 'add-outline', 'remove-outline', 'close-outline',
                    'checkmark-outline', 'arrow-back-outline', 'arrow-forward-outline', 'arrow-up-outline', 'arrow-down-outline',
                    'chevron-back-outline', 'chevron-forward-outline', 'chevron-up-outline', 'chevron-down-outline'
                ]
            },
            lineawesome: {
                name: 'Line Awesome',
                prefix: 'la la-',
                icons: [
                    'home', 'user', 'cog', 'search', 'heart', 'star', 'bell', 'envelope',
                    'phone', 'calendar', 'clock', 'map-marker', 'shopping-cart', 'credit-card',
                    'lock', 'unlock', 'eye', 'eye-slash', 'edit', 'trash', 'save', 'download',
                    'upload', 'print', 'share', 'link', 'external-link', 'copy', 'cut',
                    'paste', 'undo', 'redo', 'plus', 'minus', 'times', 'check', 'arrow-left',
                    'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left', 'chevron-right',
                    'chevron-up', 'chevron-down', 'caret-left', 'caret-right', 'caret-up', 'caret-down'
                ]
            },
            eva: {
                name: 'Eva Icons',
                prefix: 'eva eva-',
                icons: [
                    'home-outline', 'person-outline', 'settings-outline', 'search-outline', 'heart-outline',
                    'star-outline', 'bell-outline', 'email-outline', 'phone-outline', 'calendar-outline',
                    'clock-outline', 'pin-outline', 'shopping-cart-outline', 'credit-card-outline',
                    'lock-outline', 'unlock-outline', 'eye-outline', 'eye-off-outline', 'edit-outline',
                    'trash-outline', 'save-outline', 'download-outline', 'upload-outline', 'printer-outline',
                    'share-outline', 'link-outline', 'external-link-outline', 'copy-outline', 'scissors-outline',
                    'clipboard-outline', 'undo-outline', 'redo-outline', 'plus-outline', 'minus-outline',
                    'close-outline', 'checkmark-outline', 'arrow-left-outline', 'arrow-right-outline',
                    'arrow-up-outline', 'arrow-down-outline', 'chevron-left-outline', 'chevron-right-outline',
                    'chevron-up-outline', 'chevron-down-outline'
                ]
            },
            simpleline: {
                name: 'Simple Line Icons',
                prefix: 'icon-',
                icons: [
                    'home', 'user', 'settings', 'magnifier', 'heart', 'star', 'bell', 'envelope',
                    'phone', 'calendar', 'clock', 'location-pin', 'basket', 'credit-card',
                    'lock', 'lock-open', 'eye', 'eye-close', 'pencil', 'trash', 'note', 'cloud-download',
                    'cloud-upload', 'printer', 'share', 'link', 'external-link', 'docs', 'scissors',
                    'clipboard', 'action-undo', 'action-redo', 'plus', 'minus', 'close', 'check',
                    'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'control-start', 'control-end',
                    'control-play', 'control-pause', 'control-forward', 'control-backward'
                ]
            },
            tabler: {
                name: 'Tabler Icons',
                prefix: 'ti ti-',
                icons: [
                    'home', 'user', 'settings', 'search', 'heart', 'star', 'bell', 'mail',
                    'phone', 'calendar', 'clock', 'map-pin', 'shopping-cart', 'credit-card',
                    'lock', 'lock-open', 'eye', 'eye-off', 'edit', 'trash', 'device-floppy', 'download',
                    'upload', 'printer', 'share', 'link', 'external-link', 'copy', 'cut',
                    'clipboard', 'arrow-back', 'arrow-forward', 'plus', 'minus', 'x', 'check',
                    'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left', 'chevron-right',
                    'chevron-up', 'chevron-down', 'caret-left', 'caret-right', 'caret-up', 'caret-down'
                ]
            },
            phosphor: {
                name: 'Phosphor Icons',
                prefix: 'ph ph-',
                icons: [
                    'house', 'user', 'gear', 'magnifying-glass', 'heart', 'star', 'bell', 'envelope',
                    'phone', 'calendar', 'clock', 'map-pin', 'shopping-cart', 'credit-card',
                    'lock', 'lock-open', 'eye', 'eye-slash', 'pencil', 'trash', 'floppy-disk', 'download',
                    'upload', 'printer', 'share', 'link', 'arrow-square-out', 'copy', 'scissors',
                    'clipboard', 'arrow-counter-clockwise', 'arrow-clockwise', 'plus', 'minus', 'x',
                    'check', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'caret-left',
                    'caret-right', 'caret-up', 'caret-down', 'caret-double-left', 'caret-double-right',
                    'caret-double-up', 'caret-double-down'
                ]
            },
            lucide: {
                name: 'Lucide Icons',
                prefix: 'lucide lucide-',
                icons: [
                    'home', 'user', 'settings', 'search', 'heart', 'star', 'bell', 'mail',
                    'phone', 'calendar', 'clock', 'map-pin', 'shopping-cart', 'credit-card',
                    'lock', 'unlock', 'eye', 'eye-off', 'edit', 'trash', 'save', 'download',
                    'upload', 'printer', 'share', 'link', 'external-link', 'copy', 'scissors',
                    'clipboard', 'undo', 'redo', 'plus', 'minus', 'x', 'check', 'arrow-left',
                    'arrow-right', 'arrow-up', 'arrow-down', 'chevron-left', 'chevron-right',
                    'chevron-up', 'chevron-down', 'chevrons-left', 'chevrons-right', 'chevrons-up', 'chevrons-down'
                ]
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            loadAllIcons();
            setupEventListeners();
        });

        function loadAllIcons() {
            allIcons = [];
            
            Object.keys(iconSets).forEach(setKey => {
                const iconSet = iconSets[setKey];
                iconSet.icons.forEach(iconName => {
                    allIcons.push({
                        set: setKey,
                        name: iconName,
                        fullName: iconSet.prefix + iconName,
                        displayName: iconName.replace(/-/g, ' ').replace(/_/g, ' '),
                        setName: iconSet.name
                    });
                });
            });
            
            filteredIcons = [...allIcons];
            updateTotalCount();
            renderIcons();
        }

        function setupEventListeners() {
            document.getElementById('search-input').addEventListener('input', function(e) {
                currentSearch = e.target.value.toLowerCase();
                filterIcons();
            });

            document.getElementById('icon-set-filter').addEventListener('change', function(e) {
                currentIconSet = e.target.value;
                filterIcons();
            });
        }

        function filterIcons() {
            filteredIcons = allIcons.filter(icon => {
                const matchesSearch = icon.displayName.includes(currentSearch) || 
                                    icon.name.includes(currentSearch) ||
                                    icon.fullName.includes(currentSearch);
                const matchesSet = currentIconSet === 'all' || icon.set === currentIconSet;
                return matchesSearch && matchesSet;
            });
            
            currentPage = 1;
            updateTotalCount();
            renderIcons();
        }

        function renderIcons() {
            const container = document.getElementById('icons-container');
            const startIndex = 0;
            const endIndex = currentPage * iconsPerPage;
            const iconsToShow = filteredIcons.slice(startIndex, endIndex);
            
            container.innerHTML = iconsToShow.map(icon => `
                <div class="icon-card bg-white rounded-lg p-4 text-center cursor-pointer border border-gray-200" 
                     onclick="copyIcon('${icon.fullName}', '${icon.setName}')">
                    <div class="icon-preview mb-2">
                        <i class="${icon.fullName}"></i>
                    </div>
                    <div class="text-xs text-gray-600 truncate" title="${icon.displayName}">
                        ${icon.displayName}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        ${icon.setName}
                    </div>
                </div>
            `).join('');
            
            // Show/hide load more button
            const loadMoreBtn = document.getElementById('load-more');
            if (endIndex >= filteredIcons.length) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.style.display = 'block';
            }
        }

        function loadMoreIcons() {
            currentPage++;
            renderIcons();
        }

        function copyIcon(iconCode, setName) {
            navigator.clipboard.writeText(`<i class="${iconCode}"></i>`).then(() => {
                showCopyNotification(`<i class="${iconCode}"></i>`, setName);
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = `<i class="${iconCode}"></i>`;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopyNotification(`<i class="${iconCode}"></i>`, setName);
            });
        }

        function showCopyNotification(iconCode, setName) {
            const notification = document.getElementById('copy-notification');
            const message = document.getElementById('copy-message');
            
            message.innerHTML = `Icon copied! <span class="text-xs">(${setName})</span>`;
            notification.classList.remove('hidden');
            notification.classList.add('copy-success');
            
            setTimeout(() => {
                notification.classList.add('hidden');
                notification.classList.remove('copy-success');
            }, 2000);
        }

        function toggleView() {
            isGridView = !isGridView;
            const container = document.getElementById('icons-container');
            const toggleIcon = document.getElementById('view-toggle-icon');
            
            if (isGridView) {
                container.className = 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4';
                toggleIcon.className = 'fas fa-th';
            } else {
                container.className = 'space-y-2';
                toggleIcon.className = 'fas fa-list';
                // Render as list view
                renderIconsAsList();
            }
        }

        function renderIconsAsList() {
            const container = document.getElementById('icons-container');
            const startIndex = 0;
            const endIndex = currentPage * iconsPerPage;
            const iconsToShow = filteredIcons.slice(startIndex, endIndex);
            
            container.innerHTML = iconsToShow.map(icon => `
                <div class="icon-card bg-white rounded-lg p-4 flex items-center space-x-4 cursor-pointer border border-gray-200" 
                     onclick="copyIcon('${icon.fullName}', '${icon.setName}')">
                    <div class="icon-preview text-2xl">
                        <i class="${icon.fullName}"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">${icon.displayName}</div>
                        <div class="text-sm text-gray-500">${icon.setName}</div>
                        <div class="text-xs text-gray-400 font-mono">${icon.fullName}</div>
                    </div>
                </div>
            `).join('');
        }

        function updateTotalCount() {
            document.getElementById('total-icons').textContent = filteredIcons.length;
        }
    </script>
</body>
</html>