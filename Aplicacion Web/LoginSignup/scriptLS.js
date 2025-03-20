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

// Validación del formulario de Login
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors();
    let isValid = true;

    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value.trim();

    // Validación del email
    if (email === "") {
        showError('loginEmailError', 'Completa este campo.');
        isValid = false;
    } else if (!validateEmail(email)) {
        showError('loginEmailError', 'El email no es válido.');
        isValid = false;
    }

    // Validación de la contraseña
    if (password === "") {
        showError('loginPasswordError', 'Completa este campo.');
        isValid = false;
    } else if (!validatePassword(password)) {
        showError('loginPasswordError', 'La contraseña debe tener entre 6 y 50 caracteres.');
        isValid = false;
    }

    // Si la validación es correcta, enviar el formulario mediante AJAX
    if (isValid) {
        const formData = new FormData(document.getElementById('loginForm'));

        fetch('login_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())  // Asegúrate de que la respuesta sea JSON
        .then(data => {
            if (data.error) {
                // Mostrar el mensaje de error en el formulario
                showError('loginEmailError', data.error);
            } else if (data.success) {
                // Redirigir a la página de prueba si el login es exitoso
                window.location.href = 'pruebaLogin.php';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al iniciar sesión. Por favor, inténtalo de nuevo más tarde.');
        });
    }
});

function validateRole(role) {
    return role !== ""; // Asegura que se haya seleccionado un rol
}

// Validación del formulario de registro
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

    // Validación de los campos locales
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
        // Si la validación local es correcta, enviamos el formulario usando AJAX
        const formData = new FormData(document.getElementById('signupForm'));

        fetch('signup_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())  // Asegúrate de que la respuesta sea JSON
        .then(data => {
            if (data.error) {
                alert(data.error);  // Muestra el mensaje de error en un alert
            } else if (data.success) {
                alert(data.success);  // Muestra el mensaje de éxito en un alert
                window.location.href = 'LoginSignUp.php';  // Recarga la página
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al registrar. Por favor, intentalo de nuevo más tarde.');
        });
        
    }
});
