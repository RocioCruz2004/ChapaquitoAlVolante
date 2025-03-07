<?php
session_start(); // Iniciar sesión para poder destruirla
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

header("Location: login.php"); // Redirigir al login
exit();
?>
