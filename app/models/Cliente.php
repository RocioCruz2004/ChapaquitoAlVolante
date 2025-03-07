<?php
require_once '../../../config/database.php';

class Cliente {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener el perfil de un cliente
    public function getPerfil($user_id) {
        $query = "SELECT id, nombre, email, telefono FROM " . $this->table_name . " WHERE id = :user_id AND rol = 'cliente'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Editar el perfil de un cliente
    public function editarPerfil($user_id, $nombre, $telefono, $email) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, telefono = :telefono, email = :email WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $nombre = htmlspecialchars(strip_tags($nombre));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $email = htmlspecialchars(strip_tags($email));

        // Asignar los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":user_id", $user_id);

        return $stmt->execute();
    }
    // Método para crear un nuevo cliente
    public function crearCliente($nombre, $email, $telefono) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, telefono, rol) 
                  VALUES (:nombre, :email, :telefono, 'cliente')";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);

        if ($stmt->execute()) {
            return true;  // Cliente creado con éxito
        }
        return false;
    }

    // Método para obtener todos los clientes
    public function getAllClientes() {
        $query = "SELECT id, nombre, email, telefono FROM usuarios WHERE rol = 'cliente'";  // Seleccionamos solo los clientes
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Retorna todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClienteById($cliente_id) {
        $query = "SELECT id, nombre, email, telefono FROM " . $this->table_name . " WHERE id = :cliente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Retorna los datos del cliente
    }
    // Función para editar un cliente
    public function editarCliente($cliente_id, $nombre, $email, $telefono) {
    $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :cliente_id";
    $stmt = $this->conn->prepare($query);

    // Bind de parámetros
    $stmt->bindParam(":cliente_id", $cliente_id);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":telefono", $telefono);

    // Ejecutar y retornar si fue exitoso
    return $stmt->execute();
    }
}
?>
