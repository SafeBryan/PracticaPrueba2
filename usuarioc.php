<?php
require_once 'conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function register($cedula, $nombre, $apellido, $rol, $clave) {
        $hashedPassword = password_hash($clave, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (cedula, nombre, apellido, rol, clave) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $cedula, $nombre, $apellido, $rol, $hashedPassword);
        return $stmt->execute();
    }

    public function login($cedula, $clave) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        if ($usuario && password_verify($clave, $usuario['clave'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];
            $_SESSION['rol'] = $usuario['rol'];
            return true;
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['usuario_id']);
    }

    public function logout() {
        session_destroy();
    }
}
?>
