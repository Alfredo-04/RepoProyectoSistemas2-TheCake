<!DOCTYPE html>
<html>
<head>
    <title>Nuevo mensaje de contacto</title>
</head>
<body>
    <h2>Nuevo mensaje de contacto desde The Cake</h2>
    
    <p><strong>Nombre:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Teléfono:</strong> {{ $phone }}</p>
    <p><strong>Calificación:</strong> {{ $rating }}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $messageText }}</p>
</body>
</html>