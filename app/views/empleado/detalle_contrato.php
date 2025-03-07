<?php
session_start();

// Verificar si el usuario está logueado y tiene el rol 'empleado'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'empleado') {
    header("Location: ../login.php"); // Redirigir si no es un empleado
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Contrato.php';  // Incluir el modelo 'Contrato'

$database = new Database();
$db = $database->getConnection();

$contrato = new Contrato($db);

// Verificar si se recibe un ID de contrato
if (isset($_GET['id'])) {
    $contrato_id = $_GET['id'];
    $contrato_data = $contrato->verDetallesContrato($contrato_id);
}

if (!$contrato_data) {
    echo "Contrato no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Contrato</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #ff4c4c, #ff8c00);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .contenedor {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }
        h2, h3 {
            color: #b30000;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        strong {
            color: #b30000;
        }
        img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 10px auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2>Detalles del Contrato</h2>
        <p><strong>ID del Contrato:</strong> <?php echo htmlspecialchars($contrato_data['id']); ?></p>
        <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($contrato_data['fecha_inicio']); ?></p>
        <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($contrato_data['fecha_fin']); ?></p>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($contrato_data['cliente_nombre']); ?></p>
        <p><strong>Estado del Contrato:</strong> <?php echo htmlspecialchars($contrato_data['estado']); ?></p>
        <p><strong>Tipo de Entrega:</strong> <?php echo htmlspecialchars($contrato_data['tipo_entrega']); ?></p>
        <p><strong>Dirección de Entrega:</strong> <?php echo htmlspecialchars($contrato_data['direccion_entrega']); ?></p>
        <p><strong>Total:</strong> <?php echo htmlspecialchars($contrato_data['total']); ?></p>
        <p><strong>Fecha de Reserva:</strong> <?php echo htmlspecialchars($contrato_data['fecha_reserva']); ?></p>
        
        <h3>Detalles del Vehículo</h3>
        <p><strong>Nombre del Vehículo:</strong> <?php echo htmlspecialchars($contrato_data['vehiculo_nombre']); ?></p>
        <p><strong>Marca:</strong> <?php echo htmlspecialchars($contrato_data['marca']); ?></p>
        <p><strong>Modelo:</strong> <?php echo htmlspecialchars($contrato_data['modelo']); ?></p>
        <p><strong>Año:</strong> <?php echo htmlspecialchars($contrato_data['anio']); ?></p>
        <p><strong>Placa:</strong> <?php echo htmlspecialchars($contrato_data['placa']); ?></p>
        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($contrato_data['tipo']); ?></p>
        <p><strong>Precio Diario:</strong> <?php echo htmlspecialchars($contrato_data['precio_diario']); ?></p>
        <p><strong>Estado del Vehículo:</strong> <?php echo htmlspecialchars($contrato_data['vehiculo_estado']); ?></p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($contrato_data['descripcion']); ?></p>
        <p><strong>Imagen del Vehículo:</strong><br><img src="<?php echo htmlspecialchars($contrato_data['vehiculo_imagen']); ?>" alt="Imagen del vehículo"></p>
    </div>
</body>
</html>
