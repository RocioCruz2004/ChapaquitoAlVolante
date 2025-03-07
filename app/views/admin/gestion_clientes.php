<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Cliente.php';

$database = new Database();
$db = $database->getConnection();
$cliente = new Cliente($db);

// Obtener todos los clientes
$clientes = $cliente->getAllClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Gestionar Clientes</h2>
    
    <!-- Tabla de Clientes -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a> 
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
