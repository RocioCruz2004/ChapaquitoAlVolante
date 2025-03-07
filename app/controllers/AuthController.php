<?php
require_once '../../config/database.php';
require_once '../models/Usuario.php';

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

// Registrar usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro'])) { 
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];  // Contraseña ingresada
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];  // 'cliente' será el valor predeterminado

    // Verificar si el email ya está registrado
    $query = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Guardar la contraseña tal cual (sin encriptarla)
        $plain_password = $password;  // No encriptamos la contraseña

        // Llamar al método para registrar el usuario (la contraseña se guarda en texto plano)
        if ($usuario->registrarUsuario($nombre, $email, $plain_password, $telefono, $rol)) {
            // Redirigir al login después de un registro exitoso
            header("Location: ../../app/views/login.php");
            exit();
        } else {
            echo "Error al registrar el usuario.";
        }
    }
}

// Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    session_start();  // Iniciar la sesión
    $email = $_POST['email'];
    $password = $_POST['password'];  // Contraseña ingresada

    // Consultar al usuario con el correo electrónico ingresado
    $query = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Si el usuario es un cliente, verificar la contraseña en texto plano
        if ($user['rol'] == 'cliente') {
            if ($password == $user['password']) {  // Comparar las contraseñas en texto plano
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['rol'];

                // Redirigir al dashboard del cliente
                header("Location: ../../app/views/cliente/dashboard.php");
                exit();
            } else {
                echo "Credenciales incorrectas para el cliente.";
            }
        }
        // Si el usuario es un empleado, verificar la contraseña en texto plano
        elseif ($user['rol'] == 'empleado') {
            if ($password == $user['password']) {  // Contraseña en texto plano para empleados
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['rol'];

                // Redirigir al dashboard del empleado
                header("Location: ../../app/views/empleado/dashboard.php");
                exit(); 
            } else {
                echo "Credenciales incorrectas para el empleado.";
            }
        }
        // Si el usuario es un administrador, verificar la contraseña en texto plano
        elseif ($user['rol'] == 'administrador') {
            if ($password == $user['password']) {  // Contraseña en texto plano para administrador
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['rol'];

                // Redirigir al dashboard del administrador
                header("Location: ../../app/views/admin/dashboard.php");
                exit();
            } else {
                echo "Credenciales incorrectas para el administrador.";
            }
        }
    } else {
        echo "Correo electrónico incorrecto.";
    }
}
?>
