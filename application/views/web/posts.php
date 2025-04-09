<?php include 'layouts/header.php'; ?>
<style>
    .post-hero {
        height: 400px;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('https://images.nightcafe.studio/jobs/pWvU3RiBUozZlsU0u3SU/pWvU3RiBUozZlsU0u3SU--0--7yn3m.jpg?tr=w-1600,c-at_max') center/cover;
    }

    .author-img {
        width: 80px;
        height: 80px;
    }

    .related-post:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
</style>
<?php if (!empty($latest_post)) { ?>

    <!-- Post Hero Section -->
    <section class="post-hero text-white d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <!-- <span class="badge bg-primary mb-3">Artificial Intelligence</span> -->
                    <h1 class="display-4 fw-bold mb-3">
                        <?php
                        $content = strip_tags(htmlspecialchars($latest_post->post_title));
                        echo strlen($content) > 50 ? substr($content, 0, 50) . '' : $content;
                        ?>
                    </h1>
                    <div class="d-flex justify-content-center gap-4">
                        <p class="mb-0"><i class="fas fa-user me-2"></i>John Doe</p>
                        <p class="mb-0"><i class="fas fa-calendar me-2"></i>
                            <?php
                            // Format the date as Day Month Year
                            echo date('d F Y', strtotime($latest_post->created_at));
                            ?>
                        </p>
                        <p class="mb-0"><i class="fas fa-comments me-2"></i>15 Comments</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container py-5">
        <div class="row g-5">
            <!-- Article Content -->
            <div class="col-lg-8">
                <article class="blog-content">
                    <p class="lead">
                        <?php echo htmlspecialchars_decode(json_decode($latest_post->short_desc)) ?? ''; ?>
                    </p>

                    <h2 class="mt-5 mb-3">
                        <?php echo htmlspecialchars($latest_post->post_title) ?? ''; ?>
                    </h2>
                    <p>
                        <?php
                        $content = strip_tags(htmlspecialchars_decode(json_decode($latest_post->content)));
                        echo strlen($content) > 100 ? substr($content, 0, 180) . '' : $content;
                        ?>
                    </p>

                    <img style="width:650px ;height:600px;"
                        src="<?php echo base_url('public/postImages/' . $latest_post->featured_image); ?>"
                        alt="AI Applications" class="img-fluid rounded mb-4">

                    <p>
                        <?php echo htmlspecialchars_decode(json_decode($latest_post->content)) ?? ''; ?>
                    </p>

                </article>

                <!-- Author Bio -->
                <div class="author-card mt-5 p-4 bg-light rounded">
                    <div class="d-flex align-items-center gap-4">
                        <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" alt="Author"
                            class="author-img rounded-circle">
                        <div>
                            <h3 class="h5 mb-1">John Doe</h3>
                            <p class="text-muted mb-2">Chief Technology Officer at TechSolutions</p>
                            <div class="social-links">
                                <a href="#" class="text-primary me-3"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-primary me-3"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-primary"><i class="fab fa-medium"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <section class="comments mt-5">
                    <h2 class="mb-4">Comments (15)</h2>

                    <div class="comment-list">
                        <!-- Single Comment -->
                        <div class="comment d-flex gap-4 mb-4">
                            <img src="<?php echo base_url('public/banners/logo7.jpg'); ?>" alt="Author"
                                class="author-img rounded-circle">
                            <div>
                                <div class="d-flex gap-3 align-items-center mb-2">
                                    <h4 class="h6 mb-0">Sarah Johnson</h4>
                                    <small class="text-muted">March 16, 2024</small>
                                </div>
                                <p>Excellent overview of AI applications! Particularly interested in the predictive
                                    analytics section.</p>
                            </div>
                        </div>
                        <!-- Add more comments -->
                    </div>

                    <!-- Comment Form -->
                    <h3 class="mb-4">Leave a Comment</h3>

                        <form class="ajax-comment-form">
                            <input type="hidden" name="post_id" value="<?= $latest_post->id ?>">
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="4" name="coment" placeholder="Your Comment" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Post Comment</button>
                                </div>
                            </div>
                        </form>

<!-- Message area -->
<div id="comment-response" class="mt-3"></div>

                </section>
            </div>

            <!-- Sidebar -->
            <aside class="col-lg-4">
                <div class="sticky-top" style="top: 20px;">
                    <?php if (!empty($related_posts)) { 
                        foreach ($related_posts as $related_post) {
                            ?>
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h3 class="h5 mb-3">
                                        <?php
                                        $content = strip_tags(htmlspecialchars($related_post->post_title));
                                        echo strlen($content) > 30 ? substr($content, 0, 30) .'' : $content;
                                        ?>
                                    </h3>
                                    <div class="related-post card mb-3 border-0">
                                        <img src="<?php echo base_url('public/postImages/'.$related_post->thumbnail); ?>" class="card-img-top" alt="Related Post" onerror="this.onerror=null; this.src='<?php echo base_url('public/banners/logo2.jpg'); ?>'">
                                        <div class="card-body">
                                            <h4 class="h6">
                                                <?php
                                                $content = strip_tags(htmlspecialchars(json_decode($related_post->short_desc)));
                                                echo strlen($content) > 100 ? substr($content, 0, 100) . '...' : $content;
                                                ?>
                                            </h4>
                                            <a href="<?= site_url('WebController/view_post_by_id/'.$related_post->id); ?>" class="stretched-link"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } ?>


                    <!-- Newsletter -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 mb-3">Subscribe to Our Newsletter</h3>
                            <form>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Enter your email">
                                </div>
                                <button class="btn btn-primary w-100">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>
<?php } ?>
<?php include 'layouts/footer.php'; ?>
<script>
$(document).ready(function () {
    $('.ajax-comment-form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: "<?= site_url('WebController/add_user_comment') ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                    
                    if (response.status === "success") {
                        
                        console.log("Page added successfully!");
                        setTimeout(function() {
                            window.location.reload();
                        }, 2500); 

                    } else {
                        
                        console.log("failed to add new page !.");
                    }
                },
                error: function(xhr) {
                    
                    console.log("Something went wrong!");
                }
        });
    });
});
</script>
