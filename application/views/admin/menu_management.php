<?php include 'layouts/sidebar.php'; ?>

<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <!-- Main Content -->
    <div class="container">
    <h2>Menu Management - <?php echo ucfirst($menu_type); ?></h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Add Menu Item</div>
                <div class="panel-body">
                    <form method="post" action="<?php echo site_url('menu/add_item'); ?>">
                        <input type="hidden" name="menu_type" value="<?php echo $menu_type; ?>">
                        
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="type" id="menu-type">
                                <option value="custom">Custom Link</option>
                                <option value="page">Page</option>
                                <option value="post">Post</option>
                            </select>
                        </div>

                        <div class="form-group" id="page-select" style="display:none;">
                            <label>Select Page</label>
                            <select class="form-control" name="object_id">
                                <?php foreach($pages as $page): ?>
                                <option value="<?php echo $page->id; ?>"><?php echo $page->page_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group" id="post-select" style="display:none;">
                            <label>Select Post</label>
                            <select class="form-control" name="object_id">
                                <?php foreach($posts as $post): ?>
                                <option value="<?php echo $post->id; ?>"><?php echo $post->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group" id="url-field">
                            <label>URL</label>
                            <input type="text" name="url" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="newtab"> Open in new tab
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Menu Structure</div>
                <div class="panel-body">
                    <div id="menu-builder">
                        <ol class="sortable">
                            <?php echo build_menu_tree($menu_items); ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Include jQuery UI Sortable -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
    $('.sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        update: function(event, ui) {
            var menu_data = $('.sortable').nestedSortable('toArray');
            $.post('<?php echo site_url('menu/save_order'); ?>', 
            { items: JSON.stringify(menu_data) }, 
            function(response) {
                console.log('Order saved');
            });
        }
    });

    // Handle menu type changes
    $('#menu-type').change(function() {
        var type = $(this).val();
        $('#page-select, #post-select, #url-field').hide();
        if(type === 'page') {
            $('#page-select').show();
        } else if(type === 'post') {
            $('#post-select').show();
        } else {
            $('#url-field').show();
        }
    });
});
</script>

<style>
.sortable li div {
    cursor: move;
    padding: 10px;
    background: #f5f5f5;
    margin: 5px 0;
    border: 1px solid #ddd;
}
</style>


<!-- Edit Menu Item Modal -->
<!-- <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editItemId">
                    <div class="mb-3">
                        <label class="form-label">Navigation Label</label>
                        <input type="text" class="form-control" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="url" class="form-control" id="editUrl" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editNewTab">
                        <label class="form-check-label">Open in new tab</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div> -->

<?php include 'layouts/footer.php'; ?>

