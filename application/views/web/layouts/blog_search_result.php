<?php if (!empty($all_posts)): ?>
    <div class="row g-4">
        <?php foreach ($all_posts as $post): ?>
            <div class="col-md-6 col-lg-3 blog-post">
                <div class="blog-card card shadow-sm h-100">
                    <div class="position-relative overflow-hidden">
                        <?php
                        $thumbnail = !empty($post->thumbnail)
                            ? base_url('public/postImages/' . $post->thumbnail)
                            : base_url('public/postImages/default.jpg');
                        ?>
                        <img src="<?= $thumbnail ?>" class="card-img-top" alt="Post Thumbnail">
                        <span class="category-badge badge bg-primary">
                            <?= htmlspecialchars($post->category) ?>
                        </span>
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
                            <a href="<?= site_url('WebController/view_post_by_id/'.$post->id) ?>" class="text-decoration-none text-dark stretched-link">
                            <?php
                            $content = strip_tags($post->post_title);
                            $short = strlen($content) > 100 ? substr($content, 0, 70) . '...' : $content;
                            echo htmlspecialchars($short);
                            ?>
                            </a>
                        </h2>

                        <p class="card-text text-muted">
                            <?php
                            $content = strip_tags(json_decode($post->content));
                            $short = strlen($content) > 100 ? substr($content, 0, 70) . '...' : $content;
                            echo htmlspecialchars($short);
                            ?>
                        </p>

                        <div class="d-flex align-items-center mt-3">
                            <?php if (!empty($post->user_image)): ?>
                                <img src="<?= base_url('public/userImage/' . $post->user_image) ?>" class="rounded-circle me-2"
                                    width="30" height="30" alt="Author">
                            <?php else: ?>
                                <i class="bi bi-person-circle me-2" style="font-size: 30px;"></i>
                            <?php endif; ?>
                            <small class="text-muted">
                                <?= htmlspecialchars($post->author) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (!$this->input->is_ajax_request() && !empty($pagination_links)): ?>
        <div class="mt-5">
            <nav aria-label="Blog pagination">
                <?= $pagination_links ?>
            </nav>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="col-12 text-center py-5">
    <div class="alert alert-info d-inline-block px-4 py-3 shadow-sm animate__animated animate__fadeInDown" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>No posts found</strong> matching your criteria.
    </div>
    <br>
    <button onclick="window.location.href='<?= site_url('WebController/view_all_post') ?>'" 
            class="btn btn-primary mt-4 px-4 py-2 animate__animated animate__fadeInUp">
        <i class="bi bi-arrow-repeat me-2"></i> View All Posts
    </button>
</div>

<!-- Add this in your <head> or before the closing </body> tag -->


<?php endif; ?>