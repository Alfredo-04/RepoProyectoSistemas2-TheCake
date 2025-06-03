function validateName(name) {
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]{1,100}$/;
    return regex.test(name);
}

function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validatePassword(password) {
    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;
    return regex.test(password);
}

function validateConfirmPassword(password, confirmPassword) {
    return password === confirmPassword;
}

function validateTelefono(tel) {
    const regex = /^\d{8}$/;
    return regex.test(tel);
}

function validateDireccion(dir) {
    return dir.trim().length >= 5 && dir.trim().length <= 100;
}

function showError(id, message) {
    document.getElementById(id).textContent = message;
}

function clearErrors() {
    document.querySelectorAll(".error-message").forEach(el => el.textContent = "");
}

function cleanInputSpaces(inputElement) {
    inputElement.value = inputElement.value.trim();
}

document.querySelectorAll('#formEmpleado input').forEach(input => {
    input.addEventListener('blur', function () {
        cleanInputSpaces(this);
    });
    input.addEventListener('input', function () {
        if (this.value.startsWith(' ')) {
            this.value = this.value.trimStart();
        }
    });
});

document.getElementById('formEmpleado').addEventListener('submit', function (e) {
    e.preventDefault(); // Siempre evitar el submit por defecto
    clearErrors();
    let isValid = true;

    const nombre = document.getElementById('nombre').value.trim();
    const apePat = document.getElementById('apePat').value.trim();
    const apeMat = document.getElementById('apeMat').value.trim();
    const correo = document.getElementById('correo').value.trim();
    const contraseña = document.getElementById('contraseña').value.trim();
    const contraseña_confirmation = document.getElementById('contraseña_confirmation').value.trim();
    const rol_id = document.getElementById('rol_id').value;
    const telefono = document.getElementById('telefono').value.trim();
    const direccion = document.getElementById('direccion').value.trim();

    // Validaciones obligatorias
    if (nombre === "") {
        showError('nombreError', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(nombre)) {
        showError('nombreError', 'No puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (apePat === "") {
        showError('apePatError', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(apePat)) {
        showError('apePatError', 'No puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (apeMat === "") {
        showError('apeMatError', 'Completa este campo.');
        isValid = false;
    } else if (!validateName(apeMat)) {
        showError('apeMatError', 'No puede contener caracteres especiales ni números.');
        isValid = false;
    }

    if (rol_id === "") {
        showError('rol_idError', 'Completa este campo.');
        isValid = false;
    }

    if (correo === "") {
        showError('correoError', 'Completa este campo.');
        isValid = false;
    } else if (!validateEmail(correo)) {
        showError('correoError', 'El email no es válido.');
        isValid = false;
    }

    if (contraseña === "") {
        showError('contraseñaError', 'Completa este campo.');
        isValid = false;
    } else if (/\s/.test(contraseña)) {
        showError('contraseñaError', 'La contraseña no puede contener espacios.');
        isValid = false;
    } else if (!validatePassword(contraseña)) {
        showError('contraseñaError', 'Debe tener 8 caracteres, una mayúscula, un número y un carácter especial.');
        isValid = false;
    }

    if (contraseña_confirmation === "") {
        showError('contraseña_confirmationError', 'Completa este campo.');
        isValid = false;
    } else if (!validateConfirmPassword(contraseña, contraseña_confirmation)) {
        showError('contraseña_confirmationError', 'Las contraseñas no coinciden.');
        isValid = false;
    }

    if (telefono !== "" && !validateTelefono(telefono)) {
        showError('telefonoError', 'El teléfono debe tener exactamente 8 números.');
        isValid = false;
    }

    if (direccion !== "" && !validateDireccion(direccion)) {
        showError('direccionError', 'La dirección debe tener entre 5 y 100 caracteres.');
        isValid = false;
    }

    // Si no pasa validaciones, no continúa
    if (!isValid) return;

    // Envío con fetch si pasa validaciones
    const form = this;
    const formData = new FormData(form);

    Swal.fire({
        title: 'Registrando empleado...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        Swal.close();
        const data = await response.json();

        if (!response.ok) {
            throw data;
        }

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.success,
                text: "Serás redirigido...",
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        }
    })
    .catch(error => {
        Swal.close();
        const message = error?.errors 
            ? Object.values(error.errors).join('<br>') 
            : (error.message || 'Ocurrió un error inesperado.');
        Swal.fire({
            icon: 'error',
            title: 'Error al registrar',
            html: message
        });
    });
});
function clearErrorsEdit() {
    document.querySelectorAll("#formEditarUsuario .error-message").forEach(el => el.textContent = "");
}

document.getElementById('formEditarUsuario').addEventListener('submit', function(e) {
    e.preventDefault();

    clearErrorsEdit();

    let isValid = true;

    const nombre = document.getElementById('edit_nombre_usuario').value.trim();
    const correo = document.getElementById('edit_correo_usuario').value.trim();
    const rol = document.getElementById('edit_rol_usuario').value;

    if (nombre === "") {
        document.getElementById('edit_nombre_usuarioError').textContent = "Completa este campo.";
        isValid = false;
    } else if (!validateName(nombre)) {
        document.getElementById('edit_nombre_usuarioError').textContent = "No puede contener caracteres especiales ni números.";
        isValid = false;
    }

    if (correo === "") {
        document.getElementById('edit_correo_usuarioError').textContent = "Completa este campo.";
        isValid = false;
    } else if (!validateEmail(correo)) {
        document.getElementById('edit_correo_usuarioError').textContent = "El email no es válido.";
        isValid = false;
    }

    if (rol === "") {
        document.getElementById('edit_rol_usuarioError').textContent = "Completa este campo.";
        isValid = false;
    }

    if (!isValid) return;

    // Preparar datos y URL para actualizar
    const id = document.getElementById('edit_id_usuario').value;
    const url = `/usuarios/${id}`; // Cambia esta URL si es diferente en tus rutas

    const formData = new FormData(this);

    Swal.fire({
        title: 'Actualizando usuario...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(url, {
        method: 'POST', // Laravel acepta PUT con _method=PUT dentro del formData
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        Swal.close();
        const data = await response.json();

        if (!response.ok) {
            throw data;
        }

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.success,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(error => {
        Swal.close();
        if(error.errors){
            // Mostrar errores de validación Laravel debajo de cada campo
            for(const key in error.errors){
                const elem = document.getElementById(`edit_${key}Error`);
                if(elem) elem.textContent = error.errors[key][0];
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error inesperado.'
            });
        }
    });
});


function editarUsuario(id, nombre, correo, rolId) {
    if ([2, 3, 4].includes(rolId)) {
        // Para empleados
        document.getElementById('edit_id_usuario').value = id;
        document.getElementById('edit_nombre_usuario').value = nombre;
        document.getElementById('edit_correo_usuario').value = correo;
        document.getElementById('edit_rol_usuario').value = rolId;

        // Cambiar acción formulario empleado
        const formEmpleado = document.getElementById('formEditarUsuario');
        formEmpleado.action = `/usuarios/${id}`;

        // Mostrar modal empleado
        const modalEmpleado = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
        modalEmpleado.show();

    } else if (rolId === 5) {
        // Para clientes
        document.getElementById('edit_id_cliente').value = id;
        document.getElementById('edit_nombre_cliente').value = nombre;
        document.getElementById('edit_correo_cliente').value = correo;

        // Cambiar acción formulario cliente
        const formCliente = document.getElementById('formEditarCliente');
        formCliente.action = `/clientes/${id}`; // Ajusta ruta según tu backend

        // Mostrar modal cliente
        const modalCliente = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
        modalCliente.show();
    }
    

     
}


function cerrarModalUsuario() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
    modal.hide();
}

function cerrarModalCliente() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
    modal.hide();
}


    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let nombre = this.getAttribute('data-nombre');
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Eliminar usuario: ${nombre}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });


