<?php echo "<pre>";
print_r($pages);die;?>




<?php include 'layouts/sidebar.php';




?>

<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <!-- Main Menu Section -->
    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Manage Main Menus</h1>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetMainForm()">
                    <i class="bi bi-plus-lg me-2"></i>New Menu
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Main Menu Form -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Main Menu Form</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="mainMenuForm" method="post">
                            <input type="hidden" name="id" id="menu_id">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Menu Type</label>
                                <select name="menu_type" class="form-select" required>
                                    <option value="header">Header Menu</option>
                                    <option value="footer">Footer Menu</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Menu Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Link Type</label>
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-outline-primary active" data-type="page">Page</button>
                                    <button type="button" class="btn btn-outline-primary" data-type="custom">Custom URL</button>
                                </div>
                            </div>

                            <div class="mb-3 page-selection">
                                <label class="form-label fw-bold">Select Page</label>
                                <select name="page_id" class="form-select">
                                    <?php foreach ($pages as $page): ?>
                                        <option value="<?= $page->id ?>"><?= $page->page_title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3 custom-url d-none">
                                <label class="form-label fw-bold">Custom URL</label>
                                <input type="url" name="custom_url" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Save Menu</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Menu List -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Menu List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>URL</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($menus as $menu): ?>
                                    <tr data-id="<?= $menu->id ?>">
                                        <td><?= $menu->title ?></td>
                                        <td><?= ucfirst($menu->menu_type) ?></td>
                                        <td><?= $menu->url ?? site_url($menu->slug) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary edit-menu">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-menu">
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

    <!-- Submenu Section -->
    <div class="container-fluid mt-5">
        <div class="row g-4">
            <!-- Submenu Form -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Submenu Form</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="subMenuForm" method="post">
                            <input type="hidden" name="parent_id" id="parent_id">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Parent Menu</label>
                                <select name="parent_id" class="form-select" required>
                                    <?php foreach ($menus as $menu): ?>
                                        <option value="<?= $menu->id ?>"><?= $menu->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Submenu Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Save Submenu</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Submenu List -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Submenu List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Parent Menu</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($submenus as $submenu): ?>
                                    <tr data-id="<?= $submenu->id ?>">
                                        <td><?= $submenu->title ?></td>
                                        <td><?= $submenu->parent_title ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary edit-submenu">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-submenu">
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
                Are you sure you want to delete this item?
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
    // Toggle between page and custom URL
    $('[data-type]').click(function() {
        const type = $(this).data('type');
        $('[data-type]').removeClass('active');
        $(this).addClass('active');
        
        $('.page-selection, .custom-url').addClass('d-none');
        if(type === 'page') {
            $('.page-selection').removeClass('d-none');
        } else {
            $('.custom-url').removeClass('d-none');
        }
    });

    // Form handling
    $('#mainMenuForm').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= site_url('admin/menus/save') ?>',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success
            }
        });
    });

    // Delete handling
    $('.delete-menu, .delete-submenu').click(function() {
        const id = $(this).closest('tr').data('id');
        const type = $(this).hasClass('delete-submenu') ? 'submenu' : 'menu';
        
        $('#deleteModal').modal('show');
        $('#confirmDelete').off().click(function() {
            $.post(`<?= site_url('admin/menus/delete_') ?>${type}/${id}`, function() {
                location.reload();
            });
        });
    });
});

function resetMainForm() {
    $('#mainMenuForm')[0].reset();
    $('#menu_id').val('');
    $('[data-type="page"]').click();
}
</script>
<script>
$(document).ready(function() {
    // Edit Menu Handler
    $('.edit-menu, .edit-submenu').click(function() {
        const isSubmenu = $(this).hasClass('edit-submenu');
        const id = $(this).closest('tr').data('id');
        
        $.get(`<?= site_url('admin/menus/get_item/') ?>${id}`, function(response) {
            if(response.type == 'custom') {
                $('[data-type="custom"]').click();
                $('#custom_url').val(response.url);
            } else {
                $('[data-type="page"]').click();
                $('#page_id').val(response.page_id);
            }

            $('#menu_id').val(response.id);
            $('#title').val(response.title);
            $('#menu_type').val(response.menu_type);
            $('#newtab').prop('checked', response.newtab == 1);
            
            if(isSubmenu) {
                $('#parent_id').val(response.parent_id);
                $('#submenu_id').val(response.id);
            }
        });
    });

    // Delete Handler
    $('.delete-menu, .delete-submenu').click(function() {
        const id = $(this).closest('tr').data('id');
        const isSubmenu = $(this).hasClass('delete-submenu');
        
        $('#deleteModal').modal('show');
        $('#confirmDelete').off().click(function() {
            const url = isSubmenu ? 
                `<?= site_url('admin/menus/delete_submenu/') ?>${id}` :
                `<?= site_url('admin/menus/delete_menu/') ?>${id}`;
            
            $.post(url, function(response) {
                if(response.status == 'success') {
                    location.reload();
                } else {
                    alert('Delete failed');
                }
            });
        });
    });

    // Form Submit Handler
    $('#mainMenuForm, #subMenuForm').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status == 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });
});
</script>