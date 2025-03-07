<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Chapaquito Al Volante</title>
    <link rel="stylesheet" href="../../public/css/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <form action="../../app/controllers/AuthController.php" method="POST">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" name="login">Ingresar</button>
        </form>
    </div>
</body>

</html>