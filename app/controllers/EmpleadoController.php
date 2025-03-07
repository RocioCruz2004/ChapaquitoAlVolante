<?php
require_once '../models/Empleado.php';
require_once '../models/Contrato.php';

class EmpleadoController {

    private $db;
    private $empleado;
    private $contrato;

    public function __construct($database) {
        $this->db = $database;
        $this->empleado = new Empleado($this->db);
        $this->contrato = new Contrato($this->db);
    }

    // Función para mostrar el perfil del empleado
    public function verPerfil($empleado_id) {
        return $this->empleado->getEmpleadoById($empleado_id);
    }

    // Función para mostrar todos los contratos activos
    public function verContratos() {
        return $this->contrato->verContratos();
    }

    // Función para gestionar devoluciones de contratos
    public function gestionarDevolucion($contrato_id, $estado) {
        // Asegúrate de pasar el contrato_id y el nuevo estado
        return $this->contrato->gestionarDevolucion($contrato_id, $estado);
    }
}
?>
