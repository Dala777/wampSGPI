<?php
session_start();
/*if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}*/

require_once "../modelo/modelo.php";

// (A) PROCESO DE BÚSQUEDA
$palabra_clave = isset($_POST['palabra_clave']) ? $_POST['palabra_clave'] : '';
$area_enfoque = isset($_POST['area_enfoque']) ? $_POST['area_enfoque'] : '';

// Construir consulta de búsqueda
$sql = "SELECT * FROM proyectos_integradores WHERE 1";
$parametros = [];

// Búsqueda por palabras clave
if (!empty($palabra_clave)) {
    $sql .= " AND palabras_clave LIKE ?";
    $parametros[] = "%" . $palabra_clave . "%";
}

// Búsqueda por área o enfoque
if (!empty($area_enfoque)) {
    $sql .= " AND area_enfoque LIKE ?";
    $parametros[] = "%" . $area_enfoque . "%";
}

$proyectos = $_DB->select($sql, $parametros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Proyectos</title>
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

        .container {
            width: calc(100% - 220px);
            margin-left: 220px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .navigation {
            width: 220px;
            height: 100%;
            position: fixed;
            background-color: #000;
            color: #fff;
            top: 0;
            left: 0;
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
        }

        .navigation ul li.active {
            background-color: #e95913;
        }

        h1 {
            font-size: 24px;
            color: #000;
            margin-bottom: 20px;
            text-align: center;
        }

        .search-form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .search-form input[type="submit"] {
            background-color: #e95913;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-form input[type="submit"]:hover {
            background-color: #c74610;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .table th {
            background-color: #e95913;
            color: #fff;
        }

        .action-buttons img {
            width: 25px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .action-buttons img:hover {
            transform: scale(1.2);
        }

        .add-project {
            display: inline-block;
            background-color: #e95913;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .add-project:hover {
            background-color: #c74610;
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
        <li class="list active">
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

<div class="container">
    <h1>Búsqueda de Proyectos</h1>

    <!-- Formulario de búsqueda -->
    <form method="post" class="search-form">
        <input type="text" name="palabra_clave" placeholder="Buscar por palabras clave" value="<?= htmlspecialchars($palabra_clave) ?>">
        <input type="text" name="area_enfoque" placeholder="Buscar por área o enfoque" value="<?= htmlspecialchars($area_enfoque) ?>">
        <input type="submit" value="Buscar">
    </form>

    <!-- Botón para agregar proyecto -->
    <div class="text-right">
        <a href="new_proyecto.php" class="add-project">Agregar Nuevo Proyecto</a>
    </div>

    <!-- Tabla de resultados -->
    <table class="table">
        <thead>
            <tr>
                <th>Código SIS</th>
                <th>Nombre del Proyecto</th>
                <th>Descripción</th>
                <th>Palabras Clave</th>
                <th>Área / Enfoque</th>
                <th>Integrador</th>
                <th>Estado</th>
                <th>Semestre</th>
                <th>Sede</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($proyectos) > 0): ?>
                <?php foreach ($proyectos as $proyecto): ?>
                    <tr>
                        <td><?= htmlspecialchars($proyecto['codigo_sis']) ?></td>
                        <td><?= htmlspecialchars($proyecto['nombre_proyecto']) ?></td>
                        <td><?= htmlspecialchars($proyecto['descripcion']) ?></td>
                        <td><?= htmlspecialchars($proyecto['palabras_clave']) ?></td>
                        <td><?= htmlspecialchars($proyecto['area_enfoque']) ?></td>
                        <td><?= htmlspecialchars($proyecto['integrador']) ?></td>
                        <td><?= htmlspecialchars($proyecto['estado']) ?></td>
                        <td><?= htmlspecialchars($proyecto['semestre']) ?></td>
                        <td><?= htmlspecialchars($proyecto['sede']) ?></td>
                        <td class="action-buttons">
                            <a href="editar_proyecto.php?id=<?= $proyecto['id_proyecto'] ?>"><img src="../edit.png" alt="Editar"></a>
                            <a href="../controlador/eliminar_proyecto.php?id=<?= $proyecto['id_proyecto'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');"><img src="../delete.png" alt="Eliminar"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No se encontraron proyectos</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Scripts -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
