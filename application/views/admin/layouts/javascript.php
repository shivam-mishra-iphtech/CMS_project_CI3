
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        let successMessage = "<?php echo isset($_SESSION['success']) ? $_SESSION['success'] : ''; ?>";
        let errorMessage = "<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>";
        if (successMessage) {
            showAlert(successMessage, 'success', '#alert-message', '#alert-icon', '#alert-text'); <
            ? php unset($_SESSION['success']); ? >
        } else if (errorMessage) {
            showAlert(errorMessage, 'danger', '#alert-message', '#alert-icon', '#alert-text'); <
            ? php unset($_SESSION['error']); ? >
        }
    });

    function showAlert(message, type, alertId, iconId, textId) {
        const alertBox = $(alertId);
        const alertIcon = $(iconId);
        const alertText = $(textId);
        alertText.text(message);
        let alertStyles = {
            success: {
                bg: "#d4edda",
                color: "#155724",
                border: "#28a745",
                icon: "fas fa-check-circle"
            },
            danger: {
                bg: "#f8d7da",
                color: "#721c24",
                border: "#dc3545",
                icon: "fas fa-exclamation-circle"
            }
        };
        let style = alertStyles[type] || alertStyles.success;
        alertBox.css({
            "background": style.bg,
            "color": style.color,
            "border-left": `5px solid ${style.border}`
        });
        alertIcon.removeClass().addClass(style.icon);
        alertBox.css({
            "opacity": "1",
            "right": "20px"
        });
        setTimeout(() => closeAlert(alertId), 5000);
    }

    function closeAlert(alertId) {
        $(alertId).css({
            "right": "-400px",
            "opacity": "0"
        });
    }
    $(document).ajaxSuccess(function(event, xhr) {
        let response = xhr.responseJSON;
        if (response && response.status === "success") {
            showAlert(response.message || "Success!", "success", '#alert-message-ajax', '#alert-icon-ajax',
                '#alert-text-ajax');
        }
    });
    $(document).ajaxError(function(event, xhr) {
        let response = xhr.responseJSON;
        let errorMessage = response && response.message ? response.message : "Something went wrong!";
        showAlert(errorMessage, "danger", '#alert-message-ajax', '#alert-icon-ajax', '#alert-text-ajax');
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.btn-delete-user').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let deleteUrl = this.getAttribute('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to delete this post?",
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
</script>

<script>
    function previewThumbnail(event) {
        const image = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
                document.querySelector('.upload-container').style.background = '#fff';
            }
            reader.readAsDataURL(file);
        }
    }

    function previewFeatured(event) {
        const image = document.getElementById('imagePreview2');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
                document.querySelector('.upload-container2').style.background = '#fff';
            }
            reader.readAsDataURL(file);
        }
    }
    $('form.add-new-page').submit(function(e) {
        e.preventDefault();
        if (typeof CKEDITOR !== "undefined" && CKEDITOR.instances.content) {
            CKEDITOR.instances.content.updateElement();
        }
        var formData = new FormData(this);
        $.ajax({
            url: "<?= site_url('AdminController/add_new_page'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    showAlert(response.message || "Success!", "success");
                    url: "<?= site_url('AdminController/add_new_page'); ?>",
                } else {
                    showAlert(response.message || "Something went wrong!", "danger");
                }
            },
            error: function(xhr) {
                let response = xhr.responseJSON;
                let errorMessage = response && response.message ? response.message :
                    "Something went wrong!";
                showAlert(errorMessage, "danger");
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Category",
            allowClear: true,
            width: '100%' // Ensure it matches Bootstrap width
        });
    });
</script>
<script>
    function previewThumbnail(event) {
        const image = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
                document.querySelector('.upload-container').style.background = '#fff';
            }
            reader.readAsDataURL(file);
        }
    }

    function previewFeatured(event) {
        const image = document.getElementById('imagePreview2');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.classList.remove('d-none');
                document.querySelector('.upload-container2').style.background = '#fff';
            }
            reader.readAsDataURL(file);
        }
    }
</script>