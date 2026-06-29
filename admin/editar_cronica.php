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

// Validar parámetros que llegan por URL o formulario
if (!isset($_GET["id"]) && !isset($_POST["id_cronica"])) {
    header("Location: cronicasadmin.php");
    exit();
}

$id_cronica = isset($_POST["id_cronica"]) ? intval($_POST["id_cronica"]) : intval($_GET["id"]);

// Traer datos actuales de la crónica usando id_cronica
$sql = "SELECT * FROM cronicas WHERE id_cronica = $id_cronica";
$resultado = mysqli_query($conn, $sql);
$cronica = mysqli_fetch_assoc($resultado);

if (!$cronica) {
    header("Location: cronicasadmin.php");
    exit();
}

// Procesar actualización al enviar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $autor = mysqli_real_escape_string($conn, $_POST["autor"]);
    $resumen = mysqli_real_escape_string($conn, $_POST["resumen"]);
    $contenido = mysqli_real_escape_string($conn, $_POST["contenido"]);
    $imagen = $cronica["imagen"]; // Imagen por defecto

    // Si se sube una nueva imagen
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $carpeta = "../img/";
        $nuevaImagen = time() . "_" . basename($_FILES["imagen"]["name"]);

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta . $nuevaImagen)) {
            if (!empty($imagen) && file_exists($carpeta . $imagen)) {
                unlink($carpeta . $imagen); // Borrar la anterior
            }
            $imagen = $nuevaImagen;
        }
    }
    
    $sql_update = "UPDATE cronicas SET titulo = '$titulo', autor = '$autor', resumen = '$resumen', contenido = '$contenido', imagen = '$imagen' WHERE id_cronica = $id_cronica";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: cronicasadmin.php");
        exit();
    } else {
        die("Error al actualizar la crónica: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Crónica</title>
<link rel="stylesheet" href="../css/catalogo.css">
<link rel="stylesheet" href="../css/galeriaadmin.css">
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<style>
    .contenedor-volver-fijo {
        display: block;
        width: 100%;
        margin-bottom: 20px;
    }
    /* Botón corto y ovalado idéntico al que querías */
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
        <a href="cronicasadmin.php" class="btn-volver-corto">
             ← Volver
        </a>
    </div>

    <div class="upload-card">
        <h1>Editar Crónica</h1>
        <p>Actualiza la información y el cuerpo del relato.</p>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_cronica" value="<?php echo $cronica['id_cronica']; ?>">

            <div class="input-group">
                <label>Título</label>
                <input type="text" name="titulo" required value="<?php echo htmlspecialchars($cronica['titulo']); ?>">
            </div>

            <div class="input-group">
                <label>Autor</label>
                <input type="text" name="autor" required value="<?php echo htmlspecialchars($cronica['autor']); ?>">
            </div>

            <div class="input-group">
                <label>Resumen corto</label>
                <textarea name="resumen" required rows="3"><?php echo htmlspecialchars($cronica['resumen']); ?></textarea>
            </div>

            <div class="input-group">
                <label>Contenido Completo</label>
                <textarea name="contenido" required rows="10"><?php echo htmlspecialchars($cronica['contenido']); ?></textarea>
            </div>

            <?php if (!empty($cronica['imagen'])): ?>
            <div class="input-group">
                <label>Imagen actual</label>
                <img src="../img/<?php echo htmlspecialchars($cronica['imagen']); ?>" style="max-width:220px; border-radius:10px; display:block; margin-top:8px;">
            </div>
            <?php endif; ?>

            <div class="input-group">
                <label>Cambiar imagen (opcional)</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

            <button type="submit" class="btn-upload">Guardar Cambios</button>
        </form>
    </div>
</div>

</body>
</html>