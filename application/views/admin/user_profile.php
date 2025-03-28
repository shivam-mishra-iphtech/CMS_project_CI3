<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <!-- Header Section -->
    <header class="bg-surface-primary border-bottom pt-4 pb-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <?php if($user->role==2){?>
                <div class="col-12">
                    <h1 class="h2 ls-tight text-center text-md-start p-3">Admin Profile</h1>
                </div>
                <?php }else {?>
                <div class="col-12">
                    <h1 class="h2 ls-tight text-center text-md-start p-3">User Profile</h1>
                </div>
                <?php }?>

            </div>
            <hr>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container py-4">
        <div class="card shadow-lg">
            <div class="card-body">
                <!-- Flash Messages -->
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

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between flex-wrap">
                    <a href="<?= site_url('AdminController/user_list'); ?>" class="btn btn-secondary mb-2">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                    <a href="<?= site_url('AdminController/edit_user/'.$user->id); ?>" class="btn btn-primary mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                </div>
                

                <!-- User Profile Section -->
                <div class="row align-items-center text-center text-md-start mt-4">

                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="d-flex justify-content-center">
                            <img src="<?php echo base_url('public/userImage/' . (!empty($user_image) ? $user_image : 'default.png')); ?>"
                                class="img-fluid rounded-circle shadow-lg" alt="User Profile"
                                style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                    </div>

                    <!-- User Details Column -->
                    <div class="col-md-8">
                        <h1 class="display-6 mb-3"><?= $user->name; ?></h1>

                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-3">
                                <i class="fas fa-envelope fa-lg text-primary me-3"></i>
                                <p class="lead mb-0"><?= $user->email; ?></p>
                            </div>

                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                <i class="fas fa-calendar-alt fa-lg text-primary me-3"></i>
                                <p class="lead mb-0">Member since <?= date('F Y', strtotime($user->created_at)); ?></p>
                            </div>
                            <small class="text-muted d-block mt-1 text-center text-md-start">
                                Account created <?= date('d M Y', strtotime($user->created_at)); ?>
                            </small>
                            <?php if ($user->role==2){?>
                            <div class="d-flex">
                                <small>
                                    <a class="btn text-primary" href="#" data-bs-toggle="modal"
                                        data-bs-target="#changePasswordModal">Change Password</a>
                                </small>
                            </div>
                            <?php }else{ echo '';}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('AdminController/change_password'); ?>
                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>"
                        value="<?=$this->security->get_csrf_hash();?>">

                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password"
                            required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>