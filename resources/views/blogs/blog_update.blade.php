@auth
    @if(auth()->user()->role == 'admin')
        <x-app-layout>
            <link rel="stylesheet" href="css/user.css">
            <link rel="stylesheet" href="css/blogform.css">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn-primary:disabled {
        background-color: #ccc !important;
        cursor: not-allowed;
    }
</style>
<!-- Loader HTML -->
<div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; justify-content:center; align-items:center;">
    <div class="spinner" style="border:6px solid #f3f3f3; border-top:6px solid #3498db; border-radius:50%; width:50px; height:50px; animation:spin 1s linear infinite;"></div>
</div>
            <div class="main-content">
                <div class="dashboard-content">
                    <div class="container">
                        <form id="blogForm">
                            <div class="form-group">
                                <label class="form-label" for="title">Title:</label>
                                <input type="text" id="title" class="form-input" placeholder="Post Title">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subtitle">Sub Title:</label>
                                <input type="text" id="subtitle" class="form-input" placeholder="Sub Post Title">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="content">Description:</label>
                                <textarea id="content" class="form-input" placeholder="Sub Post Title" rows="4"></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label class="form-label" for="tags">Tags (Max 5):</label>
                                <input type="text" id="tags" class="form-input" placeholder="Type tag and press space or Enter">
                                <small id="tag-warning" style="color: red; display: none;">You can only add up to 5 tags.</small>
                            </div>

                            <!--<div class="form-group">-->
                            <!--    <label class="form-label" for="category">Category:</label>-->
                            <!--    <select id="category" class="select-input">-->
                            <!--        <option value="">Select Your Name</option>-->
                            <!--        <option value="technology">Technology</option>-->
                            <!--        <option value="lifestyle">Lifestyle</option>-->
                            <!--        <option value="business">Business</option>-->
                            <!--        <option value="health">Health</option>-->
                            <!--        <option value="travel">Travel</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <div class="form-group">
                                <label class="form-label">Image:</label>

                                <div class="upload-area" id="uploadArea">
                                    <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <div class="upload-text">Drop your image here.</div>
                                    <input type="file" id="fileInput" class="hidden-input" accept="image/*">
                                </div>

                            </div>

                            <div class="button-group">
                                <button type="submit" class="btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
            <script>
                // File upload functionality
                const uploadArea = document.getElementById('uploadArea');
                const fileInput = document.getElementById('fileInput');
                const fileList = document.getElementById('fileList');
                let uploadedFiles = [];

                // Click to upload
                uploadArea.addEventListener('click', () => {
                    fileInput.click();
                });

                // Drag and drop functionality
                uploadArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    uploadArea.classList.add('dragover');
                });

                uploadArea.addEventListener('dragleave', () => {
                    uploadArea.classList.remove('dragover');
                });

                uploadArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');
                    const files = Array.from(e.dataTransfer.files);
                    handleFiles(files);
                });

                // File input change
                fileInput.addEventListener('change', (e) => {
                    const files = Array.from(e.target.files);
                    handleFiles(files);
                });

                function handleFiles(files) {
                    files.forEach(file => {
                        uploadedFiles.push(file);
                        displayFile(file);
                    });
                }

                function displayFile(file) {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                                <span class="file-name">${file.name} (${formatFileSize(file.size)})</span>
                                <button type="button" class="file-remove" onclick="removeFile('${file.name}')">×</button>
                            `;
                    fileList.appendChild(fileItem);
                }

                function removeFile(fileName) {
                    uploadedFiles = uploadedFiles.filter(file => file.name !== fileName);
                    const fileItems = fileList.querySelectorAll('.file-item');
                    fileItems.forEach(item => {
                        if (item.querySelector('.file-name').textContent.includes(fileName)) {
                            item.remove();
                        }
                    });
                }

                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }

                // Rich text editor functionality
                const editor = document.getElementById('editor');
                const toolbarBtns = document.querySelectorAll('.toolbar-btn[data-command]');

                toolbarBtns.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const command = btn.getAttribute('data-command');

                        if (command === 'createLink') {
                            const url = prompt('Enter the URL:');
                            if (url) {
                                document.execCommand(command, false, url);
                            }
                        } else {
                            document.execCommand(command, false, null);
                        }

                        btn.classList.toggle('active');
                        editor.focus();
                    });
                });

                // Update toolbar button states
                editor.addEventListener('keyup', updateToolbar);
                editor.addEventListener('mouseup', updateToolbar);

                function updateToolbar() {
                    toolbarBtns.forEach(btn => {
                        const command = btn.getAttribute('data-command');
                        if (document.queryCommandState(command)) {
                            btn.classList.add('active');
                        } else {
                            btn.classList.remove('active');
                        }
                    });
                }

                // Form submission
                document.getElementById('blogForm').addEventListener('submit', (e) => {
                    e.preventDefault();

                    const formData = {
                        title: document.getElementById('title').value,
                        type: document.querySelector('input[name="type"]:checked').value,
                        category: document.getElementById('category').value,
                        content: editor.innerHTML,
                        files: uploadedFiles.map(file => file.name)
                    };

                    console.log('Blog post data:', formData);
                    alert('Blog post submitted successfully!');
                });

                // Discard button
                document.getElementById('discardBtn').addEventListener('click', () => {
                    if (confirm('Are you sure you want to discard this post?')) {
                        document.getElementById('blogForm').reset();
                        editor.innerHTML = '';
                        uploadedFiles = [];
                        fileList.innerHTML = '';
                    }
                });

                // Placeholder functionality for editor
                editor.addEventListener('focus', function () {
                    if (this.innerHTML === '') {
                        this.innerHTML = '';
                    }
                });

                editor.addEventListener('blur', function () {
                    if (this.innerHTML === '') {
                        this.innerHTML = '';
                    }
                });
            </script>
            <script>
                function handleFiles(files) {
                    const file = files[0]; // only first image shown
                    if (!file.type.startsWith('image/')) {
                        alert('Only image files are allowed.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const uploadArea = document.getElementById('uploadArea');
                        uploadArea.classList.add('uploaded'); // hide icon & text

                        // Remove previous image if exists
                        const oldImg = uploadArea.querySelector('img.preview-img');
                        if (oldImg) oldImg.remove();

                        // Add new preview image
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.classList.add('preview-img');
                        uploadArea.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);

                    uploadedFiles.push(file);
                }

            </script>
            <script>
             document.getElementById('blogForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const loader = document.getElementById('loader');
        const submitBtn = document.querySelector('.btn-primary');

        // Show loader and disable button
        loader.style.display = 'flex';
        submitBtn.disabled = true;
        submitBtn.textContent = 'Uploading...';

        const formData = new FormData();
        const fileInput = document.getElementById('fileInput');
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }

        formData.append('title', document.getElementById('title').value);
        formData.append('subtitle', document.getElementById('subtitle').value);
        formData.append('content', document.getElementById('content').value);
        formData.append('tags', document.getElementById('tags').value);

        try {
            const response = await fetch('/blog/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                document.getElementById('blogForm').reset();
                document.getElementById('uploadArea').classList.remove('uploaded');
                const previewImg = document.querySelector('.preview-img');
                if (previewImg) previewImg.remove();
            } else {
                alert('Error posting blog.');
            }
        } catch (error) {
            alert('Server error. Please try again later.');
        }

        // Hide loader and re-enable button
        loader.style.display = 'none';
        submitBtn.disabled = false;
        submitBtn.textContent = 'Post';
    });

            </script>
            
            <script>
    const tagsInput = document.getElementById('tags');
    const warning = document.getElementById('tag-warning');

    function formatTags(input) {
        return input
            .split(',')
            .map(tag => tag.trim())
            .filter(tag => tag !== '')
            .map(tag => tag.startsWith('#') ? tag : '#' + tag);
    }

    function updateTagsInput(tags) {
        tagsInput.value = tags.join(', ') + (tags.length < 5 ? ', ' : '');
    }

    tagsInput.addEventListener('keydown', function (e) {
        if (e.key === ' ' || e.key === 'Enter') {
            e.preventDefault();
            let tags = formatTags(tagsInput.value);
            if (tags.length >= 5) {
                warning.style.display = 'block';
                updateTagsInput(tags.slice(0, 5));
                return;
            }
            updateTagsInput(tags);
            warning.style.display = 'none';
        }
    });

    tagsInput.addEventListener('input', function () {
        let tags = formatTags(tagsInput.value);
        if (tags.length > 5) {
            warning.style.display = 'block';
            updateTagsInput(tags.slice(0, 5));
        } else {
            warning.style.display = 'none';
        }
    });
</script>
<script>
    CKEDITOR.replace('content');
</script>
        </x-app-layout>
    @else

    <script>window.location.href = "dashboard";</script>
    @endif
@endauth