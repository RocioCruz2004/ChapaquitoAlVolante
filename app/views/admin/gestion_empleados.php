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

// Obtener todos los empleados
$empleados = $empleado->getAllEmpleados();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Empleados</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Gestionar Empleados</h2>
    
    <!-- Tabla de Empleados -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($empleados as $empleado): ?>
            <tr>
                <td><?php echo htmlspecialchars($empleado['id']); ?></td>
                <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                <td><?php echo htmlspecialchars($empleado['email']); ?></td>
                <td><?php echo htmlspecialchars($empleado['rol']); ?></td>
                <td>
                    <a href="editar_empleado.php?id=<?php echo $empleado['id']; ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="crear_empleado.php">Crear Nuevo Empleado</a>
</body>
</html>
