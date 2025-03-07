<?php

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

require_once '../../config/database.php';  // Asegurarnos de incluir la base de datos
require_once '../models/Usuario.php';  // Incluir el modelo Usuario

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// Obtener el perfil del cliente usando su ID
$perfil = $usuario->getUserById($_SESSION['user_id']);

// Comprobar si hay un mensaje de éxito
$perfilActualizado = isset($_SESSION['perfil_actualizado']) ? $_SESSION['perfil_actualizado'] : false;
if ($perfilActualizado) {
    unset($_SESSION['perfil_actualizado']);  // Eliminar mensaje de la sesión después de mostrarlo
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Cliente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #ff4c4c, #ff8c00);;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .contenedor {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #c00;
            margin-bottom: 1rem;
        }
        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin: 10px 0 5px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #c00;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #900;
        }
        .volver {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #c00;
            font-weight: bold;
        }
        .volver:hover {
            color: #900;
        }
        .mensaje-exito {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h2>Perfil del Cliente</h2>
    
    <!-- Mostrar mensaje de éxito si el perfil fue actualizado -->
    <?php if ($perfilActualizado): ?>
        <p class="mensaje-exito">Perfil actualizado con éxito.</p>
    <?php endif; ?>
    
    <form action="../../app/controllers/ClienteController.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($perfil['nombre']); ?>" required>
        
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($perfil['email']); ?>" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($perfil['telefono']); ?>" required>
        
        <button type="submit" name="editar_perfil">Actualizar Perfil</button>
    </form>
    <a href="../views/cliente/dashboard.php" class="volver">Volver a Inicio</a>
</div>

</body>
</html>
