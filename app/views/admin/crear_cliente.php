<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../../../config/database.php';
    require_once '../../models/Cliente.php';

    $database = new Database();
    $db = $database->getConnection();
    $cliente = new Cliente($db);

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // Crear el cliente en la base de datos
    if ($cliente->crearCliente($nombre, $email, $telefono)) {
        echo "Cliente creado con éxito!";
    } else {
        echo "Error al crear cliente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Crear Cliente</h2>
    <form method="POST" action="crear_cliente.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br><br>

        <button type="submit">Crear Cliente</button>
    </form>
</body>
</html>
