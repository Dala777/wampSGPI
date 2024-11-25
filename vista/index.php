<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Gestión</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f4f4f9;
        }

        .navigation {
            width: 220px;
            height: 100vh;
            position: fixed;
            background-color: #000;
            color: #fff;
            padding-top: 20px;
        }

        .navigation ul {
            list-style: none;
            padding: 0;
        }

        .navigation ul li {
            padding: 10px 20px;
        }

        .navigation ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .navigation ul li.active {
            background-color: #e95913;
        }

        .main {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
            background-color: #fff;
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .topbar {
            background-color: #e95913;
            color: #fff;
            padding: 10px 20px;
            text-align: right;
        }

        .topbar .user span {
            font-weight: bold;
        }

        h2 {
            color: #333;
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .dashboard-widgets {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: space-around;
        }

        .widget {
            background-color: #fff;
            width: 30%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .widget:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .widget h3 {
            font-size: 2em;
            margin: 0;
            color: #333;
        }

        .widget p {
            font-size: 1.2em;
            margin-top: 10px;
            color: #777;
        }

        /* Colores personalizados para los widgets */
        .widget.estudiantes {
            border-left: 6px solid #4caf50;
        }

        .widget.registrados {
            border-left: 6px solid #ff9800;
        }

        .widget.aprobados {
            border-left: 6px solid #2196f3;
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <div class="navigation">
        <ul>
            <li class="list active">
                <a href="index.php">
                    <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                    <span class="title">Inicio</span>
                </a>
            </li>
            <li class="list">
                <a href="registro.php">
                    <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                    <span class="title">Registrar Usuarios</span>
                </a>
            </li>
            <li class="list">
                <a href="new_proyecto.php">
                    <span class="icon"><ion-icon name="file-tray-stacked-outline"></ion-icon></span>
                    <span class="title">Registrar Proyecto</span>
                </a>
            </li>
            <li class="list">
                <a href="buscar.php">
                    <span class="icon"><ion-icon name="trending-up-outline"></ion-icon></span>
                    <span class="title">Buscar</span>
                </a>
            </li>
            <li class="list">
                <a href="reportes.php">
                    <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                    <span class="title">Reportes</span>
                </a>
            </li>
            <li class="list">
                <a href="../controlador/logout.php">
                    <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                    <span class="title">Salir</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main">
        <div class="topbar">
            <span>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></span>
        </div>
        <h2>Dashboard</h2>
        <div class="dashboard-widgets">
            <div class="widget estudiantes">
                <h3>105</h3>
                <p>Estudiantes</p>
            </div>
            <div class="widget registrados">
                <h3>80</h3>
                <p>Proyectos Registrados</p>
            </div>
            <div class="widget aprobados">
                <h3>50</h3>
                <p>Proyectos Aprobados</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
