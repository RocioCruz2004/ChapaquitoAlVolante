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
$contrato = new Contrato($db);

// Verificar si se recibe un ID de contrato
if (isset($_GET['id'])) {
    $contrato_id = $_GET['id'];

    // Llamar al método de cancelar el contrato
    if ($contrato->cancelarContrato($contrato_id)) {
        header("Location: mis_contratos.php"); // Redirigir a la página de contratos
        exit();
    } else {
        echo "Error al cancelar el contrato.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Contratos - Chapaquito Al Volante</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $user['nombre']; ?></h1>
        <nav>
            <a href="logout.php">Cerrar sesión</a>
            <a href="profile.php">Editar perfil</a>
            <a href="reservar.php">Hacer nueva reserva</a>
        </nav>
    </header>

    <section class="contratos">
        <h2>Tus Contratos</h2>
        <?php if (count($contratos) > 0): ?>
            <table>
                <tr>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Vehículo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($contratos as $contrato): ?>
                    <tr>
                        <td><?php echo $contrato['fecha_inicio']; ?></td>
                        <td><?php echo $contrato['fecha_fin']; ?></td>
                        <td><?php echo $contrato['vehiculo']; ?></td>
                        <td><?php echo $contrato['estado']; ?></td>
                        <td>
                            <a href="cancelar_contrato.php?id=<?php echo $contrato['id']; ?>">Cancelar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No tienes contratos activos.</p>
        <?php endif; ?>
    </section>

</body>
</html>
