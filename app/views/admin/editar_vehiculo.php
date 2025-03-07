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

// Verificar si se recibe un ID de vehículo
if (isset($_GET['id'])) {
    $vehiculo_id = $_GET['id'];

    // Obtener los detalles del vehículo para editarlo
    $vehiculo_data = $vehiculo->getVehiculoById($vehiculo_id);  // Método que debes agregar en el modelo Vehiculo
}

if (!$vehiculo_data) {
    echo "Vehículo no encontrado.";
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $placa = $_POST['placa'];
    $tipo = $_POST['tipo'];
    $precio_diario = $_POST['precio_diario'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen']; // Deberías agregar funcionalidad para subir imágenes si es necesario

    // Actualizar el vehículo en la base de datos
    if ($vehiculo->editarVehiculo($vehiculo_id, $marca, $modelo, $anio, $placa, $tipo, $precio_diario, $estado, $descripcion, $imagen)) {
        echo "Vehículo actualizado con éxito.";
    } else {
        echo "Error al actualizar el vehículo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>

<body>
    <h2>Editar Vehículo</h2>
    <form method="POST">
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($vehiculo_data['marca']); ?>" required><br><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($vehiculo_data['modelo']); ?>" required><br><br>

        <label for="anio">Año:</label>
        <input type="text" id="anio" name="anio" value="<?php echo htmlspecialchars($vehiculo_data['anio']); ?>" required><br><br>

        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" value="<?php echo htmlspecialchars($vehiculo_data['placa']); ?>" required><br><br>

        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" value="<?php echo htmlspecialchars($vehiculo_data['tipo']); ?>" required><br><br>

        <label for="precio_diario">Precio Diario:</label>
        <input type="text" id="precio_diario" name="precio_diario" value="<?php echo htmlspecialchars($vehiculo_data['precio_diario']); ?>" required><br><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="disponible" <?php echo $vehiculo_data['estado'] == 'disponible' ? 'selected' : ''; ?>>Disponible</option>
            <option value="no disponible" <?php echo $vehiculo_data['estado'] == 'no disponible' ? 'selected' : ''; ?>>No disponible</option>
        </select><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($vehiculo_data['descripcion']); ?></textarea><br><br>

        <!-- Campo para la URL de la imagen -->
        <label for="imagen">Imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?php echo htmlspecialchars($vehiculo_data['imagen']); ?>"><br><br>

        <button type="submit">Actualizar Vehículo</button>
    </form>
</body>

</html>