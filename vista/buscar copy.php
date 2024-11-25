<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}

require_once "../modelo/modelo.php"; // Incluir el modelo

// Obtener los proyectos integradores registrados
$proyectos = $_DB->obtenerProyectos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Proyectos - Sistema de Gestión</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .main {
            margin-left: 250px; /* Ajuste según el ancho de la navegación */
            padding: 2rem;
            background-color: #ffffff;
            min-height: 100vh;
        }

        .content-wrapper {
            display: flex;
            justify-content: space-between;
        }

        .project-list-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .project-list h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333333;
        }

        .project-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .project-list th,
        .project-list td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #cccccc;
        }

        .project-list th {
            background-color: #f57c00;
            color: #ffffff;
            font-weight: 700;
        }

        .project-list td {
            background-color: #ffffff;
            color: #333333;
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <div class="navigation">
        <ul>
            <li class="list">
                <a href="index.php">
                    <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                    <span class="title">Inicio</span>
                </a>
            </li>
            <li class="list">
                <a href="new_proyecto.php">
                    <span class="icon"><ion-icon name="file-tray-stacked-outline"></ion-icon></span>
                    <span class="title">Registrar Proyecto</span>
                </a>
            </li>
            <li class="list active">
                <a href="buscar.php">
                    <span class="icon"><ion-icon name="trending-up-outline"></ion-icon></span>
                    <span class="title">Buscar</span>
                </a>
            </li>
            <li class="list">
                <a href="../controlador/logout.php"> <!-- Link al cerrar sesión -->
                    <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                    <span class="title">Salir</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main">
        <div class="project-list-container">
            <h2>Listado de Proyectos Integradores</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código SIS</th>
                        <th>Nombre del Proyecto</th>
                        <th>Descripción</th>
                        <th>Palabras Clave</th>
                        <th>Área de Enfoque</th>
                        <th>Integrador</th>
                        <th>Estado</th>
                        <th>Semestre</th>
                        <th>Sede</th>
                        <th>Documento Proyecto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proyecto) { ?>
                        <tr>
                            <td><?php echo $proyecto['id_proyecto']; ?></td>
                            <td><?php echo $proyecto['codigo_sis']; ?></td>
                            <td><?php echo $proyecto['nombre_proyecto']; ?></td>
                            <td><?php echo $proyecto['descripcion']; ?></td>
                            <td><?php echo $proyecto['palabras_clave']; ?></td>
                            <td><?php echo $proyecto['area_enfoque']; ?></td>
                            <td><?php echo $proyecto['integrador']; ?></td>
                            <td><?php echo $proyecto['estado']; ?></td>
                            <td><?php echo $proyecto['semestre']; ?></td>
                            <td><?php echo $proyecto['sede']; ?></td>
                            <td><?php echo $proyecto['documento_proyecto']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
