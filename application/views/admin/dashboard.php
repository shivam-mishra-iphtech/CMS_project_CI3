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
                        <h1 class="h2 mb-0 ls-tight p-4">Application</h1>
                    </div>

                </div>

            </div>
        </div>
    </header>
    <!-- Main -->
    <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
            <!-- Card stats -->
            <div class="row g-6 mb-6">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Budget</span>
                                    <span class="h3 font-bold mb-0">$750.90</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 mb-0 text-sm">
                                <span class="badge badge-pill bg-soft-success text-success me-2">
                                    <i class="bi bi-arrow-up me-1"></i>13%
                                </span>
                                <span class="text-nowrap text-xs text-muted">Since last month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">New projects</span>
                                    <span class="h3 font-bold mb-0">215</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 mb-0 text-sm">
                                <span class="badge badge-pill bg-soft-success text-success me-2">
                                    <i class="bi bi-arrow-up me-1"></i>30%
                                </span>
                                <span class="text-nowrap text-xs text-muted">Since last month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Total hours</span>
                                    <span class="h3 font-bold mb-0">1.400</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 mb-0 text-sm">
                                <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                    <i class="bi bi-arrow-down me-1"></i>-5%
                                </span>
                                <span class="text-nowrap text-xs text-muted">Since last month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Work load</span>
                                    <span class="h3 font-bold mb-0">95%</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                        <i class="bi bi-minecart-loaded"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 mb-0 text-sm">
                                <span class="badge badge-pill bg-soft-success text-success me-2">
                                    <i class="bi bi-arrow-up me-1"></i>10%
                                </span>
                                <span class="text-nowrap text-xs text-muted">Since last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            

            <div class="card shadow border-0 mb-7">
                <div class="card-header">
                    <h5 class="mb-0">Applications</h5>
                </div>
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
                                    <a href="<?= site_url('AdminController/user_profile/' . $user->id); ?>" class="btn btn-sm btn-neutral">View</a>
                                    <a href="<?= site_url('AdminController/edit_user/'.$user->id); ?>" class="btn btn-sm btn-neutral">
                                        <i class="bi bi-pen"></i>
                                    </a>

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
    </main>
</div>
</div>
<?php include 'layouts/footer.php'?>