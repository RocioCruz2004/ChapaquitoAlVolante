<?php
session_start();

// Verificar si el usuario está logueado y es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Vehiculo.php';  // Incluir el modelo Vehiculo

$database = new Database();
$db = $database->getConnection();
$vehiculo = new Vehiculo($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $placa = $_POST['placa'];
    $tipo = $_POST['tipo'];  // Asegúrate de que este campo esté en tu formulario
    $precio_diario = $_POST['precio_diario'];  // Asegúrate de que este campo esté en tu formulario
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];  // Asegúrate de que este campo esté en tu formulario
    $imagen = $_POST['imagen'];  // Obtener la URL de la imagen del formulario

    // Crear el vehículo en la base de datos
    if ($vehiculo->crearVehiculo($marca, $modelo, $anio, $placa, $tipo, $precio_diario, $estado, $descripcion, $imagen)) {
        echo "Vehículo creado exitosamente!";
    } else {
        echo "Error al crear el vehículo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Vehículo</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Crear Vehículo</h2>
    <form action="crear_vehiculo.php" method="POST">
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required><br><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required><br><br>

        <label for="anio">Año:</label>
        <input type="text" id="anio" name="anio" required><br><br>

        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required><br><br>

        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" required><br><br>

        <label for="precio_diario">Precio Diario:</label>
        <input type="text" id="precio_diario" name="precio_diario" required><br><br>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="disponible">Disponible</option>
            <option value="no disponible">No Disponible</option>
        </select><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="imagen">Imagen (URL):</label>
        <input type="text" name="imagen" id="imagen" required><br><br>

        <button type="submit">Crear Vehículo</button>
    </form>
</body>
</html>