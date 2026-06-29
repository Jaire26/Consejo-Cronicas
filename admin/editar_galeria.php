<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// Configuración de interfaz
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

if (!isset($_GET["id"]) && !isset($_POST["id_galeria"])) {
    header("Location: galeriaadmin.php");
    exit();
}

$id_galeria = isset($_POST["id_galeria"]) ? intval($_POST["id_galeria"]) : intval($_GET["id"]);

// Obtener datos de la fotografía por id_galeria
$sql = "SELECT * FROM galeria WHERE id_galeria = $id_galeria";
$resultado = mysqli_query($conn, $sql);
$foto = mysqli_fetch_assoc($resultado);

if (!$foto) {
    header("Location: galeriaadmin.php");
    exit();
}

// Procesar el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $ruta_imagen = $foto["ruta_imagen"];

    if (isset($_FILES["ruta_imagen"]) && $_FILES["ruta_imagen"]["error"] == 0) {
        $carpeta = "../img/";
        $nuevaImagen = time() . "_" . basename($_FILES["ruta_imagen"]["name"]);

        if (move_uploaded_file($_FILES["ruta_imagen"]["tmp_name"], $carpeta . $nuevaImagen)) {
            if (!empty($ruta_imagen) && file_exists($carpeta . $ruta_imagen)) {
                unlink($carpeta . $ruta_imagen);
            }
            $ruta_imagen = $nuevaImagen;
        }
    }

    $sql_update = "UPDATE galeria SET titulo = '$titulo', descripcion = '$descripcion', ruta_imagen = '$ruta_imagen' WHERE id_galeria = $id_galeria";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: galeriaadmin.php");
        exit();
    } else {
        die("Error al actualizar la galería: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Foto - Galería</title>
<link rel="stylesheet" href="../css/catalogo.css">
<link rel="stylesheet" href="../css/galeriaadmin.css">
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    .contenedor-volver-fijo {
        display: block;
        width: 100%;
        margin-bottom: 20px;
    }
    .btn-volver-corto {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
        color: #000000;
        padding: 10px 24px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        width: max-content;
        transition: background-color 0.2s ease;
    }
    .btn-volver-corto:hover {
        background-color: #f7f7f7;
    }
</style>
</head>
<body>

 <nav id="sidebar">
    <div class="logo">
      <img src="../img/<?php echo $config['logo']; ?>" alt="Logo">
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
    <li><a href="editar_footer.php">Editar logo y datos</a></li>
  </ul>
</nav>

<div class="main-content" style="padding: 30px;">

    <div class="contenedor-volver-fijo">
        <a href="galeriaadmin.php" class="btn-volver-corto">
             ← Volver
        </a>
    </div>

    <div class="upload-card">
        <h1>Editar Fotografía</h1>
        <p>Modifica el título, descripción o la imagen de la galería cultural.</p>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_galeria" value="<?php echo $foto['id_galeria']; ?>">

            <div class="input-group">
                <label>Título de la Imagen</label>
                <input type="text" name="titulo" required value="<?php echo htmlspecialchars($foto['titulo']); ?>">
            </div>

            <div class="input-group">
                <label>Descripción / Contexto Histórico</label>
                <textarea name="descripcion" required rows="5"><?php echo htmlspecialchars($foto['descripcion']); ?></textarea>
            </div>

            <?php if (!empty($foto['ruta_imagen'])): ?>
            <div class="input-group">
                <label>Imagen actual</label>
                <img src="../img/<?php echo htmlspecialchars($foto['ruta_imagen']); ?>" style="max-width:220px; border-radius:10px; display:block; margin-top:8px;">
            </div>
            <?php endif; ?>

            <div class="input-group">
                <label>Reemplazar Imagen (opcional)</label>
                <input type="file" name="ruta_imagen" accept="image/*">
            </div>

            <button type="submit" class="btn-upload">Guardar Cambios</button>
        </form>
    </div>
</div>

</body>
</html>