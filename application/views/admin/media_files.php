<?php include 'layouts/sidebar.php'; ?>

<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <header class="bg-surface-primary border-bottom py-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0 ls-tight">Media Library</h1>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-neutral">
                    <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="container-fluid py-4">
        <section class="media-manager">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Your Media Files</h5>
                        <div class="d-flex gap-3">
                            <button class="btn btn-sm btn-primary" id="uploadButton" data-bs-toggle="modal"
                                data-bs-target="#uploadModal">
                                <i class="bi bi-upload me-2"></i> Upload Files
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between my-3">
                        <ul class="nav nav-tabs card-header-tabs" id="mediaTabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-type="all">All Media</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-type="image">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-type="gif">GIFs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-type="pdf">PDFs</a>
                            </li>
                        </ul>
                        <div class="d-flex gap-2">
                            <div class="search-box">
                                <input type="text" class="form-control form-control-sm" id="searchInput"
                                    placeholder="Search files...">
                            </div>
                            <select class="form-select form-select-sm shadow-sm" id="sortSelect" style="width: 180px;">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="name-asc">Name A-Z</option>
                                <option value="name-desc">Name Z-A</option>
                                <option value="size-asc">Largest Size</option>
                                <option value="size-desc">Smallest Size</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4" id="mediaGrid">
                        <?php if(!empty($media_files)): ?>
                        <?php foreach($media_files as $file): ?>
                        <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 media-item"
                            data-type="<?= $file->media_file_type ?>"
                            data-name="<?= strtolower($file->media_file_name) ?>"
                            data-date="<?= strtotime($file->upload_date) ?>" data-size="<?= $file->file_size ?>">
                            <div class="card card-hover h-100">
                                <div class="position-relative">
                                    <?php if($file->media_file_type == 'image' || $file->media_file_type == 'gif'): ?>
                                    <img src="<?= base_url('public/mediaFiles/'.$file->media_file) ?>"
                                        class="card-img-top" alt="<?= $file->media_file_name ?>"
                                        style="height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                    <div class="position-relative bg-light" style="height: 150px;">
                                        <div
                                            class="d-flex flex-column align-items-center justify-content-center h-100 text-primary">
                                            <i class="bi bi-file-earmark-pdf-fill display-5"></i>
                                            <span class="mt-2 fw-medium text-truncate px-2"
                                                style="max-width: 100%;"><?= $file->media_file_name ?></span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <span
                                        class="position-absolute top-0 end-0 m-2 badge <?= $file->media_file_type == 'image' ? 'bg-primary' : ($file->media_file_type == 'gif' ? 'bg-success' : 'bg-danger') ?>">
                                        <?= strtoupper($file->media_file_type) ?>
                                    </span>
                                    <div class="btn-group btn-group-sm w-100" style="background:transparent ;">
                                        <button class="btn btn-light preview-btn" data-id="<?= $file->id ?>"
                                            data-type="<?= $file->media_file_type ?>"
                                            data-url="<?= base_url('public/mediaFiles/'.$file->media_file) ?>"
                                            data-name="<?= $file->media_file_name ?>"
                                            data-size="<?= $file->file_size ?>"
                                            data-date="<?= date('M d, Y H:i', strtotime($file->upload_date)) ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-light edit-btn" data-id="<?= $file->id ?>"
                                            data-name="<?= $file->media_file_name ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-light delete-btn" data-id="<?= $file->id ?>"
                                            data-name="<?= $file->media_file_name ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-1 text-truncate"><?= $file->media_file_name ?></h6>
                                    <p class="small text-muted mb-0">
                                        <?= date('M d, Y', strtotime($file->upload_date)) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5" id="emptyState">
                                <i class="bi bi-folder-x display-4 text-muted"></i>
                                <h5 class="mt-3">No media files found</h5>
                                <p class="text-muted">Upload your first file by clicking the button above</p>
                                <button class="btn btn-primary mt-3" id="uploadEmptyButton" data-bs-toggle="modal"
                                    data-bs-target="#uploadModal">
                                    <i class="bi bi-upload me-2"></i> Upload Files
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
                <style>
                    .pagination.bubble-style .page-item {
                        margin: 0 4px;
                    }

                    .pagination.bubble-style .page-link {
                        border: 1px solid #333;
                        border-radius: 10%;
                        width: 40px;
                        height: 40px;
                        padding: 8px 0;
                        text-align: center;
                        background-color: #f0f0f0;
                        color: #333;
                        font-weight: bold;
                        transition: all 0.3s ease;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                    }

                    .pagination.bubble-style .page-link:hover {
                        background-color: #007bff;
                        color: #fff;
                        transform: scale(1.1);
                        box-shadow: 0 6px 10px rgba(0, 123, 255, 0.3);
                    }

                    .pagination.bubble-style .page-item.active .page-link {
                        background-color: #007bff;
                        color: #fff;
                        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.4);
                    }
                </style>
                <div class="text-end m-1">
                    <?php if (!empty($pagination_links)): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination bubble-style justify-content-end">
                            <?= $pagination_links; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>

            </div>

        </section>
    </main>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?= form_open_multipart('MediaFileController/save_media_files', ['id' => 'uploadForm']) ?>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">
                    <div class="mb-3">
                        <label for="file_name" class="form-label">Files Name</label>
                        <input class="form-control" type="text" name="file_name" id="file_name"
                            placeholder="Enter base name for files">
                        <small class="text-muted">Leave blank to keep original filenames</small>
                    </div>
                    <div class="mb-3">
                        <label for="media_file" class="form-label">Select files</label>
                        <div class="dropzone border rounded p-3 text-center" id="fileDropzone">
                            <i class="bi bi-cloud-arrow-up display-4 text-muted"></i>
                            <p class="my-2">Drag & drop files here or click to browse</p>
                            <input class="form-control d-none" type="file" id="media_file" name="media_file[]" multiple
                                required>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="browseFilesBtn">Select
                                Files</button>
                        </div>
                        <div id="filePreview" class="mt-3 d-none">
                            <h6 class="small">Selected Files:</h6>
                            <ul class="list-group small" id="fileList"></ul>
                        </div>
                        <small class="text-muted">Allowed types: JPG, PNG, GIF, PDF (Max 8MB each)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmUpload">
                        <span class="spinner-border spinner-border-sm d-none" id="uploadSpinner" role="status"
                            aria-hidden="true"></span>
                        Upload Files
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewTitle">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-8 border-end">
                            <div class="p-3 text-center" style="min-height: 60vh;">
                                <img src="" class="img-fluid d-none" id="imagePreview" style="max-height: 55vh;">
                                <div class="pdf-preview d-none" id="pdfPreview">
                                    <iframe src="" frameborder="0" style="width: 100%; height: 55vh;"></iframe>
                                </div>
                                <div class="gif-preview d-none" id="gifPreview">
                                    <img src="" class="img-fluid" style="max-height: 55vh;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4">
                                <h6 class="mb-3">File Details</h6>
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Name</span>
                                        <span id="detailFileName" class="fw-medium"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Type</span>
                                        <span id="detailFileType" class="badge"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Size</span>
                                        <span id="detailFileSize"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Uploaded</span>
                                        <span id="detailFileDate"></span>
                                    </li>
                                </ul>

                                <div class="mb-4">
                                    <label class="form-label">File URL</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="fileUrlInput" readonly>
                                        <button class="btn btn-outline-secondary" type="button" id="copyUrlBtn">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Use this URL to reference the file</small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary flex-grow-1" id="downloadButton">
                                        <i class="bi bi-download me-2"></i> Download
                                    </a>
                                    <button class="btn btn-outline-secondary" id="editFromPreview"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rename File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?= form_open('MediaFileController/edit_media_file', ['id' => 'editForm']) ?>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="file_id" id="editFileId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editFileName" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="editFileName" name="file_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?= form_open('MediaFileController/delete_media_file', ['id' => 'deleteForm']) ?>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="file_id" id="deleteFileId">
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteFileName"></strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete File</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>

