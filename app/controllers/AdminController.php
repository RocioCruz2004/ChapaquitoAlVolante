<?php
session_start();
require_once '../../config/database.php';
require_once '../models/Empleado.php';  // Incluir el modelo de Empleado

class AdminController {

    private $db;
    private $empleado;

    public function __construct($database) {
        $this->db = $database;
        $this->empleado = new Empleado($this->db);
    }

    // Función para agregar un nuevo empleado
    public function agregarEmpleado($nombre, $email, $telefono, $rol) {
        $empleado = new Empleado($this->db);
        if ($empleado->agregarEmpleado($nombre, $email, $telefono, $rol)) {
            echo "Empleado agregado exitosamente";
        } else {
            echo "Error al agregar el empleado";
        }
    }

    // Función para editar un empleado existente
    public function editarEmpleado($id, $nombre, $email, $telefono, $rol) {
        if ($this->empleado->editarEmpleado($id, $nombre, $email, $telefono, $rol)) {
            echo "Empleado actualizado exitosamente";
        } else {
            echo "Error al actualizar el empleado";
        }
    }
}

// Instanciamos el controlador
$database = new Database();
$db = $database->getConnection();
$adminController = new AdminController($db);

if (isset($_POST['agregar_empleado'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];

    // Llamada al método para agregar el empleado
    $adminController->agregarEmpleado($nombre, $email, $telefono, $rol);
}
?>
