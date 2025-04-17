<?php include 'layouts/header.php'; ?>

<style>
    .hero-section {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        padding: 5rem 0;
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .value-icon {
        width: 60px;
        height: 60px;
        transition: transform 0.3s ease;
    }
    .value-icon:hover {
        transform: scale(1.1);
    }
    .img-hover {
        transition: transform 0.3s ease;
    }
    .img-hover:hover {
        transform: scale(1.02);
    }
    @media (max-width: 768px) {
        .hero-section {
            padding: 3rem 0;
        }
    }
</style>

<?php if(!empty($page)): ?>
    <!-- Hero Section -->
    <section class="hero-section text-white">
        <div class="container">
            <div class="row justify-content-center text-center py-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeIn"><?= htmlspecialchars($page->page_title)?></h1>
                    <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s"><?= json_decode($page->short_desc)?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-2">
                
                <div class="col-md-12">
                    <h2 class="text-primary mb-4">Our Story</h2>
                    <div class="lead animate__animated animate__fadeIn"><?= json_decode($page->page_content)?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Do Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6 order-md-2">
                    <img src="<?= base_url('public/pageImages/' . $page->image_1)?>" 
                         alt="Our Work" 
                         class="img-fluid rounded-3 img-hover shadow">
                         
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="text-primary mb-4">What We Do</h2>
                    <img src="<?= base_url('public/pageImages/' . $page->image_2)?>" 
                         alt="Our Story" 
                         class="img-fluid rounded-3 img-hover shadow">
                    <p>We specialize in creating innovative digital solutions that transform businesses and enhance user experiences.</p>
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
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 card-hover">
                        <img src="<?= base_url('public/banners/logo6.jpg')?>" 
                             class="card-img-top" 
                             alt="CEO">
                        <div class="card-body text-center">
                            <h5 class="card-title">John Smith</h5>
                            <p class="text-muted">CEO & Founder</p>
                        </div>
                    </div>
                </div>
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
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-3 card-hover">
                        <div class="card-body">
                            <div class="value-icon bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                                <i class="fas fa-lightbulb fs-4"></i>
                            </div>
                            <h5>Innovation</h5>
                            <p class="text-muted">Pushing boundaries in technology</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php include 'layouts/footer.php'; ?>