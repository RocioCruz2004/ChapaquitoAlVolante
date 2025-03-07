<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapaquito Al Volante - Página Principal</title>
    
    <link rel="stylesheet" href="../../public/css/index.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Iconos -->
</head>
<body>
    <?php include "templates/header.php"; ?> <!-- Incluye el archivo header.php aquí -->

    <!-- Carrusel de imágenes -->
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1441148345475-03a2e82f9719?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Zm9uZG8lMjBkZSUyMHBhbnRhbGxhJTIwZGUlMjBjb2NoZXN8ZW58MHx8MHx8fDA%3D" alt="Imagen 1">
                <div class="carousel-caption">
                    <h2>¡Reserva tu coche de forma fácil y rápida!</h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://wallpapersok.com/images/hd/need-for-speed-white-bmw-m3-gtr-0rnnvibexslbtacu.jpg" alt="Imagen 2">
                <div class="carousel-caption">
                    <h2>Tu mejor opción para alquilar vehículos</h2>
                    <a href="../../app/views/contactanos.php" class="btn">Contáctanos</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://wallpapers.com/images/hd/1920-x-1080-car-yc8cwu4kx9ecamrd.jpg" alt="Imagen 3">
                <div class="carousel-caption">
                    <h2>Disfruta de tu viaje con la mejor flota de vehículos</h2>
                    <a href="../../app/views/sobrenosotros.php" class="btn">Sobre Nosotros</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de registro de usuario -->
    <section class="register-section">
        <div class="register-box">
            <h3>Haz tu reserva ahora</h3>
            <form action="../../app/controllers/AuthController.php" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" placeholder="Teléfono" required>
                <label for="email">Correo</label>
                <input type="email" name="email" placeholder="Correo" required>
                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="hidden" name="rol" value="cliente">
                <button type="submit" name="registro">Registrarse</button>
            </form>
        </div>
        <div class="side-text">
            <h2>Una mejor manera de alquilar tus autos perfectos. ¡Confía en nosotros para tu próxima aventura!</h2>
            <div class="benefits-container">
                <div class="benefit-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Elija su lugar de recogida</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-tags"></i>
                    <p>Seleccione la mejor oferta</p>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-car"></i>
                    <p>Reserve su coche de alquiler</p>
                </div>
            </div>
        </div>
    </section>

    <script src="../../public/js/script.js"></script> <!-- Ruta al archivo JS -->

    <?php include 'templates/footer.php'; ?>
</body>
</html>