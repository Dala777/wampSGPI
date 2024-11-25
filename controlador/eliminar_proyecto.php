<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit;
}

require_once "../modelo/modelo.php";

// Verificar que se haya recibido un ID de proyecto
if (!isset($_GET['id'])) {
    header("Location: ../vista/buscar.php");
    exit;
}

$id_proyecto = $_GET['id'];

// Eliminar el proyecto de la base de datos
$sql = "DELETE FROM proyectos_integradores WHERE id_proyecto = ?";
$result = $_DB->execute($sql, [$id_proyecto]);

if ($result) {
    // Redirigir a la página de búsqueda después de eliminar con un mensaje opcional
    header("Location: ../vista/buscar.php?mensaje=proyecto_eliminado");
    exit;
} else {
    // Redirigir con un mensaje de error si no se pudo eliminar
    header("Location: ../vista/buscar.php?error=eliminacion_fallida");
    exit;
}
?>
