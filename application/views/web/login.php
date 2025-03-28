<?php include 'layouts/header.php';?>

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
        padding: 50px;
    }

    .form-control {
        border-radius: 8px;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .btn-primary {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 30px;
        }

        .banner-image {
            display: none;
        }
    }
</style>

<section class="registration-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="registration-card">
                    <div class="row g-0">
                        <!-- Banner Image -->
                        <div class="col-md-6 d-none d-md-block">
                            <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>"
                                alt="Registration Banner" class="banner-image w-100">
                        </div>

                        <!-- Login Form -->
                        <div class="col-md-6">
                            <div class="form-card">
                                <h2 class="text-center mb-4">Login</h2>

                                <?php echo form_open('WebController/login_user'); ?>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="name@example.com" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Enter password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        Login Now
                                    </button>
                                    <?php echo form_close(); ?>

                                <p class="text-center mt-3">
                                    Don't have an account?
                                    <a href="<?php echo site_url('WebController/registration'); ?>"
                                        class="text-decoration-none">
                                        Create Account
                                    </a>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/footer.php';?>