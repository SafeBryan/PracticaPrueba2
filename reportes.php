<?php
session_start();
require_once 'usuarioc.php';
require_once 'notac.php';

$usuario = new Usuario();
$nota = new Nota();

if (!$usuario->isLoggedIn() || $_SESSION['rol'] != 'profesor') {
    header('Location: index.php');
    exit();
}

$reporteNotas = $nota->reporteNotas();
$promedioNotas = $nota->promedioNotas();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reportes</title>
</head>
<body>
    <h2>Reportes</h2>
    <h3>Cantidad de estudiantes con notas en un rango específico</h3>
    <ul>
        <li>0-50: <?php echo $reporteNotas['0-50']; ?></li>
        <li>51-70: <?php echo $reporteNotas['51-70']; ?></li>
        <li>71-100: <?php echo $reporteNotas['71-100']; ?></li>
    </ul>
    <h3>Promedio de notas</h3>
    <p>Promedio: <?php echo $promedioNotas['promedio']; ?></p>
    <form method="POST" action="index.php">
        <button type="submit" name="logout">Cancelar</button>
    </form>
</body>
</html>
