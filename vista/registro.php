<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../controlador/login.php");
    exit;
}

require_once "../modelo/modelo.php"; // Incluir el modelo

// Obtener los usuarios registrados
$usuarios = $_DB->obtenerUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
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
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
        }

        .topbar {
            background-color: #e95913;
            color: #fff;
            padding: 10px;
            text-align: right;
        }

        .content-wrapper {
            margin-top: 20px;
        }

        .register-container, .user-list {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .register-container h2, .user-list h2 {
            color: #333;
            border-bottom: 3px solid #e95913;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form label {
            font-weight: bold;
        }

        form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        form button {
            padding: 10px 15px;
            background-color: #e95913;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
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

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f2f2f2;
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
            <li class="list active">
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

    <div class="main">
        <div class="topbar">
            <span>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?></span>
        </div>
        <div class="content-wrapper">
            <div class="register-container">
                <h2>Registrar Nuevo Usuario</h2>
                <form action="../controlador/usuarios.php" method="POST">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Registrar</button>
                </form>
            </div>
            <div class="user-list">
                <h2>Usuarios Registrados</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
</body>
</html>
