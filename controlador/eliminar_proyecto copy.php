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

// Mostrar mensaje de confirmación antes de eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmar'])) {
        // Eliminar el proyecto de la base de datos
        $sql = "DELETE FROM proyectos_integradores WHERE id_proyecto = ?";
        $result = $_DB->execute($sql, [$id_proyecto]);

        if ($result) {
            // Redirigir a la página de búsqueda después de eliminar
            header("Location: ../vista/buscar.php");
            exit;
        } else {
            echo "Error al eliminar el proyecto.";
        }
    } elseif (isset($_POST['cancelar'])) {
        // Redirigir a la página de búsqueda si se cancela la eliminación
        header("Location: ../vista/buscar.php");
        exit;
    }
}
?>