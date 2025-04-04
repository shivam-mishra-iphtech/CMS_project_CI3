<?php
// Ensure we have valid item data
if (!isset($item) || !is_array($item)) return;

// Escape all output values
$escapedItem = [
    'id' => htmlspecialchars($item['id'] ?? '', ENT_QUOTES, 'UTF-8'),
    'title' => htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8'),
    'url' => htmlspecialchars($item['url'] ?? '#', ENT_QUOTES, 'UTF-8'),
    'type' => htmlspecialchars($item['type'] ?? 'custom', ENT_QUOTES, 'UTF-8'),
    'newtab' => !empty($item['newtab']) ? 1 : 0,
    'page_id' => isset($item['page_id']) ? (int)$item['page_id'] : null,
    'children' => $item['children'] ?? []
];
?>

<li class="dd-item" 
    data-id="<?= $escapedItem['id'] ?>"
    data-item='<?= json_encode($escapedItem, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>'>
    
    <div class="dd-content">
        <span class="dd-handle">
            <?= $escapedItem['title'] ?>
            <?php if($escapedItem['type'] === 'custom'): ?>
                <small class="text-muted ms-2"><?= $escapedItem['url'] ?></small>
            <?php endif; ?>
        </span>

        <div class="dd-actions">
            <button type="button" class="btn btn-sm btn-link text-secondary btn-edit">
                <i class="bi bi-pencil"></i>
            </button>
            <button type="button" class="btn btn-sm btn-link text-danger btn-delete">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>

    <?php if(!empty($escapedItem['children'])): ?>
    <ol class="dd-list">
        <?php foreach($escapedItem['children'] as $childItem): ?>
            <?php 
                // Recursively include menu_item partial with child item
                $item = $childItem;
                include __DIR__.'/menu_item.php';
            ?>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>
</li>