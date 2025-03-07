<?php
session_start();

// Verificar si el usuario está logueado y es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Cliente.php';  // Incluir el modelo Cliente

$database = new Database();
$db = $database->getConnection();

$cliente = new Cliente($db);

// Verificar si se recibe un ID de cliente
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Obtener los detalles del cliente para editarlo
    $cliente_data = $cliente->getClienteById($cliente_id);  // Método que debes agregar en el modelo Cliente
}

if (!$cliente_data) {
    echo "Cliente no encontrado.";
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // Actualizar el cliente en la base de datos
    if ($cliente->editarCliente($cliente_id, $nombre, $email, $telefono)) {
        echo "Cliente actualizado con éxito.";
    } else {
        echo "Error al actualizar el cliente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Editar Cliente</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente_data['nombre']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cliente_data['email']); ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente_data['telefono']); ?>" required><br><br>

        <button type="submit">Actualizar Cliente</button>
    </form>
</body>
</html>
