<?php include 'layouts/header.php'; ?>

<!-- Add these CDNs to your header.php or here -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css">

<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #1cc88a;
        --dark-color: #2c3e50;
        --light-color: #f8f9fc;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Hero Section */
    .hero-section {
        height: 60vh;
        min-height: 600px;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
    }

    /* Animated Carousel */
    .carousel-item {
        transition: transform 1.5s ease, opacity .5s ease !important;
    }

    /* Feature Cards */
    .feature-card {
        transition: all 0.4s ease;
        border: none;
        overflow: hidden;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .feature-card img {
        transition: transform 0.5s ease;
    }

    .feature-card:hover img {
        transform: scale(1.05);
    }

    /* Platform Carousel */
    .platform-carousel {
        width: 100%;
        height: 60vh;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    }

    .platform-carousel .carousel-item img {
        object-fit: cover;
        height: 500px;
    }

    /* Pulse Animation */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    /* Floating Animation */
    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-15px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .floating-animation {
        animation: floating 3s ease-in-out infinite;
    }

    /* Gradient Background */
    .gradient-bg {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .hero-section {
            height: 80vh;
            min-height: 500px;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 70vh;
            min-height: 400px;
        }

        .display-3 {
            font-size: 2.5rem !important;
        }

        .platform-carousel .carousel-item img {
            height: 300px;
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            height: 60vh;
            min-height: 300px;
        }
    }

    /* Custom Button Styles */
    .btn-primary-gradient {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary-gradient:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Section Spacing */
    .section-spacing {
        padding: 100px 0;
    }

    /* Shape Divider */
    .shape-divider {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
    }

    .shape-divider svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 100px;
    }

    .shape-divider .shape-fill {
        fill: #FFFFFF;
    }
</style>

<section class="landing-page-section">
    <!-- Hero Carousel with Animated Text -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-inner">
            <?php if (!empty($main_banners)): ?>
                <?php foreach ($main_banners as $index => $main_banner): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="hero-section"
                            style="background-image: url('<?= base_url('public/WebBannersImage/' . $main_banner->image) ?>')">
                            <div class="hero-content">
                                <div class="container text-white text-center py-5">
                                    <h1 class="display-3 mb-3 fw-bold animate__animated animate__fadeInDown"
                                        data-aos="fade-down" data-aos-delay="300">
                                        <?= htmlspecialchars($main_banner->title) ?>
                                    </h1>
                                    <p class="lead fs-3 mb-4 animate__animated animate__fadeIn" data-aos="fade-up"
                                        data-aos-delay="500">
                                        <?= htmlspecialchars($main_banner->desc) ?>
                                    </p>
                                    <div class="d-flex gap-3 justify-content-center flex-wrap" data-aos="fade-up"
                                        data-aos-delay="700">
                                        <a href="#features" class="btn btn-primary-gradient btn-lg px-4 py-3 pulse-animation">
                                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                                        </a>
                                        <a href="#" class="btn btn-outline-light btn-lg px-4 py-3">
                                            <i class="fas fa-play-circle me-2"></i>Watch Demo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <!-- Fallback Slide -->
                <div class="carousel-item active">
                    <div class="hero-section"
                        style="background-image: url('<?= base_url('public/banners/default-banner.jpg') ?>')">
                        <div class="hero-content">
                            <div class="container text-center text-white">
                                <h1 class="display-3 mb-3 fw-bold animate__animated animate__fadeInDown">Transform Your
                                    Digital Presence</h1>
                                <p class="lead fs-3 mb-4 animate__animated animate__fadeIn">Professional Solutions for
                                    Modern Businesses</p>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="#features"
                                        class="btn btn-primary-gradient btn-lg px-4 py-3 pulse-animation">Start Free
                                        Trial</a>
                                    <a href="#" class="btn btn-outline-light btn-lg px-4 py-3">Watch Demo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Features Section -->
    <div id="features" class="container section-spacing">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 mb-3 fw-bold">Latest Posts</h2>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <p class="text-muted fs-5">Discover our latest insights and updates designed to keep you informed
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <?php if (!empty($latest_posts)): ?>
                <?php foreach ($latest_posts as $index => $latest_post): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="feature-card h-100 rounded-4 p-0">
                            <div class="overflow-hidden" style="height: 200px;">
                                <img src="<?= base_url('public/postImages/' . ($latest_post->thumbnail ?? '')) ?>"
                                    class="img-fluid w-100 h-100" alt="<?= $latest_post->post_title ?>"
                                    style="object-fit: cover;">
                            </div>
                            <div class="p-4">
                                <h3 class="h4 mb-3">
                                    <?php
                                    $content = strip_tags(htmlspecialchars_decode($latest_post->post_title));
                                    echo strlen($content) > 40 ? substr($content, 0, 40) . '...' : $content;
                                    ?>
                                </h3>
                                <p class="text-muted mb-4">
                                    <?php
                                    $content = strip_tags(htmlspecialchars_decode($latest_post->short_desc));
                                    echo strlen($content) > 80 ? substr($content, 0, 80) . '...' : $content;
                                    ?>
                                </p>
                                <a href="<?= site_url('WebController/view_post_by_id/' . $latest_post->slug) ?>"
                                    class="btn btn-outline-primary btn-sm">
                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>

    <!-- Platform Showcase with Animated Carousel -->
    <div class="bg-light position-relative py-4">
        <!-- Shape Divider -->
        <div class="shape-divider position-absolute top-0 start-0 w-100">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,
                82.39-16.72,168.19-17.73,250.45-.39C823.78,
                31,906.67,72,985.66,92.83c70.05,18.48,
                146.53,26.09,214.34,3V0H0V27.35A600.21,
                600.21,0,0,0,321.39,56.44Z" class="shape-fill" fill="green"></path>
            </svg>
        </div>

        <!-- Title Section -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 fw-bold">Our Platform</h2>
            <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                Explore the powerful features that make our platform stand out
            </p>
        </div>

        <!-- Features Section -->
        <div class="container" style="margin-bottom:60px ;">
            <div class="row justify-content-center g-4">
                <!-- Carousel Column -->
                <div class="col-md-6" data-aos="zoom-in-up">
                    <div class="carousel slide rounded-4 overflow-hidden shadow-sm" id="platformCarousel"
                        data-bs-ride="carousel" data-bs-interval="5000">

                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#platformCarousel" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#platformCarousel" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#platformCarousel" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>

                        <!-- Slides -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?= base_url('public/banners/logo3.jpg') ?>" class="d-block w-100"
                                    alt="Feature 1">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                                    <h5>Intuitive Dashboard</h5>
                                    <p>Manage all your activities from one centralized location</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('public/banners/logo7.jpg') ?>" class="d-block w-100"
                                    alt="Feature 2">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                                    <h5>Advanced Analytics</h5>
                                    <p>Get real-time insights into your performance</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('public/banners/logo2.jpg') ?>" class="d-block w-100"
                                    alt="Feature 3">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                                    <h5>Custom Integrations</h5>
                                    <p>Connect with your favorite tools and services</p>
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#platformCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#platformCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Info Card Column -->
                <div class="col-md-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="card shadow-sm p-4 rounded-4 text-center h-100">
                    <div class="text-center mb-5" data-aos="fade-up">
                        <h2 class="display-4 fw-bold">Our Platform</h2>
                        <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                            Explore the powerful features that make our platform stand out
                        </p>
                    </div>
                        <p class="mb-0">
                            On the flip side, IT and auto stocks saw selling pressure. Infosys, Maruti Suzuki, Tech
                            Mahindra,
                            Tata Consumer Products, and Cipla were among the top laggards on the Nifty, dragging the
                            index lower.
                            <br><br>
                            Global cues remained a key overhang, with investors watching developments around US tariffs,
                            geopolitical tensions, and upcoming macroeconomic data. The market’s near-term trajectory is
                            expected
                            to hinge on corporate earnings announcements and signals from global peers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Testimonials Section -->
    <div class="container section-spacing">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 mb-3 fw-bold">What Our Clients Say</h2>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <p class="text-muted fs-5">Trusted by businesses of all sizes around the world</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4 " data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3"
                            width="60" height="60" alt="Client">
                        <div>
                            <h5 class="mb-0">Sarah Johnson</h5>
                            <small class="text-muted">CEO, TechSolutions</small>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <p class="mb-0">"This platform has transformed our business operations. The analytics dashboard
                            alone has saved us countless hours of manual reporting."</p>
                    </div>
                    <div class="mt-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="60"
                            height="60" alt="Client">
                        <div>
                            <h5 class="mb-0">Michael Chen</h5>
                            <small class="text-muted">Marketing Director, GlobalCorp</small>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <p class="mb-0">"The customer support is exceptional. They've helped us customize the platform
                            to fit our unique workflow perfectly."</p>
                    </div>
                    <div class="mt-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3"
                            width="60" height="60" alt="Client">
                        <div>
                            <h5 class="mb-0">Emma Rodriguez</h5>
                            <small class="text-muted">Founder, StartupX</small>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <p class="mb-0">"As a small business, we needed an affordable solution that didn't compromise on
                            features. This was the perfect fit."</p>
                    </div>
                    <div class="mt-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA with Floating Animation -->
    <div class="gradient-bg text-white position-relative section-spacing">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <h2 class="display-4 mb-4 fw-bold">Ready to Transform Your Business?</h2>
                    <p class="lead mb-5">Join thousands of satisfied customers who have already taken their business to
                        the next level</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <a href="#" class="btn btn-light btn-lg px-5 py-3 fw-bold">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                            <i class="fas fa-phone-alt me-2"></i>Contact Sales
                        </a>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Floating elements for decoration -->
        <!-- <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="pointer-events: none;">
            <div class="position-absolute rounded-circle bg-white opacity-10"
                style="width: 300px; height: 300px; top: -50px; left: -50px;"></div>
            <div class="position-absolute rounded-circle bg-white opacity-10 floating-animation"
                style="width: 200px; height: 200px; top: 20%; right: 10%; animation-delay: 0.5s;"></div>
            <div class="position-absolute rounded-circle bg-white opacity-10 floating-animation"
                style="width: 150px; height: 150px; bottom: 10%; left: 20%; animation-delay: 1s;"></div>
        </div> -->
    </div>
</section>

<!-- Required JS Libraries -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

<script>
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Hero carousel animation
    const heroCarousel = document.getElementById('heroCarousel');
    heroCarousel.addEventListener('slide.bs.carousel', event => {
        const activeItem = event.from;
        const nextItem = event.to;

        // Animate out current item
        const activeElements = document.querySelectorAll(`.carousel-item:nth-child(${activeItem + 1}) [data-aos]`);
        activeElements.forEach(el => {
            el.classList.remove('aos-animate');
        });

        // Animate in next item
        setTimeout(() => {
            const nextElements = document.querySelectorAll(`.carousel-item:nth-child(${nextItem + 1}) [data-aos]`);
            nextElements.forEach(el => {
                el.classList.add('aos-animate');
            });
        }, 50);
    });

    // Platform carousel animation
    const platformCarousel = document.getElementById('platformCarousel');
    platformCarousel.addEventListener('slide.bs.carousel', event => {
        const activeItem = event.from;
        const nextItem = event.to;

        // Add your custom animation logic here if needed
    });

    // Simple GSAP animations
    gsap.from(".feature-card", {
        duration: 1,
        y: 50,
        opacity: 0,
        stagger: 0.1,
        ease: "power2.out"
    });
</script>

<?php include 'layouts/footer.php'; ?>