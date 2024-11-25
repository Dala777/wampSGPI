<?php
session_start();
require_once "../modelo/modelo.php";

// Variables para los filtros
$integrador = isset($_POST['integrador']) ? $_POST['integrador'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$semestre = isset($_POST['semestre']) ? $_POST['semestre'] : '';

// Construir consulta con filtros
$sql = "SELECT * FROM proyectos_integradores WHERE 1";
$parametros = [];

// Filtrar por Integrador
if (!empty($integrador)) {
    $sql .= " AND integrador = ?";
    $parametros[] = $integrador;
}

// Filtrar por Estado
if (!empty($estado)) {
    $sql .= " AND estado = ?";
    $parametros[] = $estado;
}

// Filtrar por Semestre
if (!empty($semestre)) {
    $sql .= " AND semestre = ?";
    $parametros[] = $semestre;
}

// Obtener resultados
$proyectos = $_DB->select($sql, $parametros);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reportes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .filters {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .filters label {
            margin-right: 10px;
            font-weight: bold;
            color: #000;
        }

        .filters select {
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filters input[type="submit"] {
            background-color: #e95913;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .filters input[type="submit"]:hover {
            background-color: #c74610;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        .table td {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-danger {
            background-color: #e95913;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c74610;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
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
                <a href="registro.php"> <!-- Link al registro de usuarios -->
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
            <li class="list active">
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
<div class="container">
    <h1>Gestión de Reportes</h1>

    <!-- Formulario de filtros -->
    <form method="post" class="filters">
        <label for="integrador">Integrador:</label>
        <select name="integrador" id="integrador">
            <option value="">Todos</option>
            <option value="I" <?= $integrador == 'I' ? 'selected' : '' ?>>I</option>
            <option value="II" <?= $integrador == 'II' ? 'selected' : '' ?>>II</option>
            <option value="III" <?= $integrador == 'III' ? 'selected' : '' ?>>III</option>
            <option value="Final" <?= $integrador == 'Final' ? 'selected' : '' ?>>Final</option>
        </select>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="">Todos</option>
            <option value="aprobado" <?= $estado == 'aprobado' ? 'selected' : '' ?>>Aprobado</option>
            <option value="propuesto" <?= $estado == 'propuesto' ? 'selected' : '' ?>>Propuesto</option>
            <option value="rechazado" <?= $estado == 'rechazado' ? 'selected' : '' ?>>Rechazado</option>
            <option value="cancelado" <?= $estado == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
        </select>

        <label for="semestre">Semestre:</label>
        <select name="semestre" id="semestre">
            <option value="">Todos</option>
            <?php for ($i = 1; $i <= 9; $i++): ?>
                <option value="<?= $i ?>" <?= $semestre == $i ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>

        <input type="submit" value="Filtrar">
    </form>

    <!-- Botones para generar reportes -->
    <div class="text-right mb-3">
        <a href="../controlador/ctrl_reportes.php?action=pdf&integrador=<?= urlencode($integrador) ?>&estado=<?= urlencode($estado) ?>&semestre=<?= urlencode($semestre) ?>" class="btn btn-danger">Generar PDF</a>
        <a href="../controlador/ctrl_reportes.php?action=csv&integrador=<?= urlencode($integrador) ?>&estado=<?= urlencode($estado) ?>&semestre=<?= urlencode($semestre) ?>" class="btn btn-success">Generar CSV</a>
    </div>

    <!-- Tabla de proyectos -->
    <table class="table">
        <thead>
            <tr>
                <th>Código SIS</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Palabras Clave</th>
                <th>Área / Enfoque</th>
                <th>Integrador</th>
                <th>Estado</th>
                <th>Semestre</th>
                <th>Sede</th>
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
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No se encontraron proyectos</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
