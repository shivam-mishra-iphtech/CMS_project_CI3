<?php include 'layouts/sidebar.php'?>

<!-- Main content -->
<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'?>
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
                            <table class="table table-hover table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th>S.N.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th class="text-center" scope="col">Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)) : ?>
                                    <?php foreach ($users as $index => $user) : ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <img alt="..."
                                                src="https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                                class="avatar avatar-sm rounded-circle me-2">
                                            <a class="text-heading font-semibold" href="#">
                                                <?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= site_url('AdminController/user_profile/' . $user->id); ?>"
                                                class="btn btn-sm btn-neutral">View</a>
                                            <a href="<?= site_url('AdminController/edit_user/'.$user->id); ?>"
                                                class="btn btn-sm btn-neutral">
                                                <i class="bi bi-pen"></i>
                                            </a>

                                            <!-- <a href="<?= site_url('AdminController/delete_user/'.$user->id); ?>"
                                                class="btn btn-sm btn-neutral">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                            <a href="<?= site_url('AdminController/delete_user/'.$user->id); ?>"
                                                class="btn btn-sm btn-neutral btn-delete-user">
                                                <i class="bi bi-trash"></i>
                                            </a>

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
                        <div class="card-footer border-0 py-5">
                            <span class="text-muted text-sm">Showing 10 items out of 250 results found</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </header>
</div>
<?php include 'layouts/footer.php'?>