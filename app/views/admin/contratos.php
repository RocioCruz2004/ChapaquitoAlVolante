<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php"); 
    exit();
}

require_once '../../../config/database.php'; 
require_once '../../models/Contrato.php'; 

$database = new Database();
$db = $database->getConnection();
$contrato = new Contrato($db);

// Obtener los contratos activos
$contratos = $contrato->verContratos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contratos Activos</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Contratos Activos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($contratos as $contrato): ?>
        <tr>
            <td><?php echo htmlspecialchars($contrato['id']); ?></td>
            <td><?php echo htmlspecialchars($contrato['fecha_inicio']); ?></td>
            <td><?php echo htmlspecialchars($contrato['fecha_fin']); ?></td>
            <td><?php echo htmlspecialchars($contrato['cliente_nombre']); ?></td>
            <td><?php echo htmlspecialchars($contrato['vehiculo_nombre']); ?></td>
            <td><?php echo htmlspecialchars($contrato['estado']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
