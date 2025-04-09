<?php include 'layouts/sidebar.php'; ?>

<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h2 class="mb-0 text-white">Menu Management</h2>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#menuHelpModal">
                            <i class="fas fa-question-circle me-1"></i> Help
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Add Menu Item Section -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add Menu Item</h5>
                    </div>
                    <div class="card-body">
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

                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors(); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php endif; ?>

                        <?= form_open('MenuController/add_menu_item', ['id' => 'menu-item-form']) ?>
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">

                            <div class="mb-3">
                                <label for="menu_name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                                <input type="text" name="menu_name" class="form-control" placeholder="Enter menu name" required>
                                <small class="text-muted">This is the name used in the admin panel</small>
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Menu</label>
                                <select class="form-select" name="parent_id">
                                    <option value="0">-- Top Level --</option>
                                    <?php foreach($menu_items as $item): ?>
                                        <?php if($item->parent_id == 0): ?>
                                            <option value="<?= $item->id ?>"><?= htmlspecialchars($item->menu_name) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Menu Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="menu_type" id="menu-type-selector">
                                    <option value="custom">Custom Link</option>
                                    <option value="page">Page</option>
                                    <option value="post">Post</option>
                                    <option value="category">Category</option>
                                </select>
                            </div>

                            <div class="mb-3" id="page-select" style="display:none;">
                                <label class="form-label">Select Page</label>
                                <select class="form-select" name="page_id">
                                    <?php foreach($pages as $page): ?>
                                        <option value="<?= $page->id ?>"><?= htmlspecialchars($page->page_title) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3" id="post-select" style="display:none;">
                                <label class="form-label">Select Post</label>
                                <select class="form-select" name="post_id">
                                    <?php foreach($posts as $post): ?>
                                        <option value="<?= $post->id ?>"><?= htmlspecialchars($post->post_title) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3" id="category-select" style="display:none;">
                                <label class="form-label">Select Category</label>
                                <select class="form-select" name="category_id">
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3" id="custom-link-fields">
                                <label class="form-label">Navigation Label <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                                <small class="text-muted">This is the text that will appear in the menu</small>
                            </div>

                            <div class="mb-3" id="url-field">
                                <label class="form-label">URL <span class="text-danger">*</span></label>
                                <input type="text" name="url" class="form-control" placeholder="https://example.com or /page">
                                <small class="text-muted">For internal links, you can just use /page-name</small>
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="newtab" id="newtab" role="switch">
                                <label class="form-check-label" for="newtab">Open in new tab</label>
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" checked role="switch">
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-1"></i> Add Menu Item
                                </button>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>

            <!-- Menu Structure Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Menu Structure</h5>
                        <div>
                            <button class="btn btn-sm btn-light" id="expand-all">
                                <i class="fas fa-expand me-1"></i> Expand All
                            </button>
                            <button class="btn btn-sm btn-light" id="collapse-all">
                                <i class="fas fa-compress me-1"></i> Collapse All
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(empty($menu_items)): ?>
                            <div class="alert alert-info">No menu items found. Add your first menu item using the form on the left.</div>
                        <?php else: ?>
                            <div class="dd" id="nestable">
                                <ol class="dd-list">
                                    <?php $this->load->view('admin/layouts/partials/menu_item', array('items' => $menu_items, 'parent_id' => 0)); ?>
                                </ol>
                            </div>

                            <form id="save-menu-form" method="post" action="<?= site_url('MenuController/save_menu_structure') ?>">
                                <input type="hidden" id="menu-structure" name="menu_structure">
                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Save Menu Structure
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="menuHelpModal" tabindex="-1" aria-labelledby="menuHelpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="menuHelpModalLabel">Menu Management Help</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>How to use:</h6>
                <ol>
                    <li><strong>Add Menu Items:</strong> Fill out the form on the left to add new menu items.</li>
                    <li><strong>Organize Menu:</strong> Drag and drop items to organize your menu structure.</li>
                    <li><strong>Save Changes:</strong> Click "Save Menu Structure" to save your changes.</li>
                </ol>
                
                <h6 class="mt-3">Menu Types:</h6>
                <ul>
                    <li><strong>Custom Link:</strong> Add any custom URL with your own label</li>
                    <li><strong>Page:</strong> Link to an existing page on your site</li>
                    <li><strong>Post:</strong> Link to a blog post</li>
                    <li><strong>Category:</strong> Link to a post category archive</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>

<!-- Nestable JS for drag and drop menu structure -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize nestable
        $('#nestable').nestable({
            maxDepth: 5
        });

        // Save menu structure
        $('#save-menu-form').on('submit', function(e) {
            e.preventDefault();
            var menuStructure = $('#nestable').nestable('serialize');
            $('#menu-structure').val(JSON.stringify(menuStructure));
            
            // Show loading state
            var btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');
            
            this.submit();
        });

        // Menu type selector logic
        $('#menu-type-selector').change(function() {
            var type = $(this).val();
            // Hide all fields first
            $('#page-select, #post-select, #category-select, #url-field, #custom-link-fields').hide();
            
            // Show relevant fields based on selection
            if (type === 'page') {
                $('#page-select').show();
                $('#custom-link-fields').hide();
                $('#url-field').hide();
            } else if (type === 'post') {
                $('#post-select').show();
                $('#custom-link-fields').hide();
                $('#url-field').hide();
            } else if (type === 'category') {
                $('#category-select').show();
                $('#custom-link-fields').hide();
                $('#url-field').hide();
            } else {
                $('#url-field, #custom-link-fields').show();
            }
        }).trigger('change');

        // Delete menu item confirmation
        $(document).on('click', '.delete-menu-item', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this menu item? All sub-items will also be deleted.')) {
                window.location.href = $(this).attr('href');
            }
        });

        // Expand all items
        $('#expand-all').click(function() {
            $('.dd').nestable('expandAll');
        });

        // Collapse all items
        $('#collapse-all').click(function() {
            $('.dd').nestable('collapseAll');
        });

        // Form validation
        $('#menu-item-form').validate({
            rules: {
                menu_name: "required",
                title: "required",
                url: {
                    required: function(element) {
                        return $('#menu-type-selector').val() === 'custom';
                    }
                }
            },
            messages: {
                menu_name: "Please enter a menu name",
                title: "Please enter a navigation label",
                url: "Please enter a URL"
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                element.after(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });
    });
</script>