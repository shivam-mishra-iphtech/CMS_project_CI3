<!-- Alert Box -->
<div id="alert-message" class="alert alert-dismissible fade show" role="alert" style="position: fixed; bottom: 20px; right: -400px; z-index: 9999; 
            min-width: 320px; max-width: 400px; padding: 15px 20px; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); font-size: 16px; font-weight: 500;
            transition: right 0.5s ease-in-out, opacity 0.3s ease-in-out; background: #fff; display: flex;
            align-items: center; gap: 10px; opacity: 0;">
    <i id="alert-icon" class="fas fa-info-circle"></i>
    <span id="alert-text" style="flex-grow: 1;"></span>
    <button type="button" class="close" onclick="closeAlert('#alert-message')" aria-label="Close" style="background: none; border: none; font-size: 20px; font-weight: bold; 
                   cursor: pointer; color: inherit;">
        &times;
    </button>
</div>
<div id="alert-message-ajax" class="alert alert-dismissible fade show" role="alert" style="position: fixed; bottom: 80px; right: -400px; z-index: 9999; 
            min-width: 320px; max-width: 400px; padding: 15px 20px; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); font-size: 16px; font-weight: 500;
            transition: right 0.5s ease-in-out, opacity 0.3s ease-in-out; background: #fff; display: flex;
            align-items: center; gap: 10px; opacity: 0;">
    <i id="alert-icon-ajax" class="fas fa-info-circle"></i>
    <span id="alert-text-ajax" style="flex-grow: 1;"></span>
    <button type="button" class="close" onclick="closeAlert('#alert-message-ajax')" aria-label="Close" style="background: none; border: none; font-size: 20px; font-weight: bold; 
                   cursor: pointer; color: inherit;">&times;</button>
</div>
<!-- Page Loader -->
<div id="loader-wrapper">
    <div id="loader"></div>
<!-- </div>
<style>
/* Loader Wrapper */
#loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff; /* background color */
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Actual Loader Animation */
#loader {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db; /* loader color */
    border-radius: 50%;
    width: 70px;
    height: 70px;
    animation: spin 1s linear infinite;
}

/* Animation Keyframes */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<script>
window.addEventListener("load", function(){
    const loaderWrapper = document.getElementById("loader-wrapper");
    loaderWrapper.style.opacity = "0";
    loaderWrapper.style.visibility = "hidden";
    loaderWrapper.style.transition = "all 0.5s ease-out";
});
</script> -->
<div class="page-loader">
  <div class="loader-content">
    <div class="loader-spinner"></div>
    <div class="loader-text">Loading</div>
    <div class="loader-dots">
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
</div>
<style>
   /* Page Loader Styles */
.page-loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.95);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  backdrop-filter: blur(3px);
  transition: opacity 0.5s ease, visibility 0.5s ease;
}

.loader-content {
  text-align: center;
  max-width: 200px;
}

.loader-spinner {
  width: 50px;
  height: 50px;
  margin: 0 auto 20px;
  border: 3px solid rgba(0, 0, 0, 0.1);
  border-radius: 50%;
  border-top-color: #4a6cf7;
  animation: spin 1s linear infinite;
}

.loader-text {
  font-family: 'Segoe UI', sans-serif;
  font-size: 16px;
  color: #333;
  margin-bottom: 10px;
  font-weight: 500;
}

.loader-dots {
  display: flex;
  justify-content: center;
  gap: 5px;
}

.loader-dots .dot {
  width: 8px;
  height: 8px;
  background: #4a6cf7;
  border-radius: 50%;
  opacity: 0.6;
}

.loader-dots .dot:nth-child(1) {
  animation: pulse 1.4s infinite ease-in-out;
}
.loader-dots .dot:nth-child(2) {
  animation: pulse 1.4s infinite ease-in-out 0.2s;
}
.loader-dots .dot:nth-child(3) {
  animation: pulse 1.4s infinite ease-in-out 0.4s;
}

/* Animations */
@keyframes spin {
  to { transform: rotate(360deg); }
}

@keyframes pulse {
  0%, 100% { transform: translateY(0); opacity: 0.6; }
  50% { transform: translateY(-5px); opacity: 1; }
}

/* Hide when complete */
.page-loader.hidden {
  opacity: 0;
  visibility: hidden;
}
</style>
<script>
   document.addEventListener('DOMContentLoaded', function() {
  const loader = document.querySelector('.page-loader');
  
  // Show loader immediately
  loader.classList.remove('hidden');
  
  // Hide loader when page is fully loaded
  window.addEventListener('load', function() {
    setTimeout(function() {
      loader.classList.add('hidden');
    }, 500); // Small delay for smooth transition
  });
  
  // Fallback in case load event doesn't fire
  setTimeout(function() {
    loader.classList.add('hidden');
  }, 3000); // Maximum 3 seconds
});
</script>


