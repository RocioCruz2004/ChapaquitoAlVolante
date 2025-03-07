<?php
session_start();

require_once '../../config/database.php';  
require_once '../models/Reserva.php';  
require_once '../models/Servicio.php';  

$database = new Database();
$db = $database->getConnection();
$reserva = new Reserva($db);
$servicio = new Servicio($db);

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

// Acción para realizar la reserva
if (isset($_POST['reservar'])) {
    // Recibir los datos del formulario
    $id_usuario = $_SESSION['user_id'];
    $id_vehiculo = $_POST['vehiculo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $total = $_POST['total'];  // Total recibido desde el frontend

    // Validar si las fechas son correctas
    if (strtotime($fecha_inicio) < strtotime(date('Y-m-d'))) {
        echo "La fecha de inicio no puede ser anterior a la fecha de hoy.";
        exit();
    }

    // Verificar que el vehículo no esté reservado en esas fechas
    if ($reserva->verificarReserva($id_vehiculo, $fecha_inicio, $fecha_fin)) {
        echo "El vehículo ya está reservado en esas fechas.";
        exit();
    }

    // Guardar la reserva en la base de datos
    $reserva_id = $reserva->realizarReserva($id_usuario, $id_vehiculo, $fecha_inicio, $fecha_fin, $total);  // El total se guarda aquí

    if ($reserva_id) {
        echo "Reserva realizada con éxito!";
    } else {
        echo "Hubo un error al realizar la reserva.";
    }
}

// Si se recibe el ID del vehículo
if (isset($_GET['vehiculo_id'])) {
    $vehiculo_id = $_GET['vehiculo_id'];

    // Obtener las fechas reservadas para el vehículo
    $fechas_reservadas = $reserva->getFechasReservadas($vehiculo_id);

    // Enviar las fechas reservadas al frontend
    echo json_encode(['fechas_reservadas' => $fechas_reservadas]);
    exit();
}

?>
