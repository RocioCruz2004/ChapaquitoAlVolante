<?php
// Obtener todos los clientes
$query = "SELECT id, nombre, email FROM usuarios WHERE rol = 'cliente'";
$stmt = $db->prepare($query);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Detalles de Clientes</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
    </tr>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo $cliente['id']; ?></td>
            <td><?php echo $cliente['nombre']; ?></td>
            <td><?php echo $cliente['email']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
