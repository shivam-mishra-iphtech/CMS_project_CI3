<?php include 'layouts/header.php'; ?>

<style>
    /* Base Styles */
    .blog-card {
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%;
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
</style>

<!-- Main Content Section -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Page Header with Animation -->
        <div class="mb-5 text-center page-header">
            <h1 class="display-5 fw-bold mb-3">Our Blog</h1>
            <p class="lead text-muted mb-4">Discover the latest articles and news</p>
            <form id="searchForm" class="d-flex mt-4 search-form">
                <input id="searchInput" class="form-control me-2 py-2" type="search" placeholder="Search articles..." aria-label="Search">
                <button class="btn btn-primary px-4" type="submit">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </form>

<!-- Display AJAX results here -->
<div id="searchResults" class="mt-4"></div>

        </div>

        <!-- Category Filter -->
        <div class="mb-5 category-filter">
            <div class="d-flex flex-wrap justify-content-center">
                <a href="#" class="btn btn-sm btn-primary active">All</a>
                <?php 
                    if(!empty($categories)):
                        foreach($categories as $category):
                ?>
                <a href="#" class="btn btn-sm btn-outline-primary"><?= htmlspecialchars($category->category_name)?></a>
                <?php 
                        endforeach;
                    endif;    
                ?>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="row g-4">
            <!-- Blog Post 1 -->
            <?php 
                if (!empty($all_posts)):
                    foreach($all_posts as $post):
                ?>
            <div class="col-md-6 col-lg-4 blog-post" style="animation: fadeInUp 0.6s ease forwards 0.1s;">
                <div class="blog-card card shadow-sm h-100">
                    <div class="position-relative overflow-hidden">
                        <?php
                                    $thumbnail = !empty($post->thumbnail) 
                                        ? base_url('public/postImages/' . $post->thumbnail) 
                                        : base_url('public/postImages/default.jpg');
                                ?>
                        <img src="<?= $thumbnail ?>" class="card-img-top" alt="Post Thumbnail">
                        <span class="category-badge badge bg-primary"><?= htmlspecialchars($post->category) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <small class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i>
                                <?= date('M d, Y', strtotime($post->created_at)) ?>
                            </small>
                            <small class="text-muted ms-3">
                                <i class="far fa-eye me-1"></i> 1.2k views
                            </small>
                        </div>

                        <h2 class="h5 card-title">
                            <a href="#" class="text-decoration-none text-dark stretched-link">
                                <?= htmlspecialchars($post->post_title) ?>
                            </a>
                        </h2>

                        <p class="card-text text-muted">
                            <?php
                                        $content = strip_tags(json_decode($post->content));
                                        $short = strlen($content) > 100 ? substr($content, 0, 150) . '...' : $content;
                                        echo htmlspecialchars($short);
                                    ?>
                        </p>

                        <div class="d-flex align-items-center mt-3">
                            <?php if (!empty($post->user_image)) : ?>
                            <img src="<?= base_url('public/userImage/' . $post->user_image) ?>"
                                class="rounded-circle me-2" width="30" height="30" alt="Author">
                            <?php else : ?>
                            <i class="bi bi-person-circle me-2" style="font-size: 30px;"></i>
                            <?php endif; ?>
                            <small class="text-muted"><?= htmlspecialchars($post->author) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                    endforeach;
                endif; 
                ?>

            <!-- Pagination -->
            <div class="mt-5">
                <nav aria-label="Blog pagination">
                    <?= $pagination_links ?>
                </nav>
            </div>

        </div>
</section>

<!-- Newsletter Section -->
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

<script>
    // Add intersection observer for scroll animations
    document.addEventListener('DOMContentLoaded', function() {
        const blogPosts = document.querySelectorAll('.blog-post');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });
        blogPosts.forEach(post => {
            observer.observe(post);
        });
        // Add hover effect to category filter buttons
        const filterButtons = document.querySelectorAll('.category-filter .btn');
        filterButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                if (!button.classList.contains('active')) {
                    button.classList.add('shadow-sm');
                }
            });
            button.addEventListener('mouseleave', () => {
                button.classList.remove('shadow-sm');
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // prevent normal form submission

        let query = $('#searchInput').val();

        $.ajax({
            url: '<?= site_url("WebController/search_posts") ?>',
            type: 'POST',
            data: { query: query },
            success: function(response) {
                $('#searchResults').html(response);
            },
            error: function() {
                $('#searchResults').html('<div class="alert alert-danger">Something went wrong.</div>');
            }
        });
    });
</script>
