<?php
session_start();
require_once 'usuarioc.php';
require_once 'materiac.php';

$usuario = new Usuario();
$materia = new Materia();

if (!$usuario->isLoggedIn() || $_SESSION['rol'] != 'profesor') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $nombre_materia = $_POST['nombre_materia'];
    if ($materia->crearMateria($nombre_materia)) {
        $mensaje = "Materia creada exitosamente.";
    } else {
        $mensaje = "Error al crear la materia.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Materia</title>
</head>
<body>
    <h2>Crear Materia</h2>
    <form method="POST">
        <input type="text" name="nombre_materia" placeholder="Nombre de la materia" required><br>
        <button type="submit" name="crear">Crear Materia</button>
        <button type="button" onclick="window.location.href='panel_profesor.php'">Cancelar</button>
    </form>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</body>
</html>
