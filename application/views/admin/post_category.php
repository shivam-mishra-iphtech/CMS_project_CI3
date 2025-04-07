<?php include 'layouts/sidebar.php'; ?>

<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <!-- Main Menu Section -->
    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Manage Post Category</h1>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetMainForm()">
                    <i class="bi bi-plus-lg me-2"></i>New Category
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Category Form -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Category Form</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="categoryForm" action="<?= site_url('AdminController/add_post_category')?>" method="post">
                            <input type="hidden" name="id" id="category_id">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category name</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Category name" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitButton">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category List -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Post Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="DataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($post_categories as $category): ?>
                                    <tr data-id="<?= $category->id ?>">
                                        <td><?= htmlspecialchars($category->category_name) ?></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-primary edit-category">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-category">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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
                Are you sure you want to delete this category?
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
        let deleteId;

        // Edit Category Handler
        $('body').on('click', '.edit-category', function() {
            const row = $(this).closest('tr');
            const categoryId = row.data('id');
            const title = row.find('td:first').text().trim();

            $('#category_id').val(categoryId);
            $('input[name="title"]').val(title);
            
            $('#submitButton')
                .html('Update')
                .removeClass('btn-primary')
                .addClass('btn-warning');
        });

        // Delete Category Handler
        $('body').on('click', '.delete-category', function() {
            deleteId = $(this).closest('tr').data('id');
            $('#deleteModal').modal('show');
        });

        // Confirm Delete
        $('#confirmDelete').click(function() {
            window.location.href = '<?= site_url('AdminController/delete_post_category/') ?>' + deleteId;
        });
    });

    // Form Reset Function
    function resetMainForm() {
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        $('#submitButton')
            .html('Save')
            .removeClass('btn-warning')
            .addClass('btn-primary');
    }
</script>