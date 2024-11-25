<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}

require_once "../modelo/modelo.php";

// Verificar si se enviaron todos los campos
if (isset($_POST['id_proyecto']) && isset($_POST['codigo_sis']) && isset($_POST['nombre_proyecto']) && isset($_POST['descripcion']) && isset($_POST['palabras_clave']) && isset($_POST['area_enfoque']) && isset($_POST['integrador']) && isset($_POST['estado']) && isset($_POST['semestre']) && isset($_POST['sede'])) {
    
    // Llamar al método del modelo para actualizar el proyecto
    $resultado = $_DB->actualizarProyecto($_POST);

    if ($resultado) {
        // Redirigir si la actualización fue exitosa
        header("Location: ../vista/buscar.php");
        exit;
    } else {
        echo "Error al actualizar el proyecto.";
    }
} else {
    echo "Faltan datos obligatorios.";
}
?>
