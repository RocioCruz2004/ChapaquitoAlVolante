<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros últimos servicios - Chapaquito al Volante</title>
    
    <!-- Enlaces a CSS -->
    <link rel="stylesheet" href="../../public/css/style.css"> 
    <link rel="stylesheet" href="../../public/css/servicio.css">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "templates/header.php"; ?> <!-- Header -->

    <div class="contenedor">
        <h3> Servicio </h3>
        <h1>Nuestros últimos servicios</h1>

        <div class="services-grid">
            <!-- Servicio 1 -->
            <div class="service-item">
                <i class="fas fa-car-side service-icon"></i>
                <h2>Alquiler de Vehículos por Día</h2>
                <ul>
                    <li>Perfecto para viajes cortos o necesidades temporales.</li>
                    <li>Amplia selección de vehículos modernos y confiables.</li>
                    <li>Precios competitivos y sin complicaciones.</li>
                </ul>
            </div>

            <!-- Servicio 2 -->
            <div class="service-item">
                <i class="fas fa-car service-icon"></i>
                <h2>Alquiler de Vehículos de Lujo</h2>
                <ul>
                    <li>Experimenta el máximo confort y estilo con nuestra flota de vehículos premium.</li>
                    <li>Perfecto para eventos especiales y reuniones de negocios.</li>
                    <li>Servicio personalizado y atención de primera.</li>
                </ul>
            </div>

            <!-- Servicio 3 -->
            <div class="service-item">
                <i class="fas fa-map-marker-alt service-icon"></i>
                <h2>Servicio de Entrega a su Ubicación</h2>
                <ul>
                    <li>Recibe tu vehículo donde lo necesites.</li>
                    <li>Servicio rápido y eficiente en toda la ciudad.</li>
                    <li>Comodidad y ahorro de tiempo garantizados.</li>
                </ul>
            </div>

            <!-- Servicio 4 -->
            <div class="service-item">
                <i class="fas fa-mountain service-icon"></i>
                <h2>Alquiler de Vehículos para Aventura 4x4</h2>
                <ul>
                    <li>Explora terrenos difíciles con nuestros robustos 4x4.</li>
                    <li>Equipados para cualquier tipo de aventura.</li>
                    <li>Seguridad y rendimiento en cada viaje.</li>
                </ul>
            </div>
        </div>
    </div>

    <?php include "templates/footer.php"; ?> <!-- Footer -->
</body>
</html>
