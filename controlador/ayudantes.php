<?php
require_once "../modelo/modelo.php";

// Función para insertar un nuevo ayudante
function insertarAyudante($codigoEstudiante, $nombreEstudiante, $materia, $horario, $aula, $docente, $telefono) {
    global $_DB;
    $sql = "INSERT INTO AYUDANTE (codigo_estudiante, nombre_estudiante, materia, horario, aula, docente, telefono) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    return $_DB->execute($sql, [$codigoEstudiante, $nombreEstudiante, $materia, $horario, $aula, $docente, $telefono]);
}

// Función para obtener todos los ayudantes
function obtenerAyudantes() {
    global $_DB;
    $sql = "SELECT * FROM AYUDANTE";
    return $_DB->select($sql);
}

// Función para actualizar un ayudante existente
function actualizarAyudante($idAyudante, $codigoEstudiante, $nombreEstudiante, $materia, $horario, $aula, $docente, $telefono) {
    global $_DB;
    $sql = "UPDATE AYUDANTE SET codigo_estudiante = ?, nombre_estudiante = ?, materia = ?, horario = ?, aula = ?, docente = ?, telefono = ? 
            WHERE id_ayudante = ?";
    return $_DB->execute($sql, [$codigoEstudiante, $nombreEstudiante, $materia, $horario, $aula, $docente, $telefono, $idAyudante]);
}

// Función para eliminar un ayudante
function eliminarAyudante($idAyudante) {
    global $_DB;
    $sql = "DELETE FROM AYUDANTE WHERE id_ayudante = ?";
    return $_DB->execute($sql, [$idAyudante]);
}

// Manejo de las solicitudes CRUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'] ?? '';
    $idAyudante = $_POST['id_ayudante'] ?? null;
    $codigoEstudiante = $_POST['codigo_estudiante'] ?? '';
    $nombreEstudiante = $_POST['nombre_estudiante'] ?? '';
    $materia = $_POST['materia'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $aula = $_POST['aula'] ?? '';
    $docente = $_POST['docente'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    switch ($accion) {
        case 'insertar':
            insertarAyudante($codigoEstudiante, $nombreEstudiante, $materia, $horario, $aula, $docente, $telefono);
            break;
        case 'actualizar':
            actualizarAyudante($idAyudante, $codigoEstudiante, $nombreEstudiante, $materia, $horario, $aula, $docente, $telefono);
            break;
        case 'eliminar':
            eliminarAyudante($idAyudante);
            break;
    }

    header("Location: ../vista/ayudantes.php");
    exit;
}
?>
