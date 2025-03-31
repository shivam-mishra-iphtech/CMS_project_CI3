<?php include 'layouts/header.php';?>

<style>
    /* Enhanced Custom CSS */
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.1)), 
                    url('<?php echo base_url('public/banners/hero-bg.jpg'); ?>');
        background-size: cover;
        background-position: center;
        padding: 8rem 0;
        position: relative;
    }

    .feature-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 15px;
        padding: 2rem;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .pricing-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }

    .carousel-container {
        height: 60vh;
        border-radius: 15px;
        overflow: hidden;
    }

    .carousel-img {
        height: 60vh;
        object-fit: cover;
    }

    .highlight-card {
        position: relative;
        z-index: 1;
        background: linear-gradient(135deg, #4a90e2, #2f5d9e);
        color: white;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 4rem 0;
        }
        
        .display-4 {
            font-size: 2.5rem;
        }
        
        .carousel-container {
            height: 40vh;
        }
        
        .carousel-img {
            height: 40vh;
        }
        
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
        
        .trust-badges img {
            max-width: 80%;
        }
    }

    @media (max-width: 576px) {
        .cta-buttons .btn {
            width: 100%;
            margin: 10px 0;
        }
        
        .feature-card {
            margin: 1rem 0;
        }
        
        .pricing-card {
            margin: 1rem 0;
        }
    }
</style>

<section class="landing-page-section">
    <!-- Hero Section -->
    <div class="container-fluid px-0">
        <div class="hero-section text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <h1 class="display-4 mb-4 fw-bold">Transform Your Digital Experience</h1>
                        <p class="lead mb-4 fs-5">Join 50,000+ businesses accelerating their growth</p>
                        <div class="cta-buttons d-flex flex-wrap justify-content-center gap-3">
                            <a href="#" class="btn btn-light btn-lg px-5 py-3">Start Free Trial</a>
                            <a href="#" class="btn btn-outline-light btn-lg px-5 py-3">Watch Demo</a>
                        </div>
                        <!-- <div class="trust-badges mt-5">
                            <img src="<?php echo base_url('public/banners/logo2.jpg'); ?>" class="img-fluid" style="max-height: 45px" alt="Trusted companies">
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6 mb-3">Why Choose Us?</h2>
                <p class="text-muted fs-5">Discover features designed to boost your productivity</p>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card shadow">
                    <h3 class="mb-3">Lightning Fast</h3>
                    <p class="text-muted mb-4">Optimized infrastructure delivers 99.9% uptime</p>
                    <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" class="img-fluid rounded-3" alt="Performance">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card shadow">
                    <h3 class="mb-3">Lightning Fast</h3>
                    <p class="text-muted mb-4">Optimized infrastructure delivers 99.9% uptime</p>
                    <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" class="img-fluid rounded-3" alt="Performance">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card shadow">
                    <h3 class="mb-3">Lightning Fast</h3>
                    <p class="text-muted mb-4">Optimized infrastructure delivers 99.9% uptime</p>
                    <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" class="img-fluid rounded-3" alt="Performance">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card shadow">
                    <h3 class="mb-3">Lightning Fast</h3>
                    <p class="text-muted mb-4">Optimized infrastructure delivers 99.9% uptime</p>
                    <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" class="img-fluid rounded-3" alt="Performance">
                </div>
            </div>

            
        </div>
    </div>

    <!-- Image Carousel -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="carousel-container shadow">
                    <div id="platformCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item active h-100">
                                <img src="<?php echo base_url('public/banners/logo3.jpg'); ?>" class="d-block w-100 carousel-img" alt="Dashboard">
                            </div>
                            <div class="carousel-item active h-100">
                                <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" class="d-block w-100 carousel-img" alt="Dashboard">
                            </div>
                            <div class="carousel-item active h-100">
                                <img src="<?php echo base_url('public/banners/logo2.jpg'); ?>" class="d-block w-100 carousel-img" alt="Dashboard">
                            </div>
                            <!-- Add other carousel items -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#platformCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#platformCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6 mb-3">Simple, Transparent Pricing</h2>
                <p class="text-muted fs-5">Start free, upgrade as you grow</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="pricing-card shadow p-4 h-100">
                    <h4 class="mb-4">Starter</h4>
                    <div class="price display-4 mb-3">$29</div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Up to 10 users</li>
                        <!-- Other list items -->
                    </ul>
                    <a href="#" class="btn btn-outline-primary w-100 mt-auto">Start Trial</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="pricing-card shadow p-4 h-100">
                    <h4 class="mb-4">Starter</h4>
                    <div class="price display-4 mb-3">$29</div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Up to 10 users</li>
                        <!-- Other list items -->
                    </ul>
                    <a href="#" class="btn btn-outline-primary w-100 mt-auto">Start Trial</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="pricing-card shadow p-4 h-100">
                    <h4 class="mb-4">Starter</h4>
                    <div class="price display-4 mb-3">$29</div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Up to 10 users</li>
                        <!-- Other list items -->
                    </ul>
                    <a href="#" class="btn btn-outline-primary w-100 mt-auto">Start Trial</a>
                </div>
            </div>

            <!-- Repeat for other pricing cards -->
        </div>
    </div>

    <!-- Final CTA -->
    <div class="container-fluid bg-dark text-white py-5">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <h2 class="display-6 mb-4">Ready to Get Started?</h2>
                    <p class="lead mb-5">Join thousands of satisfied customers today</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#" class="btn btn-light btn-lg px-5 py-3">Start Free Trial</a>
                        <a href="#" class="btn btn-outline-light btn-lg px-5 py-3">Schedule Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/footer.php';?>