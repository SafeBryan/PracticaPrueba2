<?php
require_once 'conexion.php';

class Materia {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function obtenerMaterias() {
        $result = $this->conn->query("SELECT * FROM materias");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function asignarMateria($estudiante_id, $materia_id) {
        $stmt = $this->conn->prepare("INSERT INTO estudiantes_materias (estudiante_id, materia_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $estudiante_id, $materia_id);
        return $stmt->execute();
    }

    public function obtenerMateriasEstudiante($estudiante_id) {
        $stmt = $this->conn->prepare("SELECT m.nombre FROM materias m JOIN estudiantes_materias em ON m.id = em.materia_id WHERE em.estudiante_id = ?");
        $stmt->bind_param("i", $estudiante_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function crearMateria($nombre) {
        $stmt = $this->conn->prepare("INSERT INTO materias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        return $stmt->execute();
    }
}
?>
