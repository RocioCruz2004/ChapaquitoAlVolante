<?php
session_start();  // Asegurarnos de que la sesión esté iniciada

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';  // Asegurarnos de incluir la base de datos
require_once '../../models/Usuario.php';  // Incluir el modelo Usuario

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// Obtener los datos del cliente usando el ID de usuario de la sesión
$user = $usuario->getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Cliente - Chapaquito al Volante</title>
    <link rel="stylesheet" href="../../../public/css/dashboard_cliente.css"> <!-- Archivo CSS externo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- FontAwesome -->
</head>
<body>
    <!-- Contenido principal -->
    <div class="container my-5">
        <h1 class="text-center mb-4">Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></h1>
        <div class="dashboard-options">
            <!-- Tarjeta 1: Ver Perfil -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Ver Perfil</h5>
                    <p class="card-text">Actualiza tu información personal.</p>
                    <a href="../../controllers/ClienteController.php?action=perfil" class="btn btn-primary">Ir al Perfil</a>
                </div>
            </div>

            <!-- Tarjeta 2: Hacer Nueva Reserva -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Hacer Nueva Reserva</h5>
                    <p class="card-text">Reserva un vehículo para tu próximo viaje.</p>
                    <a href="reservar.php" class="btn btn-primary">Reservar Ahora</a>
                </div>
            </div>

            <!-- Tarjeta 3: Ver Mis Reservas -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Ver Mis Reservas</h5>
                    <p class="card-text">Revisa el estado de tus reservas actuales.</p>
                    <a href="ver_reservas.php" class="btn btn-primary">Ver Reservas</a>
                </div>
            </div>

            <!-- Tarjeta 4: Información de la Empresa -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Información de la Empresa</h5>
                    <p class="card-text">Conoce más sobre nosotros.</p>
                    <a href="infoempresa.php" class="btn btn-primary">Más Información</a>
                </div>
            </div>
        </div>

        <!-- Botón de Cerrar Sesión -->
        <div class="text-center mt-5">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>