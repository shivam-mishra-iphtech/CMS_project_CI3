<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<main class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <header class="bg-light border-bottom py-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Page Category Management</h1>
                <button type="button" class="btn btn-secondary btn-sm" onclick="resetForm()">
                    <i class="bi bi-plus-lg"></i> Add New
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Flash Messages -->
            <!-- <div class="col-12">
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-0">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-0">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
            </div> -->

            <!-- Form Column -->
            <div class="col-lg-4 col-md-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <?= form_open('AdminController/add_page_category', ['id' => 'categoryForm']); ?>
                            <input type="hidden" name="id" id="category_id" value="">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Category Name</label>
                                <input type="text" 
                                    class="form-control form-control-sm shadow-none <?= form_error('title') ? 'is-invalid' : '' ?>" 
                                    id="title" 
                                    name="title"
                                    placeholder="Enter category name"
                                    required>
                                <?php if(form_error('title')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('title'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="text-end  gap-2">
                                <button type="submit" class="w-50 btn btn-primary btn-sm">
                                    <i class="bi bi-save me-1"></i> Save Category
                                </button>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Table Column -->
            <!-- Table Column -->
<div class="col-lg-8 col-md-7">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle" id="categoryTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">#</th>
                            <th class="text-start ps-4">Category Name</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td class="text-start ps-4 fw-semibold"><?= htmlspecialchars($category->category_name); ?></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-primary edit-category"
                                            data-id="<?= $category->id; ?>"
                                            data-title="<?= htmlspecialchars($category->category_name); ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-category"
                                            data-id="<?= $category->id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 bg-light">
                                    <div class="py-4">
                                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                                        <p class="text-muted mt-3 mb-0">No categories found</p>
                                    </div>
                                </td>
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



<?php include 'layouts/footer.php'; ?>

<!-- DataTables Configuration -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
    // Initialize DataTable with Bootstrap 5 styling
    const table = $('#categoryTable').DataTable({
        order: [[0, 'asc']],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            search: "Search categories:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "<i class='bi bi-chevron-double-left'></i>",
                previous: "<i class='bi bi-chevron-left'></i>",
                next: "<i class='bi bi-chevron-right'></i>",
                last: "<i class='bi bi-chevron-double-right'></i>"
            }
        },
        responsive: true,
        columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
        }]
    });

    // Ensure proper pagination styling
    $('#categoryTable_paginate').addClass('pagination-sm');

    // Edit Category Handler
    $('body').on('click', '.edit-category', function () {
        const categoryId = $(this).data('id');
        const categoryTitle = $(this).data('title');

        $('#category_id').val(categoryId);
        $('#title').val(categoryTitle).focus();
        $('button[type="submit"]').html('<i class="bi bi-arrow-repeat me-2"></i> Update');
    });

   
});

// Reset Form Function
function resetForm() {
    $('#categoryForm')[0].reset();
    $('#category_id').val('');
    $('button[type="submit"]').html('<i class="bi bi-save me-2"></i> Save Category');
    $('#title').focus();
}


</script>