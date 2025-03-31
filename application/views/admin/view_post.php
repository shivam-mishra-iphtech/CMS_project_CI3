<?php include 'layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="d-flex flex-column flex-grow-1 min-vh-100 bg-light">
    <?php include 'layouts/header.php'; ?>

    <main class="flex-grow-1">
        <div class="container py-5">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold">Post Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small">
                            <li class="breadcrumb-item"><a href="<?= site_url('AdminController/posts_list'); ?>">Posts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
                        </ol>
                    </nav>
                </div>
                <a href="<?= site_url('AdminController/posts_list'); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to list
                </a>
            </div>

            <!-- Post Content Card -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <?php if (!empty($post)) : ?>
                        <!-- Thumbnail Section -->
                        <div class="mb-4 text-center">
                            <?php if (!empty($post->thumbnail)) : ?>
                                <img src="<?= base_url('public/postImages/' . $post->thumbnail); ?>" 
                                     alt="Post thumbnail" 
                                     class="img-fluid rounded-3 shadow-sm"
                                     style="max-height: 400px; object-fit: cover;">
                            <?php else : ?>
                                <div class="bg-light rounded-3 p-5 text-muted">
                                    <i class="bi bi-image fs-1"></i>
                                    <p class="mt-2 mb-0">No thumbnail available</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Post Metadata -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-primary px-3 py-2"> 
                                <?= $post->category == 1 ? 'Latest Post' : 'Trending Post' ?>
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-2"></i>
                                <?= date('M j, Y', strtotime($post->created_at)) ?>
                            </small>
                        </div>

                        <!-- Title Section -->
                        <h1 class="h4 fw-bold mb-4">
                            <?= htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8') ?>
                        </h1>

                        <!-- Content Section -->
                        <article class="post-content fs-6 lh-lg text-secondary">
                            <?php 
                                $decodedContent = json_decode($post->content, true);
                                $content = is_array($decodedContent) ? implode(' ', $decodedContent) : $decodedContent;
                                echo nl2br(htmlspecialchars_decode($content, ENT_QUOTES)); 
                            ?>
                        </article>
                    <?php else : ?>
                        <!-- Error State -->
                        <div class="text-center py-5">
                            <i class="bi bi-exclamation-circle fs-1 text-danger"></i>
                            <h2 class="mt-3">Post Not Found</h2>
                            <p class="text-muted">The requested post could not be located</p>
                            <a href="<?= site_url('AdminController/posts_list'); ?>" class="btn btn-primary mt-3">
                                <i class="bi bi-arrow-left me-2"></i>Return to Posts
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'layouts/footer.php'; ?>

<style>
    .post-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .card {
        border-radius: 1rem;
    }
</style>