function clearErrorsEditCliente() {
    document.querySelectorAll("#formEditarCliente .error-message").forEach(el => el.textContent = "");
}

document.getElementById('formEditarCliente').addEventListener('submit', function(e) {
    e.preventDefault();

    clearErrorsEditCliente();

    let isValid = true;

    const nombre = document.getElementById('edit_nombre_cliente').value.trim();
    const correo = document.getElementById('edit_correo_cliente').value.trim();

    if (nombre === "") {
        document.getElementById('edit_nombre_clienteError').textContent = "Completa este campo.";
        isValid = false;
    } else if (!validateName(nombre)) {
        document.getElementById('edit_nombre_clienteError').textContent = "No puede contener caracteres especiales ni números.";
        isValid = false;
    }

    if (correo === "") {
        document.getElementById('edit_correo_clienteError').textContent = "Completa este campo.";
        isValid = false;
    } else if (!validateEmail(correo)) {
        document.getElementById('edit_correo_clienteError').textContent = "El email no es válido.";
        isValid = false;
    }

    if (!isValid) return;

    const id = document.getElementById('edit_id_cliente').value;
    const url = `/clientes/${id}`;  // Ajusta la URL si es necesario

    const formData = new FormData(this);

    Swal.fire({
        title: 'Actualizando cliente...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        Swal.close();
        const data = await response.json();

        if (!response.ok) {
            throw data;
        }

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.success,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(error => {
        Swal.close();
        if(error.errors){
            for(const key in error.errors){
                const elem = document.getElementById(`edit_${key}Error`);
                if(elem) elem.textContent = error.errors[key][0];
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error inesperado.'
            });
        }
    });
});
