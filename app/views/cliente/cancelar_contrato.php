<?php
session_start();

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

require_once '../../models/Contrato.php';

$database = new Database();
$db = $database->getConnection();
$reserva = new Reserva($db);

// Verificar si se recibe un ID de reserva
if (isset($_GET['id'])) {
    $reserva_id = $_GET['id'];

    // Llamar al método de cancelar la reserva
    if ($reserva->cancelarReserva($reserva_id)) {
        header("Location: mis_reservas.php"); // Redirigir a la página de reservas
        exit();
    } else {
        echo "Error al cancelar la reserva.";
    }
}
?>
