<?php
// Incluir el archivo del modelo
require_once "../modelo/modelo.php";
session_start();

// Función para iniciar sesión
function iniciarSesion($email, $password) {
    global $_DB;

    // SQL para buscar al usuario por su email
    $sql = "SELECT * FROM USUARIOS WHERE email = ?";
    $usuario = $_DB->select($sql, [$email]);

    if ($usuario) {
        // Verificar la contraseña
        if (password_verify($password, $usuario[0]["contrasena"])) {
            // Almacenar información del usuario en la sesión
            $_SESSION["usuario_id"] = $usuario[0]["id_usuario"];
            $_SESSION["usuario_nombre"] = $usuario[0]["nombre"];
            $_SESSION["tipo_usuario"] = $usuario[0]["tipo_usuario"]; // Para determinar el tipo de usuario

            return "Login exitoso.";
        } else {
            return "Contraseña incorrecta.";
        }
    } else {
        return "Usuario no encontrado.";
    }
    
}

// Lógica para manejar la solicitud de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $mensaje = iniciarSesion($email, $password);
    echo $mensaje;
}

if ($mensaje === "Login exitoso.") {
    header("Location: ../vista/index.php"); // Redirige al usuario a su página de inicio después del login
    exit;
} else {
    echo $mensaje;
}

?>
