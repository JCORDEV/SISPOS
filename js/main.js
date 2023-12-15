const toastButton = document.querySelector('#toast-button');
const toastContent = document.querySelector('.toast');

// const toast = new bootstrap.Toast(toastContent);
// toast.show();

if (toastButton) {
    toastButton.addEventListener('submit',  function() {
        const toast = new bootstrap.Toast(toastContent);
        toast.show();
    });
}