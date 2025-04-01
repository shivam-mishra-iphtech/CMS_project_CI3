<!-- Alert Box -->

<div id="alert-message" class="alert alert-dismissible fade show" role="alert" 
     style="position: fixed; bottom: 20px; right: -400px; z-index: 9999; 
            min-width: 320px; max-width: 400px; padding: 15px 20px; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); font-size: 16px; font-weight: 500;
            transition: right 0.5s ease-in-out, opacity 0.3s ease-in-out; background: #fff; display: flex;
            align-items: center; gap: 10px; opacity: 0;">
    <i id="alert-icon" class="fas fa-info-circle"></i>
    <span id="alert-text" style="flex-grow: 1;"></span>
    <button type="button" class="close" onclick="closeAlert()" aria-label="Close" 
            style="background: none; border: none; font-size: 20px; font-weight: bold; 
                   cursor: pointer; color: inherit;">
        &times;
    </button>
</div>

<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">
    <!-- Social Media Section -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>Get connected with us on social networks:</span>
        </div>
        <div class="d-flex justify-content-center">
            <a href="#" class="me-4 text-reset">
                <i class="logo_icon bi bi-facebook"></i>
            </a>
            <a href="#" class="me-4 text-reset">
                <i class="logo_icon bi bi-twitter"></i>
            </a>
            <a href="#" class="me-4 text-reset">
                <i class="logo_icon bi bi-google"></i>
            </a>
            <a href="#" class="me-4 text-reset">
                <i class="logo_icon bi bi-instagram"></i>
            </a>
            <a href="#" class="me-4 text-reset">
                <i class="logo_icon bi bi-linkedin"></i>
            </a>
            <a href="#" class="me-4 text-reset">
                <i class="logo_icon bi bi-github"></i>
            </a>
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

                <!-- Quick Links Column -->
                <div class="col-md-6 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Quick Links</h6>
                    <p><a href="<?php echo site_url('WebController/registration'); ?>" class="text-reset">Register</a></p>
                    <p><a href="<?php echo site_url('WebController/login'); ?>" class="text-reset">Login</a></p>
                    <p><a href="#profile" class="text-reset">Profile</a></p>
                </div>

                <!-- Resources Column -->
                <div class="col-md-6 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">Resources</h6>
                    <p><a href="#contact" class="text-reset">Contact</a></p>
                    <p><a href="<?php echo site_url('WebController/view_page')?>" class="text-reset">About Us</a></p>
                    <p><a href="#terms" class="text-reset">Terms & Conditions</a></p>
                    <p><a href="#policy" class="text-reset">Privacy Policy</a></p>
                </div>

                <!-- Contact Column -->
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

<!-- Dropdown Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.dropdown-submenu > a').forEach(function(element) {
            element.addEventListener('click', function(e) {
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
    document.getElementById('fileInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.upload-preview');
                if (preview) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<!-- Alert System Script -->
<script>
    $(document).ready(function() {
        let successMessage = "<?php echo isset($_SESSION['success']) ? $_SESSION['success'] : ''; ?>";
        let errorMessage = "<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>";

        if (successMessage) {
            showAlert(successMessage, 'success');
            <?php unset($_SESSION['success']); ?> // Clear flash message
        } else if (errorMessage) {
            showAlert(errorMessage, 'danger');
            <?php unset($_SESSION['error']); ?> // Clear flash message
        }
    });

    function showAlert(message, type) {
        const alertBox = $('#alert-message');
        const alertIcon = $('#alert-icon');

        $('#alert-text').text(message);
        
        // Set icon and color based on type
        if (type === 'success') {
            alertBox.css({ "background": "#d4edda", "color": "#155724", "border-left": "5px solid #28a745" });
            alertIcon.removeClass().addClass("fas fa-check-circle");
        } else if (type === 'danger') {
            alertBox.css({ "background": "#f8d7da", "color": "#721c24", "border-left": "5px solid #dc3545" });
            alertIcon.removeClass().addClass("fas fa-exclamation-circle");
        }

        // Slide in from right
        alertBox.css({ "opacity": "1", "right": "20px" });

        // Auto close after 5 seconds
        setTimeout(() => closeAlert(), 5000);
    }

    function closeAlert() {
        $('#alert-message').css({ "right": "-400px", "opacity": "0" });
    }
</script>

<!-- Image Preview Script -->
<script>
    function previewImage(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.style.objectFit = "cover"; // Ensure image fits properly inside the box
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
    }

    .footer-link:hover {
        color: #0d6efd !important;
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        #alert-message {
            bottom: 10px;
            right: 10px;
            left: 10px;
            width: auto;
        }
        
        .dropdown-menu {
            position: static !important;
            transform: none !important;
        }
    }

    .logo_icon {
        font-size: 1.25rem;
        font-weight:700;
        vertical-align: -0.125em;
    }
</style>
</body>
</html>