<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">File Manager</h1>
                    <p class="text-gray-600 mt-1">Manage your files and media with advanced tools</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <button onclick="toggleViewMode('grid')" class="p-2 {{ $viewMode === 'grid' ? 'bg-blue-100 text-blue-600' : 'text-gray-400' }} rounded hover:bg-gray-100">
                            <i class="fas fa-th"></i>
                        </button>
                        <button onclick="toggleViewMode('list')" class="p-2 {{ $viewMode === 'list' ? 'bg-blue-100 text-blue-600' : 'text-gray-400' }} rounded hover:bg-gray-100">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    <button onclick="openUploadModal()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-upload mr-2"></i>Upload
                    </button>
                </div>
            </div>
        </div>

        <!-- File Manager Controls -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Breadcrumb -->
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="#" onclick="navigateToFolder('/')" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </li>
                            <li>
                                <span class="text-gray-900 font-medium">{{ $currentFolder }}</span>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model="searchQuery"
                            placeholder="Search files..." 
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <!-- Sort -->
                    <select wire:model="sortBy" class="text-sm border-gray-300 rounded-md">
                        <option value="name">Name</option>
                        <option value="size">Size</option>
                        <option value="modified">Modified</option>
                        <option value="type">Type</option>
                    </select>
                    
                    <!-- Filter -->
                    <select wire:model="filterType" class="text-sm border-gray-300 rounded-md">
                        <option value="all">All Files</option>
                        <option value="images">Images</option>
                        <option value="documents">Documents</option>
                        <option value="videos">Videos</option>
                        <option value="audio">Audio</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- File Manager Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Folders</h3>
                    <div class="space-y-2">
                        <button onclick="navigateToFolder('/')" class="w-full flex items-center space-x-3 p-2 rounded hover:bg-gray-50 {{ $currentFolder === '/' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-home w-5"></i>
                            <span>Root</span>
                        </button>
                        <button onclick="navigateToFolder('/images')" class="w-full flex items-center space-x-3 p-2 rounded hover:bg-gray-50 {{ $currentFolder === '/images' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-images w-5"></i>
                            <span>Images</span>
                        </button>
                        <button onclick="navigateToFolder('/documents')" class="w-full flex items-center space-x-3 p-2 rounded hover:bg-gray-50 {{ $currentFolder === '/documents' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-file-alt w-5"></i>
                            <span>Documents</span>
                        </button>
                        <button onclick="navigateToFolder('/videos')" class="w-full flex items-center space-x-3 p-2 rounded hover:bg-gray-50 {{ $currentFolder === '/videos' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-video w-5"></i>
                            <span>Videos</span>
                        </button>
                        <button onclick="navigateToFolder('/audio')" class="w-full flex items-center space-x-3 p-2 rounded hover:bg-gray-50 {{ $currentFolder === '/audio' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            <i class="fas fa-music w-5"></i>
                            <span>Audio</span>
                        </button>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Storage Usage</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Used</span>
                                <span class="text-gray-900">2.5 GB</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 25%"></div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Available</span>
                                <span class="text-gray-900">7.5 GB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <!-- File List Header -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <input 
                                    type="checkbox" 
                                    onchange="toggleSelectAll(this.checked)"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >
                                <span class="text-sm text-gray-600">{{ count($this->getFiles()) }} files</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="bulkDelete()" class="text-sm text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                                <button onclick="bulkDownload()" class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-download mr-1"></i>Download
                                </button>
                                <button onclick="bulkMove()" class="text-sm text-green-600 hover:text-green-800">
                                    <i class="fas fa-folder mr-1"></i>Move
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- File List -->
                    <div class="p-4">
                        @if($viewMode === 'grid')
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach($this->getFiles() as $file)
                                    <div class="relative group">
                                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:shadow-md transition-shadow" onclick="selectFile({{ $file['id'] }})">
                                            @if(str_starts_with($file['type'], 'image/'))
                                                <img src="{{ $file['thumbnail'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-file text-4xl text-gray-400"></i>
                                                </div>
                                            @endif
                                            
                                            <!-- File Actions Overlay -->
                                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                                <button onclick="previewFile({{ $file['id'] }})" class="p-2 bg-white rounded-full hover:bg-gray-100">
                                                    <i class="fas fa-eye text-gray-600"></i>
                                                </button>
                                                <button onclick="downloadFile({{ $file['id'] }})" class="p-2 bg-white rounded-full hover:bg-gray-100">
                                                    <i class="fas fa-download text-gray-600"></i>
                                                </button>
                                                <button onclick="deleteFile({{ $file['id'] }})" class="p-2 bg-white rounded-full hover:bg-gray-100">
                                                    <i class="fas fa-trash text-red-600"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Selection Checkbox -->
                                            <div class="absolute top-2 left-2">
                                                <input 
                                                    type="checkbox" 
                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                    onchange="toggleFileSelection({{ $file['id'] }}, this.checked)"
                                                >
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $file['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ number_format($file['size'] / 1024, 1) }} KB</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($this->getFiles() as $file)
                                    <div class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg">
                                        <input 
                                            type="checkbox" 
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            onchange="toggleFileSelection({{ $file['id'] }}, this.checked)"
                                        >
                                        
                                        <div class="flex-shrink-0">
                                            @if(str_starts_with($file['type'], 'image/'))
                                                <img src="{{ $file['thumbnail'] }}" alt="{{ $file['name'] }}" class="w-10 h-10 object-cover rounded">
                                            @else
                                                <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center">
                                                    <i class="fas fa-file text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $file['name'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $file['type'] }} • {{ number_format($file['size'] / 1024, 1) }} KB</p>
                                        </div>
                                        
                                        <div class="text-sm text-gray-500">
                                            {{ $file['modified']->format('M d, Y') }}
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <button onclick="previewFile({{ $file['id'] }})" class="p-1 text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="downloadFile({{ $file['id'] }})" class="p-1 text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button onclick="deleteFile({{ $file['id'] }})" class="p-1 text-gray-400 hover:text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{ $this->form }}
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="upload-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Upload Files</h3>
                    <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
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
                        <button onclick="closeUploadModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
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

    <!-- Image Cropper Modal -->
    <div id="cropper-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Image Cropper</h3>
                    <button onclick="closeCropperModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-center h-96 bg-gray-100 rounded-lg">
                        <div id="cropper-container" class="w-full h-full">
                            <!-- Cropper will be initialized here -->
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button onclick="rotateImage(-90)" class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button onclick="rotateImage(90)" class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                <i class="fas fa-redo"></i>
                            </button>
                            <button onclick="flipImage()" class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                <i class="fas fa-arrows-alt-h"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <button onclick="closeCropperModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                Cancel
                            </button>
                            <button onclick="cropImage()" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Crop Image
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- File Preview Modal -->
    <div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">File Preview</h3>
                    <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="preview-content" class="h-96 bg-gray-100 rounded-lg flex items-center justify-center">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <script>
        // File Manager functionality
        let selectedFiles = [];
        let cropper = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeFileManager();
        });
        
        function initializeFileManager() {
            // Initialize file manager
            console.log('File Manager initialized');
        }
        
        function toggleViewMode(mode) {
            // In a real application, this would update the view mode
            showNotification(`View mode changed to ${mode}`, 'success');
        }
        
        function navigateToFolder(folder) {
            // In a real application, this would navigate to the folder
            showNotification(`Navigated to ${folder}`, 'info');
        }
        
        function toggleSelectAll(checked) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (checkbox !== event.target) {
                    checkbox.checked = checked;
                }
            });
        }
        
        function toggleFileSelection(fileId, checked) {
            if (checked) {
                selectedFiles.push(fileId);
            } else {
                selectedFiles = selectedFiles.filter(id => id !== fileId);
            }
        }
        
        function selectFile(fileId) {
            // Toggle file selection
            const checkbox = event.target.closest('.group').querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            toggleFileSelection(fileId, checkbox.checked);
        }
        
        function previewFile(fileId) {
            // In a real application, this would load file preview
            document.getElementById('preview-content').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-file text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">File preview for file ID: ${fileId}</p>
                </div>
            `;
            document.getElementById('preview-modal').classList.remove('hidden');
        }
        
        function downloadFile(fileId) {
            // In a real application, this would download the file
            showNotification(`Downloading file ${fileId}`, 'success');
        }
        
        function deleteFile(fileId) {
            if (confirm('Are you sure you want to delete this file?')) {
                // In a real application, this would delete the file
                showNotification(`File ${fileId} deleted`, 'success');
            }
        }
        
        function bulkDelete() {
            if (selectedFiles.length === 0) {
                showNotification('No files selected', 'warning');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${selectedFiles.length} files?`)) {
                // In a real application, this would delete selected files
                showNotification(`${selectedFiles.length} files deleted`, 'success');
                selectedFiles = [];
            }
        }
        
        function bulkDownload() {
            if (selectedFiles.length === 0) {
                showNotification('No files selected', 'warning');
                return;
            }
            
            // In a real application, this would download selected files
            showNotification(`Downloading ${selectedFiles.length} files`, 'success');
        }
        
        function bulkMove() {
            if (selectedFiles.length === 0) {
                showNotification('No files selected', 'warning');
                return;
            }
            
            // In a real application, this would open move dialog
            showNotification(`Moving ${selectedFiles.length} files`, 'info');
        }
        
        function openUploadModal() {
            document.getElementById('upload-modal').classList.remove('hidden');
        }
        
        function closeUploadModal() {
            document.getElementById('upload-modal').classList.add('hidden');
        }
        
        function uploadFiles() {
            // In a real application, this would upload files
            showNotification('Files uploaded successfully', 'success');
            closeUploadModal();
        }
        
        function closeCropperModal() {
            document.getElementById('cropper-modal').classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }
        
        function closePreviewModal() {
            document.getElementById('preview-modal').classList.add('hidden');
        }
        
        function rotateImage(degrees) {
            if (cropper) {
                cropper.rotate(degrees);
            }
        }
        
        function flipImage() {
            if (cropper) {
                cropper.scaleX(-cropper.getData().scaleX);
            }
        }
        
        function cropImage() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas();
                // In a real application, this would save the cropped image
                showNotification('Image cropped successfully', 'success');
                closeCropperModal();
            }
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