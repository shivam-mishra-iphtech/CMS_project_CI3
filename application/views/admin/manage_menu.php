<?php include 'layouts/sidebar.php'; //echo"<pre>";

// print_r($categories);

?>

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
    .submenu-item {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        position: relative;
    }
    .remove-submenu {
        position: absolute;
        top: 5px;
        right: 5px;
        color: #dc3545;
        cursor: pointer;
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
                            <select name="menu_position" id="menu_position" class="form-select" required>
                                <option value="">Select Position</option>
                                <option value="header">Header Menu</option>
                                <option value="footer">Footer Menu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="menu_name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="Enter Menu Name" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="has_submenu" name="has_submenu">
                            <label class="form-check-label" for="has_submenu">Has Sub-Menu Items</label>
                        </div>

                        <!-- Submenu Items Container -->
                        <div id="submenuItemsContainer" class="mb-3" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Submenu Items</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addSubmenuBtn">
                                    <i class="bi bi-plus"></i> Add Submenu
                                </button>
                            </div>
                            
                            <div id="submenuItemsList">
                                <!-- Submenu items will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Main Menu Link Section (shown when no submenus) -->
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
                                        <option value="<?= $page->slug ?>"><?= $page->page_title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="main_post_link" class="link-type-section">
                                <label for="main_post_select" class="form-label">Select Post</label>
                                <select class="form-select" name="main_post_select" id="main_post_select">
                                    <?php foreach($posts as $post): ?>
                                        <option value="<?= $post->slug ?>"><?= $post->post_title ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div id="main_post_category_link" class="link-type-section">
                                <label for="main_category_select" class="form-label">Select Category</label>
                                <select class="form-select" name="main_category_select" id="main_post_category_select">
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category->id ?>"><?= $category->category_name ?></option>
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
                                        <th>Link Type</th>
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
                                                                    <?= $submenu->menu_name ?>
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
                                                <td><?= ucfirst($menu->link_type) ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary me-1 edit-btn" 
                                                            data-id="<?= $menu->id ?>"
                                                            data-menu-name="<?= $menu->menu_name ?>"
                                                            data-position="<?= $menu->menu_position ?>"
                                                            data-link-type="<?= $menu->link_type ?>"
                                                            data-object-id="<?= $menu->object_id ?>"
                                                            data-url="<?= $menu->url ?>"
                                                            data-has-submenu="<?= !empty($menu->submenus) ? '1' : '0' ?>">
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
                                            <td colspan="6" class="text-center py-4">No menu items found</td>
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

<!-- Submenu Item Template (hidden) -->
<div id="submenuItemTemplate" style="display: none;">
    <div class="submenu-item">
        <span class="remove-submenu"><i class="bi bi-x-circle"></i></span>
        <div class="mb-2">
            <label class="form-label">Submenu Name</label>
            <input type="text" class="form-control submenu-name" name="submenu_names[]" placeholder="Enter Submenu Name" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Link Type</label>
            <select class="form-select submenu-link-type" name="submenu_link_types[]">
                <option value="">Select Link Type</option>
                <option value="page">Page</option>
                <option value="post">Post</option>
                <option value="post_category">Post Category</option>
                <option value="custom">Custom URL</option>
            </select>
        </div>
        <div class="submenu-page-link link-type-section">
            <label class="form-label">Select Page</label>
            <select class="form-select submenu-page-select" name="submenu_page_selects[]">
                <?php foreach($pages as $page): ?>
                    <option value="<?= $page->slug ?>"><?= $page->page_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="submenu-post-link link-type-section">
            <label class="form-label">Select Post</label>
            <select class="form-select submenu-post-select" name="submenu_post_selects[]">
                <?php foreach($posts as $post): ?>
                    <option value="<?= $post->slug ?>"><?= $post->post_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="submenu-post_category-link link-type-section">
            <label class="form-label">Select Category</label>
            <select class="form-select submenu-post_category-select" name="submenu_category_selects[]">
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->id ?>"><?= $category->category_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="submenu-custom-link link-type-section">
            <label class="form-label">Custom URL</label>
            <input type="text" class="form-control submenu-custom-url" name="submenu_custom_urls[]" placeholder="Enter URL (e.g. https://example.com)">
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
                $('#submenuItemsContainer').show();
                $('#mainLinkSection').hide();
            } else {
                $('#submenuItemsContainer').hide();
                $('#mainLinkSection').show();
            }
        });
        
        // Handle main menu link type change
        $('#main_link_type').change(function() {
            $('.link-type-section').hide();
            const selectedType = $(this).val();
            if(selectedType) {
                // alert(selectedType)
                $('#main_' + selectedType + '_link').show();
            }
        });
        
        // Add new submenu item
        $('#addSubmenuBtn').click(function() {
            const newItem = $('#submenuItemTemplate').html();
            $('#submenuItemsList').append(newItem);
        });
        
        // Handle submenu link type change (delegated event)
        $(document).on('change', '.submenu-link-type', function() {
            const container = $(this).closest('.submenu-item');
            container.find('.link-type-section').hide();
            const selectedType = $(this).val();
            if(selectedType) {
                container.find('.submenu-' + selectedType + '-link').show();
            }
        });
        
        // Remove submenu item
        $(document).on('click', '.remove-submenu', function() {
            $(this).closest('.submenu-item').remove();
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
        
        // Form submission
        $('#menuForm').submit(function(e) {
            e.preventDefault();
            
            const formData = $(this).serialize();
            
            // Validate form
            if(!$('#menu_position').val()) {
                alert('Please select menu position');
                return;
            }
            
            if(!$('#menu_name').val()) {
                alert('Please enter menu name');
                return;
            }
            
            // Submit via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        alert('Menu saved successfully');
                        window.location.reload();
                    } else {
                        alert('Error: ' + (response.message || 'Failed to save menu'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while saving the menu: ' + error);
                }
            });
        });
        
        // Edit button click handler
        $('.edit-btn').click(function() {
            const id = $(this).data('id');
            const menuName = $(this).data('menu-name');
            const position = $(this).data('position');
            const linkType = $(this).data('link-type');
            const objectId = $(this).data('object-id');
            const url = $(this).data('url');
            const hasSubmenu = $(this).data('has-submenu');
            
            resetForm();
            
            $('#menu_id').val(id);
            $('#menu_name').val(menuName);
            $('#menu_position').val(position);
            
            // Check if it has submenus
            if(hasSubmenu == '1') {
                $('#has_submenu').prop('checked', true).trigger('change');
                // Load submenu items via AJAX
                $.ajax({
                    url: '<?= site_url('AdminController/get_menu_submenus') ?>',
                    type: 'POST',
                    data: { menu_id: id },
                    dataType: 'json',
                    success: function(response) {
                        if(response.success && response.submenus.length > 0) {
                            $('#submenuItemsList').empty();
                            response.submenus.forEach(function(submenu) {
                                const newItem = $('#submenuItemTemplate').html();
                                $('#submenuItemsList').append(newItem);
                                
                                const lastItem = $('#submenuItemsList .submenu-item').last();
                                lastItem.find('.submenu-name').val(submenu.menu_name);
                                lastItem.find('.submenu-link-type').val(submenu.link_type).trigger('change');
                                
                                switch(submenu.link_type) {
                                    case 'page':
                                        lastItem.find('.submenu-page-select').val(submenu.object_id);
                                        break;
                                    case 'post':
                                        lastItem.find('.submenu-post-select').val(submenu.object_id);
                                        break;
                                    case 'post_category':
                                        lastItem.find('.submenu-category-select').val(submenu.object_id);
                                        break;
                                    case 'custom':
                                        lastItem.find('.submenu-custom-url').val(submenu.url);
                                        break;
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        alert('Failed to load submenu items');
                    }
                });
            } else {
                $('#main_link_type').val(linkType).trigger('change');


               
                
                // Set the appropriate link value based on type
                switch(linkType) {
                    case 'page':
                        $('#main_page_select').val(objectId);
                        break;
                    case 'post':
                        $('#main_post_select').val(objectId);
                        break;
                    case 'post_category':
                        $('#main_category_select').val(objectId);
                        break;
                    case 'custom':
                        $('#main_custom_url').val(url);
                        break;
                }
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
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            alert('Menu deleted successfully');
                            window.location.reload();
                        } else {
                            alert('Error: ' + (response.message || 'Failed to delete menu'));
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while deleting the menu');
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
        $('#submenuItemsContainer').hide();
        $('#mainLinkSection').show();
        $('#has_submenu').prop('checked', false);
        $('#submenuItemsList').empty();
    }
</script>