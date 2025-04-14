
<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->

<div class="d-flex flex-column flex-grow-1 h-100 ">
    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-surface-primary border-bottom py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Page List</h1>
                <a href="<?= site_url('AdminController/add_page'); ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg "></i>Add New Page
                </a>
            </div>

            <!-- Posts Table Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="pageListTable"  class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="">Title</th>
                                    <!-- <th class="text-center">Category</th> -->
                                    <th class="text-center">Publish</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                <tr class="border-top">
                                    <td class="ps-3" style="max-width: 400px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="square-thumbnail">
                                                <?php if (!empty($page->image_1)) : ?>
                                                <img src="<?= base_url('public/pageImages/' . $page->image_1); ?>"
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
                                                    <?= htmlspecialchars($page->page_title); ?></h6>
                                                <p class="text-muted mb-0 small text-truncate"
                                                    style="max-width: 300px;">
                                                    <?php
                                                        $content = strip_tags(json_decode($page->page_content));
                                                        echo strlen($content) > 40 ? substr($content, 0, 40) . '...' : $content;
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- <td class="text-center small">
                                        <span style="font-size:13px ; color: green;" class="badge bg-info bg-opacity-10">
                                            <?= $page->category_name  ?>
                                        </span>
                                    </td> -->
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input custom-toggle status-toggle"
                                                    style="width:40px; height:20px;" type="checkbox" role="switch"
                                                    id="statusSwitch<?= $page->id; ?>" data-id="<?= $page->id; ?>"
                                                    <?= $page->status == 1 ? 'checked' : ''; ?>>
                                            </div>
                                        </div>
                                    </td>

                                    

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="<?= site_url('AdminController/view_page/' . $page->id); ?>"
                                                class="btn btn-outline-primary " title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= site_url('AdminController/edit_page/'.$page->id); ?>"
                                                class="btn btn-outline-warning " title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a id="delete_page" data-id="<?=$page->id?>" href=""
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
                        <span class="text-muted small">Showing <?= count($pages); ?> entries</span>
                       
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
            let postId = $(this).data('id');  
            let status = $(this).prop('checked') ? 1 : 0; 

           
            $.ajax({
                url: "<?= site_url('AdminController/update_page_status'); ?>",  
                type: "POST",  
                data: {
                    post_id: postId,  
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
<script>
    $(document).ready(function() {
    $(document).on('click', '.btn-delete-user', function(e) {
        e.preventDefault(); // Prevent default behavior

        let pageId = $(this).data('id'); // Get the page ID
        if (!pageId) {
            console.log("Page ID is missing!");
            return;
        }

        // Call the existing SweetAlert confirmation function
        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to delete this post?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, execute AJAX request
                $.ajax({
                    url: "<?= site_url('AdminController/delete_page'); ?>",  
                    type: "POST",  
                    data: { page_id: pageId },
                    dataType: "json",  
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire("Deleted!", "The page has been deleted.", "success")
                                // .then(() => {
                                //     location.reload(); 
                                // });
                        } else {
                            Swal.fire("Error!", "Failed to delete the page.", "error");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    }
                });
            }
        });
    });
});


    
</script>



<script>
    $(document).ready(function() {
        $('#pageListTable').DataTable({
            "dom": '<"dt-buttons"Bf><"clear">lirtp',
            "paging": true,
            "autoWidth": true,
            "buttons": [
                'colvis',
                'copyHtml5',
                'csvHtml5',
                'excelHtml5',
                'pdfHtml5',
                'print'
            ]
        });
    });
</script>



