<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// 1. Configurar la ruta de la imagen (Como estamos en admin, las imágenes están afuera en ../img/)
$ruta_img = "../img/";

// 2. Obtener los datos actuales de la BD
$query = "SELECT * FROM configuracion WHERE id = 1";
$resultado = mysqli_query($conn, $query);
$config = mysqli_fetch_assoc($resultado);

// 3. Procesar el formulario al enviar (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $ubicacion = mysqli_real_escape_string($conn, $_POST['ubicacion']);
    $nombre_logo = $config['logo']; 

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $nombre_logo = "logo_sitio_" . time() . "." . $extension;
        
        // Se guarda usando la ruta correcta hacia afuera
        move_uploaded_file($_FILES['logo']['tmp_name'], $ruta_img . $nombre_logo);
    }

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
    <title>Configuración del Sitio</title>
    <link rel="stylesheet" href="../css/catalogo.css"> 
    <style>
        .form-container { max-width: 600px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #333; }
        .form-group input[type="text"], .form-group input[type="email"] { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-guardar { background: #4A154B; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        .btn-guardar:hover { background: #3a103b; }
    </style>
</head>
<body>

    <nav id="sidebar"> 
      <div class="logo">
        <img src="<?php echo $ruta_img . $config['logo']; ?>" alt="Logo">
      </div>
      <ul class="menu">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="historiaadmin.php">Historia</a></li>
        <li><a href="cronicasadmin.php">Crónicas</a></li>
        <li><a href="galeriaadmin.php">Galería</a></li>
        <li><a href="eventosadmin.php">Eventos</a></li>
        <li><a href="perfilesadmin.php">Perfiles</a></li>
        <li><a href="noticiasadmin.php">Noticias</a></li>
        <li><a href="entrevistasadmin.php">Entrevistas</a></li>
        <li style="border-top: 1px solid rgba(255,255,255,0.2); margin-top: 10px; padding-top: 10px;">
            <a href="editar_footer.php" style="color: #ffc107; font-weight: bold;">⚙️ Configurar Footer</a>
        </li>
      </ul>
    </nav>

    <div class="main-content">
        <div class="form-container">
            <h2>Configuración del Sitio (Footer y Logo)</h2>
            
            <?php if(isset($_GET['status']) && $_GET['status'] == 'success') echo "<p style='color:green; font-weight:bold; background:#e2f0d9; padding:10px; border-radius:4px;'>¡Cambios guardados correctamente!</p>"; ?>
            
            <form action="editar_footer.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Logo Actual del Sitio:</label>
                    <img src="<?php echo $ruta_img . $config['logo']; ?>" alt="Logo Actual" style="max-height: 80px; display:block; margin-bottom: 15px; border: 1px solid #ddd; padding: 5px;">
                    <input type="file" name="logo" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Correo Electrónico de Contacto:</label>
                    <input type="email" name="correo" value="<?php echo htmlspecialchars($config['correo']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Teléfono de Contacto:</label>
                    <input type="text" name="telefono" value="<?php echo htmlspecialchars($config['telefono']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Ubicación / Dirección:</label>
                    <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($config['ubicacion']); ?>" required>
                </div>
                <button type="submit" class="btn-guardar">💾 Guardar Configuración</button>
            </form>
        </div>
    </div>

    <?php include("../componentes/footer.php"); ?>

</body>
</html>