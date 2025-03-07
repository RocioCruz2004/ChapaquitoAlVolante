<?php
class Reporte {

    private $conn;
    private $table_name = "reservas";  // Asumimos que usas la tabla reservas, ajusta si es necesario

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener el total de reservas
    public function getTotalReservas() {
        $query = "SELECT COUNT(*) as total_reservas FROM " . $this->table_name;  // Aquí ajusta el nombre de la tabla si es necesario
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_reservas'];
    }

    // Obtener el total de clientes
    public function getTotalClientes() {
        $query = "SELECT COUNT(*) as total_clientes FROM usuarios WHERE rol = 'cliente'";  // Asumiendo que la tabla de clientes es usuarios
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_clientes'];
    }

    // Obtener el total de vehículos
    public function getTotalVehiculos() {
        $query = "SELECT COUNT(*) as total_vehiculos FROM vehiculos";  // Aquí asegúrate de que el nombre de la tabla es correcto
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_vehiculos'];
    }
}
?>
