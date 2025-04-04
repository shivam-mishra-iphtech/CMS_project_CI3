<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Manage Menus</h1>
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
                        <h5 class="mb-0">Manage Menu</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= form_open('AdminController/add_page_category', ['id' => 'mainMenuForm']); ?>
                        <input type="hidden" name="id" id="menu_id" value="">
                        <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                        <div class="mb-4">
                            <label for="menu_type" class="form-label fw-bold">Menu Type</label>
                            <select class="form-select select2 form-control-sm shadow-none <?= form_error('menu_type') ? 'is-invalid' : '' ?>" 
                                name="menu_type" required>
                                <option value="">Select Menu Type</option>
                                <option value="header" <?= set_select('menu_type', 'header') ?>>Header Menu</option>
                                <option value="footer" <?= set_select('menu_type', 'footer') ?>>Footer Menu</option>
                            </select>
                            <?php if(form_error('menu_type')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('menu_type'); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="menu_name" class="form-label fw-bold">Menu Name</label>
                            <input type="text" class="form-control <?= form_error('menu_name') ? 'is-invalid' : '' ?>"
                                id="menu_name" name="menu_name" value="<?= set_value('menu_name'); ?>"
                                placeholder="Enter menu name" required>
                            <?php if(form_error('menu_name')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('menu_name'); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="page_id" class="form-label fw-bold">Link to Page</label>
                            <select class="form-select select2 form-control-sm shadow-none <?= form_error('page_id') ? 'is-invalid' : '' ?>" 
                                name="page_id" required>
                                <option value="">Select Page</option>
                                <?php foreach ($pages as $page): ?>
                                    <option value="<?= $page->id ?>" <?= set_select('page_id', $page->id) ?>>
                                        <?= htmlspecialchars($page->page_title) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(form_error('page_id')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('page_id'); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="submitMainButton">
                                <i class="bi bi-save me-1"></i> Save Menu
                            </button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Main Menu Table -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Menu List</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="mainMenuTable" class="table align-middle">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Menu Name</th>
                                        <th>Type</th>
                                        <th>Linked Page</th>
                                        <th width="20%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    <?php if (!empty($menus)): ?>
                                    <?php foreach ($menus as $menu): ?>
                                    <tr>
                                        <td class="text-center small"><?= $count++; ?></td>
                                        <td class="fw-medium"><?= htmlspecialchars($menu->menu_name); ?></td>
                                        <td><?= ucfirst($menu->menu_type) ?> Menu</td>
                                        <td><?= htmlspecialchars($menu->page_title) ?></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button"
                                                    class="btn btn-sm fw-bold text-primary px-3 edit-menu"
                                                    data-id="<?= $menu->id; ?>" 
                                                    data-menu-type="<?= $menu->menu_type ?>"
                                                    data-menu-name="<?= htmlspecialchars($menu->menu_name); ?>"
                                                    data-page-id="<?= $menu->page_id ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm text-danger fw-bold px-3 delete-menu"
                                                    data-id="<?= $menu->id; ?>">
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

    <hr>

    <!-- Submenu Section -->
    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Manage Submenus</h1>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetSubForm()">
                    <i class="bi bi-plus-lg me-2"></i>New Submenu
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Submenu Form -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Manage Submenu</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= form_open('AdminController/handle_submenu', ['id' => 'subMenuForm']); ?>
                        <input type="hidden" name="id" id="submenu_id" value="">
                        <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                        <div class="mb-4">
                            <label for="parent_id" class="form-label fw-bold">Parent Menu</label>
                            <select class="form-select select2 form-control-sm shadow-none <?= form_error('parent_id') ? 'is-invalid' : '' ?>" 
                                name="parent_id" required>
                                <option value="">Select Parent Menu</option>
                                <?php foreach ($menus as $menu): ?>
                                <option value="<?= $menu->id ?>" <?= set_select('parent_id', $menu->id) ?>>
                                    <?= htmlspecialchars($menu->menu_name) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(form_error('parent_id')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('parent_id'); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="submenu_name" class="form-label fw-bold">Submenu Name</label>
                            <input type="text"
                                class="form-control <?= form_error('submenu_name') ? 'is-invalid' : '' ?>"
                                id="submenu_name" name="submenu_name" value="<?= set_value('submenu_name'); ?>"
                                placeholder="Enter submenu name" required>
                            <?php if(form_error('submenu_name')): ?>
                            <div class="invalid-feedback">
                                <?= form_error('submenu_name'); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="submitSubButton">
                                <i class="bi bi-save me-1"></i> Save Submenu
                            </button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Submenu Table -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Submenu List</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table id="subMenuTable" class="table align-middle">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Submenu Name</th>
                                        <th>Parent Menu</th>
                                        <th width="20%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    <?php if (!empty($submenus)): ?>
                                    <?php foreach ($submenus as $submenu): ?>
                                    <tr>
                                        <td class="text-center small"><?= $count++; ?></td>
                                        <td class="fw-medium"><?= htmlspecialchars($submenu->submenu_name); ?></td>
                                        <td><?= htmlspecialchars($submenu->parent_name) ?></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button"
                                                    class="btn btn-sm fw-bold text-primary px-3 edit-submenu"
                                                    data-id="<?= $submenu->id; ?>"
                                                    data-parent-id="<?= $submenu->parent_id ?>"
                                                    data-submenu-name="<?= htmlspecialchars($submenu->submenu_name); ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm text-danger fw-bold px-3 delete-submenu"
                                                    data-id="<?= $submenu->id; ?>">
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
                Are you sure you want to delete this item? This action cannot be undone.
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
        // Initialize DataTables
        $('#mainMenuTable, #subMenuTable').DataTable({
            "ordering": true,
            "order": [[0, 'asc']],
            "pageLength": 10,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "previous": "<i class='bi bi-chevron-left'></i>",
                    "next": "<i class='bi bi-chevron-right'></i>"
                }
            }
        });

        // Initialize Select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });

        // Main Menu Handlers
        $('body').on('click', '.edit-menu', function() {
            const menuData = {
                id: $(this).data('id'),
                type: $(this).data('menu-type'),
                name: $(this).data('menu-name'),
                pageId: $(this).data('page-id')
            };
            $('#menu_id').val(menuData.id);
            $('[name="menu_type"]').val(menuData.type).trigger('change');
            $('#menu_name').val(menuData.name);
            $('[name="page_id"]').val(menuData.pageId).trigger('change');
            $('#submitMainButton')
                .html('<i class="bi bi-check-lg me-1"></i> Update Menu')
                .removeClass('btn-primary')
                .addClass('btn-warning');
        });

        // Submenu Handlers
        $('body').on('click', '.edit-submenu', function() {
            const subData = {
                id: $(this).data('id'),
                parentId: $(this).data('parent-id'),
                name: $(this).data('submenu-name')
            };
            $('#submenu_id').val(subData.id);
            $('[name="parent_id"]').val(subData.parentId).trigger('change');
            $('#submenu_name').val(subData.name);
            $('#submitSubButton')
                .html('<i class="bi bi-check-lg me-1"></i> Update Submenu')
                .removeClass('btn-primary')
                .addClass('btn-warning');
        });

        // Delete Handler
        let deleteUrl = '';
        $('body').on('click', '.delete-menu, .delete-submenu', function() {
            const isSubmenu = $(this).hasClass('delete-submenu');
            deleteUrl = isSubmenu ?
                '<?= site_url('AdminController/delete_submenu/') ?>' + $(this).data('id') :
                '<?= site_url('AdminController/delete_menu/') ?>' + $(this).data('id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').click(function() {
            window.location.href = deleteUrl;
        });

        // Form Reset Functions
        function resetMainForm() {
            $('#mainMenuForm')[0].reset();
            $('#menu_id').val('');
            $('[name="menu_type"]').val(null).trigger('change');
            $('[name="page_id"]').val(null).trigger('change');
            $('#submitMainButton')
                .html('<i class="bi bi-save me-1"></i> Save Menu')
                .removeClass('btn-warning')
                .addClass('btn-primary');
        }

        function resetSubForm() {
            $('#subMenuForm')[0].reset();
            $('#submenu_id').val('');
            $('[name="parent_id"]').val(null).trigger('change');
            $('#submitSubButton')
                .html('<i class="bi bi-save me-1"></i> Save Submenu')
                .removeClass('btn-warning')
                .addClass('btn-primary');
        }
    });
</script>