<?php

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($nombre, $email, $password, $telefono, $rol) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, password, telefono, rol) 
                  VALUES (:nombre, :email, :password, :telefono, :rol)";
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos recibidos
        $nombre = htmlspecialchars(strip_tags($nombre));
        $email = htmlspecialchars(strip_tags($email));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $rol = htmlspecialchars(strip_tags($rol));

        // Asignar los valores a los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":rol", $rol);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getUserById($user_id) {
        $query = "SELECT id, nombre, email, telefono FROM " . $this->table_name . " WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    
}
?>