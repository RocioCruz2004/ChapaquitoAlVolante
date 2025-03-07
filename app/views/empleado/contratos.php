<?php
session_start();

// Verificar si el usuario está logueado y tiene el rol 'empleado'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'empleado') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Contrato.php';

$database = new Database();
$db = $database->getConnection();

$contrato = new Contrato($db);
$contratos = $contrato->verContratos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contratos Activos</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; 
            background: linear-gradient(135deg, #ff4c4c, #ff8c00);
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: white;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            max-width: 1000px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .acciones a {
            text-decoration: none;
            color:rgb(185, 12, 12);
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .acciones a:hover {
            background-color:rgb(255, 0, 0);
            color: white;
        }

        p {
            color: #7f8c8d;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Contratos Activos</h2>
    <?php if (count($contratos) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($contratos as $contrato): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contrato['id']); ?></td>
                    <td><?php echo htmlspecialchars($contrato['fecha_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($contrato['fecha_fin']); ?></td>
                    <td><?php echo htmlspecialchars($contrato['cliente_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($contrato['vehiculo_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($contrato['estado']); ?></td>
                    <td><?php echo htmlspecialchars($contrato['total']); ?></td>
                    <td class="acciones">
                        <a href="detalle_contrato.php?id=<?php echo $contrato['id']; ?>">Ver</a> | 
                        <a href="gestionar_devolucion.php?id=<?php echo $contrato['id']; ?>">Devolución</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay contratos activos.</p>
    <?php endif; ?>
</body>
</html>
