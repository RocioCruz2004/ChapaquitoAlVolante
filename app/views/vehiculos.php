<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos - Chapaquito al Volante</title>
    <link rel="stylesheet" href="../../public/css/style.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
    <link rel="stylesheet" href="../../public/css/vehiculos.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Iconos -->
</head>
<body>
    <?php include "templates/header.php"; ?> <!-- Incluye el archivo header.php aquí -->

    <!-- Sección de vehículos -->
    <section class="vehicles-section">
        <div class="container">
            <h1>Nuestra Flota de Vehículos</h1>
            <p>Explora nuestra amplia selección de vehículos modernos y bien mantenidos. Encuentra el auto perfecto para tu próximo viaje.</p>

            <div class="vehicle-grid">
                <?php
                // Conexión a la base de datos
                $servername = "127.0.0.1";
                $username = "root"; // Cambia esto si es necesario
                $password = ""; // Cambia esto si es necesario
                $dbname = "chapaquitoalvolante";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta para obtener los vehículos
                $sql = "SELECT * FROM vehiculos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Mostrar los datos de cada vehículo
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="vehicle-card">';
                        echo '<img src="' . $row["imagen"] . '" alt="' . $row["marca"] . ' ' . $row["modelo"] . '">';
                        echo '<div class="vehicle-info">';
                        echo '<h3>' . $row["marca"] . ' ' . $row["modelo"] . '</h3>';
                        echo '<p class="price">$' . $row["precio_diario"] . ' /día</p>';
                        echo '<div class="actions">';
                        echo '<a href="login.php?id=' . $row["id"] . '" class="btn">Reservar Ahora</a>';
                        echo '<button class="btn-details" onclick="toggleDetails(' . $row["id"] . ')">Detalles</button>';
                        echo '</div>';
                        echo '<div class="details" id="details-' . $row["id"] . '">';
                        echo '<p>' . $row["descripcion"] . '</p>';
                        echo '<ul>';
                        echo '<li><i class="fas fa-calendar-alt"></i> Año: ' . $row["anio"] . '</li>';
                        echo '<li><i class="fas fa-car"></i> Tipo: ' . $row["tipo"] . '</li>';
                        echo '<li><i class="fas fa-tag"></i> Precio diario: $' . $row["precio_diario"] . '</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay vehículos disponibles en este momento.</p>';
                }

                // Cerrar conexión
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'templates/footer.php'; ?>

    <!-- Script para manejar los detalles -->
    <script>
        function toggleDetails(id) {
            const details = document.getElementById(`details-${id}`);
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
</body>
</html>