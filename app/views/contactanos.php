<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos - Chapaquito Al Volante</title>
    <link rel="stylesheet" href="../../public/css/style.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
    <link rel="stylesheet" href="../../public/css/contactanos.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'templates/header.php'; ?>

    <div class="contact-container">
        <!-- Información de contacto -->
        <div class="contact-info">
            <h2>Contáctanos</h2>
            <p><strong>Dirección:</strong> Barrio Lurdes, Tarija, Bolivia</p>
            <p><strong>Teléfono:</strong> <a href="tel:+59176868891">+591 76868891</a></p>
            <p><strong>Correo:</strong> <a href="mailto:chapaquitoalvolante@gmail.com">chapaquitoalvolante@gmail.com</a></p>

            <!-- Redes sociales con iconos de Font Awesome -->
            <div class="social-media">
                <h3>Síguenos en redes sociales:</h3>
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="contact-form">
            <h2>Envíanos un mensaje</h2>
            <form action="procesar_formulario.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="text" name="asunto" placeholder="Asunto" required>
                <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." required></textarea>
                <button type="submit">Enviar mensaje</button>
            </form>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>

</body>
</html>
