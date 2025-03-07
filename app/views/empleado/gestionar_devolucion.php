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

$mensaje = ""; // Variable para el mensaje de estado

// Verificar si se recibe un ID de contrato
if (isset($_GET['id'])) {
    $contrato_id = $_GET['id'];

    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $estado = $_POST['estado'];  // Obtener el estado seleccionado

        // Intentar gestionar la devolución y cambiar el estado
        if ($contrato->gestionarDevolucion($contrato_id, $estado)) {
            $mensaje = "El contrato ha sido actualizado correctamente.";
        } else {
            $mensaje = "Hubo un error al actualizar el contrato.";
        }
    }

    // Obtener los detalles del contrato para mostrar en el formulario
    $contrato_data = $contrato->getContratoById($contrato_id);
    if (!$contrato_data) {
        echo "Contrato no encontrado.";
        exit();
    }
} else {
    echo "ID de contrato no válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Devolución</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #ff4c4c, #ff8c00);
            margin: 0;
            padding: 20px;
        }
        .contenedor {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h2, h3 {
            color: #d32f2f;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #d32f2f;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .mensaje {
            margin-top: 15px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            font-weight: bold;
        }
        .exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h2>Gestión de Devolución de Vehículo</h2>
        <p><a href="contratos.php">Volver a la lista de contratos</a></p>
        
        <h3>Detalles del Contrato</h3>
        <p><strong>ID del Contrato:</strong> <?php echo htmlspecialchars($contrato_data['id']); ?></p>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($contrato_data['cliente_nombre']); ?></p>
        <p><strong>Vehículo:</strong> <?php echo htmlspecialchars($contrato_data['vehiculo_nombre']); ?></p>
        <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($contrato_data['fecha_inicio']); ?></p>
        <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($contrato_data['fecha_fin']); ?></p>
    
        <!-- Formulario para cambiar el estado -->
        <form action="gestionar_devolucion.php?id=<?php echo $contrato_id; ?>" method="POST">
            <label for="estado">Seleccionar estado:</label>
            <select name="estado" id="estado">
                <option value="pendiente" <?php echo ($contrato_data['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="confirmada" <?php echo ($contrato_data['estado'] == 'confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                <option value="cancelada" <?php echo ($contrato_data['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                <option value="finalizada" <?php echo ($contrato_data['estado'] == 'finalizada') ? 'selected' : ''; ?>>Finalizada</option>
            </select>
            <br>
            <button type="submit">Actualizar Estado</button>
        </form>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo ($mensaje == "El contrato ha sido actualizado correctamente.") ? 'exito' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
