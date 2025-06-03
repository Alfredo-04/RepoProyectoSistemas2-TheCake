@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    body {
        background: linear-gradient(135deg, #f8a29b, #ff6f61);
        color: #333;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        text-align: center;
    }
    .container {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 30px;
        margin: 40px auto;
        max-width: 1000px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        animation: slideIn 1s ease-in-out;
    }
    @keyframes slideIn {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    h2 {
        font-size: 2.5rem;
        color: #ff6f61;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        margin-bottom: 30px;
        animation: fadeIn 2s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    form {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #ff6f61;
    font-size: 1rem;
    position: static; /* Cambia a relative */
    z-index: 10; /* Asegura que esté encima */
    opacity: 1 !important; /* Fuerza visibilidad */
    transition: none !important; /* Elimina animaciones que lo oculten */
}


    .form-control {
        background-color: #fff5f3;
        border: 2px solid #ff6f61;
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
        transition: all 0.3s;
        margin-bottom: 20px;
    }
    
    .btn-primary {
        background: #ff6f61;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    }
    .btn-primary:hover {
        background: #ff3b30;
        transform: scale(1.05);
    }
    .form-control:focus {
        border-color: #ff6f61;
        box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
        outline: none;
    }

    
    @media (max-width: 768px) {
        .container { width: 90%; padding: 20px; }
        h2 { font-size: 2rem; }
    }

    form .form-label {
    text-align: left;
    display: block; /* Asegura que ocupe toda la línea */
}


</style>


<style>
    .btn-warning {
        background: #ffbc0a;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    }

    .btn-warning:hover {
        background: #f4a900;
        transform: scale(1.05);
    }

    .btn-danger {
        background: #ff6f61;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    }

    .btn-danger:hover {
        background: #ff3b30;
        transform: scale(1.05);
    }

    .btn-sm {
        padding: 6px 12px;
        margin: 0 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-sm i {
        margin-right: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
    }

    thead {
        background: #6c757d;
        color: white;
        font-size: 1.1rem;
    }

    th, td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        text-align: center;
    }

    tbody tr:hover {
        background: rgba(108, 117, 125, 0.1);
        transition: background 0.3s;
    }

    .img-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
    }
    .error-message {
    color: #e74c3c;
    font-size: 0.9em;
    margin-top: 4px;
    margin-bottom: 4px;
    display: block;
    height: 16px;
    animation: shake 0.5s ease-in-out;

    
}

.modal {
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
    display: none;
}


</style>



<div class="container mt-5">
    <h2>Registro de Usuario</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

<form method="POST" action="{{ route('usuarios.empleado.store') }}" id="formEmpleado">
    @csrf

    <div class="form-group">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre">
        <span class="error-message text-danger" id="nombreError"></span>
    </div>

    <div class="form-group">
        <label for="apePat" class="form-label">Apellido Paterno</label>
        <input type="text" class="form-control" id="apePat" name="apePat">
        <span class="error-message text-danger" id="apePatError"></span>
    </div>

    <div class="form-group">
        <label for="apeMat" class="form-label">Apellido Materno</label>
        <input type="text" class="form-control" id="apeMat" name="apeMat">
        <span class="error-message text-danger" id="apeMatError"></span>
    </div>

    <div class="form-group">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Opcional">
        <span class="error-message text-danger" id="telefonoError"></span>
    </div>

    <div class="form-group">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Opcional">
        <span class="error-message text-danger" id="direccionError"></span>
    </div>

    <div class="form-group">
        <label for="rol_id" class="form-label">Rol</label>
        <select class="form-control" id="rol_id" name="rol_id">
            <option value="">Seleccione un rol</option>
            @foreach($rolesEmpleados as $rol)
                <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
            @endforeach
        </select>
        <span class="error-message text-danger" id="rol_idError"></span>
    </div>

    <div class="form-group position-relative">
        <label for="correo" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" >
        <span class="error-message text-danger" id="correoError"></span>
    </div>

    <!-- Contraseña -->
    <div class="form-group position-relative">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" >
        <span class="toggle-password" onclick="togglePassword('contraseña', this)" 
              style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
                     cursor: pointer; color: #ff6f61; font-size: 1.3rem;">
            <i class="bi bi-eye-slash"></i>
        </span>
        <span class="error-message text-danger" id="contraseñaError"></span>
    </div>

    <!-- Confirmar Contraseña -->
    <div class="form-group position-relative">
        <label for="contraseña_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="contraseña_confirmation" name="contraseña_confirmation" >
        <span class="toggle-password" onclick="togglePassword('contraseña_confirmation', this)" 
              style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
                     cursor: pointer; color: #ff6f61; font-size: 1.3rem;">
            <i class="bi bi-eye-slash"></i>
        </span>
        <span class="error-message text-danger" id="contraseña_confirmationError"></span>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
        <button type="button" class="btn btn-warning" onclick="document.getElementById('formEmpleado').reset()">Limpiar Formulario</button>
    </div>
</form>


<hr class="my-5">
    <h3 class="mb-3 text-secondary">Lista de Usuarios</h3>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->rol->nombre_rol ?? 'Sin rol' }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <button 
                                    class="btn btn-warning btn-sm d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px; border-radius: 50%; padding: 0;"
                                    onclick="editarUsuario(
                                        {{ $usuario->id_usuario }},
                                        '{{ $usuario->nombre }}',
                                        '{{ $usuario->correo }}',
                                        {{ $usuario->rol_id }}
                                    )"
                                    title="Editar Usuario"
                                >
                                    <i class="fas fa-edit" style="font-size: 18px;"></i>
                                </button>


                                <!-- <form 
                                    action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" 
                                    method="POST"
                                    class="form-eliminar" 
                                    data-nombre="{{ $usuario->nombre }}"
                                    style="display: inline-block; margin: 0; padding: 0;"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; border-radius: 50%; padding: 0;"
                                        title="Eliminar Usuario"
                                    >
                                        <i class="fas fa-trash" style="font-size: 18px;"></i>
                                    </button>
                                </form> -->
                            @if ($usuario->rol_id == 5)
                                {{-- Cliente --}}
                                <form action="{{ route('clientes.destroy', $usuario->id_usuario) }}" method="POST" class="form-eliminar" data-nombre="{{ $usuario->nombre }}"
                                style="display: inline-block; margin: 0; padding: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; border-radius: 50%; padding: 0;"
                                        title="Eliminar Usuario Cliente"
                                    >
                                        <i class="fas fa-trash" style="font-size: 18px;"></i>
                                    </button>
                                </form>
                            @else
                                {{-- Empleado --}}
                                <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="form-eliminar" data-nombre="{{ $usuario->nombre }}"
                                style="display: inline-block; margin: 0; padding: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; border-radius: 50%; padding: 0;"
                                        title="Eliminar Usuario Empleado"
                                    >
                                        <i class="fas fa-trash" style="font-size: 18px;"></i>
                                    </button>
                                </form>
                            @endif

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content" id="formEditarUsuario">
            @csrf
            @method('PUT')

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id_usuario">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" id="edit_nombre_usuario" class="form-control" required>
                    <div class="error-message text-danger" id="edit_nombre_usuarioError"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Correo</label>
                    <input type="email" name="correo" id="edit_correo_usuario" class="form-control" required>
                    <div class="error-message text-danger" id="edit_correo_usuarioError"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rol</label>
                    <select name="rol" id="edit_rol_usuario" class="form-control" required>
                        <option value="">Seleccione un rol</option>
                        @foreach($rolesEmpleados as $rol)
                            <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                        @endforeach
                    </select>
                    <div class="error-message text-danger" id="edit_rol_usuarioError"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal para Editar Cliente -->
<div class="modal fade" id="modalEditarCliente" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content" id="formEditarCliente">
            @csrf
            @method('PUT')

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id_cliente">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" id="edit_nombre_cliente" class="form-control" required>
                    <div class="error-message text-danger" id="edit_nombre_clienteError"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Correo</label>
                    <input type="email" name="correo" id="edit_correo_cliente" class="form-control" required>
                    <div class="error-message text-danger" id="edit_correo_clienteError"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
            </div>
        </form>
    </div>
</div>



<!-- Scripts necesarios -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</div>


@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: `{!! implode('<br>', $errors->all()) !!}`
    });
</script>
@endif

<script>
function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    const icon = iconElement.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        input.type = "password";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}
</script>
<script>{!! file_get_contents(resource_path('js/usuarios.js')) !!}</script>
@endsection
