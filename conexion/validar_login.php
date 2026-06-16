<?php
session_start();

// AJUSTE 1: Como validar_login.php está DENTRO de la carpeta 'conexion', 
// ya NO necesitas escribir "conexion.php" a secas si está al mismo nivel.
// Si tu archivo de conexión está en la misma carpeta, se queda así.
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
            
            // Las variables de sesión coinciden perfectamente con tu admin/index.php
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["id_rol"] = $usuario["id_rol"];

            // AJUSTE 2: Ruta de Redirección. 
            // validar_login.php está en 'conexion/'. Debe subir un nivel (../) 
            // para salir a la raíz y luego entrar a 'admin/index.php'
            header("Location: ../admin/index.php");
            exit();

        } else {
            // Consejo: En lugar de un 'echo' suelto, es mejor regresarlo al login con un mensaje de error
            header("Location: ../login.php?error=pass_incorrecto");
            exit();
        }

    } else {
        header("Location: ../login.php?error=user_no_encontrado");
        exit();
    }

} else {
    // AJUSTE 3: Para regresar al login desde la carpeta 'conexion/', debes subir un nivel
    header("Location: ../login.php");
    exit();
}
?>