<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">
    <!-- Social Media Section -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>Get connected with us on social networks:</span>
        </div>
        <div class="d-flex justify-content-center">
            <?php if (!empty($this->footer_data['social_media'])): ?>
                <?php foreach ($this->footer_data['social_media'] as $media): ?>
                    <a href="<?= $media->media_link ?>" class="me-3 text-reset social-icon" target="_blank"
                        title="<?= ucfirst($media->media_name) ?>">
                        <i class="fs-4 <?= $media->icon_class ?>" style="color: <?= $media->icon_color ?>"></i>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Links Section -->
    <section class="px-lg-5">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3 g-4">
                <!-- Company Column -->
                <div class="col-md-6 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>IPH Technologies
                    </h6>
                    <p class="text-secondary">
                        Your trusted partner in technology solutions. Delivering excellence through innovation.
                    </p>
                </div>

                <?php $this->load->helper('menu'); ?>
                <?php echo load_footer_menu(); ?>

                <!-- Static Contact Column -->
                <div class="col-md-6 col-lg-4 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="logo_icon bi bi-house-door me-3"></i> Lucknow, UP, India</p>
                    <p><i class="logo_icon bi bi-envelope me-3"></i> info@example.com</p>
                    <p><i class="logo_icon bi bi-telephone me-3"></i> +91 7387853416</p>
                    <p><i class="logo_icon bi bi-printer me-3"></i> +91 6391583178</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Copyright Section -->
    <div class="text-center p-4 bg-light border-top">
        © 2023 Copyright:
        <a class="text-reset fw-bold" href="/">iph-technologies.com</a>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Dropdown Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.dropdown-submenu > a').forEach(function (element) {
            element.addEventListener('click', function (e) {
                if (window.innerWidth < 992) {
                    const nextEl = this.nextElementSibling;
                    if (nextEl && nextEl.classList.contains('dropdown-menu')) {
                        e.preventDefault();
                        nextEl.style.display = nextEl.style.display === 'block' ? 'none' : 'block';
                    }
                }
            });
        });
    });
</script>

<!-- File Input Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.querySelector('.upload-preview');
                        if (preview) {
                            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>

<!-- Alert System Script -->
<script>
    $(document).ready(function () {
        // Check for normal flash messages
        let successMessage = "<?php echo isset($_SESSION['success']) ? addslashes($_SESSION['success']) : ''; ?>";
        let errorMessage = "<?php echo isset($_SESSION['error']) ? addslashes($_SESSION['error']) : ''; ?>";

        if (successMessage) {
            showAlert(successMessage, 'success', '#alert-message', '#alert-icon', '#alert-text');
            <?php unset($_SESSION['success']); ?>
        }
        if (errorMessage) {
            showAlert(errorMessage, 'danger', '#alert-message', '#alert-icon', '#alert-text');
            <?php unset($_SESSION['error']); ?>
        }
    });

    // Global alert function
    function showAlert(message, type, alertId = '#alert-message', iconId = '#alert-icon', textId = '#alert-text') {
        const alertBox = $(alertId);
        const alertIcon = $(iconId);
        const alertText = $(textId);

        alertText.text(message);

        const alertStyles = {
            success: {
                bg: "#d4edda",
                color: "#155724",
                border: "5px solid #28a745",
                icon: "fas fa-check-circle"
            },
            danger: {
                bg: "#f8d7da",
                color: "#721c24",
                border: "5px solid #dc3545",
                icon: "fas fa-exclamation-circle"
            },
            info: {
                bg: "#d1ecf1",
                color: "#0c5460",
                border: "5px solid #17a2b8",
                icon: "fas fa-info-circle"
            },
            warning: {
                bg: "#fff3cd",
                color: "#856404",
                border: "5px solid #ffc107",
                icon: "fas fa-exclamation-triangle"
            }
        };

        const style = alertStyles[type] || alertStyles.info;

        alertBox.css({
            "background": style.bg,
            "color": style.color,
            "border-left": style.border
        });

        alertIcon.removeClass().addClass(style.icon);

        // Show alert
        alertBox.css({
            "opacity": "1",
            "right": "20px"
        });

        // Auto close after 5 seconds
        setTimeout(() => closeAlert(alertId), 5000);
    }

    function closeAlert(alertId) {
        $(alertId).css({
            "right": "-400px",
            "opacity": "0"
        });
    }

    // AJAX response handling
    $(document).ajaxComplete(function (event, xhr, settings) {
        try {
            const response = xhr.responseJSON;
            if (response) {
                if (response.status === "success") {
                    showAlert(response.message || "Operation successful!", "success",
                        '#alert-message-ajax', '#alert-icon-ajax', '#alert-text-ajax');
                } else if (response.status === "error") {
                    showAlert(response.message || "An error occurred!", "danger",
                        '#alert-message-ajax', '#alert-icon-ajax', '#alert-text-ajax');
                }
            }
        } catch (e) {
            console.log("Non-JSON response or parsing error");
        }
    });

    // Delete confirmation
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.btn-delete-user').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let deleteUrl = this.getAttribute('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to delete this item?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });

    // Image preview function
    function previewImage(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let preview = document.getElementById('imagePreview');
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.objectFit = "cover";
                }
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<!-- Additional CSS -->
<style>
    .footer-link {
        transition: all 0.3s ease;
        text-decoration: none;
        color: #6c757d !important;
        display: inline-block;
    }

    .footer-link:hover {
        color: #0d6efd !important;
        transform: translateX(5px);
    }

    @media (max-width: 768px) {

        #alert-message,
        #alert-message-ajax {
            bottom: 10px;
            right: 10px;
            left: 10px;
            width: calc(100% - 20px);
            max-width: none;
        }

        .dropdown-menu {
            position: static !important;
            transform: none !important;
        }
    }

    .logo_icon {
        font-size: 1.25rem;
        font-weight: 700;
        vertical-align: -0.125em;
    }

    .social-icon {
        transition: transform 0.3s ease, color 0.3s ease;
        display: inline-block;
    }

    .social-icon:hover {
        transform: scale(1.2);
        opacity: 0.8;
    }
