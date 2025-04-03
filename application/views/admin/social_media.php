<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Social Media Management</h1>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetForm()">
                    <i class="bi bi-plus-lg me-2"></i>New Media
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Manage Media Links</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= form_open('AdminController/save_social_media', ['id' => 'mediaForm']); ?>
                        <input type="hidden" name="id" id="media_id">
                        <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                        <div class="mb-4">
                            <label for="media_icon_id" class="form-label fw-bold">Media Name</label>
                            <select class="form-select select2 <?= form_error('media_icon_id') ? 'is-invalid' : '' ?>"
                                name="media_icon_id" id="media_icon_id" required>
                                <option value="">Select Platform</option>
                                <?php foreach ($media_icons as $media_icon): ?>
                                <option value="<?= $media_icon->id ?>"
                                    data-icon-class="bi <?= $media_icon->icon_class ?>"
                                    data-icon-color="<?= $media_icon->icon_color ?>"
                                    <?= set_select('media_icon_id', $media_icon->id) ?>>
                                    <?= $media_icon->media_name ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(form_error('media_icon_id')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('media_icon_id') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="media_link" class="form-label fw-bold">Media Link</label>
                            <input type="url" class="form-control <?= form_error('media_link') ? 'is-invalid' : '' ?>"
                                id="media_link" name="media_link" value="<?= set_value('media_link') ?>"
                                placeholder="https://example.com" required>
                            <?php if(form_error('media_link')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('media_link') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <i class="bi bi-save me-1"></i> Save
                            </button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Table Column -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Social Media List</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="DataTable" class="table align-middle">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Platform</th>
                                        <th>URL</th>
                                        <th width="20%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($social_media)): ?>
                                    <?php foreach ($social_media as $index => $media): ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td>
                                            <i class="bi <?= htmlspecialchars($media->icon_class) ?> fs-5 me-2"
                                                style="color: <?= htmlspecialchars($media->icon_color) ?>"></i>
                                            <?= htmlspecialchars($media->media_name) ?>
                                        </td>
                                        <td class="text-truncate" style="max-width: 300px;">
                                            <?= htmlspecialchars($media->media_link) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary edit-media"
                                                    data-id="<?= $media->id ?>"
                                                    data-media-icon-id="<?= $media->media_icon_id ?>"
                                                    data-url="<?= htmlspecialchars($media->media_link, ENT_QUOTES) ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-media"
                                                    data-id="<?= $media->id ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No social media links found</td>
                                    </tr>
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
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this social media link? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>

<script>
    $(document).ready(function() {
        // Initialize Select2 with custom icons
        $('#media_icon_id').select2({
            templateResult: formatIcon,
            templateSelection: formatIcon
        });

        function formatIcon(option) {
            if (!option.id) return option.text;
            const iconClass = $(option.element).data('icon-class');
            const iconColor = $(option.element).data('icon-color');
            return $('<span><i class="' + iconClass + ' me-2" style="color:' + iconColor + '"></i>' + option
                .text + '</span>');
        }

        // Edit media handler
        $('body').on('click', '.edit-media', function() {
            const mediaId = $(this).data('id');
            const iconId = $(this).data('media-icon-id');
            const url = $(this).data('url');
            $('#media_id').val(mediaId);
            $('#media_icon_id').val(iconId).trigger('change');
            $('#media_link').val(url).focus();
            $('#submitButton')
                .html('<i class="bi bi-arrow-repeat me-1"></i> Update')
                .removeClass('btn-primary')
                .addClass('btn-warning');
        });

        // Delete media handler
        let deleteId;
        $('body').on('click', '.delete-media', function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').click(function() {
            window.location.href = '<?= site_url('AdminController/delete_social_media/') ?>' + deleteId;
        });
    });

    // Form reset handler
    function resetForm() {
        $('#mediaForm')[0].reset();
        $('#media_id').val('');
        $('#media_icon_id').val('').trigger('change');
        $('#submitButton')
            .html('<i class="bi bi-save me-1"></i> Save')
            .removeClass('btn-warning')
            .addClass('btn-primary');
        $('#media_link').focus();
    }
</script>