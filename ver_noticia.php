<?php
include("conexion/conexion.php");
 
if (!isset($_GET["id"])) {
    header("Location: noticias.php");
    exit();
}
 
$id_noticia = intval($_GET["id"]);
 
$sql = "SELECT * FROM noticias WHERE id_noticia = $id_noticia";
$resultado = mysqli_query($conn, $sql);
$noticia = mysqli_fetch_assoc($resultado);
 
if (!$noticia) {
    header("Location: noticias.php");
    exit();
}
 
// Traer las imágenes adicionales de la galería
$sql_galeria = "SELECT * FROM noticias_imagenes WHERE id_noticia = $id_noticia ORDER BY orden ASC";
$res_galeria = mysqli_query($conn, $sql_galeria);
 
$titulo    = htmlspecialchars($noticia["titulo"]);
$contenido = htmlspecialchars($noticia["contenido"]);
$imagen    = $noticia["imagen"];
$fecha     = $noticia["fecha_publicacion"] ?? null;
 
if (!empty($imagen)) {
    $rutaPortada = "img/noticias/" . htmlspecialchars($imagen);
} else {
    $rutaPortada = "https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titulo; ?></title>
  <link rel="stylesheet" href="css/catalogo.css?v=3">
</head>
<body>
 
 <nav id="sidebar">
 
    <div class="logo">
      <img src="img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
    </div>
 
    <ul class="menu">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="historia.php">Historia</a></li>
        <li><a href="cronicas.php">Crónicas</a></li>
        <li><a href="galeria.php">Galería</a></li>
        <li><a href="eventos.php">Eventos</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="entrevistas.php">Entrevistas</a></li>
    </ul>
 
</nav>
 
<div class="main-content">
  <section class="noticia-detalle">
 
    <a href="noticias.php" class="btn-volver-noticia">← Volver a Noticias</a>
 
    <div class="noticia-card">
 
      <h1 class="noticia-titulo"><?php echo $titulo; ?></h1>
 
      <div class="noticia-meta-container">
      <span class="card-tag">Noticia</span>
      <p class="noticia-fecha">
      <?php
      if (!empty($fecha) && $fecha !== "0000-00-00") {
        echo "Publicado el: " . date("d/m/Y", strtotime($fecha));
      } else {
        echo "Sin fecha";
      }
      ?>
      </p>
      </div>
      <div class="noticia-imagen-principal">
        <img src="<?php echo $rutaPortada; ?>" alt="<?php echo $titulo; ?>">
      </div>
 
      <div class="noticia-contenido">
        <?php echo nl2br($contenido); ?>
      </div>
 
      <?php if (mysqli_num_rows($res_galeria) > 0): ?>
      <div class="noticia-galeria-titulo">Galería de imágenes</div>
      <div class="noticia-galeria">
        <?php while ($img = mysqli_fetch_assoc($res_galeria)): ?>
          <img src="img/noticias/<?php echo htmlspecialchars($img['imagen']); ?>" alt="Imagen de la noticia">
        <?php endwhile; ?>
      </div>
      <?php endif; ?>
 
    </div>
 
  </section>
</div>
 
<footer class="footer-global">
    <div class="footer-content">
      <h2>Crónica Huejutlense</h2>
      <div class="footer-contact">
          <p><strong>Correo:</strong> contacto@cronicahuejutla.com</p>
          <p><strong>Teléfono:</strong> +52 775 487 9831</p>
          <p><strong>Ubicación:</strong> Huejutla de Reyes, Hidalgo</p>
      </div>
    </div>
</footer>
 
</body>
</html>