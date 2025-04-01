<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="h-screen flex-grow-1 overflow-y-lg-auto">

    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-light border-bottom py-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="h3 mb-0">Add New Page</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container my-4">
        <div class="card shadow border-0">
            
            <div class="card-body p-4 p-md-5">
                <!-- Flash Messages -->
                <div class="mb-4">
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                </div>

                <!-- Post Creation Form -->
                <?= form_open_multipart('AdminController/add_new_post'); ?>
                <div class="row g-4">
                    <div>
                        <div class="text-start">
                            <a href="<?= site_url('AdminController/posts_list'); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to List
                            </a>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-3">Save Post</button>
                        </div>
                    </div>
                    
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <input type="hidden" name="user_id" value=" <?php echo $this->session->userdata('user_id'); ?>">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Page Title</label>
                            <input type="text" class="form-control form-control-sm shadow-none" id="title" name="title"
                                placeholder="Enter page title" required>
                        </div>

                        

                        <!-- Include CKEditor -->
                        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

                        <div class="mb-3">
                            <label for="content" class="form-label">Full Content</label>
                            <textarea class="form-control" id="content" name="content" rows=""
                                placeholder="Enter full content" required></textarea>
                        </div>

                        <script>
                            CKEDITOR.replace('content');
                        </script>
                        <div class="mb-4">
                            <label for="short_description" class="form-label fw-bold">Short Description</label>
                            <textarea class="form-control shadow-none" id="short_description" name="short_description" rows="3"
                                placeholder="Enter short description" required></textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <div class="card border mb-3">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-3">Page Category</h6>
                                <select class="form-select select2 form-control-sm shadow-none" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="1">About Us</option>
                                    <option value="2">Term & Condition</option>
                                    <option value="2">Privacy policy</option>

                                </select>
                            </div>
                        </div>
                        <!-- Thumbnail Upload -->
                        <div class="card border mb-4">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-3">Thumbnail Image</h6>
                                <div class="upload-container border-2 border-dashed rounded-2 p-4 text-center"
                                    onclick="document.getElementById('fileInput').click()"
                                    style="cursor: pointer; background: #f8f9fa;">
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                    <p class="mb-0 text-muted mt-2">Click to upload thumbnail</p>
                                    <input type="file" class="d-none" id="fileInput" name="thumbnail_image"
                                        accept="image/*" onchange="previewThumbnail(event)">
                                    <div class="upload-preview mt-3">
                                        <img src="" id="imagePreview" class="img-thumbnail d-none w-100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card border mb-4">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-3">Featured Image</h6>
                                <div class="upload-container2 border-2 border-dashed rounded-2 p-4 text-center"
                                    onclick="document.getElementById('fileInput2').click()"
                                    style="cursor: pointer; background: #f8f9fa;">
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                    <p class="mb-0 text-muted mt-2">Click to upload Featured Image</p>
                                    <input type="file" class="d-none" id="fileInput2" name="Featured_image"
                                        accept="image/*" onchange="previewFeatured(event)">
                                    <div class="upload-preview mt-3">
                                        <img src="" id="imagePreview2" class="img-thumbnail d-none w-100">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>

<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    function previewThumbnail(event) {
        const image = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
                document.querySelector('.upload-container').style.background = '#fff';
            }
            reader.readAsDataURL(file);
        }
    }

    function previewFeatured(event) {
        const image = document.getElementById('imagePreview2');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
                document.querySelector('.upload-container2').style.background = '#fff';
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true,
            width: '100%' // Ensure it matches Bootstrap width
        });
    });
</script>

</body>

</html>