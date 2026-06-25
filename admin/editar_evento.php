<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

if (!isset($_GET["id"]) && !isset($_POST["id_evento"])) {
    header("Location: eventosadmin.php");
    exit();
}

$id_evento = isset($_POST["id_evento"]) ? intval($_POST["id_evento"]) : intval($_GET["id"]);

// Consultar evento por id_evento
$sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
$resultado = mysqli_query($conn, $sql);
$evento = mysqli_fetch_assoc($resultado);

if (!$evento) {
    header("Location: eventosadmin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $fecha = mysqli_real_escape_string($conn, $_POST["fecha"]);
    $lugar = mysqli_real_escape_string($conn, $_POST["lugar"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $imagen = $evento["imagen"];

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $carpeta = "../img/";
        $nuevaImagen = time() . "_" . basename($_FILES["imagen"]["name"]);

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $carpeta . $nuevaImagen)) {
            if (!empty($imagen) && file_exists($carpeta . $imagen)) {
                unlink($carpeta . $imagen);
            }
            $imagen = $nuevaImagen;
        }
    }

    $sql_update = "UPDATE eventos SET nombre = '$nombre', fecha = '$fecha', lugar = '$lugar', descripcion = '$descripcion', imagen = '$imagen' WHERE id_evento = $id_evento";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: eventosadmin.php");
        exit();
    } else {
        die("Error al actualizar el evento: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Evento</title>
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
        <a href="eventosadmin.php" class="btn-volver-corto">
             ← Volver
        </a>
    </div>

    <div class="upload-card">
        <h1>Editar Evento</h1>
        <p>Modifica los datos del evento o celebración cultural.</p>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">

            <div class="input-group">
                <label>Nombre del Evento</label>
                <input type="text" name="nombre" required value="<?php echo htmlspecialchars($evento['nombre']); ?>">
            </div>

            <div class="input-group">
                <label>Fecha</label>
                <input type="date" name="fecha" required value="<?php echo htmlspecialchars($evento['fecha']); ?>">
            </div>

            <div class="input-group">
                <label>Lugar</label>
                <input type="text" name="lugar" required value="<?php echo htmlspecialchars($evento['lugar']); ?>">
            </div>

            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" required rows="5"><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
            </div>

            <?php if (!empty($evento['imagen'])): ?>
            <div class="input-group">
                <label>Imagen del banner actual</label>
                <img src="../img/<?php echo htmlspecialchars($evento['imagen']); ?>" style="max-width:220px; border-radius:10px; display:block; margin-top:8px;">
            </div>
            <?php endif; ?>

            <div class="input-group">
                <label>Reemplazar Imagen (opcional)</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

            <button type="submit" class="btn-upload">Guardar Cambios</button>
        </form>
    </div>
</div>

</body>
</html>