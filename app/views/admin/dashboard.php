<?php
session_start();

// Verificar si el usuario está logueado y tiene el rol 'administrador'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'administrador') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Reporte.php';  // Asegúrate de tener este modelo correctamente configurado

$database = new Database();
$db = $database->getConnection();
$reporte = new Reporte($db);

// Obtener los reportes de la base de datos
$reservas = $reporte->getTotalReservas();
$clientes = $reporte->getTotalClientes();
$vehiculos = $reporte->getTotalVehiculos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Cargar Chart.js -->
    <link rel="stylesheet" href="../../../public/css/administrador.css">
    
</head>
<body>

    <h2>Dashboard de Administración</h2>

    <!-- Menú de Navegación -->
    <nav>
        <ul>
            <li><a href="gestion_clientes.php">Gestionar Clientes</a></li>
            <li><a href="gestion_empleados.php">Gestionar Empleados</a></li>
            <li><a href="gestion_vehiculos.php">Gestionar Vehículos</a></li>
            <li><a href="contratos.php">Gestionar Contratos</a></li>
        </ul>
    </nav>

    <!-- Estats -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total de Reservas</h3>
            <p><?php echo $reservas; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total de Clientes</h3>
            <p><?php echo $clientes; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total de Vehículos</h3>
            <p><?php echo $vehiculos; ?></p>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="chart-container">
        <div>
            <h4>Reporte Gráfico de Reservas</h4>
            <canvas id="reservasChart" width="400" height="200"></canvas>
        </div>
        <div>
            <h4>Reporte Gráfico de Clientes</h4>
            <canvas id="clientesChart" width="400" height="200"></canvas>
        </div>
        <div>
            <h4>Reporte Gráfico de Vehículos</h4>
            <canvas id="vehiculosChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        // Obtener los datos de PHP y pasarlos a JavaScript
        const reservas = <?php echo json_encode($reservas); ?>;
        const clientes = <?php echo json_encode($clientes); ?>;
        const vehiculos = <?php echo json_encode($vehiculos); ?>;

        // Datos para los gráficos
        const dataReservas = {
            labels: ['Reservas'],
            datasets: [{
                label: 'Total de Reservas',
                data: [reservas],
                backgroundColor: '#FF5733',  // Color de la barra de reservas
                borderColor: '#FF5733',
                borderWidth: 1
            }]
        };

        const dataClientes = {
            labels: ['Clientes'],
            datasets: [{
                label: 'Total de Clientes',
                data: [clientes],
                backgroundColor: '#33FF57',  // Color de la barra de clientes
                borderColor: '#33FF57',
                borderWidth: 1
            }]
        };

        const dataVehiculos = {
            labels: ['Vehículos'],
            datasets: [{
                label: 'Total de Vehículos',
                data: [vehiculos],
                backgroundColor: '#3357FF',  // Color de la barra de vehículos
                borderColor: '#3357FF',
                borderWidth: 1
            }]
        };

        // Gráfico de Reservas
        const ctxReservas = document.getElementById('reservasChart').getContext('2d');
        const reservasChart = new Chart(ctxReservas, {
            type: 'bar', // Ahora usamos 'bar' en lugar de 'horizontalBar'
            data: dataReservas
        });

        // Gráfico de Clientes
        const ctxClientes = document.getElementById('clientesChart').getContext('2d');
        const clientesChart = new Chart(ctxClientes, {
            type: 'bar', // Ahora usamos 'bar' en lugar de 'horizontalBar'
            data: dataClientes
        });

        // Gráfico de Vehículos
        const ctxVehiculos = document.getElementById('vehiculosChart').getContext('2d');
        const vehiculosChart = new Chart(ctxVehiculos, {
            type: 'bar', // Ahora usamos 'bar' en lugar de 'horizontalBar'
            data: dataVehiculos
        });
    </script>

</body>
</html>
