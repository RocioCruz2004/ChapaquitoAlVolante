<?php
class Contrato {
    private $conn;
    private $table_name = "reservas";  // La tabla es 'reservas'

    public function __construct($db) {
        $this->conn = $db;
    }


   // Ver detalles de una reserva específica con todos los datos del vehículo
   public function verDetallesContrato($id) {
    $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.tipo_entrega, r.direccion_entrega, r.total, r.fecha_reserva, 
                     u.nombre AS cliente_nombre, v.marca AS vehiculo_nombre, v.marca, v.modelo, v.anio, v.placa, v.tipo, 
                     v.precio_diario, v.estado AS vehiculo_estado, v.descripcion, v.imagen AS vehiculo_imagen
              FROM " . $this->table_name . " r
              LEFT JOIN usuarios u ON r.id_usuario = u.id
              LEFT JOIN vehiculos v ON r.id_vehiculo = v.id
              WHERE r.id = :id";  // Obtener todos los detalles de la reserva y el vehículo
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  // Devolver los detalles de la reserva con todos los datos del vehículo
    }

    // Obtener las reservas de un usuario
    public function getContratosByUserId($user_id) {
        $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.tipo_entrega, r.direccion_entrega, r.total, r.fecha_reserva, 
                         u.nombre AS cliente_nombre, v.nombre AS vehiculo_nombre, v.imagen AS vehiculo_imagen
                  FROM " . $this->table_name . " r
                  LEFT JOIN usuarios u ON r.id_usuario = u.id
                  LEFT JOIN vehiculos v ON r.id_vehiculo = v.id
                  WHERE r.id_usuario = :user_id AND r.estado != 'finalizado'";  // Obtener reservas activas de un usuario
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devolver las reservas activas del usuario con nombre del cliente y vehículo
    }

    // Ver detalles de un contrato específico por ID
    public function getContratoById($id) {
        $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.tipo_entrega, r.direccion_entrega, r.total, r.fecha_reserva, 
                         u.nombre AS cliente_nombre, v.marca AS vehiculo_nombre, v.imagen AS vehiculo_imagen
                  FROM " . $this->table_name . " r
                  LEFT JOIN usuarios u ON r.id_usuario = u.id
                  LEFT JOIN vehiculos v ON r.id_vehiculo = v.id
                  WHERE r.id = :id";  // Obtener detalles del contrato con nombre del cliente y vehículo
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Devolver los detalles del contrato con nombre del cliente y vehículo
    }

    public function verContratos() {
        // Asegúrate de que haces un JOIN con la tabla de vehículos para obtener la marca
        $query = "SELECT c.id, c.fecha_inicio, c.fecha_fin, v.marca AS vehiculo_nombre, u.nombre AS cliente_nombre, c.estado, c.total
                  FROM " . $this->table_name . " c
                  JOIN vehiculos v ON c.id_vehiculo = v.id
                  JOIN usuarios u ON c.id_usuario = u.id
                  WHERE c.estado != 'finalizado'";  // Asegúrate de que solo devuelves contratos no finalizados
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devolver todos los contratos activos
    }

    // Obtener detalles de un contrato por ID
    public function obtenerDetallesContrato($id) {
        $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.tipo_entrega, r.direccion_entrega, r.total, r.fecha_reserva,
                         u.nombre AS cliente_nombre, v.nombre AS vehiculo_nombre, v.marca, v.modelo, v.anio, v.placa, v.tipo, v.precio_diario
                  FROM " . $this->table_name . " r
                  LEFT JOIN usuarios u ON r.id_usuario = u.id
                  LEFT JOIN vehiculos v ON r.id_vehiculo = v.id
                  WHERE r.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Devolver los detalles de un contrato
    }

       // Obtener todos los contratos activos o un contrato específico por ID
       public function obtenerContratos($id = null, $user_id = null) {
        // Si se proporciona un ID de contrato, obtenemos solo ese contrato
        if ($id) {
            $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.tipo_entrega, r.direccion_entrega, r.total, r.fecha_reserva, 
                             u.nombre AS cliente_nombre, v.marca AS vehiculo_nombre, v.marca, v.modelo, v.anio, v.placa, v.tipo, 
                             v.precio_diario, v.estado AS vehiculo_estado, v.descripcion, v.imagen AS vehiculo_imagen
                      FROM " . $this->table_name . " r
                      LEFT JOIN usuarios u ON r.id_usuario = u.id
                      LEFT JOIN vehiculos v ON r.id_vehiculo = v.id
                      WHERE r.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
        } 
        // Si se proporciona un ID de usuario, obtenemos los contratos de ese usuario
        elseif ($user_id) {
            $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.tipo_entrega, r.direccion_entrega, r.total, r.fecha_reserva, 
                             u.nombre AS cliente_nombre, v.marca AS vehiculo_nombre, v.imagen AS vehiculo_imagen
                      FROM " . $this->table_name . " r
                      LEFT JOIN usuarios u ON r.id_usuario = u.id
                      LEFT JOIN vehiculos v ON r.id_vehiculo = v.id
                      WHERE r.id_usuario = :user_id AND r.estado != 'finalizado'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
        } 
        // Si no se proporciona ningún parámetro, obtenemos todos los contratos activos
        else {
            $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, v.marca, u.nombre AS cliente_nombre 
                      FROM " . $this->table_name . " r
                      JOIN vehiculos v ON r.id_vehiculo = v.id
                      JOIN usuarios u ON r.id_usuario = u.id
                      WHERE r.estado != 'finalizado'";
            $stmt = $this->conn->prepare($query);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retorna los contratos
    }

    // Gestionar la devolución de un contrato (actualizar el estado)
    public function gestionarDevolucion($id, $estado) {
        // Asegúrate de que el valor del estado esté siendo enviado correctamente
        $query = "UPDATE " . $this->table_name . " SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Asignar los parámetros
        $stmt->bindParam(":estado", $estado);  // Asignar el estado recibido como parámetro
        $stmt->bindParam(":id", $id);  // Asignar el ID del contrato

        return $stmt->execute();  // Cambiar el estado del contrato
    }
}
?>
