

<?php
// echo "<pre>";
// print_r($this->router->routes);
// echo "</pre>";
// exit;
include 'layouts/header.php'; ?>

<style>
    .registration-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
        background-image: url("<?php echo base_url('public/banners/logo6.jpg'); ?>");
        background-size: cover;
        background-position: center;
    }
    .registration-card {
        border:2px solid #b942f5;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
        /* transition: transform 0.3s ease; */
        background: white;
    }

    /* .registration-card:hover {
        transform: translateY(-5px);
    } */

    .banner-image {
        height: 100%;
        object-fit: cover;
    }

    .form-card {
        padding: 40px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #80bdff;
    }

    .upload-container {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .upload-container:hover {
        border-color: #0d6efd;
    }

    .upload-input {
        display: none;
    }

    .upload-icon {
        font-size: 2rem;
        color: #6c757d;
    }

    .upload-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        margin-top: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .registration-card {
            flex-direction: column;
        }

        .banner-image {
            display: none;
        }

        .form-card {
            padding: 30px;
        }

        .upload-container {
            padding: 15px;
        }
    }
</style>

<section class="registration-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="registration-card d-flex flex-column flex-md-row">
                    <!-- Banner Image -->
                    <div class="col-md-6 d-none d-md-block">
                        <img src="<?php echo base_url('public/banners/reg_banner.jpg'); ?>" alt="Registration Banner"
                            class="banner-image w-100">
                    </div>

                    <!-- Registration Form -->
                    <div class="col-md-6">
                        <div class="form-card">
                            <h2 class="mb-4 text-center">Create Account</h2>
                            <div class="text-start">
                                <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo $this->session->flashdata('success'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <?php endif; ?>

                                <!-- Form Validation Errors -->
                                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                            </div>

                            <?php echo form_open_multipart(site_url('WebController/add_user')); ?>




                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="name@example.com" required>
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

                            <!-- Image Upload -->
                            <!-- <div class="mb-4">
                                <label class="form-label">Profile Image</label>
                                <div class="upload-container" onclick="document.getElementById('fileInput').click()">
                                    <i class="bi bi-cloud-upload upload-icon"></i>
                                    <p class="mb-0 text-muted">Click to upload photo</p>
                                    <input type="file" class="upload-input" id="fileInput" name="profile_image"
                                        accept="image/*">
                                    <div class="upload-preview"></div>
                                </div>
                            </div> -->

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Create Account
                            </button>

                            <p class="text-center mb-0">
                                Already have an account?
                                <a href="<?php echo site_url('WebController/login'); ?>"
                                    class="text-decoration-none">Login here</a>
                            </p>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/footer.php'; ?>
