<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}

require_once "../modelo/modelo.php"; // Incluir el modelo

// Obtener los usuarios registrados
$usuarios = $_DB->obtenerUsuarios();

require_once "../controlador/ayudantes.php";
$ayudantes = obtenerAyudantes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ayudantes</title>
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

        .register-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 48%;
        }

        .user-list {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 48%;
        }

        .register-container h2,
        .user-list h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333333;
        }

        .register-container form {
            display: flex;
            flex-direction: column;
        }

        .register-container label {
            margin-bottom: 0.5rem;
            color: #333333;
            font-weight: 700;
        }

        .register-container input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .register-container button {
            background-color: #f57c00; /* Naranja */
            color: #ffffff;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .register-container button:hover {
            background-color: #e65100; /* Naranja oscuro */
        }

        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-list th,
        .user-list td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #cccccc;
        }

        .user-list th {
            background-color: #f57c00;
            color: #ffffff;
            font-weight: 700;
        }

        .user-list td {
            background-color: #ffffff;
            color: #333333;
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
                <a href="ayudantes.php">
                    <span class="icon"><ion-icon name="file-tray-stacked-outline"></ion-icon></span>
                    <span class="title">Ayudantías</span>
                </a>
            </li>
            <li class="list">
                <a href="#">
                    <span class="icon"><ion-icon name="file-tray-stacked-outline"></ion-icon></span>
                    <span class="title">Becas</span>
                </a>
            </li>
            <li class="list">
                <a href="#">
                    <span class="icon"><ion-icon name="trending-up-outline"></ion-icon></span>
                    <span class="title">Iniciativas Sociales</span>
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
            <div class="user">
                <span>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></span>
            </div>
        </div>

        <h1>Gestión de Ayudantes</h1>

    <h2>Añadir Ayudante</h2>
    <form action="../controlador/ayudantes.php" method="POST">
        <input type="hidden" name="accion" value="insertar">
        <label>Código de Estudiante: <input type="text" name="codigo_estudiante"></label><br>
        <label>Nombre del Estudiante: <input type="text" name="nombre_estudiante"></label><br>
        <label>Materia: <input type="text" name="materia"></label><br>
        <label>Horario: <input type="text" name="horario"></label><br>
        <label>Aula: <input type="text" name="aula"></label><br>
        <label>Docente: <input type="text" name="docente"></label><br>
        <label>Teléfono: <input type="text" name="telefono"></label><br>
        <button type="submit">Añadir Ayudante</button>
    </form>

    <h2>Lista de Ayudantes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Código Estudiante</th>
            <th>Nombre</th>
            <th>Materia</th>
            <th>Horario</th>
            <th>Aula</th>
            <th>Docente</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($ayudantes as $ayudante): ?>
        <tr>
            <td><?php echo $ayudante['id_ayudante']; ?></td>
            <td><?php echo $ayudante['codigo_estudiante']; ?></td>
            <td><?php echo $ayudante['nombre_estudiante']; ?></td>
            <td><?php echo $ayudante['materia']; ?></td>
            <td><?php echo $ayudante['horario']; ?></td>
            <td><?php echo $ayudante['aula']; ?></td>
            <td><?php echo $ayudante['docente']; ?></td>
            <td><?php echo $ayudante['telefono']; ?></td>
            <td>
                <form action="../controlador/ayudantes.php" method="POST" style="display:inline;">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id_ayudante" value="<?php echo $ayudante['id_ayudante']; ?>">
                    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este ayudante?');">Eliminar</button>
                </form>

                <form action="editar_ayudante.php" method="GET" style="display:inline;">
                    <input type="hidden" name="id_ayudante" value="<?php echo $ayudante['id_ayudante']; ?>">
                    <button type="submit">Editar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    </div>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
