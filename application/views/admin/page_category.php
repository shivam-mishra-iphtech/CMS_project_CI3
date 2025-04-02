
<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Page Categories</h1>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetForm()">
                    <i class="bi bi-plus-lg me-2"></i>New Category
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Form Column -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Manage Category</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= form_open('AdminController/add_page_category', ['id' => 'categoryForm']); ?>
                            <input type="hidden" name="id" id="category_id" value="">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">Category Name</label>
                                <input type="text" 
                                    class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" 
                                    id="title" 
                                    name="title"
                                    value="<?= set_value('title'); ?>"
                                    placeholder="Enter category name"
                                    required>
                                <?php if(form_error('title')): ?>
                                    <div class="invalid-feedback">
                                        <?= form_error('title'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    <i class="bi bi-save me-1"></i> Save Category
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
                        <h5 class="mb-0">Categories List</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="DataTable" class="table align-middle">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Category Name</th>
                                        <th width="20%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td class="text-center small"><?= $count++; ?></td>
                                                <td class="fw-medium"><?= htmlspecialchars($category->category_name); ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" 
                                                            class="btn btn-sm fw-bold text-primary px-3 edit-category"
                                                            data-id="<?= $category->id; ?>"
                                                            data-title="<?= htmlspecialchars($category->category_name); ?>">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button type="button" 
                                                            class="btn btn-sm text-danger fw-bold  px-3 delete-category"
                                                            data-id="<?= $category->id; ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
<?php include 'layouts/footer.php'; ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> -->

<!-- Scripts -->
<script>
   $(document).ready(function () {
       // Initialize DataTable with better configuration
    //    $('#categoriesTable').DataTable({
    //        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    //        pagingType: "simple_numbers",
    //        responsive: true,
    //        language: {
    //            emptyTable: '<div class="text-center py-5"><i class="bi bi-folder-x fs-4 text-muted"></i><p class="text-muted mt-3">No categories found</p></div>',
    //            search: "_INPUT_",
    //            searchPlaceholder: "Search categories..."
    //        },
    //        columnDefs: [
    //            { orderable: false, targets: [2] }
    //        ]
    //    });

       // Edit Category Handler
       $('body').on('click', '.edit-category', function () {
           $('#category_id').val($(this).data('id'));
           $('#title').val($(this).data('title')).focus();
           $('#submitButton')
               .html('<i class="bi bi-check-lg me-1"></i> Update Category')
               .removeClass('btn-primary')
               .addClass('btn-warning');
       });

       // Delete Category Handler
       let deleteId;
       $('body').on('click', '.delete-category', function () {
           deleteId = $(this).data('id');
           $('#deleteModal').modal('show');
       });

       $('#confirmDelete').click(function() {
           window.location.href = '<?= site_url('AdminController/delete_page_category/') ?>' + deleteId;
       });

       // Reset Form Function
       function resetForm() {
           $('#categoryForm')[0].reset();
           $('#category_id').val('');
           $('#submitButton')
               .html('<i class="bi bi-save me-1"></i> Save Category')
               .removeClass('btn-warning')
               .addClass('btn-primary');
           $('#title').focus();
       }
   });
</script>