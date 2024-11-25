<?php
// Incluir el archivo del modelo
require_once "../modelo/modelo.php";

// Función para registrar un nuevo usuario
function registrarUsuario($nombre, $email, $password) {
    global $_DB;

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($password)) {
        return "Todos los campos son obligatorios.";
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El formato del correo electrónico no es válido.";
    }

    // Validar que el usuario no exista ya en la base de datos
    $sql = "SELECT COUNT(*) FROM USUARIOS WHERE email = ?";
    $stmt = $_DB->getPDO()->prepare($sql); // Utiliza el nuevo método getPDO()
    $stmt->execute([$email]);
    $existe = $stmt->fetchColumn();

    if ($existe > 0) {
        return "El correo electrónico ya está registrado.";
    }

    // Encriptar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // SQL para insertar un nuevo usuario en la tabla USUARIO
    $sql = "INSERT INTO USUARIOS (nombre, email, contrasena) VALUES (?, ?, ?)";
    $result = $_DB->execute($sql, [$nombre, $email, $passwordHash]); // Ejecuta la consulta

    if ($result) {
        return "Usuario registrado con éxito.";
    } else {
        return "Error al registrar el usuario.";
    }
}

// Lógica para manejar la solicitud de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $mensaje = registrarUsuario($nombre, $email, $password);

    if ($mensaje === "Usuario registrado con éxito.") {
        header("Location: ../vista/registro.php"); // Redirige al usuario a la página de inicio después del registro
        exit;
    } else {
        echo $mensaje;
    }
}
