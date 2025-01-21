import Swal from "sweetalert2"

document.addEventListener("DOMContentLoaded", function() {
    function confirmDelete(formId, message, confirmText, denyText) {
        Swal.fire({
            title: message,
            showDenyButton: true,
            confirmButtonText: confirmText,
            denyButtonText: denyText
          }).then((result) => {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
    }
    window.confirmDelete = confirmDelete
})