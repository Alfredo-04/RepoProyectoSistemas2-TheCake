<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login y Registro - The Cake</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        {!! file_get_contents(resource_path('css/stylesLS.css')) !!}
    </style>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

<div class="container" id="container">
    <!-- Formulario de Registro -->
    <div class="form-container register-container">
        <form id="signupForm" action="{{ route('usuarios.store') }}" method="POST" novalidate onsubmit="event.preventDefault();">
            @csrf <!-- Token de seguridad de Laravel -->
            
            <h1>Regístrate</h1>
            <input type="text" id="signupName" name="nombre" placeholder="Nombre" required>
            <span class="error-message" id="signupNameError"></span>
            
            <input type="text" id="signupLastName1" name="apePat" placeholder="Apellido Paterno" required>
            <span class="error-message" id="signupLastName1Error"></span>
            
            <input type="text" id="signupLastName2" name="apeMat" placeholder="Apellido Materno" required>
            <span class="error-message" id="signupLastName2Error"></span>
            
            <input type="email" id="signupEmail" name="correo" placeholder="Email" required>
            <span class="error-message" id="signupEmailError"></span>
            
            <div class="input-wrapper">
                <input type="password" id="signupPassword" name="contraseña" placeholder="Contraseña" required>
                <span class="toggle-password" onclick="togglePassword('signupPassword', this)">
                    <i class="bi bi-eye-slash"></i> 
                </span>
            </div>
            <span class="error-message" id="signupPasswordError"></span>
            
            <div class="input-wrapper">
                <input type="password" id="signupConfirmPassword" name="contraseña_confirmation" placeholder="Confirmar Contraseña" required>
                <span class="toggle-password" onclick="togglePassword('signupConfirmPassword', this)">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            <span class="error-message" id="signupConfirmPasswordError"></span>
            
            <button type="submit">Registrarse</button>
        </form>
    </div>

    <!-- Formulario de Login -->
<div class="form-container login-container">
    <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
        @csrf
        <h1>Inicia Sesión</h1>

        

        
        <input type="email" id="loginEmail" name="correo" placeholder="Email" required value="{{ old('correo') }}">
        <span class="error-message" id="loginEmailError"></span>
        
        <div class="input-wrapper">
            <input type="password" id="loginPassword" name="contraseña" placeholder="Contraseña" required>
            <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
                <i class="bi bi-eye-slash"></i>
            </span>
        </div>
        <span class="error-message" id="loginPasswordError"></span>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
</div>

    <!-- Overlay (Efecto visual) -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
            <img 
                src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(resource_path('img/Logo_the_cake.jpg'))) }}" 
                alt="Logo The Cake" 
                class="logo">

                <h1 class="title">¿Ya tienes una cuenta?</h1>
                <p>Inicia sesión aquí.</p>
                <button class="ghost" id="loginButton">Iniciar Sesión</button>
            </div>
            <div class="overlay-panel overlay-right">
            <img 
                src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(resource_path('img/Logo_the_cake.jpg'))) }}" 
                alt="Logo The Cake" 
                class="logo">

                <h1 class="title">¡Únete a nosotros!</h1>
                <p>Regístrate para comenzar tu viaje con The Cake.</p>
                <button class="ghost" id="registerButton">Registrarse</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>{!! file_get_contents(resource_path('js/scriptLS.js')) !!}</script>

</body>
</html>