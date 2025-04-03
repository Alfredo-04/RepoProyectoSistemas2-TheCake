// Alternar entre Login y Registro
const container = document.getElementById('container');
const loginButton = document.getElementById('loginButton');
const registerButton = document.getElementById('registerButton');

// Limpiar errores y datos al cambiar de formulario
function resetForm(formId) {
    const form = document.getElementById(formId);
    form.reset(); // Limpia los inputs
    clearErrors(); // Limpia los mensajes de error
}

loginButton.addEventListener('click', function (e) {
    e.preventDefault();
    resetForm('loginForm'); // Limpia el formulario de login
    container.classList.remove("right-panel-active");
});

registerButton.addEventListener('click', function (e) {
    e.preventDefault();
    resetForm('signupForm'); // Limpia el formulario de registro
    container.classList.add("right-panel-active");
});

// Funciones de validación
function validateName(name) {
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{1,100}$/;
    return regex.test(name);
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validatePassword(password) {
    return password.length >= 6 && password.length <= 50;
}

function validateConfirmPassword(password, confirmPassword) {
    return password === confirmPassword;
}

function showError(id, message) {
    document.getElementById(id).textContent = message;
}

function clearErrors() {
    document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
}

document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors();
    let isValid = true;

    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value.trim();

    if (email === "") {
        showError('loginEmailError', 'Completa este campo.');
        isValid = false;
    } else if (!validateEmail(email)) {
        showError('loginEmailError', 'El email no es válido.');
        isValid = false;
    }

    if (password === "") {
        showError('loginPasswordError', 'Completa este campo.');
        isValid = false;
    } else if (!validatePassword(password)) {
        showError('loginPasswordError', 'La contraseña debe tener entre 6 y 50 caracteres.');
        isValid = false;
    }

    if (isValid) {
        const formData = new FormData(document.getElementById('loginForm'));

        fetch('login_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // ⚠️ Alerta de error con SweetAlert
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: data.error,
                });
            } else if (data.success) {
                // ✅ Alerta de éxito con SweetAlert
                Swal.fire({
                    icon: "success",
                    title: "¡Inicio de sesión exitoso!",
                    text: "Redirigiendo...",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect; // Redirigir al usuario
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "Error de conexión",
                text: "Hubo un problema al iniciar sesión. Inténtalo de nuevo más tarde.",
            });
        });
    }
});


function validateRole(role) {
    return role !== ""; // Asegura que se haya seleccionado un rol
}

document.getElementById('signupForm').addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors();
    let isValid = true;

    const name = document.getElementById('signupName').value.trim();
    const lastName1 = document.getElementById('signupLastName1').value.trim();
    const lastName2 = document.getElementById('signupLastName2').value.trim();
    const email = document.getElementById('signupEmail').value.trim();
    const password = document.getElementById('signupPassword').value.trim();
    const confirmPassword = document.getElementById('signupConfirmPassword').value.trim();
    const role = document.getElementById('signupRole').value;

    if (name === "") {
        showError('signupNameError', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(name)) {
        showError('signupNameError', 'El nombre no puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (lastName1 === "") {
        showError('signupLastName1Error', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(lastName1)) {
        showError('signupLastName1Error', 'El apellido paterno no puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (lastName2 === "") {
        showError('signupLastName2Error', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(lastName2)) {
        showError('signupLastName2Error', 'El apellido materno no puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (email === "") {
        showError('signupEmailError', 'Completa este campo.');
        isValid = false;
    } else if (!validateEmail(email)) {
        showError('signupEmailError', 'El email no es válido.');
        isValid = false;
    }

    if (password === "") {
        showError('signupPasswordError', 'Completa este campo.');
        isValid = false;
    } else if (!validatePassword(password)) {
        showError('signupPasswordError', 'La contraseña debe tener entre 6 y 50 caracteres.');
        isValid = false;
    }

    if (confirmPassword === "") {
        showError('signupConfirmPasswordError', 'Completa este campo.');
        isValid = false;
    } else if (!validateConfirmPassword(password, confirmPassword)) {
        showError('signupConfirmPasswordError', 'Las contraseñas no coinciden.');
        isValid = false;
    }

    if (!validateRole(role)) {
        showError('signupRoleError', 'Selecciona un rol.');
        isValid = false;
    }

    if (isValid) {
        const formData = new FormData(document.getElementById('signupForm'));

        fetch('signup_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // ⚠️ Alerta de error con SweetAlert
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.error,
                });
            } else if (data.success) {
                // ✅ Alerta de éxito con SweetAlert
                Swal.fire({
                    icon: "success",
                    title: "¡Registro exitoso!",
                    text: "Serás redirigido al login...",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'LoginSignUp.php'; // Redirigir después del éxito
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "Error de conexión",
                text: "Hubo un problema al registrar. Inténtalo de nuevo más tarde.",
            });
        });
    }
});

