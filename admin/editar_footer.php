<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// 1. Obtener los datos actuales
$query = "SELECT * FROM configuracion WHERE id = 1";
$resultado = mysqli_query($conn, $query);
$config = mysqli_fetch_assoc($resultado);

// 2. Procesar la actualización cuando se envíe el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $ubicacion = mysqli_real_escape_string($conn, $_POST['ubicacion']);
    $nombre_logo = $config['logo']; // Dejar el actual por defecto

    // Si el usuario subió un logo nuevo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $ruta_destino = "../img/";
        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $nombre_logo = "logo_sitio_" . time() . "." . $extension;
        
        move_uploaded_file($_FILES['logo']['tmp_name'], $ruta_destino . $nombre_logo);
    }

    // Actualizar la base de datos
    $update = "UPDATE configuracion SET logo='$nombre_logo', correo='$correo', telefono='$telefono', ubicacion='$ubicacion' WHERE id = 1";
    if (mysqli_query($conn, $update)) {
        header("Location: editar_footer.php?status=success");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Footer y Logo</title>
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        .form-container { max-width: 600px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-guardar { background: #4A154B; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Configuración del Sitio (Footer y Logo)</h2>
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success') echo "<p style='color:green;'>¡Cambios guardados correctamente!</p>"; ?>
        
        <form action="editar_footer.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Logo Actual:</label>
                <img src="../img/<?php echo $config['logo']; ?>" alt="Logo" style="max-height: 80px; display:block; margin-bottom: 10px;">
                <input type="file" name="logo" accept="image/*">
            </div>
            <div class="form-group">
                <label>Correo de Contacto:</label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($config['correo']); ?>" required>
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo htmlspecialchars($config['telefono']); ?>" required>
            </div>
            <div class="form-group">
                <label>Ubicación:</label>
                <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($config['ubicacion']); ?>" required>
            </div>
            <button type="submit" class="btn-guardar">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>