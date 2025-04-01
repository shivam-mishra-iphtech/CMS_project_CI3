<?php include 'layouts/header.php'; ?>
    <style>
        .custom-bg {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }
        .team-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .value-icon {
            width: 60px;
            height: 60px;
        }
    </style>

    <!-- Hero Section -->
    <section class="custom-bg text-white py-5">
        <div class="container">
            <div class="row text-center py-5">
                <div class="col-12">
                    <h1 class="display-4 fw-bold mb-3">About TechSolutions</h1>
                    <p class="lead mb-4">Pioneering digital solutions since 2015</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" alt="Our Story" class="img-fluid rounded-3">
                </div>
                <div class="col-md-6">
                    <h2 class="text-primary mb-4">Our Story</h2>
                    <p class="lead">Founded in 2015, TechSolutions started as a small team of passionate developers. Today, we're a global leader in digital transformation, serving clients across 15 countries.</p>
                    <p>Our journey began with a simple mission: to make technology accessible and beneficial for everyone. Through innovation and dedication, we've helped over 500 businesses achieve their digital goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Do Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6 order-md-2">
                    <img src="<?php echo base_url('public/banners/logo3.jpg'); ?>" alt="Our Work" class="img-fluid rounded-3">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="text-primary mb-4">What We Do</h2>
                    <p class="lead">We specialize in creating tailored digital solutions that drive business growth.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i>Custom Software Development</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i>Cloud Solutions & Migration</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i>AI & Machine Learning Solutions</li>
                        <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i>Cybersecurity Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="text-primary">Our Leadership</h2>
                    <p class="lead">Meet the visionaries driving our success</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 team-card">
                        <img src="<?php echo base_url('public/banners/logo6.jpg'); ?>" class="card-img-top" alt="CEO">
                        <div class="card-body">
                            <h5 class="card-title">John Smith</h5>
                            <p class="text-muted">CEO & Founder</p>
                        </div>
                    </div>
                </div>
                <!-- Add more team members similarly -->
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="text-primary">Our Core Values</h2>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-3">
                        <div class="card-body">
                            <div class="value-icon bg-primary text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-lightbulb fs-4 mt-3"></i>
                            </div>
                            <h5>Innovation</h5>
                            <p class="text-muted">Pushing boundaries in technology</p>
                        </div>
                    </div>
                </div>
                <!-- Add more values similarly -->
            </div>
        </div>
    </section>
    <?php include 'layouts/footer.php'; ?>

   