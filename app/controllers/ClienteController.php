<?php
session_start();
require_once '../../config/database.php';  // Incluir la base de datos
require_once '../models/Cliente.php';  // Incluir el modelo Cliente

$database = new Database();
$db = $database->getConnection();
$cliente = new Cliente($db);

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

// Acción para ver el perfil
if (isset($_GET['action']) && $_GET['action'] == 'perfil') {
    $perfil = $cliente->getPerfil($_SESSION['user_id']);
    require_once '../../app/views/cliente/perfil.php';  // Mostrar la vista del perfil
}

// Editar perfil
if (isset($_POST['editar_perfil'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Llamar al método para editar el perfil
    if ($cliente->editarPerfil($_SESSION['user_id'], $nombre, $telefono, $email)) {
        // Redirigir a la vista de perfil después de la actualización
        header("Location: ?action=perfil");
        exit();
    } else {
        echo "Error al actualizar el perfil.";
    }
}
?>
