<?php 
session_start();

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';  // Asegurarnos de incluir la base de datos
require_once '../../models/Reserva.php';  // Incluir el modelo Reserva
require_once '../../models/Vehiculo.php';  // Incluir el modelo Vehiculo
require_once '../../models/Servicio.php';  // Incluir el modelo Servicio

$database = new Database();
$db = $database->getConnection();

$reserva = new Reserva($db);
$vehiculo = new Vehiculo($db);
$servicio = new Servicio($db);

// Obtener los vehículos disponibles
$vehiculos = $vehiculo->getVehiculosDisponibles();

// Obtener los servicios adicionales
$servicios = $servicio->getServiciosAdicionales();
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
        $_SESSION['mensaje'] = "La fecha de inicio no puede ser anterior a la fecha de hoy.";
        header("Location: ../../../views/reservar/reservar.php");
        exit();
    }

    // Verificar que el vehículo no esté reservado en esas fechas
    if ($reserva->verificarReserva($id_vehiculo, $fecha_inicio, $fecha_fin)) {
        $_SESSION['mensaje'] = "El vehículo ya está reservado en esas fechas.";
        header("Location: ../../../views/reservar/reservar.php");
        exit();
    }

    // Guardar la reserva en la base de datos
    $reserva_id = $reserva->realizarReserva($id_usuario, $id_vehiculo, $fecha_inicio, $fecha_fin, $total);  // El total se guarda aquí

    if ($reserva_id) {
        $_SESSION['mensaje'] = "Reserva realizada con éxito!";
    } else {
        $_SESSION['mensaje'] = "Hubo un error al realizar la reserva.";
    }

    // Redirigir de nuevo a la vista de reserva
    header("Location: ../../../views/reservar/reservar.php");
    exit();
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer una Nueva Reserva</title>
    <link rel="stylesheet" href="../../../public/css/reservar.css"> <!-- Archivo CSS -->
    <script src="../../../public/js/reservar.js"></script> <!-- Archivo JS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Estilo de Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- Flatpickr -->
</head>
<body>
    <h2>Hacer una Nueva Reserva</h2>
    <form action="../../../app/controllers/ReservaController.php" method="POST">
        <!-- Selección del Vehículo -->
        <label for="vehiculo">Seleccionar Vehículo:</label>
        <select name="vehiculo" id="vehiculo" required>
            <?php foreach ($vehiculos as $v): ?>
                <option value="<?php echo $v['id']; ?>" data-precio="<?php echo $v['precio_diario']; ?>">
                    <?php echo $v['marca'] . ' - ' . $v['modelo']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <!-- Selección de Fechas -->
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="text" id="fecha_inicio" name="fecha_inicio" required><br><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="text" id="fecha_fin" name="fecha_fin" required><br><br>

        <!-- Calcular Total -->
        <label for="total">Total:</label>
        <input type="text" id="total" name="total" readonly><br><br>

        <!-- Servicios Adicionales -->
        <label>Servicios Adicionales:</label><br>
        <?php foreach ($servicios as $s): ?>
            <label for="servicio_<?php echo $s['id']; ?>"><?php echo $s['nombre'] . ' - ' . $s['precio']; ?> (Precio por unidad)</label><br>
            <input type="number" id="servicio_<?php echo $s['id']; ?>" name="servicios[<?php echo $s['id']; ?>]" value="0" min="0" data-precio="<?php echo $s['precio']; ?>" onchange="calcularTotal()"> <!-- Cantidad -->
            <br><br>
        <?php endforeach; ?>

        <button type="submit" name="reservar">Realizar Reserva</button>
    </form>

    <script>
        // Función para actualizar las fechas bloqueadas
        function actualizarFechasBloqueadas(vehiculoId) {
            fetch(`../../../app/controllers/ReservaController.php?vehiculo_id=${vehiculoId}`)
                .then(response => response.json())
                .then(data => {
                    const fechasReservadas = data.fechas_reservadas;

                    // Re-inicializar el calendario (flatpickr) para la fecha de inicio
                    flatpickr("#fecha_inicio", {
                        minDate: "today",  // Bloquear fechas pasadas
                        disable: fechasReservadas,  // Bloquear las fechas reservadas
                        dateFormat: "Y-m-d"
                    });

                    // Re-inicializar el calendario (flatpickr) para la fecha de fin
                    flatpickr("#fecha_fin", {
                        minDate: "today",  // Bloquear fechas pasadas
                        disable: fechasReservadas,  // Bloquear las fechas reservadas
                        dateFormat: "Y-m-d"
                    });
                })
                .catch(error => {
                    console.error('Error al obtener las fechas reservadas:', error);
                });
        }

        // Evento para actualizar las fechas bloqueadas al cambiar el vehículo
        document.getElementById('vehiculo').addEventListener('change', function() {
            const vehiculoId = this.value;
            actualizarFechasBloqueadas(vehiculoId);
        });

        // Inicializar el calendario con el primer vehículo al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const vehiculoId = document.getElementById('vehiculo').value;
            actualizarFechasBloqueadas(vehiculoId);
        });

        // Cálculo de Total al seleccionar fechas y servicios
        document.getElementById('fecha_inicio').addEventListener('change', calcularTotal);
        document.getElementById('fecha_fin').addEventListener('change', calcularTotal);
        document.getElementById('vehiculo').addEventListener('change', calcularTotal);

        function calcularTotal() {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            const vehiculoSeleccionado = document.getElementById('vehiculo');
            const precioPorDia = parseFloat(vehiculoSeleccionado.options[vehiculoSeleccionado.selectedIndex].getAttribute('data-precio'));

            if (fechaInicio && fechaFin && !isNaN(precioPorDia)) {
                const fechaInicioObj = new Date(fechaInicio);
                const fechaFinObj = new Date(fechaFin);
                const diffTime = Math.abs(fechaFinObj - fechaInicioObj);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Diferencia en días

                let total = precioPorDia * diffDays;

                const serviciosSeleccionados = document.querySelectorAll('input[name^="servicios["]');
                let serviciosTotales = 0;
                serviciosSeleccionados.forEach(servicio => {
                    const cantidad = parseInt(servicio.value);
                    const precioServicio = parseFloat(servicio.dataset.precio);
                    if (!isNaN(cantidad)) {
                        serviciosTotales += cantidad * precioServicio;
                    }
                });

                total += serviciosTotales;
                document.getElementById('total').value = total.toFixed(2); // Mostrar con dos decimales
            }
        }
    </script>
</body>
</html>
