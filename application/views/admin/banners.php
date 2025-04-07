<!-- Sidebar -->
<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <!-- Page Header -->
    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="h5 mb-0 fw-bold text-dark">Banners Management</h1>
            <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetForm()">
                <i class="bi bi-plus-lg me-2"></i>New Banner
            </button>
        </div>
    </header>

    <!-- Content Container -->
    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Banner Form -->
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0"><?= isset($banner) ? 'Edit' : 'Add' ?> Banner</h5>
                    </div>
                    <div class="card-body">
                        <?= form_open_multipart('BannerController/save_banner', ['id' => 'bannerForm']); ?>

                        <!-- Flash Messages -->
                        <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>
                        <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="id" id="banner_id">
                        <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                        <!-- Form Fields -->
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Banner Type *</label>
                                        <select class="form-select select2" name="banner_type" id="banner_type" required>
                                            <option value="">Select Banner type</option>
                                            <option value="Main Banner">Main Banner</option>
                                            <option value="Site Logo">Site Logo</option>
                                            <option value="Promotional Banner">Promotional Banner</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea class="form-control" name="desc" id="desc" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Image Upload -->
                                <div class="mt-4">
                                    <label class="form-label fw-bold">Thumbnail Image *</label>
                                    <div class="upload-container border border-2 border-dashed rounded-3 p-4 text-center bg-light"
                                        onclick="document.getElementById('fileInput').click()">
                                        <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">Click to upload image</p>
                                        <small class="text-muted">JPEG, PNG, or WebP formats only</small>
                                        <input type="file" class="d-none" id="fileInput" name="image" accept="image/*"
                                            onchange="previewThumbnail(event)">
                                        <div class="upload-preview mt-3 position-relative">
                                            <img src="" id="imagePreview" class="img-fluid d-none rounded shadow-sm">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 mt-1 me-1 d-none"
                                                onclick="clearImage()" id="clearImageBtn">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <i class="bi bi-save me-1"></i> Save Banner
                            </button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Banner List Table -->
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0"> Banners List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="DataTable" class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th class="text-center">Publish</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($banners)): ?>
                                    <?php foreach ($banners as $index => $banner): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if (!empty($banner->image)) : ?>
                                                <img src="<?= base_url('public/WebBannersImage/' . htmlspecialchars($banner->image)); ?>"
                                                    class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-0 text-truncate" style="max-width: 300px;">
                                                        <?= htmlspecialchars($banner->title); ?>
                                                    </h6>
                                                    <p class="text-muted mb-0 small text-truncate" style="max-width: 300px;">
                                                        <?= strlen(strip_tags($banner->desc)) > 40 ? substr(strip_tags($banner->desc), 0, 40) . '...' : strip_tags($banner->desc); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($banner->banner_type) ?></span></td>
                                        <td class="text-center align-middle">
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input status-toggle" type="checkbox"
                                                    id="statusSwitch<?= $banner->id; ?>"
                                                    data-id="<?= $banner->id; ?>"
                                                    <?= $banner->status == 1 ? 'checked' : ''; ?>
                                                    style="width:40px; height:20px;">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary edit-btn"
                                                data-id="<?= $banner->id ?>"
                                                data-type="<?= htmlspecialchars($banner->banner_type) ?>"
                                                data-title="<?= htmlspecialchars($banner->title) ?>"
                                                data-desc="<?= htmlspecialchars($banner->desc) ?>"
                                                data-image="<?= base_url('public/WebBannersImage/' . htmlspecialchars($banner->image)) ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $banner->id ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-4">No banners found</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this banner? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>

<!-- Scripts -->
<script>
    $(document).ready(function () {
        $('#banner_type').select2({
            placeholder: "Select banner type",
            minimumResultsForSearch: Infinity
        });

        // Edit Handler
        $('.edit-btn').click(function () {
            const btn = $(this);
            $('#banner_id').val(btn.data('id'));
            $('#banner_type').val(btn.data('type')).trigger('change');
            $('#title').val(btn.data('title'));
            $('#desc').val(btn.data('desc'));
            const img = btn.data('image');
            if (img) {
                $('#imagePreview').attr('src', img).removeClass('d-none');
                $('#clearImageBtn').removeClass('d-none');
            }
            $('#submitButton').html('<i class="bi bi-arrow-repeat me-1"></i> Update Banner');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Delete Handler
        let deleteId;
        $('.delete-btn').click(function () {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });
        $('#confirmDelete').click(function () {
            window.location.href = '<?= site_url('BannerController/delete_banner/') ?>' + deleteId;
        });

        // Status Toggle Handler
        $('.status-toggle').change(function () {
            let bannerId = $(this).data('id');
            let status = $(this).prop('checked') ? 1 : 0;
            $.ajax({
                url: "<?= site_url('BannerController/update_banner_status'); ?>",
                type: "POST",
                data: {
                    banner_id: bannerId,
                    status: status
                },
                dataType: "json",
                success: function (response) {
                    console.log(response.status === "success" ? "Status updated successfully!" : "Failed to update status.");
                },
                error: function () {
                    console.log("Something went wrong!");
                }
            });
        });
    });

    function resetForm() {
        $('#bannerForm')[0].reset();
        $('#banner_id').val('');
        $('#banner_type').val('').trigger('change');
        $('#imagePreview').attr('src', '').addClass('d-none');
        $('#clearImageBtn').addClass('d-none');
        $('#submitButton').html('<i class="bi bi-save me-1"></i> Save Banner');
    }

    function previewThumbnail(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result).removeClass('d-none');
            $('#clearImageBtn').removeClass('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }

    function clearImage() {
        $('#fileInput').val('');
        $('#imagePreview').attr('src', '').addClass('d-none');
        $('#clearImageBtn').addClass('d-none');
    }
</script>

<style>
    .upload-container {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-container:hover {
        background-color: #f1f3f5 !important;
        border-color: #0d6efd !important;
    }

    .upload-preview img {
        max-height: 180px;
        object-fit: contain;
    }
</style>