<!-- Scripts -->
<script>
    // $(document).ready(function() {
    //     const menuBuilder = $('#menu-builder');
    //     let currentMenuType = $('#menu-type').val();
    //     const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    //     const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
        
    //     // Initialize nestable
    //     const initNestable = () => {
    //         menuBuilder.nestable({
    //             group: 1,
    //             maxDepth: 3,
    //             callback: updateEmptyState
    //         });
    //     };
    //     initNestable();

    //     // Handle menu type change
    //     $('#menu-type').change(function() {
    //         currentMenuType = $(this).val();
    //         loadMenuStructure(currentMenuType);
    //     });

    //     // Load menu structure
    //     const loadMenuStructure = (menuType) => {
    //         $.ajax({
    //             url: '<?= site_url('MenuController/manage_menus') ?>',
    //             method: 'POST',
    //             data: {
    //                 menu_type: menuType,
    //                 [csrfName]: csrfHash
    //             },
    //             success: function(response) {
    //                 menuBuilder.html(response.html);
    //                 initNestable();
    //                 updateEmptyState();
    //             }
    //         });
    //     };

    //     // Add page item
    //     $('.add-item').click(function() {
    //         const item = $(this).closest('.page-item');
    //         addMenuItem({
    //             id: `page-${Date.now()}`,
    //             title: item.data('title'),
    //             type: 'page',
    //             pageId: item.data('id'),
    //             url: item.data('url'),
    //             newTab: false
    //         });
    //     });

    //     // Add custom link
    //     $('#add-custom-link').click(function() {
    //         const url = $('#custom-link-url').val();
    //         if (isValidUrl(url)) {
    //             const newItem = {
    //                 id: `custom-${Date.now()}`,
    //                 title: new URL(url).hostname,
    //                 type: 'custom',
    //                 url: url,
    //                 newTab: false
    //             };
    //             addMenuItem(newItem);
    //             $('#custom-link-url').val('');
    //             $('#editItemId').val(newItem.id);
    //             $('#editTitle').val(newItem.title);
    //             $('#editUrl').val(newItem.url);
    //             $('#editModal').modal('show');
    //         }
    //     });

    //     // Save menu structure
    //     $('#save-menu').click(function() {
    //         const structure = menuBuilder.nestable('serialize');
    //         $.ajax({
    //             url: '<?= site_url('MenuController/save') ?>',
    //             method: 'POST',
    //             data: {
    //                 menu_type: currentMenuType,
    //                 structure: JSON.stringify(structure),
    //                 [csrfName]: csrfHash
    //             },
    //             success: function(response) {
    //                 if(response.success) {
    //                     showToast('success', response.message);
    //                     loadMenuStructure(currentMenuType);
    //                 } else {
    //                     showToast('error', response.message);
    //                 }
    //             }
    //         });
    //     });

    //     // Edit item
    //     menuBuilder.on('click', '.btn-edit', function() {
    //         const item = $(this).closest('.dd-item');
    //         const data = item.data('item');
    //         $('#editItemId').val(data.id);
    //         $('#editTitle').val(data.title);
    //         $('#editUrl').val(data.url);
    //         $('#editNewTab').prop('checked', data.newTab);
    //         $('#editModal').modal('show');
    //     });

    //     // Save edited changes
    //     $('#saveChanges').click(function() {
    //         const itemId = $('#editItemId').val();
    //         const item = $(`.dd-item[data-id="${itemId}"]`);
    //         const data = item.data('item');
    //         data.title = $('#editTitle').val();
    //         data.url = $('#editUrl').val();
    //         data.newTab = $('#editNewTab').prop('checked');
    //         item.data('item', data);
    //         item.find('.dd-handle').html(`${data.title} ${data.type === 'custom' ? `<small class="text-muted ms-2">${data.url}</small>` : ''}`);
    //         $('#editModal').modal('hide');
    //     });

    //     // Delete item
    //     menuBuilder.on('click', '.btn-delete', function() {
    //         $(this).closest('.dd-item').remove();
    //         updateEmptyState();
    //     });

    //     function addMenuItem(data) {
    //         const itemHtml = `
    //         <li class="dd-item card" data-id="${data.id}" data-item='${JSON.stringify(data)}'>
    //             <div class="dd-content">
    //                 <span class="dd-handle">
    //                     ${data.title}
    //                     ${data.type === 'custom' ? `<small class="text-muted ms-2">${data.url}</small>` : ''}
    //                 </span>
    //                 <div class="dd-actions">
    //                     <button class="btn btn-sm btn-link text-secondary btn-edit">
    //                         <i class="bi bi-pencil"></i>
    //                     </button>
    //                     <button class="btn btn-sm btn-link text-danger btn-delete">
    //                         <i class="bi bi-trash"></i>
    //                     </button>
    //                 </div>
    //             </div>
    //             <ol class="dd-list"></ol>
    //         </li>
    //         `;
    //         menuBuilder.find('.dd-list').append(itemHtml);
    //         updateEmptyState();
    //     }

    //     function updateEmptyState() {
    //         const isEmpty = menuBuilder.find('.dd-item').length === 0;
    //         $('#empty-state').toggle(isEmpty);
    //         if (isEmpty) menuBuilder.find('.dd-list').html('');
    //     }

    //     function isValidUrl(url) {
    //         try {
    //             new URL(url);
    //             return true;
    //         } catch {
    //             showToast('warning', 'Please enter a valid URL');
    //             return false;
    //         }
    //     }

    //     function showToast(type, message) {
    //         // Implement toast notifications using your preferred library
    //         console.log(`${type}: ${message}`);
    //     }
    // });
</script>