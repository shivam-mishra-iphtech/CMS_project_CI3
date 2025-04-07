<?php include 'layouts/header.php'; ?>

<style>
    /* Minimal Custom CSS */
    .hero-section {
        height: 60vh;
        min-height: 400px;
        background-size: cover;
        background-position: center;
    }

    .carousel-item {
        transition: opacity 1s ease-in-out !important;
    }

    .feature-card {
        transition: transform 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 50vh;
            min-height: 300px;
        }

        .display-3 {
            font-size: 2.5rem !important;
        }
    }
</style>

<section class="landing-page-section">
    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php if(!empty($main_banners)): ?>
            <?php foreach($main_banners as $index => $main_banner): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="hero-section d-flex align-items-center"
                    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= base_url('public/WebBannersImage/' . $main_banner->image) ?>')">
                    <div class="container text-white text-center py-5">
                        <h1 class="display-3 mb-0 fw-bold"><?= htmlspecialchars($main_banner->title) ?></h1>
                        <p class="lead fs-4 mb-4"><?= htmlspecialchars($main_banner->desc) ?></p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="#" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-rocket me-2"></i>Start Free Trial
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-play-circle me-2"></i>Watch Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
            <?php else: ?>
            <!-- Fallback Slide -->
            <div class="carousel-item active">
                <div class="hero-section d-flex align-items-center"
                    style="background-image: url('<?= base_url('public/banners/default-banner.jpg') ?>')">
                    <div class="container text-center text-white">
                        <h1 class="display-3 mb-3 fw-bold">Transform Your Digital Presence</h1>
                        <p class="lead fs-4 mb-4">Professional Solutions for Modern Businesses</p>
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="#" class="btn btn-light btn-lg px-4">Start Free Trial</a>
                            <a href="#" class="btn btn-outline-light btn-lg px-4">Watch Demo</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 mb-3">Latest Post</h2>
            <p class="text-muted fs-5">Discover features designed to boost your productivity</p>
        </div>
        <div class="row g-4">
            <?php if(!empty($latest_posts)): ?>
            <?php foreach($latest_posts as $latest_post): ?>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100 shadow-lg rounded-3 p-4">
                    <h3 class="h4 mb-3"><?php
                            $content = strip_tags(htmlspecialchars_decode($latest_post->post_title));
                            echo strlen($content) > 40 ? substr($content, 0, 40) . '...' : $content;
                        ?></h3>
                    <p class="text-muted mb-4"><?php
                            $content = strip_tags(htmlspecialchars_decode($latest_post->short_desc));
                            echo strlen($content) > 80 ? substr($content, 0, 80) . '...' : $content;
                        ?></p>
                    <img src="<?= base_url('public/postImages/' . ($latest_post->thumbnail ?? '')) ?>"
                        class="img-fluid rounded-3" alt="<?= $latest_post->post_title ?>">
                    <div class="mt-3">
                        <a href="<?= site_url('WebController/view_post_by_id/'.$latest_post->id) ?>"
                            class="btn btn-outline-primary">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>

    <!-- Platform Carousel -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="ratio ratio-16x9 shadow rounded-3 overflow-hidden">
                    <div id="platformCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?= base_url('public/banners/logo3.jpg') ?>" class="d-block w-100"
                                    alt="Feature 1">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('public/banners/logo7.jpg') ?>" class="d-block w-100"
                                    alt="Feature 2">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('public/banners/logo2.jpg') ?>" class="d-block w-100"
                                    alt="Feature 3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <!-- <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 mb-3">Simple, Transparent Pricing</h2>
            <p class="text-muted fs-5">Start free, upgrade as you grow</p>
        </div>
        <div class="row g-4">
            <?php foreach($plans as $plan): ?>
                <div class="col-lg-4">
                    <div class="h-100 p-4 border rounded-3 shadow-sm">
                        <h4 class="mb-3"><?= $plan['title'] ?></h4>
                        <div class="h2 mb-3"><?= $plan['price'] ?></div>
                        <ul class="list-unstyled mb-4">
                            <?php foreach($plan['features'] as $feature): ?>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?= $feature ?></li>
                            <?php endforeach ?>
                        </ul>
                        <button class="btn btn-outline-primary w-100">Start Trial</button>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div> -->

    <!-- Final CTA -->
    <div class="bg-dark text-white py-5">
        <div class="container text-center py-4">
            <h2 class="display-5 mb-4">Ready to Get Started?</h2>
            <p class="lead mb-5">Join thousands of satisfied customers today</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="#" class="btn btn-light btn-lg px-4 py-2">Start Free Trial</a>
                <a href="#" class="btn btn-outline-light btn-lg px-4 py-2">Schedule Demo</a>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/footer.php'; ?>