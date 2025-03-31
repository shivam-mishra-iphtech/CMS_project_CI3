<?php include 'layouts/header.php'; ?>
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center shadow-lg p-4">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal"
                        class="btn btn-light btn-sm shadow-sm">
                        <i class="bi bi-pen"></i>
                    </a>
                </div>
                <div class="card-body">
                    <img src="<?php echo base_url('public/userImage/' . (!empty($user_image) ? $user_image : 'default.png')); ?>"
                        alt="User Profile" class="img-fluid rounded-circle shadow profile-image">
                    <h3 class="mt-3"><?php echo !empty($user->name) ? $user->name : 'N/A'; ?></h3>
                    <p class="text-muted"><?php echo !empty($user->email) ? $user->email : 'N/A'; ?></p>
                    <div class="">
                    <small>
                        <a class="btn text-primary" href="#" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">Change Password</a>
                    </small>
                </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap 5 Modal -->
<div class=" w-80 modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart(site_url('WebController/update_user')); ?>
                <input type="hidden" name="user_id" value="<?php echo $user->id ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo !empty($user->name) ? $user->name : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo !empty($user->email) ? $user->email : ''; ?>" required>
                </div>
                <div class="mb-4 text-center">
                    <label class="form-label d-block">Profile Image</label>
                    <div class="upload-container position-relative d-inline-block p-2 border rounded"
                        onclick="document.getElementById('fileInput').click()"
                        style="width: 150px; height: 150px; cursor: pointer; background: #f8f9fa;">

                        <!-- Image Preview -->
                        <img id="imagePreview"
                            src="<?php echo base_url('public/userImage/' . (!empty($user_image) ? $user_image : 'default.png')); ?>"
                            class="img-fluid rounded-circle shadow"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">

                        <!-- Hidden File Input -->
                        <input type="file" class="d-none" id="fileInput" name="profile_image" accept="image/*"
                            onchange="previewImage(event)">
                    </div>
                    <p class="text-muted mt-2">Click to change photo</p>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- --------- change password ------------ -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('WebController/change_password'); ?>
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

<!-- Bootstrap 5 JS (Required for Modal) -->

<!-- CSS for Image Styling -->
<style>
    .profile-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>