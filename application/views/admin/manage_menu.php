<?php include 'layouts/sidebar.php'; ?>
<style>
    .select2-container .select2-selection--single {
        height: 38px;
        padding: 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .submenu-section {
        display: none;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 10px;
    }
    .link-type-section {
        display: none;
        margin-top: 10px;
    }
</style>

<!-- Main Content -->
<main class="flex-grow-1 overflow-y-lg-auto bg-light">
    <?php include 'layouts/header.php'; ?>

    <header class="bg-white shadow-sm py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0 fw-bold text-dark">Menu Management</h1>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="resetForm()">
                    <i class="bi bi-plus-lg me-2"></i>New Menu
                </button>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Manage Menu Links</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= form_open('AdminController/save_menu', ['id' => 'menuForm']); ?>
                        <input type="hidden" name="id" id="menu_id">
                        <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">

                        <div class="mb-3">
                            <label for="menu_position" class="form-label">Menu Position</label>
                            <select name="menu_position" id="menu_position" class="form-select">
                                <option value="header">Header Menu</option>
                                <option value="footer">Footer Menu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="menu_name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="Enter Menu Name">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="has_submenu">
                            <label class="form-check-label" for="has_submenu">Add Sub-Menu</label>
                        </div>

                        <!-- Submenu Section (hidden by default) -->
                        <div id="submenuSection" class="submenu-section mb-3">
                            <div class="mb-3">
                                <label for="sub_menu_name" class="form-label">Sub Menu Name</label>
                                <input type="text" name="sub_menu_name" class="form-control" id="sub_menu_name" placeholder="Enter Sub Menu Name">
                            </div>
                            
                            <div class="mb-3">
                                <label for="submenu_link_type" class="form-label">Link Type</label>
                                <select class="form-select" name="submenu_link_type" id="submenu_link_type">
                                    <option value="">Select Link Type</option>
                                    <option value="page">Page</option>
                                    <option value="post">Post</option>
                                    <option value="post_category">Post Category</option>
                                    <option value="custom">Custom URL</option>
                                </select>
                            </div>
                            
                            <!-- Submenu Link Sections -->
                            <div id="submenu_page_link" class="link-type-section">
                                <label for="submenu_page_select" class="form-label">Select Page</label>
                                <select class="form-select" name="submenu_page_select" id="submenu_page_select">
                                    <?php foreach($pages as $page): ?>
                                        <option value="<?= $page->id ?>"><?= $page->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="submenu_post_link" class="link-type-section">
                                <label for="submenu_post_select" class="form-label">Select Post</label>
                                <select class="form-select" name="submenu_post_select" id="submenu_post_select">
                                    <?php foreach($posts as $post): ?>
                                        <option value="<?= $post->id ?>"><?= $post->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="submenu_category_link" class="link-type-section">
                                <label for="submenu_category_select" class="form-label">Select Category</label>
                                <select class="form-select" name="submenu_category_select" id="submenu_category_select">
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="submenu_custom_link" class="link-type-section">
                                <label for="submenu_custom_url" class="form-label">Custom URL</label>
                                <input type="text" name="submenu_custom_url" class="form-control" id="submenu_custom_url" placeholder="Enter URL (e.g. https://example.com)">
                            </div>
                        </div>

                        <!-- Main Menu Link Section -->
                        <div id="mainLinkSection">
                            <div class="mb-3">
                                <label for="main_link_type" class="form-label">Link Type</label>
                                <select class="form-select" name="main_link_type" id="main_link_type">
                                    <option value="">Select Link Type</option>
                                    <option value="page">Page</option>
                                    <option value="post">Post</option>
                                    <option value="post_category">Post Category</option>
                                    <option value="custom">Custom URL</option>
                                </select>
                            </div>
                            
                            <!-- Main Menu Link Sections -->
                            <div id="main_page_link" class="link-type-section">
                                <label for="main_page_select" class="form-label">Select Page</label>
                                <select class="form-select" name="main_page_select" id="main_page_select">
                                    <?php foreach($pages as $page): ?>
                                        <option value="<?= $page->id ?>"><?= $page->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="main_post_link" class="link-type-section">
                                <label for="main_post_select" class="form-label">Select Post</label>
                                <select class="form-select" name="main_post_select" id="main_post_select">
                                    <?php foreach($posts as $post): ?>
                                        <option value="<?= $post->id ?>"><?= $post->title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="main_category_link" class="link-type-section">
                                <label for="main_category_select" class="form-label">Select Category</label>
                                <select class="form-select" name="main_category_select" id="main_category_select">
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="main_custom_link" class="link-type-section">
                                <label for="main_custom_url" class="form-label">Custom URL</label>
                                <input type="text" name="main_custom_url" class="form-control" id="main_custom_url" placeholder="Enter URL (e.g. https://example.com)">
                            </div>
                        </div>

                        <div class="d-grid mt-3">
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Menu List</h5>
                            <div class="form-group mb-0">
                                <select class="form-select form-select-sm" id="filter_position" style="width: 150px;">
                                    <option value="all">All Menus</option>
                                    <option value="header">Header Menus</option>
                                    <option value="footer">Footer Menus</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table align-middle" id="menuTable">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th>Menu Name</th>
                                        <th>Position</th>
                                        <th>URL</th>
                                        <th width="15%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($menus)): ?>
                                        <?php foreach($menus as $index => $menu): ?>
                                            <tr>
                                                <td class="text-center"><?= $index + 1 ?></td>
                                                <td>
                                                    <?= $menu->menu_name ?>
                                                    <?php if(!empty($menu->submenus)): ?>
                                                        <ul class="list-unstyled mt-2">
                                                            <?php foreach($menu->submenus as $submenu): ?>
                                                                <li class="ps-3">
                                                                    <i class="bi bi-arrow-return-right me-1"></i>
                                                                    <?= $submenu->sub_menu_name ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= ucfirst($menu->menu_position) ?></td>
                                                <td>
                                                    <?= $menu->url ?>
                                                    <?php if(!empty($menu->submenus)): ?>
                                                        <ul class="list-unstyled mt-2">
                                                            <?php foreach($menu->submenus as $submenu): ?>
                                                                <li class="ps-3">
                                                                    <i class="bi bi-arrow-return-right me-1"></i>
                                                                    <?= $submenu->url ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary me-1 edit-btn" 
                                                            data-id="<?= $menu->id ?>"
                                                            data-menu-name="<?= $menu->menu_name ?>"
                                                            data-position="<?= $menu->menu_position ?>"
                                                            data-link-type="<?= $menu->link_type ?>"
                                                            >
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $menu->id ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No menu items found</td>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this menu item? This action cannot be undone.
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
        // Initialize variables
        let menuToDelete = null;
        
        // Toggle submenu section
        $('#has_submenu').change(function() {
            if($(this).is(':checked')) {
                $('#submenuSection').show();
                $('#mainLinkSection').hide();
            } else {
                $('#submenuSection').hide();
                $('#mainLinkSection').show();
            }
        });
        
        // Handle submenu link type change
        $('#submenu_link_type').change(function() {
            $('.link-type-section').hide();
            const selectedType = $(this).val();
            if(selectedType) {
                $('#submenu_' + selectedType + '_link').show();
            }
        });
        
        // Handle main menu link type change
        $('#main_link_type').change(function() {
            $('.link-type-section').hide();
            const selectedType = $(this).val();
            if(selectedType) {
                $('#main_' + selectedType + '_link').show();
            }
        });
        
        // Filter menu items by position
        $('#filter_position').change(function() {
            const position = $(this).val();
            if(position === 'all') {
                $('#menuTable tbody tr').show();
            } else {
                $('#menuTable tbody tr').each(function() {
                    const rowPosition = $(this).find('td:eq(2)').text().toLowerCase();
                    if(rowPosition.includes(position)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
        
        // Edit button click handler
        $('.edit-btn').click(function() {
            const id = $(this).data('id');
            const menuName = $(this).data('menu-name');
            const position = $(this).data('position');
            const linkType = $(this).data('link-type');
            const linkValue = $(this).data('link-value');
            
            $('#menu_id').val(id);
            $('#menu_name').val(menuName);
            $('#menu_position').val(position);
            
            // Check if it has submenus (you'll need to implement this logic based on your data)
            // For now, we'll assume it's a main menu item
            $('#has_submenu').prop('checked', false).trigger('change');
            $('#main_link_type').val(linkType).trigger('change');
            
            // Set the appropriate link value based on type
            if(linkType === 'custom') {
                $('#main_custom_url').val(linkValue);
            } else {
                $('#main_' + linkType + '_select').val(linkValue);
            }
            
            // Scroll to the form
            $('html, body').animate({
                scrollTop: $('#menuForm').offset().top - 20
            }, 500);
        });
        
        // Delete button click handler
        $('.delete-btn').click(function() {
            menuToDelete = $(this).data('id');
            $('#deleteModal').modal('show');
        });
        
        // Confirm delete
        $('#confirmDelete').click(function() {
            if(menuToDelete) {
                $.ajax({
                    url: '<?= site_url('AdminController/delete_menu') ?>',
                    type: 'POST',
                    data: { id: menuToDelete },
                    success: function(response) {
                        if(response.success) {
                            location.reload();
                        } else {
                            alert('Error deleting menu item');
                        }
                    }
                });
            }
            $('#deleteModal').modal('hide');
        });
    });
    
    function resetForm() {
        $('#menuForm')[0].reset();
        $('#menu_id').val('');
        $('.link-type-section').hide();
        $('#submenuSection').hide();
        $('#mainLinkSection').show();
        $('#has_submenu').prop('checked', false);
    }
</script>