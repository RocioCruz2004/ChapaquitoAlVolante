<?php
class Servicio {
    private $conn;
    private $table_name = "servicios_adicionales";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener los servicios adicionales disponibles
    public function getServiciosAdicionales() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
