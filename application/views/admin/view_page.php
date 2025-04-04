<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-light border-bottom py-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="h3 mb-0 text-primary fw-bold">Edit Page</h1>
                    <nav aria-label="breadcrumb" class="mt-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="<?php echo site_url('AdminController/dashboard')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Page</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="container-lg my-4">
        <div class="card shadow-sm border-0 overflow-hidden">
            <form action="save_about.php" method="POST">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="<?= site_url('AdminController/page_list'); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a> <a class="btn btn-sm btn-primary"
                            href="<?= site_url('AdminController/edit_page/'.$page->id); ?>">Edit</a>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Page Content</label>
                        <textarea name="about_content" id="editor1" class="form-control">
                            <?php echo htmlspecialchars(json_decode($page->page_content)??''); ?>
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Description</label>
                        <textarea class="form-control" id="editor1" name="content" rows="5"
                            placeholder="Enter full content"
                            required><?= htmlspecialchars(json_decode($page->short_desc) ?? '', ENT_QUOTES); ?></textarea>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>

<!-- CKEditor Implementation -->
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1', {
        toolbar: [{
                name: 'document',
                items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']
            },
            {
                name: 'clipboard',
                items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
            },
            {
                name: 'editing',
                items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-',
                    'RemoveFormat'
                ]
            },
            '/',
            {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                    'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
                    '-', 'BidiLtr', 'BidiRtl'
                ]
            },
            {
                name: 'links',
                items: ['Link', 'Unlink', 'Anchor']
            },
            {
                name: 'insert',
                items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
            },
            '/',
            {
                name: 'styles',
                items: ['Styles', 'Format', 'Font', 'FontSize']
            },
            {
                name: 'colors',
                items: ['TextColor', 'BGColor']
            },
            {
                name: 'tools',
                items: ['Maximize', 'ShowBlocks']
            }
        ],
        extraAllowedContent: 'iframe[*]',
        filebrowserUploadUrl: 'upload.php',
        height: 600
    });
</script>

<?php include 'layouts/footer.php'; ?>