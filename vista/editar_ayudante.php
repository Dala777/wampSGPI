<?php
require_once "../controlador/ayudantes.php";

$idAyudante = $_GET['id_ayudante'] ?? null;
$ayudante = null;

if ($idAyudante) {
    $ayudantes = obtenerAyudantes();
    foreach ($ayudantes as $a) {
        if ($a['id_ayudante'] == $idAyudante) {
            $ayudante = $a;
            break;
        }
    }
}

if (!$ayudante) {
    echo "Ayudante no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ayudante</title>
</head>
<body>
    <h1>Editar Ayudante</h1>

    <form action="../controlador/ayudantes.php" method="POST">
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id_ayudante" value="<?php echo $ayudante['id_ayudante']; ?>">
        <label>Código de Estudiante: <input type="text" name="codigo_estudiante" value="<?php echo $ayudante['codigo_estudiante']; ?>"></label><br>
        <label>Nombre del Estudiante: <input type="text" name="nombre_estudiante" value="<?php echo $ayudante['nombre_estudiante']; ?>"></label><br>
        <label>Materia: <input type="text" name="materia" value="<?php echo $ayudante['materia']; ?>"></label><br>
        <label>Horario: <input type="text" name="horario" value="<?php echo $ayudante['horario']; ?>"></label><br>
        <label>Aula: <input type="text" name="aula" value="<?php echo $ayudante['aula']; ?>"></label><br>
        <label>Docente: <input type="text" name="docente" value="<?php echo $ayudante['docente']; ?>"></label><br>
        <label>Teléfono: <input type="text" name="telefono" value="<?php echo $ayudante['telefono']; ?>"></label><br>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>