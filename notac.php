<?php
require_once 'conexion.php';

class Nota {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function asignarNota($estudiante_id, $materia_id, $profesor_id, $nota) {
        $stmt = $this->conn->prepare("INSERT INTO notas (estudiante_id, materia_id, profesor_id, nota) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE nota = ?");
        $stmt->bind_param("iiiii", $estudiante_id, $materia_id, $profesor_id, $nota, $nota);
        return $stmt->execute();
    }

    public function obtenerNotasEstudiante($estudiante_id) {
        $stmt = $this->conn->prepare("SELECT m.nombre, n.nota FROM notas n JOIN materias m ON n.materia_id = m.id WHERE n.estudiante_id = ?");
        $stmt->bind_param("i", $estudiante_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerEstudiantes() {
        $stmt = $this->conn->prepare("SELECT id, nombre, apellido FROM usuarios WHERE rol = 'estudiante'");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function reporteNotas() {
        $stmt = $this->conn->prepare("SELECT 
            SUM(CASE WHEN nota BETWEEN 0 AND 50 THEN 1 ELSE 0 END) AS '0-50',
            SUM(CASE WHEN nota BETWEEN 51 AND 70 THEN 1 ELSE 0 END) AS '51-70',
            SUM(CASE WHEN nota BETWEEN 71 AND 100 THEN 1 ELSE 0 END) AS '71-100'
            FROM notas");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function promedioNotas() {
        $stmt = $this->conn->prepare("SELECT AVG(nota) as promedio FROM notas");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
