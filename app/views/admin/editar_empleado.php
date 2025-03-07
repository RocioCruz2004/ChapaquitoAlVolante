<?php
session_start();

// Verificar si el usuario está logueado y es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Empleado.php';  // Incluir el modelo Empleado

$database = new Database();
$db = $database->getConnection();

$empleado = new Empleado($db);

// Verificar si se recibe un ID de empleado
if (isset($_GET['id'])) {
    $empleado_id = $_GET['id'];

    // Obtener los detalles del empleado para editarlo
    $empleado_data = $empleado->getEmpleadoById($empleado_id);  // Método que debes agregar en el modelo Empleado
}

if (!$empleado_data) {
    echo "Empleado no encontrado.";
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $rol = "empleado";  // Aseguramos que el rol sea "empleado"

    // Actualizar el empleado en la base de datos
    if ($empleado->editarEmpleado($empleado_id, $nombre, $email, $telefono, $rol)) {
        echo "Empleado actualizado con éxito.";
    } else {
        echo "Error al actualizar el empleado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="../../../public/css/administrador.css">
</head>
<body>
    <h2>Editar Empleado</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($empleado_data['nombre']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($empleado_data['email']); ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empleado_data['telefono']); ?>" required><br><br>

        <button type="submit">Actualizar Empleado</button>
    </form>
</body>
</html>
