<?php
session_start();
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST["correo"]);
    $password = trim($_POST["password"]);

    // Buscamos al usuario únicamente por su correo y estado activo
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND estado = 'activo'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificación segura usando el Hash de PHP
        if (password_verify($password, $usuario["password_hash"])) {
            
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["id_rol"] = $usuario["id_rol"];

            header("Location: ../admin/");
            exit();

        } else {
            echo "Contraseña incorrecta.";
        }

    } else {
        echo "Usuario no encontrado o inactivo.";
    }

} else {
    header("Location: ../login.php");
    exit();
}
?>