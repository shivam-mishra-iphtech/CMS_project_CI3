<style>
    <style>
    /* Custom Styling for Better UI */
    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px;
    }
    .dataTables_length, .dataTables_filter {
        margin-bottom: 15px;
    }
    .dt-buttons button {
        background: #38301a !important;
        color: white !important;
        border-radius: 5px;
        margin-right: 5px;
    }
    table.dataTable tbody tr:hover {
        background-color: #f1f1f1;
    }
    .dataTables_wrapper {
        padding: 10px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
</style>
<!-- Alert Boxes -->
<div id="alert-message" class="alert alert-dismissible fade show" role="alert" 
     style="position: fixed; bottom: 20px; right: -400px; z-index: 9999; 
            min-width: 320px; max-width: 400px; padding: 15px 20px; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); font-size: 16px; font-weight: 500;
            transition: right 0.5s ease-in-out, opacity 0.3s ease-in-out; background: #fff; display: flex;
            align-items: center; gap: 10px; opacity: 0;">
    <i id="alert-icon" class="fas fa-info-circle"></i>
    <span id="alert-text" style="flex-grow: 1;"></span>
    <button type="button" class="close" onclick="closeAlert('#alert-message')" aria-label="Close" 
            style="background: none; border: none; font-size: 20px; font-weight: bold; 
                   cursor: pointer; color: inherit;">&times;</button>
</div>

<div id="alert-message-ajax" class="alert alert-dismissible fade show" role="alert" 
     style="position: fixed; bottom: 80px; right: -400px; z-index: 9999; 
            min-width: 320px; max-width: 400px; padding: 15px 20px; border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); font-size: 16px; font-weight: 500;
            transition: right 0.5s ease-in-out, opacity 0.3s ease-in-out; background: #fff; display: flex;
            align-items: center; gap: 10px; opacity: 0;">
    <i id="alert-icon-ajax" class="fas fa-info-circle"></i>
    <span id="alert-text-ajax" style="flex-grow: 1;"></span>
    <button type="button" class="close" onclick="closeAlert('#alert-message-ajax')" aria-label="Close" 
            style="background: none; border: none; font-size: 20px; font-weight: bold; 
                   cursor: pointer; color: inherit;">&times;</button>
</div>

<!-- jQuery, Bootstrap, and Plugins -->
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
            showAlert(successMessage, 'success', '#alert-message', '#alert-icon', '#alert-text');
            <?php unset($_SESSION['success']); ?>
        } else if (errorMessage) {
            showAlert(errorMessage, 'danger', '#alert-message', '#alert-icon', '#alert-text');
            <?php unset($_SESSION['error']); ?>
        }
    });

    function showAlert(message, type, alertId, iconId, textId) {
        const alertBox = $(alertId);
        const alertIcon = $(iconId);
        const alertText = $(textId);
        alertText.text(message);

        let alertStyles = {
            success: { bg: "#d4edda", color: "#155724", border: "#28a745", icon: "fas fa-check-circle" },
            danger: { bg: "#f8d7da", color: "#721c24", border: "#dc3545", icon: "fas fa-exclamation-circle" }
        };
        let style = alertStyles[type] || alertStyles.success;

        alertBox.css({ "background": style.bg, "color": style.color, "border-left": `5px solid ${style.border}` });
        alertIcon.removeClass().addClass(style.icon);
        alertBox.css({ "opacity": "1", "right": "20px" });
        setTimeout(() => closeAlert(alertId), 5000);
    }

    function closeAlert(alertId) {
        $(alertId).css({ "right": "-400px", "opacity": "0" });
    }

    $(document).ajaxSuccess(function(event, xhr) {
        let response = xhr.responseJSON;
        if (response && response.status === "success") {
            showAlert(response.message || "Success!", "success", '#alert-message-ajax', '#alert-icon-ajax', '#alert-text-ajax');
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
    $(document).ready(function() {
        $('#DataTable').DataTable({
            "dom": '<"dt-buttons"Bf><"clear">lirtp',
            "paging": true,
            "autoWidth": true,
            "buttons": [
                'colvis',
                'copyHtml5',
                'csvHtml5',
                'excelHtml5',
                'pdfHtml5',
                'print'
            ]
        });
    });
</script>