</style>
</body>

</html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Existing animation code...

        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        const searchResults = document.getElementById('searchResults');
        const searchLoading = document.getElementById('searchLoading');
        const categoryButtons = document.querySelectorAll('.category-btn');
        const container = document.querySelector('.container');

        // Real-time search function
        function performSearch() {
            const searchTerm = searchInput.value.trim();
            const activeCategory = document.querySelector('.category-btn.active')?.dataset.category || '';

            searchLoading.style.display = 'block';
            container.classList.add('searching');

            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const url = new URL('<?= site_url('WebController/search_posts') ?>', window.location.origin);

                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                }

                if (activeCategory) {
                    url.searchParams.set('category', activeCategory);
                }

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        searchResults.innerHTML = html;
                        animatePosts();
                        updateURL(searchTerm, activeCategory);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        searchResults.innerHTML = '<div class="alert alert-danger">Error loading results</div>';
                    })
                    .finally(() => {
                        searchLoading.style.display = 'none';
                        container.classList.remove('searching');
                    });
            }, 500); // 500ms delay after typing stops
        }

        // Animate newly loaded posts
        function animatePosts() {
            const posts = document.querySelectorAll('.blog-post');
            posts.forEach((post, index) => {
                post.style.animation = `fadeInUp 0.6s ease forwards ${index * 0.1}s`;
                post.style.opacity = '0';
                post.style.transform = 'translateY(30px)';
            });
        }

        // Update URL without reload
        function updateURL(search, category) {
            const url = new URL(window.location.pathname, window.location.origin);

            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }

            if (category) {
                url.searchParams.set('category', category);
            } else {
                url.searchParams.delete('category');
            }

            window.history.pushState({}, '', url);
        }

        // Event listeners
        searchInput.addEventListener('input', performSearch);

        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            performSearch();
        });

        categoryButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Update active state
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'btn-primary');
                    btn.classList.add('btn-outline-primary');
                });

                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-outline-primary');

                // Perform search
                performSearch();
            });
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            const categoryParam = urlParams.get('category');

            if (searchParam !== null) {
                searchInput.value = searchParam;
            } else {
                searchInput.value = '';
            }

            categoryButtons.forEach(button => {
                button.classList.remove('active', 'btn-primary');
                button.classList.add('btn-outline-primary');

                if ((button.dataset.category === categoryParam) ||
                    (!categoryParam && button.dataset.category === '')) {
                    button.classList.add('active', 'btn-primary');
                    button.classList.remove('btn-outline-primary');
                }
            });

            performSearch();
        });

        // Initial animation of posts
        animatePosts();
    });
</script>