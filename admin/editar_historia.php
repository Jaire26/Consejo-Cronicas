<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

include("../conexion/conexion.php");

// Traer la configuración (para el logo dinámico)
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// Validar que llegó un id válido por la URL (GET) o formulario (POST)
if (!isset($_GET["id"]) && !isset($_POST["id_historia"])) {
    header("Location: historiaadmin.php");
    exit();
}

$id_historia = isset($_POST["id_historia"]) ? intval($_POST["id_historia"]) : intval($_GET["id"]);

// Traer los datos actuales de la historia usando id_historia
$sql = "SELECT * FROM historias WHERE id_historia = $id_historia";
$resultado = mysqli_query($conn, $sql);
$historia = mysqli_fetch_assoc($resultado);

if (!$historia) {
    header("Location: historiaadmin.php");
    exit();
}

// Si se envió el formulario, actualizamos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $imagen = $historia["imagen"]; // Dejar la imagen actual por defecto

    // Si se sube una nueva imagen, la procesamos
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $carpeta = "../img/";

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $nuevaImagen = time() . "_" . basename($_FILES["imagen"]["name"]);

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta . $nuevaImagen)) {
            // Borrar la imagen vieja si existía para ahorrar espacio
            if (!empty($imagen) && file_exists($carpeta . $imagen)) {
                unlink($carpeta . $imagen);
            }
            $imagen = $nuevaImagen;
        }
    }
    
    $sql_update = "UPDATE historias SET titulo = '$titulo', descripcion = '$descripcion', imagen = '$imagen' WHERE id_historia = $id_historia";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: historiaadmin.php");
        exit();
    } else {
        die("Error al actualizar en la Base de Datos: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Historia</title>
<link rel="stylesheet" href="../css/catalogo.css">
<link rel="stylesheet" href="../css/galeriaadmin.css">
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<style>
    /* Estilo exacto para el botón Volver ovalado y blanco */
    .btn-volver-personalizado {
        display: inline-block;
        background-color: #fff;
        color: #000;
        padding: 12px 30px;
        border-radius: 50px; /* Hace el botón ovalado */
        text-decoration: none;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        transition: background 0.3s ease;
    }
    .btn-volver-personalizado:hover {
        background-color: #f5f5f5;
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

    <a href="historiaadmin.php" class="btn-volver-personalizado">
         ← Volver
    </a>

    <div class="upload-card">

        <h1>Editar Historia</h1>
        <p>Actualiza el contenido de esta publicación histórica.</p>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id_historia" value="<?php echo $historia['id_historia']; ?>">

            <div class="input-group">
                <label>Título</label>
                <input type="text" name="titulo" required value="<?php echo htmlspecialchars($historia['titulo']); ?>">
            </div>

            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" required rows="6"><?php echo htmlspecialchars($historia['descripcion']); ?></textarea>
            </div>

            <?php if (!empty($historia['imagen'])): ?>
            <div class="input-group">
                <label>Imagen actual</label>
                <img src="../img/<?php echo htmlspecialchars($historia['imagen']); ?>"
                     alt="Imagen actual"
                     style="max-width:220px; border-radius:10px; display:block; margin-top:8px;">
            </div>
            <?php endif; ?>

            <div class="input-group">
                <label>Cambiar imagen (opcional)</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

            <button type="submit" class="btn-upload">
                Guardar Cambios
            </button>

        </form>

    </div>
</div>

</body>
</html>