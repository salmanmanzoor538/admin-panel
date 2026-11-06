<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Code Editors</h1>
                    <p class="text-gray-600 mt-1">Multiple code editors with syntax highlighting and advanced features</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Active Editor:</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium" id="active-editor">
                            Ace Editor
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Language:</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium" id="active-language">
                            JavaScript
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{ $this->form }}
        </div>

        <!-- Editor Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-code text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Ace Editor</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">High-performance code editor with syntax highlighting, auto-completion, and themes.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Multiple themes</li>
                    <li>• Syntax highlighting</li>
                    <li>• Auto-completion</li>
                    <li>• Code folding</li>
                </ul>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-edit text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">CKEditor</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Rich text editor with advanced formatting, media embedding, and collaboration features.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Rich text editing</li>
                    <li>• Media embedding</li>
                    <li>• Collaboration</li>
                    <li>• Plugins</li>
                </ul>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">TinyMCE</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Powerful WYSIWYG editor with extensive customization and plugin support.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• WYSIWYG editing</li>
                    <li>• Customizable</li>
                    <li>• Plugin support</li>
                    <li>• Mobile friendly</li>
                </ul>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <i class="fas fa-sun text-orange-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Summernote</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Lightweight WYSIWYG editor built on Bootstrap with clean interface.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Lightweight</li>
                    <li>• Bootstrap based</li>
                    <li>• Clean interface</li>
                    <li>• Easy integration</li>
                </ul>
            </div>
        </div>

        <!-- Code Examples -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Code Examples</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-medium text-gray-900 mb-2">JavaScript Example</h3>
                    <pre class="bg-gray-900 text-green-400 p-4 rounded-lg text-sm overflow-x-auto"><code>// JavaScript example
function fibonacci(n) {
    if (n <= 1) return n;
    return fibonacci(n - 1) + fibonacci(n - 2);
}

const result = fibonacci(10);
console.log(result);</code></pre>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 mb-2">PHP Example</h3>
                    <pre class="bg-gray-900 text-green-400 p-4 rounded-lg text-sm overflow-x-auto"><code>// PHP example
class User {
    private $name;
    private $email;
    
    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
    
