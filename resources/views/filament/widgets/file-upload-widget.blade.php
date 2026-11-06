<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>File Upload Widget</span>
                <div class="flex space-x-2">
                    <select wire:model="uploadType" class="text-sm border-gray-300 rounded-md">
                        @foreach($this->getUploadTypeOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-slot>

        <div class="space-y-6">
            <!-- Configuration Form -->
            <div class="bg-gray-50 p-4 rounded-lg">
                {{ $this->form }}
            </div>

            <!-- File Upload Area -->
            <div class="space-y-4">
                @if($uploadType === 'filepond')
                    <!-- Filepond Upload -->
                    <div class="filepond-container">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Files (Filepond)
                        </label>
                        <div class="filepond-wrapper">
                            <input 
                                type="file" 
                                class="filepond" 
                                name="filepond"
                                multiple
                                data-max-file-size="{{ $this->getMaxFileSize() }}"
                                data-max-files="{{ $this->getMaxFiles() }}"
                                data-accepted-file-types="{{ implode(',', $this->getAcceptedFileTypes()) }}"
                            >
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Drag and drop files here or click to browse. 
                            Max file size: {{ $this->data['maxFileSize'] ?? 10 }}MB, 
                            Max files: {{ $this->getMaxFiles() }}
                        </p>
                    </div>
                @else
                    <!-- Dropzone Upload -->
                    <div class="dropzone-container">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Files (Dropzone)
                        </label>
                        <div 
                            class="dropzone dropzone-wrapper"
                            data-max-file-size="{{ $this->getMaxFileSize() }}"
                            data-max-files="{{ $this->getMaxFiles() }}"
                            data-accepted-files="{{ implode(',', $this->getAcceptedFileTypes()) }}"
                        >
                            <div class="dropzone-message">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-lg text-gray-600">Drop files here or click to upload</p>
                                <p class="text-sm text-gray-500">
                                    Max file size: {{ $this->data['maxFileSize'] ?? 10 }}MB, 
                                    Max files: {{ $this->getMaxFiles() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Upload Progress -->
            <div id="upload-progress" class="hidden">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-800">Uploading files...</span>
                        <span class="text-sm text-blue-600" id="upload-percentage">0%</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div id="upload-progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Uploaded Files List -->
            <div id="uploaded-files" class="hidden">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Uploaded Files</h4>
                <div id="files-list" class="space-y-2">
                    <!-- Files will be added here dynamically -->
                </div>
            </div>

            <!-- Upload Actions -->
            <div class="flex items-center justify-between pt-4 border-t">
                <div class="flex items-center space-x-4">
                    <button 
                        type="button" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onclick="startUpload()"
                    >
                        <i class="fas fa-upload mr-2"></i>Start Upload
                    </button>
                    <button 
                        type="button" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        onclick="clearFiles()"
                    >
                        <i class="fas fa-trash mr-2"></i>Clear All
                    </button>
                </div>
                <div class="text-sm text-gray-500">
                    <span id="file-count">0</span> files selected
                </div>
            </div>
        </div>
    </x-filament::section>

    <script>
        let filepondInstance;
        let dropzoneInstance;
        let uploadedFiles = [];
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeUploader();
        });
        
        function initializeUploader() {
            const uploadType = '{{ $uploadType }}';
            
            if (uploadType === 'filepond') {
                initializeFilepond();
            } else {
                initializeDropzone();
            }
        }
        
        function initializeFilepond() {
            const input = document.querySelector('.filepond');
            if (input) {
                filepondInstance = FilePond.create(input, {
                    allowMultiple: true,
                    maxFiles: {{ $this->getMaxFiles() }},
                    maxFileSize: '{{ $this->data['maxFileSize'] ?? 10 }}MB',
                    acceptedFileTypes: {!! json_encode($this->getAcceptedFileTypes()) !!},
                    server: {
                        process: '/admin/upload',
                        revert: '/admin/upload/revert',
                        load: '/admin/upload/load/',
                    },
                    onprocessfile: (error, file) => {
                        if (!error) {
                            uploadedFiles.push({
                                id: file.id,
                                name: file.filename,
                                size: file.filesize,
                                type: file.fileType,
                            });
                            updateFileList();
                        }
                    },
                    onremovefile: (error, file) => {
                        if (!error) {
                            uploadedFiles = uploadedFiles.filter(f => f.id !== file.id);
                            updateFileList();
                        }
                    }
                });
            }
        }
        
        function initializeDropzone() {
            const dropzoneElement = document.querySelector('.dropzone');
            if (dropzoneElement) {
                dropzoneInstance = new Dropzone(dropzoneElement, {
                    url: '/admin/upload',
                    maxFilesize: {{ $this->data['maxFileSize'] ?? 10 }},
                    acceptedFiles: {!! json_encode(implode(',', $this->getAcceptedFileTypes())) !!},
                    maxFiles: {{ $this->getMaxFiles() }},
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Drop files here or click to upload',
                    dictRemoveFile: 'Remove file',
                    dictCancelUpload: 'Cancel upload',
                    init: function() {
                        this.on('addedfile', function(file) {
                            updateFileCount();
                        });
                        
                        this.on('removedfile', function(file) {
                            updateFileCount();
                        });
                        
                        this.on('success', function(file, response) {
                            uploadedFiles.push({
                                id: response.id || Date.now(),
                                name: file.name,
                                size: file.size,
                                type: file.type,
                            });
                            updateFileList();
                        });
                        
                        this.on('error', function(file, errorMessage) {
                            showNotification('Upload error: ' + errorMessage, 'error');
                        });
                    }
                });
            }
        }
        
        function startUpload() {
            if (filepondInstance) {
                filepondInstance.processFiles();
            } else if (dropzoneInstance) {
                dropzoneInstance.processQueue();
            }
        }
        
        function clearFiles() {
            if (filepondInstance) {
                filepondInstance.removeFiles();
            } else if (dropzoneInstance) {
                dropzoneInstance.removeAllFiles(true);
            }
            uploadedFiles = [];
            updateFileList();
            updateFileCount();
        }
        
        function updateFileCount() {
            let count = 0;
            if (filepondInstance) {
                count = filepondInstance.getFiles().length;
            } else if (dropzoneInstance) {
                count = dropzoneInstance.files.length;
            }
            document.getElementById('file-count').textContent = count;
        }
        
        function updateFileList() {
            const filesList = document.getElementById('files-list');
            const uploadedFilesDiv = document.getElementById('uploaded-files');
            
            if (uploadedFiles.length > 0) {
                uploadedFilesDiv.classList.remove('hidden');
                filesList.innerHTML = uploadedFiles.map(file => `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file text-gray-400"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">${file.name}</p>
                                <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-blue-500 hover:text-blue-700" onclick="downloadFile('${file.id}')">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="text-red-500 hover:text-red-700" onclick="removeFile('${file.id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
            } else {
                uploadedFilesDiv.classList.add('hidden');
            }
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        function downloadFile(fileId) {
            window.open('/admin/upload/download/' + fileId, '_blank');
        }
        
        function removeFile(fileId) {
            if (confirm('Are you sure you want to remove this file?')) {
                uploadedFiles = uploadedFiles.filter(f => f.id !== fileId);
                updateFileList();
                
                // Remove from uploader
                if (filepondInstance) {
                    const file = filepondInstance.getFiles().find(f => f.id === fileId);
                    if (file) {
                        filepondInstance.removeFile(file);
                    }
                }
            }
        }
    </script>
</x-filament-widgets::widget>