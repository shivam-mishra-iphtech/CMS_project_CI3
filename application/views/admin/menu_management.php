<?php include 'layouts/sidebar.php'; ?>

<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Menu Management</h2>
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
                        <form method="post" action="<?php echo site_url('MenuController/add_menu_item'); ?>">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">

                            <div class="mb-3">
                                <label for="menu_name" class="form-label">Menu Name</label>
                                <input type="text" name="menu_name" class="form-control" placeholder="Enter menu name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Menu</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0">-- Top Level --</option>
                                    <?php foreach($menu_items as $item): ?>
                                        <?php if($item->parent_id == 0): ?>
                                            <option value="<?php echo $item->id; ?>"><?php echo $item->menu_name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Menu Type</label>
                                <select class="form-control" name="menu_type" id="menu-type-selector">
                                    <option value="custom">Custom Link</option>
                                    <option value="page">Page</option>
                                    <option value="post">Post</option>
                                    <option value="category">Category</option>
                                </select>
                            </div>

                            <div class="mb-3" id="page-select" style="display:none;">
                                <label class="form-label">Select Page</label>
                                <select class="form-control" name="page_id">
                                    <?php foreach($pages as $page): ?>
                                    <option value="<?php echo $page->id; ?>"><?php echo $page->page_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3" id="post-select" style="display:none;">
                                <label class="form-label">Select Post</label>
                                <select class="form-control" name="post_id">
                                    <?php foreach($posts as $post): ?>
                                    <option value="<?php echo $post->id; ?>"><?php echo $post->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3" id="category-select" style="display:none;">
                                <label class="form-label">Select Category</label>
                                <select class="form-control" name="category_id">
                                    <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3" id="custom-link-fields">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3" id="url-field">
                                <label class="form-label">URL</label>
                                <input type="text" name="url" class="form-control" placeholder="https://example.com">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="newtab" id="newtab">
                                <label class="form-check-label" for="newtab">Open in new tab</label>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Item</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Menu Structure Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Menu Structure</h5>
                    </div>
                    <div class="card-body">
                        <?php if(empty($menu_items)): ?>
                            <div class="alert alert-info">No menu items found. Add your first menu item.</div>
                        <?php else: ?>
                            <div class="dd" id="nestable">
                                <ol class="dd-list">
                                    <?php $this->load->view('admin/layouts/partials/menu_items', array('items' => $menu_items, 'parent_id' => 0)); ?>
                                </ol>
                            </div>
                            
                            <form id="save-menu-form" method="post" action="<?php echo site_url('MenuController/save_menu_structure'); ?>">
                                <input type="hidden" id="menu-structure" name="menu_structure">
                                <button type="submit" class="btn btn-success mt-3">Save Menu Structure</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
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
        } else if (type === 'post') {
            $('#post-select').show();
        } else if (type === 'category') {
            $('#category-select').show();
        } else {
            $('#url-field, #custom-link-fields').show();
        }
    }).trigger('change');
});
</script>