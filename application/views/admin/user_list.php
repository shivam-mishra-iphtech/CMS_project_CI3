<?php include 'layouts/sidebar.php'; ?>

<!-- Main content -->
<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>
    <!-- Header -->
    <header class="bg-surface-primary border-bottom pt-6">
        <div class="container-fluid">
            <div class="mb-npx">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                        <!-- Title -->
                        <h1 class="h2 mb-0 ls-tight p-4">Users List</h1>
                    </div>
                    <hr>
                    <div class="card shadow border-0 mb-7">
                        <div class="table-responsive">
                            <table id="userDataTable" class="table table-hover table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        <th class="text-center" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)) : ?>
                                        <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td>
                                                    <img alt="Profile"
                                                        src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                                        class="avatar avatar-sm rounded-circle me-2">
                                                    <a class="text-heading font-semibold" href="#">
                                                        <?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td>
                                                    
                                                    <?php if($user->role ==0 ): echo"User"; else: echo "Editor"; endif   ?>
                                                </td>
                                               
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="<?= site_url('AdminController/user_profile/' . $user->id); ?>"
                                                            class="btn btn-outline-primary " title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="<?= site_url('AdminController/edit_user/' .$user->id); ?>"
                                                            class="btn btn-outline-warning " title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="<?= site_url('AdminController/delete_user/' .$user->id); ?>"
                                                            class="btn btn-outline-danger  btn-delete-user" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No users found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<?php include 'layouts/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#userDataTable').DataTable({
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
