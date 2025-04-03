

    
    // Crear botones de navegación para móvil
    const mobileButtons = `
        <div class="mobile-switch-buttons">
            <button class="ghost mobile-switch-btn" id="mobileLoginButton">Iniciar Sesión</button>
            <button class="ghost mobile-switch-btn" id="mobileRegisterButton">Registrarse</button>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', mobileButtons);
    
    // Mostrar/ocultar según el tamaño de pantalla
    function checkScreenSize() {
        const mobileButtons = document.querySelector('.mobile-switch-buttons');
        if (window.innerWidth <= 480) {
            mobileButtons.style.display = 'flex';
            document.querySelector('.overlay-container').style.display = 'none';
        } else {
            mobileButtons.style.display = 'none';
            document.querySelector('.overlay-container').style.display = 'block';
        }
    }
    
    // Event listeners para los botones móviles
    document.getElementById('mobileLoginButton').addEventListener('click', function() {
        container.classList.remove("right-panel-active");
        resetForm('signupForm');
    });
    
    document.getElementById('mobileRegisterButton').addEventListener('click', function() {
        container.classList.add("right-panel-active");
        resetForm('loginForm');
    });
    
    // Verificar al cargar y al redimensionar
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);






// Alternar entre Login y Registro
const container = document.getElementById('container');
const loginButton = document.getElementById('loginButton');
const registerButton = document.getElementById('registerButton');

    // Limpiar errores y datos al cambiar de formulario
    function resetForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            clearErrors();
        }
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
    // Mínimo 8 caracteres, al menos 1 mayúscula, 1 número y 1 carácter especial
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;
    return regex.test(password);
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

// Aplicar a todos los formularios
document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(input => {
    // Limpiar al salir del campo (evento blur)
    input.addEventListener('blur', function() {
        cleanInputSpaces(this);
    });
    
    // Opcional: Prevenir espacios al principio mientras escribe
    input.addEventListener('input', function(e) {
        if (this.value.startsWith(' ')) {
            this.value = this.value.trimStart();
        }
    });
});




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
                    didOpen: () => {
                        document.body.style.overflow = "auto"; // Evita que desaparezca el scroll
                    },
                    willClose: () => {
                        document.body.style.overflow = ""; // Restaura el overflow cuando la alerta se cierra
                    },
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

function cleanInputSpaces(inputElement) {
    // Elimina espacios al principio y al final
    inputElement.value = inputElement.value.trim();
    
    // Elimina múltiples espacios entre palabras (opcional)
    // inputElement.value = inputElement.value.replace(/\s+/g, ' ');
}


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
        showError('signupNameError', 'No puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (lastName1 === "") {
        showError('signupLastName1Error', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(lastName1)) {
        showError('signupLastName1Error', 'No puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (lastName2 === "") {
        showError('signupLastName2Error', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(lastName2)) {
        showError('signupLastName2Error', 'No puede contener caracteres especiales ni números.');
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
        
    } 
    else if (/\s/.test(password)) {
        showError('signupPasswordError', 'La contraseña no puede contener espacios.');
        isValid = false;
    }
    else if (password.length < 8) {
        showError('signupPasswordError', 'La contraseña debe tener al menos 8 caracteres.');
        isValid = false;
    } else if (!/[A-Z]/.test(password)) {
        showError('signupPasswordError', 'Debe contener al menos una letra mayúscula.');
        isValid = false;
    } else if (!/\d/.test(password)) {
        showError('signupPasswordError', 'Debe contener al menos un número.');
        isValid = false;
    } else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        showError('signupPasswordError', 'Debe contener al menos un carácter especial.');
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

function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    const icon = iconElement.querySelector('i');
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye"); // Ojo abierto cuando se muestra la contraseña
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash"); // Ojo cerrado/tachado cuando se oculta
    }
    
}
