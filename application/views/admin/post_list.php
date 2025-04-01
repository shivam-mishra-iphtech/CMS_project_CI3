
<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="d-flex flex-column flex-grow-1 h-100 overflow-hidden">
    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-surface-primary border-bottom py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Posts List</h1>
                <a href="<?= site_url('AdminController/add_post'); ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg "></i>Add New Post
                </a>
            </div>

            <!-- Posts Table Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="">Title</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Publish</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($posts)) : ?>
                                <?php foreach ($posts as $post) : ?>
                                <tr class="border-top">
                                    <td class="ps-3" style="max-width: 400px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="square-thumbnail">
                                                <?php if (!empty($post->thumbnail)) : ?>
                                                <img src="<?= base_url('public/postImages/' . $post->thumbnail); ?>"
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
                                                    <?= htmlspecialchars($post->post_title); ?></h6>
                                                <p class="text-muted mb-0 small text-truncate"
                                                    style="max-width: 300px;">
                                                    <?php
                                                        $content = strip_tags(htmlspecialchars_decode($post->content));
                                                        echo strlen($content) > 40 ? substr($content, 0, 40) . '...' : $content;
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center small">
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <?= $post->category == 1 ? 'Latest' : 'Trending'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input custom-toggle status-toggle"
                                                    style="width:40px; height:20px;" type="checkbox" role="switch"
                                                    id="statusSwitch<?= $post->id; ?>" data-id="<?= $post->id; ?>"
                                                    <?= $post->status == 1 ? 'checked' : ''; ?>>
                                            </div>
                                        </div>
                                    </td>

                                    

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="<?= site_url('AdminController/view_post/' . $post->id); ?>"
                                                class="btn btn-outline-primary " title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= site_url('AdminController/edit_post/'.$post->id); ?>"
                                                class="btn btn-outline-warning " title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= site_url('AdminController/delete_post/'.$post->id); ?>"
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
                                        <i class="bi bi-file-post fs-1 text-muted"></i>
                                        <p class="text-muted mt-3">No posts available</p>
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
                        <span class="text-muted small">Showing <?= count($posts); ?> entries</span>
                        <!-- Add pagination here if needed -->
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>


<?php include 'layouts/footer.php'; ?>
<script>
    $(document).ready(function() {
        // Event listener for status toggle switch change
        $('.status-toggle').change(function() {
            let postId = $(this).data('id');  // Get the post ID
            let status = $(this).prop('checked') ? 1 : 0;  // Determine new status

            // Send AJAX request to update post status
            $.ajax({
                url: "<?= site_url('AdminController/update_post_status'); ?>",  // Update URL
                type: "POST",  // POST request method
                data: {
                    post_id: postId,  // Send post ID
                    status: status    // Send new status value (1 for active, 0 for inactive)
                },
                dataType: "json",  // Expecting a JSON response
                success: function(response) {
                    // Optionally handle any post-response actions (if needed)
                    if (response.status === "success") {
                        // Optional: You can use something else to notify the user if needed
                        console.log("Status updated successfully!");
                    } else {
                        // Optional: Handle failure case
                        console.log("Failed to update status.");
                    }
                },
                error: function(xhr) {
                    // If the AJAX request fails, you can still log or handle the error
                    console.log("Something went wrong!");
                }
            });
        });
    });
</script>


