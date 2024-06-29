<?php
session_start();
require_once 'usuarioc.php';
require_once 'notac.php';
require_once 'materiac.php';

$usuario = new Usuario();
$nota = new Nota();
$materia = new Materia();

if (!$usuario->isLoggedIn() || $_SESSION['rol'] != 'estudiante') {
    header('Location: index.php');
    exit();
}

$estudiante_id = $_SESSION['usuario_id'];
$notas = $nota->obtenerNotasEstudiante($estudiante_id);
$materias = $materia->obtenerMateriasEstudiante($estudiante_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Estudiante</title>
</head>
<body>
    <h2>Panel de Estudiante</h2>
    <h3>Materias</h3>
    <ul>
        <?php foreach ($materias as $materia): ?>
            <li><?php echo "Materia: " . $materia['nombre']; ?></li>
        <?php endforeach; ?>
    </ul>
    <h3>Notas</h3>
    <ul>
        <?php foreach ($notas as $nota): ?>
            <li><?php echo $nota['nombre'] . ": " . $nota['nota']; ?></li>
        <?php endforeach; ?>
    </ul>
    <form method="POST" action="index.php">
        <button type="submit" name="logout">Cancelar</button>
    </form>
</body>
</html>
