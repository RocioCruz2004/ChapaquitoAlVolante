<?php
session_start();
// Verificar si el usuario está logueado y tiene el rol 'empleado'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'empleado') {
    header("Location: ../login.php"); // Redirigir si no es un empleado
    exit();
}

// Incluir la clase Database para la conexión
require_once '../../../config/database.php';
// Incluir el modelo de Empleado
require_once '../../models/Empleado.php';

// Crear una instancia de la clase Database para obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia del modelo Empleado
$empleado = new Empleado($db);

// Obtener la información del empleado logueado usando su ID de sesión
$empleado_data = $empleado->getEmpleadoById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Empleado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #ff4c4c, #ff8c00);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .contenedor {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            color: #d32f2f;
            margin-bottom: 15px;
        }
        p {
            margin: 10px 0;
            color: #333;
        }
        strong {
            color: #d32f2f;
        }
    </style>
</head>
<body>
<div class="contenedor">
        <h2>Perfil de <?php echo htmlspecialchars($empleado_data['nombre']); ?></h2>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($empleado_data['email']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($empleado_data['telefono']); ?></p>
        <p><strong>Rol:</strong> <?php echo htmlspecialchars($empleado_data['rol']); ?></p>
        <p><strong>Fecha de Registro:</strong> <?php echo htmlspecialchars($empleado_data['fecha_registro']); ?></p>
    </div>
</body>
</html>
