<?php include 'layouts/header.php';?>

<!-- Add custom CSS for enhanced design -->
<style>
    .landing-page-section {
        overflow-x: hidden;
    }
    .hero-section {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                    url('<?php echo base_url('public/banners/hero-bg.jpg'); ?>');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 120px 0;
        border-radius: 15px;
    }
    .feature-card {
        transition: transform 0.3s;
        border: none;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .feature-card:hover {
        transform: translateY(-10px);
    }
    .testimonial-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin: 10px;
    }
    .pricing-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s;
    }
    .pricing-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .highlight-card {
        transform: scale(1.05);
        background: #4a90e2;
        color: white;
    }
    .image-carousel {
        height: 50vh;
        object-fit: contain;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
</style>

<section class="landing-page-section">
    <!-- Hero Section -->
    <div class="container-fluid px-0">
        <div class="hero-section text-center">
            <div class="container">
                <h1 class="display-4 mb-4 fw-bold">Transform Your Digital Experience</h1>
                <p class="lead mb-4 fs-5">Join 50,000+ businesses accelerating their growth with our platform</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-light btn-lg px-5 py-3 me-3">Start Free Trial</a>
                    <a href="#" class="btn btn-outline-light btn-lg px-5 py-3">Watch Demo</a>
                </div>
                <div class="trust-badges mt-5">
                    <img src="<?php echo base_url('public/banners/logo1.jpg'); ?>" class="img-fluid" style="height: 40px" alt="Trusted by companies">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6">Why Choose Us?</h2>
                <p class="text-muted">Discover features designed to boost your productivity</p>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card shadow">
                    <div class="icon-wrapper bg-primary mb-3">
                        <i class="fas fa-bolt fa-3x text-white"></i>
                    </div>
                    <h3>Lightning Fast</h3>
                    <p class="text-muted">Optimized infrastructure delivers 99.9% uptime and instant response times</p>
                    <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" class="img-fluid" alt="Performance chart">
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card shadow">
                    <div class="icon-wrapper bg-success mb-3">
                        <i class="fas fa-shield-alt fa-3x text-white"></i>
                    </div>
                    <h3>Bank-grade Security</h3>
                    <p class="text-muted">256-bit encryption and GDPR compliance ensure your data stays safe</p>
                    <img src="<?php echo base_url('public/banners/logo6.jpg'); ?>" class="img-fluid" alt="Security shield">
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card shadow">
                    <div class="icon-wrapper bg-info mb-3">
                        <i class="fas fa-rocket fa-3x text-white"></i>
                    </div>
                    <h3>Scalable Solutions</h3>
                    <p class="text-muted">Grow from startup to enterprise without switching platforms</p>
                    <img src="<?php echo base_url('public/banners/logo1.jpg'); ?>" class="img-fluid" alt="Scaling graph">
                </div>
            </div>
        </div>
    </div>

    <!-- Image Carousel -->
    <div class=" w-50 container py-5">
        <div class="image-carousel ">
            <div id="platformCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo base_url('public/banners/logo3.jpg'); ?>" class="d-block w-100 img-fluid carousel-img" alt="Dashboard">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo base_url('public/banners/logo2.jpg'); ?>" class="d-block w-100 img-fluid carousel-img" alt="Mobile View">
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .carousel-img {
        height: 50vh;
        object-fit: contain; /* Ensures the whole image is visible without being cut */
    }
</style>


    <!-- Pricing Section -->
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-12 text-center mb-5">
                <h2 class="display-6">Simple, Transparent Pricing</h2>
                <p class="text-muted">Start free, upgrade as you grow</p>
            </div>

            <div class="col-md-4">
                <div class="pricing-card shadow p-4">
                    <h4>Starter</h4>
                    <div class="price display-4">$29</div>
                    <small class="text-muted">per month</small>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Up to 10 users</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>50GB storage</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Basic analytics</li>
                    </ul>
                    <a href="#" class="btn btn-outline-primary w-100">Start Free Trial</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pricing-card shadow p-4 highlight-card">
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">Most Popular</span>
                    <h4>Professional</h4>
                    <div class="price display-4">$99</div>
                    <small class="text-muted">per month</small>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-white me-2"></i>Up to 50 users</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-white me-2"></i>500GB storage</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-white me-2"></i>Advanced analytics</li>
                    </ul>
                    <a href="#" class="btn btn-light w-100">Get Started</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="pricing-card shadow p-4">
                    <h4>Enterprise</h4>
                    <div class="price display-4">$299</div>
                    <small class="text-muted">per month</small>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Unlimited users</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>2TB storage</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i>Premium support</li>
                    </ul>
                    <a href="#" class="btn btn-outline-primary w-100">Contact Sales</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA -->
    <div class="container-fluid bg-dark text-white py-5 mt-5">
        <div class="container text-center">
            <h2 class="display-6 mb-4">Ready to Get Started?</h2>
            <p class="lead mb-5">Join thousands of satisfied customers today</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="btn btn-light btn-lg px-5">Start Free Trial</a>
                <a href="#" class="btn btn-outline-light btn-lg px-5">Schedule Demo</a>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/footer.php';?>