let warningTime = 5 * 60 * 1000; // 5 minutos
let warningTimer;

function resetTimer() {
    clearTimeout(warningTimer);
    warningTimer = setTimeout(showWarning, warningTime);
}

function showWarning() {
    Swal.fire({
        icon: 'warning',
        title: 'Sesión por expirar',
        text: 'Tu sesión expirará pronto por inactividad. ¿Sigues ahí?',
        showCancelButton: true,
        confirmButtonText: 'Sí, Mantener sesión',
        cancelButtonText: 'Cerrar sesión',
        timer: 60 * 1000, // 1 minuto
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            resetTimer();
        } else {
            logoutUser(); 
        }
    });
}

function logoutUser() {
    document.getElementById('logout-form').submit();
}

window.onload = resetTimer;
document.onmousemove = resetTimer;
document.onkeypress = resetTimer;
document.onscroll = resetTimer;
document.onclick = resetTimer;
