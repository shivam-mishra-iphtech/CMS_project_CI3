<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-surface-primary border-bottom pt-6">
        <div class="container-fluid">
            <div class="mb-npx">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                        <h1 class="h2 mb-0 ls-tight p-4">Add New User</h1>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <!-- Flash Messages -->
                <div class="text-start">
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <!-- Validation Errors -->
                    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                </div>

                <!-- User Registration Form -->
                <?= form_open_multipart('AdminController/add_new_user'); ?>
                
                    <label for="user_role" class="form-label">User Role</label>
                    <select class="form-select form-control-sm shadow-none mb-3" name="user_role" required>
                        <option value="">Select Category</option>
                        <option value="0">User</option>
                        <option value="1"> Editor</option>
                    </select>
              

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Create password" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Confirm password" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary mb-3">Add User</button>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>