<?php include 'layouts/header.php'; ?>

<style>
    .blog-card {
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 50%;
        overflow: hidden;
        border: none;
        border-radius: 8px;
    }

    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.12), 0 10px 10px rgba(0, 0, 0, 0.08);
    }

    .card-img-top {
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .blog-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .category-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-weight: 600;
        margin-bottom: 0.75rem;
        transition: color 0.3s ease;
    }

    .blog-card:hover .card-title {
        color: var(--bs-primary);
    }

    /* Header Animation */
    .page-header {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }

    /* Blog Post Animation */
    .blog-post {
        opacity: 0;
        transform: translateY(30px);
    }

    /* Search Form */
    .search-form {
        max-width: 600px;
        margin: 0 auto;
    }

    /* Category Filter */
    .category-filter .btn {
        transition: all 0.3s ease;
        border-radius: 20px;
        padding: 6px 16px;
        margin: 0 4px 8px;
    }

    .category-filter .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .category-filter .btn.active {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Newsletter Section */
    .newsletter-section {
        background: linear-gradient(135deg, #2c3e50 0%, #4ca1af 100%);
        position: relative;
        overflow: hidden;
    }

    .newsletter-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
        animation: pulse 8s infinite linear;
    }





    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .card-img-top {
            height: 180px;
        }
    }

    @media (max-width: 768px) {
        .card-img-top {
            height: 160px;
        }

        .card-body {
            padding: 1.25rem;
        }

        .category-badge {
            top: 10px;
            right: 10px;
            padding: 4px 10px;
        }
    }

    @media (max-width: 576px) {
        .card-img-top {
            height: 140px;
        }

        .category-filter .btn {
            padding: 4px 12px;
            font-size: 0.8rem;
        }
    }

    /* Container for pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 10px 0;
    }

    /* Water bubble effect */
    .pagination .page-item .page-link {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        padding: 0;
        text-align: center;
        line-height: 45px;
        font-weight: bold;
        background: linear-gradient(145deg, #c2f0ff, #a6e3ff);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2),
            inset 0 1px 3px rgba(255, 255, 255, 0.5);
        color: #007bff;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        border: none;
    }

    /* Hover effect */
    .pagination .page-item .page-link:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3),
            inset 0 2px 4px rgba(255, 255, 255, 0.6);
        background: linear-gradient(145deg, #a6e3ff, #c2f0ff);
    }

    /* Active page */
    .pagination .page-item.active .page-link {
        background: radial-gradient(circle, #007bff 30%, #4facfe 100%);
        color: #fff !important;
        box-shadow: 0 8px 15px rgba(0, 123, 255, 0.4),
            inset 0 2px 5px rgba(255, 255, 255, 0.4);
    }

    /* Hide focus outline */
    .pagination .page-link:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.3);
    }

    #searchLoading {
        display: none;
        text-align: center;
        padding: 20px 0;
    }

    #searchResults {
        transition: opacity 0.3s ease;
    }

    .searching #searchResults {
        opacity: 0.5;
    }
</style>

<!-- Main Content Section -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Page Header with Animation -->
        <div class="mb-5 text-center page-header">
            <h1 class="display-5 fw-bold mb-3">Our Blog</h1>
            <p class="lead text-muted mb-4">Discover the latest articles and news</p>
            <form id="searchForm" class="d-flex mt-4 search-form">
                <input id="searchInput" value="<?= htmlspecialchars($current_search ?? '') ?>"
                    class="form-control me-2 py-2" type="search" placeholder="Search articles..." aria-label="Search"
                    autocomplete="off">
                <button class="btn btn-primary px-4" type="submit">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </form>
        </div>

        <!-- Loading Indicator -->
        <div id="searchLoading" class="text-center py-3" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="mb-5 category-filter">
            <div class="d-flex flex-wrap justify-content-center">
                <a href="#" data-category=""
                    class="category-btn btn btn-sm <?= empty($current_category) ? 'btn-primary active' : 'btn-outline-primary' ?>">All</a>
                <?php
                if (!empty($categories)):
                    foreach ($categories as $category):
                        ?>
                        <a href="#" data-category="<?= htmlspecialchars($category->category_name) ?>"
                            class="category-btn btn btn-sm <?= ($current_category == $category->category_name) ? 'btn-primary active' : 'btn-outline-primary' ?>">
                            <?= htmlspecialchars($category->category_name) ?>
                        </a>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div id="searchResults">
            <?php include 'layouts/blog_search_result.php' ?>
        </div>

        <!-- Pagination -->

    </div>
</section>

<section class="py-5 newsletter-section text-white">
    <div class="container text-center position-relative">
        <h2 class="h4 mb-3">Stay updated with our newsletter</h2>
        <p class="mb-4">Get the latest articles delivered to your inbox</p>
        <form class="row g-2 justify-content-center">
            <div class="col-md-6 col-12">
                <input type="email" class="form-control form-control-lg" placeholder="Your email address">
            </div>
            <div class="col-md-2 col-12">
                <button type="submit" class="btn btn-light btn-lg w-100 text-primary fw-bold">
                    Subscribe <i class="fas fa-paper-plane ms-1"></i>
                </button>
            </div>
        </form>
        <p class="small mt-3 opacity-75">We'll never share your email. Unsubscribe at any time.</p>
    </div>
</section>

<?php include 'layouts/footer.php'; ?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> -->
