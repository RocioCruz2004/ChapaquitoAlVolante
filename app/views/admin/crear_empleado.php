<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php"); 
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Empleado.php';

$database = new Database();
$db = $database->getConnection();
$empleado = new Empleado($db);

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];

    if ($empleado->agregarEmpleado($nombre, $email, $telefono, $rol)) {
        $mensaje = "Empleado creado con éxito!";
    } else {
        $mensaje = "Error al crear empleado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empleado</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Crear Empleado</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (!empty($mensaje)): ?>
        <div style="color: <?php echo (strpos($mensaje, 'éxito') !== false) ? 'green' : 'red'; ?>; margin-bottom: 20px;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario para crear empleado -->
    <form method="POST" action="crear_empleado.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br><br>

        <label for="rol">Rol:</label>
        <select name="rol" required>
            <option value="empleado">Empleado</option>
            <option value="administrador">Administrador</option>
        </select><br><br>

        <button type="submit">Crear Empleado</button>
    </form>
</body>
</html>