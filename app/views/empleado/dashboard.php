<?php
session_start();

// Verificar si el usuario está logueado y tiene el rol 'empleado'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'empleado') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Empleado.php';

$database = new Database();
$db = $database->getConnection();
$empleado = new Empleado($db);

$clientesData = $empleado->contarClientesPorFecha();
$reservasData = $empleado->contarReservasPorFecha();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Empleado</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #ff4c4c, #ff8c00);
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color:rgb(255, 255, 255);
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        form {
            margin: 20px 0;
        }
        input, button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color:rgb(224, 16, 16);
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color:rgb(158, 3, 3);
        }
        .graficos {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .grafico-container {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h2>Bienvenido al Dashboard del Empleado</h2>
    <nav>
        <ul>
        <li><a href="perfil.php" target="_blank">Ver Perfil</a></li>
        <li><a href="contratos.php" target="_blank">Ver Contratos</a></li>
        <li><a href="calendario.php" target="_blank">Calendario</a></li>
        </ul>
    </nav>

    <h3>Seleccionar Rango de Fechas</h3>
    <form action="dashboard.php" method="GET">
        <input type="date" id="fecha_inicio" name="fecha_inicio">
        <input type="date" id="fecha_fin" name="fecha_fin">
        <button type="submit">Filtrar</button>
    </form>

    <h3>Reportes Gráficos</h3>
    <div class="graficos">
        <div class="grafico-container">
            <canvas id="clientesChart"></canvas>
            <h4>Clientes: <span id="clientesCount">0</span></h4>
        </div>
        <div class="grafico-container">
            <canvas id="reservasChart"></canvas>
            <h4>Reservas: <span id="reservasCount">0</span></h4>
        </div>
    </div>

    <script>
        const clientesData = <?php echo json_encode($clientesData); ?>;
        const reservasData = <?php echo json_encode($reservasData); ?>;

        const clientesLabels = clientesData.map(item => item.fecha);
        const clientesValues = clientesData.map(item => item.total);
        const reservasLabels = reservasData.map(item => item.fecha);
        const reservasValues = reservasData.map(item => item.total);

        document.getElementById("clientesCount").innerText = clientesValues.reduce((acc, val) => acc + val, 0);
        document.getElementById("reservasCount").innerText = reservasValues.reduce((acc, val) => acc + val, 0);

        new Chart(document.getElementById('clientesChart'), {
            type: 'line',
            data: {
                labels: clientesLabels,
                datasets: [{
                    label: 'Clientes',
                    data: clientesValues,
                    borderColor: '#e74c3c',
                    borderWidth: 2,
                    fill: false
                }]
            }
        });

        new Chart(document.getElementById('reservasChart'), {
            type: 'line',
            data: {
                labels: reservasLabels,
                datasets: [{
                    label: 'Reservas',
                    data: reservasValues,
                    borderColor: '#2ecc71',
                    borderWidth: 2,
                    fill: false
                }]
            }
        });
    </script>
    <?php
    // Controlar la acción que se pasa en la URL
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        // Incluir el archivo correspondiente según la acción
        switch ($action) {
            case 'perfil':
                include 'perfil.php';  // Ver perfil del empleado
                break;
            case 'contratos':
                include 'contratos.php';  // Ver contratos activos
                break;
            case 'calendario':
                include 'calendario.php';  // Ver calendario de reservas
                break;
            default:
                echo "<p>Acción no válida.</p>";
        }
    }
    ?>
</body>
</html>
