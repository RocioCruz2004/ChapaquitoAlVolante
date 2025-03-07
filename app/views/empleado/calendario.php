<?php
session_start();

// Verificar si el usuario está logueado y tiene el rol 'empleado'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'empleado') {
    header("Location: ../login.php"); // Redirigir si no es un empleado
    exit();
}

// Incluir la clase Database para la conexión
require_once '../../../config/database.php';
// Incluir el modelo de Contrato (para obtener las reservas)
require_once '../../models/Contrato.php';

// Crear una instancia de la clase Database para obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia del modelo Contrato
$contrato = new Contrato($db);

// Obtener todas las reservas activas
$reservas = $contrato->verContratos();  // Esta función debe devolver las fechas y marcas de los autos

// Convertir los datos de las reservas en formato adecuado para FullCalendar
$eventos = array();
foreach ($reservas as $reserva) {
    // En calendario.php, cambia las líneas 29 y 32:
    $evento = array(
        'title' => 'Marca: ' . $reserva['vehiculo_nombre'] . ' - Cliente: ' . $reserva['cliente_nombre'],
        'start' => $reserva['fecha_inicio'],  // Formato: YYYY-MM-DD
        'end' => $reserva['fecha_fin'],      // Formato: YYYY-MM-DD
        'description' => 'Marca: ' . $reserva['vehiculo_nombre'] . ' - Cliente: ' . $reserva['cliente_nombre'],
        'backgroundColor' => '#FF0000',  // Color rojo para marcar las reservas
        'borderColor' => '#FF0000'
    );
    $eventos[] = $evento;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Reservas</title>

    <!-- Cargar jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Cargar moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Cargar FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
</head>
<body>
    <h2>Calendario de Reservas</h2>

    <!-- Contenedor para el calendario -->
    <div id="calendar"></div>

    <script>
        $(document).ready(function() {
            // Inicializamos el calendario
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: <?php echo json_encode($eventos); ?>,  // Cargar los eventos desde PHP
                eventClick: function(event) {
                    // Al hacer clic en un evento, mostrar los detalles
                    alert(event.description);  // Mostrar detalles de la reserva
                }
            });
        });
    </script>
</body>
</html>
