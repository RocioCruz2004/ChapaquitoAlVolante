<?php
class Empleado {
    private $conn;
    private $table_name = "usuarios";  // Nombre correcto de la tabla

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener información de un empleado por ID
    public function getEmpleadoById($empleado_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :empleado_id AND rol = 'empleado'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":empleado_id", $empleado_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Devolver la información del empleado
    }

    // Actualizar la información del perfil del empleado
    public function editarPerfil($empleado_id, $nombre, $telefono, $email) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, telefono = :telefono, email = :email WHERE id = :empleado_id";
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $nombre = htmlspecialchars(strip_tags($nombre));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $email = htmlspecialchars(strip_tags($email));

        // Asignar los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":empleado_id", $empleado_id);

        return $stmt->execute();  // Ejecutar la consulta
    }

    // Obtener la cantidad de clientes por fecha (agrupado por día)
    public function contarClientesPorFecha() {
        $query = "SELECT COUNT(*) as total, DATE(fecha_registro) as fecha
                  FROM " . $this->table_name . "
                  WHERE rol = 'cliente'
                  GROUP BY DATE(fecha_registro)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener la cantidad de reservas por fecha (agrupado por día)
    public function contarReservasPorFecha() {
        $query = "SELECT COUNT(*) as total, DATE(fecha_reserva) as fecha
                  FROM reservas
                  GROUP BY DATE(fecha_reserva)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para contar el total de clientes (sin agrupación por fecha)
    public function contarClientes() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE rol = 'cliente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Método para contar el total de reservas (sin agrupación por fecha)
    public function contarReservas() {
        $query = "SELECT COUNT(*) as total FROM reservas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Método para agregar un nuevo empleado
    public function agregarEmpleado($nombre, $email, $telefono, $rol) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, telefono, rol)
                VALUES (:nombre, :email, :telefono, :rol)";
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $nombre = htmlspecialchars(strip_tags($nombre));
        $email = htmlspecialchars(strip_tags($email));
        $telefono = htmlspecialchars(strip_tags($telefono));
        $rol = htmlspecialchars(strip_tags($rol));

        // Asignar los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":rol", $rol);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para eliminar un empleado
    public function eliminarEmpleado($empleado_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :empleado_id";
        $stmt = $this->conn->prepare($query);

        // Asignar el parámetro
        $stmt->bindParam(":empleado_id", $empleado_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Método para actualizar la información del perfil del empleado
    public function editarEmpleado($empleado_id, $nombre, $email, $telefono, $rol) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, email = :email, telefono = :telefono, rol = :rol WHERE id = :empleado_id";
        $stmt = $this->conn->prepare($query);
    
        // Bind de parámetros
        $stmt->bindParam(":empleado_id", $empleado_id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":rol", $rol);  // Pasamos el rol para asegurarnos de que siempre sea "empleado"
    
        // Ejecutar y retornar si fue exitoso
        return $stmt->execute();
    }
    // Método para obtener todos los empleados
    public function obtenerEmpleados() {
        $query = "SELECT id, nombre, email, telefono, rol FROM " . $this->table_name . " WHERE rol = 'empleado'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retorna todos los empleados
    }
    public function getAllEmpleados() {
        // Modificamos la consulta para seleccionar solo los empleados y administradores
        $query = "SELECT * FROM " . $this->table_name . " WHERE rol = 'empleado'";  // Obtener empleados y administradores de la tabla
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retorna los empleados y administradores
    }
}
?>
