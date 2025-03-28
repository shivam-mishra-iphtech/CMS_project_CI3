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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.btn-delete-user').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            let deleteUrl = this.getAttribute('href'); // Get delete URL

            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to delete this user?",
                icon: "warning",
                width: "350px",  // Smaller alert box
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl; // Redirect to delete URL
                }
            });
        });
    });
});
</script>

