<?php 

// echo "<pre>"; 
// print_r($comments);



?>

<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="d-flex flex-column flex-grow-1 h-100 overflow-hidden">
    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-surface-primary border-bottom py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Comments List</h1>
            </div>

            <!-- comments Table Card -->
            <div class="card shadow-sm" style="border:1px solid darkgray;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="DataTable" class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th class="">User Name</th>
                                    <th class="text-center">Comment</th>
                                   
                                    <th class="text-center">Publish</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($comments)) : ?>
                                <?php foreach ($comments as $index => $comment) : ?>
                                <tr class="border-top">
                                    <td><?= $index+1?></td>
                                    <td class="ps-3" style="max-width: 400px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="square-thumbnail">
                                                <?php if (!empty($comment->userImage)) : ?>
                                                <img src="<?= base_url('public/userImage/' . $comment->userImage); ?>"
                                                    alt="Thumbnail" class="img-fluid rounded"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate" style="max-width: 300px;">
                                                    <?= htmlspecialchars($comment->user_name); ?></h6>
                                                    <p class="text-muted mb-0 small text-truncate"
                                                    style="max-width: 300px;">
                                                    <?php
                                                        $user_email = strip_tags(htmlspecialchars_decode($comment->email));
                                                        echo strlen($user_email) > 40 ? substr($user_email, 0, 40) . '...' : $user_email;
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center small">
                                        <?php
                                            $content = strip_tags(htmlspecialchars_decode($comment->user_coment));
                                            echo strlen($content) > 40 ? substr($content, 0, 40) . '...' : $content;
                                        ?>
                                    </td>
                                    
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input custom-toggle status-toggle"
                                                    style="width:40px; height:20px;" type="checkbox" role="switch"
                                                    id="statusSwitch<?= $comment->id; ?>" data-id="<?= $comment->id; ?>"
                                                    <?= $comment->status == 1 ? 'checked' : ''; ?>>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="<?= site_url('AdminController/view_comment/' . $comment->id); ?>"
                                                class="btn btn-outline-primary " title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <!-- <a href="<?= site_url('AdminController/edit_comment/'.$comment->id); ?>"
                                                class="btn btn-outline-warning " title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a> -->
                                            <a href="<?= site_url('AdminController/delete_comment/'.$comment->id); ?>"
                                                class="btn btn-outline-danger  btn-delete-user" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-file-comment fs-1 text-muted"></i>
                                        <p class="text-muted mt-3">No comments available</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table Footer -->
                <div class="card-footer bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Showing <?= count($comments); ?> entries</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<?php include 'layouts/footer.php'; ?>
<script>
    $(document).ready(function() {
        $('.status-toggle').change(function() {
            let commentId = $(this).data('id');
            let status = $(this).prop('checked') ? 1 : 0;
            $.ajax({
                url: "<?= site_url('AdminController/update_comment_status'); ?>",
                type: "comment",
                data: {
                    comment_id: commentId,
                    status: status
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        console.log("Status updated successfully!");
                    } else {
                        console.log("Failed to update status.");
                    }
                },
                error: function(xhr) {
                    console.log("Something went wrong!");
                }
            });
        });
    });
</script>