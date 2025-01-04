
function confirmationMessage(type = 'Warning', message, confirmText, denyText, buttonIdConfirmed) {
    Swal.fire({
        title: message,
        text: null,
        icon: type,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmText,
        cancelButtonText: denyText
      }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(buttonIdConfirmed).submit();
        }
      });
}