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

    // Verificar si se está realizando una acción de eliminar
    if (isset($_GET['action']) && $_GET['action'] == 'eliminar') {
        // Intentar eliminar el vehículo
        if ($vehiculo->eliminarVehiculo($vehiculo_id)) {
            // Redirigir a la página de gestión de vehículos después de eliminar
            header("Location: gestion_vehiculos.php");
            exit();
        } else {
            echo "Error al eliminar el vehículo.";
        }
    } else {
        // Obtener los detalles del vehículo para editarlo
        $vehiculo_data = $vehiculo->getVehiculoById($vehiculo_id);

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
            $imagen = $_POST['imagen']; // URL de la imagen

            // Actualizar el vehículo en la base de datos
            if ($vehiculo->editarVehiculo($vehiculo_id, $marca, $modelo, $anio, $placa, $tipo, $precio_diario, $estado, $descripcion, $imagen)) {
                echo "Vehículo actualizado con éxito.";
            } else {
                echo "Error al actualizar el vehículo.";
            }
        }
    }
} else {
    echo "ID de vehículo no válido.";
}
?>