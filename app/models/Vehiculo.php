<?php
class Vehiculo {
    private $conn;
    private $table_name = "vehiculos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener vehículos disponibles
    public function getVehiculosDisponibles() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE estado = 'disponible'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener vehículos disponibles
    }
     // Método para crear un vehículo
     public function crearVehiculo($marca, $modelo, $anio, $placa, $tipo, $precio_diario, $estado, $descripcion, $imagen) {
        $query = "INSERT INTO vehiculos (marca, modelo, anio, placa, tipo, precio_diario, estado, descripcion, imagen) 
                  VALUES (:marca, :modelo, :anio, :placa, :tipo, :precio_diario, :estado, :descripcion, :imagen)";
        $stmt = $this->conn->prepare($query);
    
        // Asignar los valores a los parámetros
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":anio", $anio);
        $stmt->bindParam(":placa", $placa);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":precio_diario", $precio_diario);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":imagen", $imagen);
    
        return $stmt->execute();
    }
    // Método para obtener todos los vehículos
    public function getAllVehiculos() {
        $query = "SELECT * FROM " . $this->table_name;  // Obtén todos los vehículos de la tabla
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retorna todos los vehículos
    }
    public function getVehiculoById($vehiculo_id) {
        $query = "SELECT * FROM vehiculos WHERE id = :vehiculo_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":vehiculo_id", $vehiculo_id);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Asegúrate de que esté devolviendo todos los datos, incluido 'estado'
    }
     
    public function editarVehiculo($vehiculo_id, $marca, $modelo, $anio, $placa, $tipo, $precio_diario, $estado, $descripcion, $imagen) {
        $query = "UPDATE " . $this->table_name . " SET marca = :marca, modelo = :modelo, anio = :anio, placa = :placa, 
                  tipo = :tipo, precio_diario = :precio_diario, estado = :estado, descripcion = :descripcion, imagen = :imagen WHERE id = :vehiculo_id";
        
        $stmt = $this->conn->prepare($query);
    
        // Bind de parámetros
        $stmt->bindParam(":vehiculo_id", $vehiculo_id);
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":anio", $anio);
        $stmt->bindParam(":placa", $placa);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":precio_diario", $precio_diario);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":imagen", $imagen);
    
        // Ejecutar y retornar si fue exitoso
        return $stmt->execute();
    }
    // Método para eliminar un vehículo
    public function eliminarVehiculo($vehiculo_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :vehiculo_id";
        $stmt = $this->conn->prepare($query);

        // Asignar el ID del vehículo a eliminar
        $stmt->bindParam(":vehiculo_id", $vehiculo_id);

        // Ejecutar la eliminación
        return $stmt->execute();
    }  
}
?>
