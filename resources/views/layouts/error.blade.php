<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Error')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff6f61, #f8a29b);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            padding: 0;
            margin: 0;
            overflow: hidden;
            animation: fadeInBody 1s ease-out;
        }

        @keyframes fadeInBody {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .error-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: slideIn 1.2s ease-out;
        }

        @keyframes slideIn {
            0% { opacity: 0; transform: translateY(-40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .error-icon {
            font-size: 5rem;
            margin-bottom: 10px;
            animation: pulseIcon 2s infinite ease-in-out;
        }

        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            animation: fadeInCode 1.5s ease-in;
        }

        @keyframes fadeInCode {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .error-message {
            font-size: 1.5rem;
            margin-bottom: 30px;
            max-width: 600px;
            padding: 0 20px;
            animation: fadeInMessage 2s ease-in;
        }

        @keyframes fadeInMessage {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-volver {
            background-color: #ffbc0a;
            padding: 12px 30px;
            font-weight: bold;
            border-radius: 12px;
            color: #000;
            text-decoration: none;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            transition: 0.3s ease-in-out;
            animation: fadeInButton 2.2s ease;
        }

        @keyframes fadeInButton {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-volver:hover {
            background-color: #f4a900;
            transform: scale(1.05);
        }
@keyframes glitch {
  0% {
    text-shadow: 2px 2px red, -2px -2px cyan;
    transform: translate(0, 0);
  }
  10% {
    text-shadow: -2px -2px lime, 2px 2px magenta;
    transform: translate(-2px, 2px) skew(-2deg);
  }
  20% {
    text-shadow: 2px 2px red, -2px -2px cyan;
    transform: translate(2px, -2px) skew(2deg);
  }
  30% {
    text-shadow: -2px -2px lime, 2px 2px magenta;
    transform: translate(1px, 1px);
  }
  40% {
    text-shadow: 3px 3px red, -3px -3px cyan;
    transform: translate(-1px, -1px) skew(0deg);
  }
  50% {
    text-shadow: none;
    transform: translate(0, 0);
  }
  60% {
    text-shadow: 1px -1px red, -1px 1px cyan;
    transform: translate(2px, 0) skew(3deg);
  }
  70% {
    text-shadow: -3px 3px lime, 3px -3px magenta;
    transform: translate(-2px, 2px);
  }
  80% {
    text-shadow: 2px -2px red, -2px 2px cyan;
    transform: translate(0, -2px) skew(-1deg);
  }
  90% {
    text-shadow: none;
    transform: translate(1px, 1px);
  }
  100% {
    text-shadow: 2px 2px red, -2px -2px cyan;
    transform: translate(0, 0);
  }
}

.glitch {
  animation: glitch 1.2s infinite;
}


    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">{!! trim($__env->yieldContent('icon')) ?: '<i class="fas fa-triangle-exclamation"></i>' !!}</div>

        <div class="error-code glitch">@yield('code', 'Error')</div>
<div class="error-message glitch">@yield('message', 'Ha ocurrido un error inesperado.')</div>

        <a href="{{ route('home') }}" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>
</body>
<script>
    // Forzamos recarga si viene del cache del navegador
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
</html>