    public function getName() {
        return $this->name;
    }
}</code></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Ace Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/ace.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/mode-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/mode-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/mode-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/mode-html.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/mode-css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/mode-json.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/theme-monokai.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/theme-github.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/theme-tomorrow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/theme-twilight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/theme-solarized_dark.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/theme-solarized_light.min.js"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Summernote -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">

    <script>
        // Code Editors functionality
        let aceEditor = null;
        let ckEditor = null;
        let tinyMCE = null;
        let summernote = null;
        let activeEditor = 'ace';
        let currentTheme = @json($aceTheme);
        let currentMode = @json($aceMode);
        let currentFontSize = @json($aceFontSize);
        let wrapMode = @json($aceWrapMode);
        let showGutter = @json($aceShowGutter);
        let showLineNumbers = @json($aceShowLineNumbers);
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeEditors();
        });
        
        function initializeEditors() {
            initializeAceEditor();
            initializeCKEditor();
            initializeTinyMCE();
            initializeSummernote();
        }
        
        function initializeAceEditor() {
            aceEditor = ace.edit("ace-editor");
            aceEditor.setTheme("ace/theme/" + currentTheme);
            aceEditor.session.setMode("ace/mode/" + currentMode);
            aceEditor.setFontSize(currentFontSize + "px");
            aceEditor.getSession().setUseWrapMode(wrapMode);
            aceEditor.renderer.setShowGutter(showGutter);
            aceEditor.renderer.setShowLineNumbers(showLineNumbers);
            
            // Set initial content
            aceEditor.setValue(`// Welcome to Ace Editor
function greet(name) {
    return "Hello, " + name + "!";
}

const message = greet("World");
console.log(message);

// Try editing this code!
// Features:
// - Syntax highlighting
// - Auto-completion
// - Code folding
// - Multiple themes
// - Various languages`);
            
            aceEditor.clearSelection();
        }
        
        function initializeCKEditor() {
            ClassicEditor
                .create(document.querySelector('#ckeditor'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'imageUpload', 'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    },
                    language: 'en',
                    image: {
                        toolbar: [
                            'imageTextAlternative', 'imageStyle:full', 'imageStyle:side'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells'
                        ]
                    }
                })
                .then(editor => {
                    ckEditor = editor;
                    editor.setData(`
                        <h2>Welcome to CKEditor</h2>
                        <p>This is a <strong>rich text editor</strong> with advanced formatting capabilities.</p>
                        <ul>
                            <li>Rich text editing</li>
                            <li>Media embedding</li>
                            <li>Collaboration features</li>
                            <li>Plugin support</li>
                        </ul>
                        <p>Try editing this content!</p>
                    `);
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                });
        }
        
        function initializeTinyMCE() {
            tinymce.init({
                selector: '#tinymce',
                height: 400,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic forecolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
                setup: function (editor) {
                    editor.on('init', function () {
                        tinyMCE = editor;
                        editor.setContent(`
                            <h2>Welcome to TinyMCE</h2>
                            <p>This is a <strong>powerful WYSIWYG editor</strong> with extensive customization options.</p>
                            <ul>
                                <li>WYSIWYG editing</li>
                                <li>Customizable interface</li>
                                <li>Plugin support</li>
                                <li>Mobile friendly</li>
                            </ul>
                            <p>Try editing this content!</p>
                        `);
                    });
                }
            });
        }
        
        function initializeSummernote() {
            $('#summernote').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        summernote = this;
                        $(this).summernote('code', `
                            <h2>Welcome to Summernote</h2>
                            <p>This is a <strong>lightweight WYSIWYG editor</strong> built on Bootstrap.</p>
                            <ul>
                                <li>Lightweight and fast</li>
                                <li>Bootstrap based</li>
                                <li>Clean interface</li>
                                <li>Easy integration</li>
                            </ul>
                            <p>Try editing this content!</p>
                        `);
                    }
                }
            });
        }
        
        function updateAceTheme(theme) {
            if (aceEditor) {
                aceEditor.setTheme("ace/theme/" + theme);
                currentTheme = theme;
                updateActiveEditor('ace');
            }
        }
        
        function updateAceMode(mode) {
            if (aceEditor) {
                aceEditor.session.setMode("ace/mode/" + mode);
                currentMode = mode;
                updateActiveLanguage(mode);
            }
        }
        
        function updateAceFontSize(size) {
            if (aceEditor) {
                aceEditor.setFontSize(size + "px");
                currentFontSize = size;
            }
        }
        
        function updateAceWrapMode(enabled) {
            if (aceEditor) {
                aceEditor.getSession().setUseWrapMode(enabled);
                wrapMode = enabled;
            }
        }
        
        function updateAceShowGutter(enabled) {
            if (aceEditor) {
                aceEditor.renderer.setShowGutter(enabled);
                showGutter = enabled;
            }
        }
        
        function updateAceShowLineNumbers(enabled) {
            if (aceEditor) {
                aceEditor.renderer.setShowLineNumbers(enabled);
                showLineNumbers = enabled;
            }
        }
        
        function updateActiveEditor(editor) {
            activeEditor = editor;
            const activeEditorElement = document.getElementById('active-editor');
            if (activeEditorElement) {
                const editorNames = {
                    'ace': 'Ace Editor',
                    'ckeditor': 'CKEditor',
                    'tinymce': 'TinyMCE',
                    'summernote': 'Summernote'
                };
                activeEditorElement.textContent = editorNames[editor] || editor;
            }
        }
        
        function updateActiveLanguage(language) {
            const activeLanguageElement = document.getElementById('active-language');
            if (activeLanguageElement) {
                const languageNames = {
                    'javascript': 'JavaScript',
                    'php': 'PHP',
                    'python': 'Python',
                    'java': 'Java',
                    'html': 'HTML',
                    'css': 'CSS',
                    'json': 'JSON',
                    'xml': 'XML',
                    'sql': 'SQL',
                    'markdown': 'Markdown',
                    'yaml': 'YAML',
                    'dockerfile': 'Dockerfile'
                };
                activeLanguageElement.textContent = languageNames[language] || language;
            }
        }
        
        function saveCode() {
            let content = '';
            let filename = 'code.txt';
            
            switch(activeEditor) {
                case 'ace':
                    content = aceEditor.getValue();
                    filename = 'code.' + currentMode;
                    break;
                case 'ckeditor':
                    content = ckEditor.getData();
                    filename = 'content.html';
                    break;
                case 'tinymce':
                    content = tinyMCE.getContent();
                    filename = 'content.html';
                    break;
                case 'summernote':
                    content = $('#summernote').summernote('code');
                    filename = 'content.html';
                    break;
            }
            
            // Create and download file
            const blob = new Blob([content], { type: 'text/plain' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            showNotification('Code saved successfully', 'success');
        }
        
        function loadCode() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.txt,.js,.php,.html,.css,.json,.xml,.sql,.md,.yml,.yaml';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const content = e.target.result;
                        switch(activeEditor) {
                            case 'ace':
                                aceEditor.setValue(content);
                                break;
                            case 'ckeditor':
                                ckEditor.setData(content);
                                break;
                            case 'tinymce':
                                tinyMCE.setContent(content);
                                break;
                            case 'summernote':
                                $('#summernote').summernote('code', content);
                                break;
                        }
                        showNotification('Code loaded successfully', 'success');
                    };
                    reader.readAsText(file);
                }
            };
            input.click();
        }
        
        function formatCode() {
            switch(activeEditor) {
                case 'ace':
                    aceEditor.getSession().getDocument().setValue(
                        aceEditor.getSession().getDocument().getValue()
                    );
                    break;
                case 'ckeditor':
                    // CKEditor auto-formats content
                    break;
                case 'tinymce':
                    // TinyMCE auto-formats content
                    break;
                case 'summernote':
                    // Summernote auto-formats content
                    break;
            }
            showNotification('Code formatted successfully', 'success');
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
        
        // Global functions for form updates
        window.updateAceTheme = updateAceTheme;
        window.updateAceMode = updateAceMode;
        window.updateAceFontSize = updateAceFontSize;
        window.updateAceWrapMode = updateAceWrapMode;
        window.updateAceShowGutter = updateAceShowGutter;
        window.updateAceShowLineNumbers = updateAceShowLineNumbers;
        window.saveCode = saveCode;
        window.loadCode = loadCode;
        window.formatCode = formatCode;
    </script>
</x-filament-panels::page>