<style>
    .dropzone {
        border: 2px dashed #dee2e6;
        transition: all 0.3s;
        cursor: pointer;
    }

    .dropzone:hover {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }

    .dropzone.active {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
    }

    .media-item {
        transition: transform 0.2s;
    }

    .media-item:hover {
        transform: translateY(-5px);
    }

    .card-hover {
        transition: box-shadow 0.3s;
    }

    .card-hover:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    #previewModal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    #fileUrlInput {
        font-size: 0.85rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize elements
        const modals = {
            upload: new bootstrap.Modal('#uploadModal'),
            preview: new bootstrap.Modal('#previewModal'),
            edit: new bootstrap.Modal('#editModal'),
            delete: new bootstrap.Modal('#deleteModal')
        };
        // File upload handling
        const fileDropzone = document.getElementById('fileDropzone');
        const fileInput = document.getElementById('media_file');
        const fileList = document.getElementById('fileList');
        const filePreview = document.getElementById('filePreview');
        // Event handlers
        fileDropzone.addEventListener('click', (e) => {
            if (e.target.id !== 'browseFilesBtn') {
                fileInput.click();
            }
        });
        document.getElementById('browseFilesBtn').addEventListener('click', () => fileInput.click());
        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
            fileDropzone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                fileDropzone.classList.toggle('active', ['dragenter', 'dragover'].includes(
                    evt));
                if (evt === 'drop') handleFiles(e.dataTransfer.files);
            });
        });
        fileInput.addEventListener('change', () => handleFiles(fileInput.files));

        function handleFiles(files) {
            fileList.innerHTML = '';
            const dataTransfer = new DataTransfer();
            Array.from(files).forEach(file => {
                if (!['image/jpeg', 'image/png', 'image/gif', 'application/pdf'].includes(file.type)) {
                    showToast('error', `Invalid file type: ${file.name}`);
                    return;
                }
                if (file.size > 8 * 1024 * 1024) {
                    showToast('error', `File too large: ${file.name}`);
                    return;
                }
                dataTransfer.items.add(file);
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                <div class="text-truncate me-2" style="max-width: 200px;">${file.name}</div>
                <span class="badge bg-secondary">${formatFileSize(file.size)}</span>
            `;
                fileList.appendChild(li);
            });
            fileInput.files = dataTransfer.files;
            filePreview.classList.toggle('d-none', dataTransfer.files.length === 0);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
        }
        // Form submissions
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = document.getElementById('confirmUpload');
            const spinner = document.getElementById('uploadSpinner');
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    showToast(data.success ? 'success' : 'error', data.message);
                    if (data.success) {
                        modals.upload.hide();
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    showToast('error', 'An error occurred during upload');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    spinner.classList.add('d-none');
                });
        });
        // Preview functionality
        document.querySelectorAll('.preview-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.dataset.url;
                const type = this.dataset.type;
                const name = this.dataset.name;
                const size = this.dataset.size;
                const date = this.dataset.date;
                // Set file details
                document.getElementById('detailFileName').textContent = name;
                document.getElementById('detailFileType').textContent = type.toUpperCase();
                document.getElementById('detailFileType').className =
                    `badge ${type === 'image' ? 'bg-primary' : (type === 'gif' ? 'bg-success' : 'bg-danger')}`;
                document.getElementById('detailFileSize').textContent = formatFileSize(size);
                document.getElementById('detailFileDate').textContent = date;
                document.getElementById('fileUrlInput').value = url;
                // Set preview content
                document.getElementById('imagePreview').classList.add('d-none');
                document.getElementById('gifPreview').classList.add('d-none');
                document.getElementById('pdfPreview').classList.add('d-none');
                if (type === 'image') {
                    document.getElementById('imagePreview').src = url;
                    document.getElementById('imagePreview').classList.remove('d-none');
                } else if (type === 'gif') {
                    document.getElementById('gifPreview').querySelector('img').src = url;
                    document.getElementById('gifPreview').classList.remove('d-none');
                } else if (type === 'pdf') {
                    document.querySelector('#pdfPreview iframe').src = url;
                    document.getElementById('pdfPreview').classList.remove('d-none');
                }
                // Set download button
                const downloadBtn = document.getElementById('downloadButton');
                downloadBtn.href = url;
                downloadBtn.download = name;
                // Set edit button
                const editBtn = document.getElementById('editFromPreview');
                editBtn.dataset.id = this.dataset.id;
                editBtn.dataset.name = name;
                modals.preview.show();
            });
        });
        // URL copy functionality
        document.getElementById('copyUrlBtn').addEventListener('click', function() {
            const urlInput = document.getElementById('fileUrlInput');
            urlInput.select();
            document.execCommand('copy');
            showToast('success', 'URL copied to clipboard!');
        });
        // Edit functionality
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editFileId').value = this.dataset.id;
                document.getElementById('editFileName').value = this.dataset.name;
                modals.edit.show();
            });
        });
        // Also handle edit button from preview modal
        document.getElementById('editFromPreview').addEventListener('click', function() {
            document.getElementById('editFileId').value = this.dataset.id;
            document.getElementById('editFileName').value = this.dataset.name;
            modals.preview.hide();
        });
        // Delete functionality
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('deleteFileId').value = this.dataset.id;
                document.getElementById('deleteFileName').textContent = this.dataset.name;
                modals.delete.show();
            });
        });
        // Filter and sort functionality
        const mediaItems = document.querySelectorAll('.media-item');

        function filterAndSortMedia() {
            const typeFilter = document.querySelector('#mediaTabs .nav-link.active').dataset.type;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const sortOption = document.getElementById('sortSelect').value;
            mediaItems.forEach(item => {
                const matchesType = typeFilter === 'all' || item.dataset.type === typeFilter;
                const matchesSearch = item.dataset.name.includes(searchTerm);
                item.style.display = matchesType && matchesSearch ? 'block' : 'none';
            });
            const visibleItems = Array.from(mediaItems).filter(item => item.style.display !== 'none');
            visibleItems.sort((a, b) => {
                switch (sortOption) {
                    case 'newest':
                        return b.dataset.date - a.dataset.date;
                    case 'oldest':
                        return a.dataset.date - b.dataset.date;
                    case 'name-asc':
                        return a.dataset.name.localeCompare(b.dataset.name);
                    case 'name-desc':
                        return b.dataset.name.localeCompare(a.dataset.name);
                    case 'size-asc':
                        return b.dataset.size - a.dataset.size;
                    case 'size-desc':
                        return a.dataset.size - b.dataset.size;
                    default:
                        return 0;
                }
            });
            const mediaGrid = document.getElementById('mediaGrid');
            visibleItems.forEach(item => mediaGrid.appendChild(item));
        }
        document.getElementById('mediaTabs').addEventListener('click', e => {
            if (e.target.classList.contains('nav-link')) {
                e.preventDefault();
                document.querySelectorAll('#mediaTabs .nav-link').forEach(link => link.classList.remove(
                    'active'));
                e.target.classList.add('active');
                filterAndSortMedia();
            }
        });
        document.getElementById('sortSelect').addEventListener('change', filterAndSortMedia);
        document.getElementById('searchInput').addEventListener('input', filterAndSortMedia);
        // Toast notification
        function showToast(type, message) {
            // Remove any existing toasts first
            document.querySelectorAll('.custom-toast').forEach(toast => toast.remove());
            const toast = document.createElement('div');
            toast.className =
                `custom-toast toast align-items-center text-dark bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
            toast.style.zIndex = '1100';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();
            toast.addEventListener('hidden.bs.toast', () => toast.remove());
        }
    });
</script>