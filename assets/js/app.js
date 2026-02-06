document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    Swal.fire({
      title: '¿Eliminar registro?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});

const flash = document.querySelector('[data-flash-message]');
if (flash) {
  Swal.fire({
    icon: flash.dataset.flashType || 'success',
    title: flash.dataset.flashMessage,
    timer: 1800,
    showConfirmButton: false
  });
}
