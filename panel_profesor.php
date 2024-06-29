<?php
session_start();
require_once 'usuarioc.php';
require_once 'notac.php';
require_once 'materiac.php';

$usuario = new Usuario();
$nota = new Nota();
$materia = new Materia();

if (!$usuario->isLoggedIn() || $_SESSION['rol'] != 'profesor') {
    header('Location: index.php');
    exit();
}

$profesor_id = $_SESSION['usuario_id'];
$estudiantes = $nota->obtenerEstudiantes();
$materias = $materia->obtenerMaterias();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Profesor</title>
</head>
<body>
    <h2>Panel de Profesor</h2>
    <h3>Asignar Materia</h3>
    <form method="POST">
        <select name="estudiante_id" required>
            <?php foreach ($estudiantes as $estudiante): ?>
                <option value="<?php echo $estudiante['id']; ?>"><?php echo $estudiante['nombre'] . " " . $estudiante['apellido']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <select name="materia_id" required>
            <?php foreach ($materias as $materia_item): ?>
                <option value="<?php echo $materia_item['id']; ?>"><?php echo $materia_item['nombre']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit" name="asignar_materia">Asignar Materia</button>
        <button type="button" onclick="window.location.href='panel_profesor.php'">Cancelar</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['asignar_materia'])) {
        $estudiante_id = $_POST['estudiante_id'];
        $materia_id = $_POST['materia_id'];
        if ($materia->asignarMateria($estudiante_id, $materia_id)) {
            echo "<p>Materia asignada exitosamente</p>";
        } else {
            echo "<p>Error al asignar la materia</p>";
        }
    }
    ?>
    <h3>Asignar Nota</h3>
    <form method="POST">
        <select name="estudiante_id" required>
            <?php foreach ($estudiantes as $estudiante): ?>
                <option value="<?php echo $estudiante['id']; ?>"><?php echo $estudiante['nombre'] . " " . $estudiante['apellido']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <select name="materia_id" required>
            <?php foreach ($materias as $materia_item): ?>
                <option value="<?php echo $materia_item['id']; ?>"><?php echo $materia_item['nombre']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="number" name="nota" min="0" max="100" required><br>
        <button type="submit" name="asignar_nota">Asignar Nota</button>
        <button type="button" onclick="window.location.href='panel_profesor.php'">Cancelar</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['asignar_nota'])) {
        $estudiante_id = $_POST['estudiante_id'];
        $materia_id = $_POST['materia_id'];
        $nota_valor = $_POST['nota'];
        if ($nota->asignarNota($estudiante_id, $materia_id, $profesor_id, $nota_valor)) {
            echo "<p>Nota asignada exitosamente</p>";
        } else {
            echo "<p>Error al asignar la nota</p>";
        }
    }
    ?>
    <form method="POST" action="reportes.php">
        <button type="submit" name="reportes">Reportes</button>
    </form>
    <form method="POST" action="crear_materia.php">
        <button type="submit" name="crear_materia">Crear Materia</button>
    </form>
    <form method="POST" action="index.php">
        <button type="submit" name="logout">Cancelar</button>
    </form>
</body>
</html>
