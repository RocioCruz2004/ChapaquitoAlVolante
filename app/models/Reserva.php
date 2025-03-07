<?php
class Reserva {
    private $conn;
    private $table_name = "reservas";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Realizar la reserva
    public function realizarReserva($id_usuario, $id_vehiculo, $fecha_inicio, $fecha_fin, $total) {
        $query = "INSERT INTO reservas (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, total) 
                  VALUES (:id_usuario, :id_vehiculo, :fecha_inicio, :fecha_fin, :total)";
        
        $stmt = $this->conn->prepare($query);
        
        // Asignar los valores a los parámetros
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->bindParam(":id_vehiculo", $id_vehiculo);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio);
        $stmt->bindParam(":fecha_fin", $fecha_fin);
        $stmt->bindParam(":total", $total);
        
        return $stmt->execute();
    }
    
    /// Método para agregar servicios adicionales
    public function agregarServicio($id_reserva, $id_servicio, $cantidad) {
        $query = "INSERT INTO reservas_servicios (id_reserva, id_servicio, cantidad) 
                  VALUES (:id_reserva, :id_servicio, :cantidad)";
    
        $stmt = $this->conn->prepare($query);
    
        // Asignar los valores a los parámetros
        $stmt->bindParam(":id_reserva", $id_reserva);
        $stmt->bindParam(":id_servicio", $id_servicio);
        $stmt->bindParam(":cantidad", $cantidad);
    
        return $stmt->execute();  // Insertar los servicios
    }
    public function getReservasPorUsuario($id_usuario) {
        $query = "SELECT r.id, v.marca, v.modelo, r.fecha_inicio, r.fecha_fin, r.total 
                  FROM " . $this->table_name . " r
                  JOIN vehiculos v ON r.id_vehiculo = v.id
                  WHERE r.id_usuario = :id_usuario
                  ORDER BY r.fecha_inicio DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Verificar que el vehículo no esté reservado en esas fechas
public function verificarReserva($id_vehiculo, $fecha_inicio, $fecha_fin) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id_vehiculo = :id_vehiculo AND 
              ((:fecha_inicio BETWEEN fecha_inicio AND fecha_fin) OR 
               (:fecha_fin BETWEEN fecha_inicio AND fecha_fin))";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id_vehiculo", $id_vehiculo);
    $stmt->bindParam(":fecha_inicio", $fecha_inicio);
    $stmt->bindParam(":fecha_fin", $fecha_fin);
    $stmt->execute();

    // Si hay alguna reserva que solape con las fechas seleccionadas
    return $stmt->rowCount() > 0;
}
// Método para obtener las fechas reservadas de un vehículo
public function getFechasReservadas($id_vehiculo) {
    $query = "SELECT fecha_inicio, fecha_fin FROM " . $this->table_name . " WHERE id_vehiculo = :id_vehiculo AND estado != 'finalizado'";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id_vehiculo", $id_vehiculo);
    $stmt->execute();

    $fechas_reservadas = [];

    // Obtener las fechas de cada reserva y agregarlas
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($reservas as $reserva) {
        $startDate = new DateTime($reserva['fecha_inicio']);
        $endDate = new DateTime($reserva['fecha_fin']);
        
        // Agregar las fechas de inicio, fin e intermedias
        while ($startDate <= $endDate) {
            $fechas_reservadas[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }
    }

    return $fechas_reservadas;  // Retorna todas las fechas reservadas
}



}
