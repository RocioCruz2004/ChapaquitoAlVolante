<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Vehiculo.php';

$database = new Database();
$db = $database->getConnection();
$vehiculo = new Vehiculo($db);

// Obtener todos los vehículos
$vehiculos = $vehiculo->getAllVehiculos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Vehículos</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Gestionar Vehículos</h2>
    
    <!-- Tabla de Vehículos -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Placa</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($vehiculos as $vehiculo): ?>
            <tr>
                <td><?php echo htmlspecialchars($vehiculo['id']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['marca']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['modelo']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['anio']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['placa']); ?></td>
                <td><?php echo htmlspecialchars($vehiculo['estado']); ?></td>
                <td>
                    <a href="editar_vehiculo.php?id=<?php echo $vehiculo['id']; ?>">Editar</a> 
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="crear_vehiculo.php">Crear Nuevo Vehículo</a>
</body>
</html>
