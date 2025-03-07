<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'cliente') {
    header("Location: ../login.php");
    exit();
}

require_once '../../../config/database.php';
require_once '../../models/Reserva.php';

$database = new Database();
$db = $database->getConnection();
$reserva = new Reserva($db);

// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['user_id'];

// Obtener las reservas del usuario
$reservas = $reserva->getReservasPorUsuario($usuario_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="../../assets/css/ver_reservas.css"> 
    <style>
        /* Estilos básicos para personalizar */
        body {
            background: linear-gradient(135deg, #ff4c4c, #ff8c00); /* Rojo y naranja */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color:rgb(165, 164, 164);
            color: white;
        }

        tr:nth-child(even) {
            background-color:rgb(255, 255, 255);
        }

        tr:nth-child(odd) {
            background-color:rgb(248, 248, 248);
        }

        .btn-detalles {
            background-color: #e63946;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-detalles:hover {
            background-color: #d62828;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .btn-close {
            margin-top: 10px;
            display: block;
            width: 100%;
            text-align: center;
            background:rgb(255, 0, 0);
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-close:hover {
            background:rgb(53, 0, 0);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Mis Reservas</h2>

    <?php if (count($reservas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vehículo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo $reserva['id']; ?></td>
                        <td><?php echo $reserva['marca'] . ' ' . $reserva['modelo']; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($reserva['fecha_inicio'])); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($reserva['fecha_fin'])); ?></td>
                        <td><strong>$<?php echo number_format($reserva['total'], 2); ?></strong></td>
                        <td>
                            <button class="btn-detalles" 
                                data-id="<?php echo $reserva['id']; ?>" 
                                data-vehiculo="<?php echo $reserva['marca'] . ' ' . $reserva['modelo']; ?>" 
                                data-fecha_inicio="<?php echo date('d/m/Y', strtotime($reserva['fecha_inicio'])); ?>"
                                data-fecha_fin="<?php echo date('d/m/Y', strtotime($reserva['fecha_fin'])); ?>"
                                data-total="<?php echo number_format($reserva['total'], 2); ?>">
                                Ver Detalles
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-reservas text-center">No tienes reservas registradas.</p>
    <?php endif; ?>

    <div class="text-center" style="margin-top: 20px; text-align: center;">
        <a href="dashboard.php" class="btn-close">Volver al Inicio</a>
    </div>
</div>

<!-- Modal para ver detalles -->
<div class="modal" id="detalleModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Detalles de la Reserva</h5>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <p><strong>ID de Reserva:</strong> <span id="modal-id"></span></p>
            <p><strong>Vehículo:</strong> <span id="modal-vehiculo"></span></p>
            <p><strong>Fecha de Inicio:</strong> <span id="modal-fecha-inicio"></span></p>
            <p><strong>Fecha de Fin:</strong> <span id="modal-fecha-fin"></span></p>
            <p><strong>Total:</strong> $<span id="modal-total"></span></p>
        </div>
        <button class="btn-close close-modal">Cerrar</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("detalleModal");
    let closeModalButtons = document.querySelectorAll(".close-modal");
    let detalleButtons = document.querySelectorAll(".btn-detalles");

    detalleButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("modal-id").textContent = this.getAttribute("data-id");
            document.getElementById("modal-vehiculo").textContent = this.getAttribute("data-vehiculo");
            document.getElementById("modal-fecha-inicio").textContent = this.getAttribute("data-fecha_inicio");
            document.getElementById("modal-fecha-fin").textContent = this.getAttribute("data-fecha_fin");
            document.getElementById("modal-total").textContent = this.getAttribute("data-total");

            modal.style.display = "flex";
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener("click", function () {
            modal.style.display = "none";
        });
    });

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>

</body>
</html>
