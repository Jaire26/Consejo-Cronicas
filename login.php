<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Crónica Huejutlense</title>

    <link rel="stylesheet" href="css/login.css">
</head>

<body class="login-body">

    <div class="login-container">

        <h2>Iniciar Sesión</h2>
        <p>Accede al panel de administración</p>

        <img
            src="img/LogoConsejo-removebg-preview.png"
            alt="Logo Crónica Huejutlense"
            class="login-logo">

        <?php if (isset($_GET['error'])): ?>
            <div style="color: #ff3333; background-color: #ffe6e6; border: 1px solid #ffb3b3; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; text-align: center;">
                <strong>¡Error!</strong> 
                <?php 
                    if ($_GET['error'] == 'pass_incorrecto') {
                        echo "La contraseña introducida es incorrecta.";
                    } elseif ($_GET['error'] == 'user_no_encontrado') {
                        echo "El correo electrónico no está registrado";
                    } else {
                        echo "Ocurrió un error al intentar iniciar sesión.";
                    }
                ?>
            </div>
        <?php endif; ?>

        <form action="conexion/validar_login.php" method="POST">

            <div class="input-group">
                <label for="correo">Correo electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    placeholder="Ingrese su correo"
                    required>
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Ingrese su contraseña"
                    required>
            </div>

            <button type="submit" class="btn-submit">
                Ingresar
            </button>

        </form>

        <a href="index.php" class="back-home">
            ← Volver al inicio
        </a>

    </div>

</body>
</html>