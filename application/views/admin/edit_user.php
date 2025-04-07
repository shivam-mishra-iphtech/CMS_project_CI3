<?php include 'layouts/sidebar.php'; ?>

<div class="h-screen flex-grow-1 overflow-y-lg-auto">
    <?php include 'layouts/header.php'; ?>

    <header class="bg-surface-primary border-bottom py-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
            
                <h1 class="h2 mb-0 ls-tight">
                    <?php if($user->role != 0): ?>
                        Edit Your Profile
                    <?php else: ?>
                    Edit User Data
                    <?php endif?>

                </h1>
                <a href="<?= site_url('AdminController/user_list'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </header>

    <div class="container  mt-5">
        <div class="card shadow border-0">
            <div class="card-body p-4">

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (validation_errors()): ?>
                <div class="alert alert-warning alert-dismissible fade show">
                    <?= validation_errors(); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Form -->
                <?= form_open_multipart('AdminController/update_user'); ?>
                <input type="hidden" name="user_id" value="<?= isset($user->id) ? $user->id : ''; ?>">

                <div class="row">
                <?php if($user->role != 2): ?>
                    <label for="user_role" class="form-label">User Role</label>
                    <select class="form-select form-control-sm shadow-none mb-3" name="user_role" required>
                        <option value="">Select Category</option>
                        <option value="0" <?= set_select('user_role', '0', isset($user->role) && $user->role == 0); ?>>
                            User</option>
                        <option value="1" <?= set_select('user_role', '1', isset($user->role) && $user->role == 1); ?>>
                            Editor</option>
                    </select>
                    <?php endif ?>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= set_value('name', isset($user->name) ? $user->name : ''); ?>"
                                placeholder="Enter your name" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= set_value('email', isset($user->email) ? $user->email : ''); ?>"
                                placeholder="name@example.com" required>
                        </div>
                    </div>
                </div>
                <?php if($user->role!=0   ): ?>
                <div class=" w-50 mb-4">
                    <label class="form-label">Profile Image</label>
                    <div class="upload-container text-center p-3 border rounded"
                        onclick="document.getElementById('fileInput').click()"
                        style="cursor: pointer; background: #f8f9fa;">
                        <i class="bi bi-cloud-upload upload-icon display-4 text-muted"></i>
                        <p class="mb-0 text-muted">Click to upload photo</p>
                        <input type="file" class="upload-input d-none" id="fileInput" name="profile_image"
                            accept="image/*" onchange="previewImage(event)">
                        <div class="upload-preview mt-2">
                            <?php if (!empty($user->profile_image)): ?>
                            <img src="<?= base_url('uploads/'.$user->profile_image); ?>" id="imagePreview" class=""
                                style="width: 80px; height: 80px;">
                            <?php else: ?>
                            <img id="imagePreview" class="d-none" style="width: 100px; height: 120px;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>

<script>
    function previewImage(event) {
        const image = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    }
</script>