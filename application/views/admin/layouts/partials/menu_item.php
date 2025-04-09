<?php foreach ($items as $item): ?>
    <?php if ($item->parent_id == $parent_id): ?>
        <li class="dd-item" data-id="<?php echo $item->id; ?>">
            <div class="dd-handle bg-light p-3 d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-arrows-alt me-2"></i>
                    <?php echo $item->menu_name; ?>
                    <?php if($item->menu_type != 'custom'): ?>
                        <small class="text-muted ms-2">(<?php echo ucfirst($item->menu_type); ?>)</small>
                    <?php endif; ?>
                </span>
                <div class="btn-group">
                    <a href="<?php echo site_url('MenuController/edit_menu_item/'.$item->id); ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pen"></i>
                    </a>
                    <a href="<?php echo site_url('MenuController/delete_menu_item/'.$item->id); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
            <?php
            // Check if this item has children
            $has_children = false;
            foreach ($items as $child_item) {
                if ($child_item->parent_id == $item->id) {
                    $has_children = true;
                    break;
                }
            }
            ?>
            <?php if ($has_children): ?>
                <ol class="dd-list">
                    <?php $this->load->view('menu/menu_structure', array('items' => $items, 'parent_id' => $item->id)); ?>
                </ol>
            <?php endif; ?>
        </li>
    <?php endif; ?>
<?php endforeach; ?>