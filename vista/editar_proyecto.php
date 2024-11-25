<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}

require_once "../modelo/modelo.php"; // Incluir el modelo

// Verificar si el ID del proyecto se ha enviado
if (isset($_GET['id'])) {
    $id_proyecto = $_GET['id'];

    // Obtener los datos del proyecto a editar desde el modelo
    $proyecto = $_DB->obtenerProyectoPorId($id_proyecto);

    // Si no existe el proyecto, redirigir
    if (!$proyecto) {
        header("Location: buscar.php");
        exit;
    }
} else {
    // Si no hay ID en la URL, redirigir al listado de proyectos
    header("Location: buscar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto Integrador</title>
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

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #000;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container textarea {
            resize: none;
        }

        .form-container button {
            background-color: #e95913;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
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
    <div class="container">
        <h1>Editar Proyecto Integrador</h1>
        <div class="form-container">
            <form action="../controlador/ctrl_editar_proyecto.php" method="POST">
                <!-- Campo oculto para enviar el ID del proyecto -->
                <input type="hidden" name="id_proyecto" value="<?= $proyecto['id_proyecto'] ?>">

                <label for="codigo_sis">Código SIS:</label>
                <input type="text" name="codigo_sis" value="<?= $proyecto['codigo_sis'] ?>" required>

                <label for="nombre_proyecto">Nombre del Proyecto:</label>
                <input type="text" name="nombre_proyecto" value="<?= $proyecto['nombre_proyecto'] ?>" required>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" rows="4"><?= $proyecto['descripcion'] ?></textarea>

                <label for="palabras_clave">Palabras Clave:</label>
                <input type="text" name="palabras_clave" value="<?= $proyecto['palabras_clave'] ?>">

                <label for="area_enfoque">Área de Enfoque:</label>
                <input type="text" name="area_enfoque" value="<?= $proyecto['area_enfoque'] ?>">

                <label for="integrador">Integrador:</label>
                <select name="integrador" required>
                    <option value="I" <?= $proyecto['integrador'] == 'I' ? 'selected' : '' ?>>I</option>
                    <option value="II" <?= $proyecto['integrador'] == 'II' ? 'selected' : '' ?>>II</option>
                    <option value="III" <?= $proyecto['integrador'] == 'III' ? 'selected' : '' ?>>III</option>
                    <option value="Final" <?= $proyecto['integrador'] == 'Final' ? 'selected' : '' ?>>Final</option>
                </select>

                <label for="estado">Estado:</label>
                <select name="estado" required>
                    <option value="aprobado" <?= $proyecto['estado'] == 'aprobado' ? 'selected' : '' ?>>Aprobado</option>
                    <option value="propuesto" <?= $proyecto['estado'] == 'propuesto' ? 'selected' : '' ?>>Propuesto</option>
                    <option value="rechazado" <?= $proyecto['estado'] == 'rechazado' ? 'selected' : '' ?>>Rechazado</option>
                    <option value="cancelado" <?= $proyecto['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>

                <label for="semestre">Semestre:</label>
                <select name="semestre" required>
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <option value="<?= $i ?>" <?= $proyecto['semestre'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <label for="sede">Sede:</label>
                <select name="sede" required>
                    <option value="CBBA" <?= $proyecto['sede'] == 'CBBA' ? 'selected' : '' ?>>CBBA</option>
                    <option value="La Paz" <?= $proyecto['sede'] == 'La Paz' ? 'selected' : '' ?>>La Paz</option>
                    <option value="El Alto" <?= $proyecto['sede'] == 'El Alto' ? 'selected' : '' ?>>El Alto</option>
                    <option value="Santa Cruz" <?= $proyecto['sede'] == 'Santa Cruz' ? 'selected' : '' ?>>Santa Cruz</option>
                </select>

                <label for="documento_proyecto">Documento del Proyecto (opcional):</label>
                <input type="text" name="documento_proyecto" value="<?= $proyecto['documento_proyecto'] ?>">

                <button type="submit">Actualizar Proyecto</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
