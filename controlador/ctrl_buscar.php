<?php
require_once '../modelo/DB.php';

if (isset($_GET['buscar'])) {
    $filtro = $_GET['buscar'];
    
    // Consulta para filtrar por palabras clave o área/enfoque
    $sql = "SELECT * FROM proyectos_integradores 
            WHERE palabras_clave LIKE ? 
            OR area_enfoque LIKE ?";
    $resultados = $_DB->select($sql, ["%$filtro%", "%$filtro%"]);
} else {
    // Mostrar todos los proyectos si no hay búsqueda
    $sql = "SELECT * FROM proyectos_integradores";
    $resultados = $_DB->select($sql);
}
?>
