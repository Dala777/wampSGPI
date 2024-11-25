<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit;
}

// Incluir el modelo
require_once "../modelo/modelo.php";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si todos los campos requeridos están llenos
    if (
        isset($_POST['codigo_sis'], $_POST['nombre_proyecto'], $_POST['integrador'], 
              $_POST['estado'], $_POST['semestre'], $_POST['sede']) &&
        !empty($_POST['codigo_sis']) && !empty($_POST['nombre_proyecto']) &&
        !empty($_POST['integrador']) && !empty($_POST['estado']) &&
        !empty($_POST['semestre']) && !empty($_POST['sede'])
    ) {
        // Obtener los datos del formulario
        $codigo_sis = $_POST['codigo_sis'];
        $nombre_proyecto = $_POST['nombre_proyecto'];
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
        $palabras_clave = isset($_POST['palabras_clave']) ? $_POST['palabras_clave'] : null;
        $area_enfoque = isset($_POST['area_enfoque']) ? $_POST['area_enfoque'] : null;
        $integrador = $_POST['integrador'];
        $estado = $_POST['estado'];
        $semestre = $_POST['semestre'];
        $sede = $_POST['sede'];
        $id_usuario = $_SESSION['id_usuario']; // Asegúrate de que el ID del usuario esté en la sesión

        // Documento del proyecto (opcional)
        $documento_proyecto = isset($_POST['documento_proyecto']) ? $_POST['documento_proyecto'] : null;

        // Preparar la consulta SQL
        $sql = "INSERT INTO proyectos_integradores (codigo_sis, nombre_proyecto, descripcion, palabras_clave, area_enfoque, integrador, estado, semestre, sede, documento_proyecto, id_usuario)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Ejecutar la consulta
        $params = [
            $codigo_sis,
            $nombre_proyecto,
            $descripcion,
            $palabras_clave,
            $area_enfoque,
            $integrador,
            $estado,
            $semestre,
            $sede,
            $documento_proyecto,
            $id_usuario
        ];

        if ($_DB->execute($sql, $params)) {
            // Redirigir al usuario a la página de éxito o lista de proyectos
            header("Location: ../vista/new_proyecto.php");
            exit;
        } else {
            // Error en la inserción, redirigir con mensaje de error
            $_SESSION['error'] = "No se pudo registrar el proyecto. Inténtalo de nuevo.";
            header("Location: ../vista/new_proyecto.php");
            exit;
        }
    } else {
        // Redirigir con un mensaje de error si faltan campos
        $_SESSION['error'] = "Todos los campos obligatorios deben ser completados.";
        header("Location: ../vista/new_proyecto.php");
        exit;
    }
} else {
    // Si no se ha enviado el formulario, redirigir a la página de registro
    header("Location: ../vista/new_proyecto.php");
    exit;
}
?>
