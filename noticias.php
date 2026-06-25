<?php
include("conexion/conexion.php");
 
// Traer todas las noticias guardadas, las más nuevas primero
$sql = "SELECT * FROM noticias ORDER BY id_noticia DESC";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Noticias</title>
  <link rel="stylesheet" href="css/catalogo.css?v=2">
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
  <section class="feed-section">
 
    <div class="section-title">
      <h2>Noticias</h2>
      <p>Entérate de las últimas novedades</p>
    </div>
 
    <div class="search-box">
      <input type="text" placeholder="Buscar...">
    </div>
 
    <div class="feed-container">
 
      <?php
      if ($resultado && mysqli_num_rows($resultado) > 0) {
          while ($noticia = mysqli_fetch_assoc($resultado)) {
 
              $titulo    = htmlspecialchars($noticia["titulo"]);
              $contenido = htmlspecialchars($noticia["contenido"]);
              $imagen    = $noticia["imagen"];
              $categoria = htmlspecialchars($noticia["categoria"] ?? "General");
              $fecha     = $noticia["fecha_publicacion"];
              if (!empty($imagen)) {
                  $rutaImagen = "img/noticias/" . htmlspecialchars($imagen);
              } else {
                  $rutaImagen = "https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600";
              }
              ?>
 
              <?php
              $resumen = mb_strlen($contenido) > 160 ? mb_substr($contenido, 0, 160) . "..." : $contenido;
              ?>
 
              <div class="feed-card">
                <div class="feed-image">
                  <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $titulo; ?>">
                </div>
                <div class="feed-info">
                  <span class="tag tag-evento">
                  <?php echo $categoria; ?>
                  </span>
                  <h3><?php echo $titulo; ?></h3>
                  <p class="fecha-noticia">
                  <?php
                  if(!empty($fecha) && $fecha !== "0000-00-00"){
                      echo date("d/m/Y", strtotime($fecha));
                  }else{
                      echo "Sin fecha";
                  }
                  ?>
                  </p>
                  <p><?php echo $resumen; ?></p>
                  <a href="ver_noticia.php?id=<?php echo $noticia['id_noticia']; ?>" class="btn-leer-mas">Leer más →</a>
                </div>
              </div>
 
              <?php
          }
      } else {
          echo "<p style='padding:20px;'>Aún no hay noticias publicadas.</p>";
      }
      ?>
 
    </div>
 
  </section>
</div>
 
<footer class="footer-global">
    <div class="footer-content">
      <h2>Crónica Huejutlense</h2>
 
      <div class="footer-contact">
          <p>
            <strong>Correo:</strong>
            contacto@cronicahuejutla.com
          </p>
 
          <p>
            <strong>Teléfono:</strong>
            +52 775 487 9831
          </p>
 
          <p>
            <strong>Ubicación:</strong>
            Huejutla de Reyes, Hidalgo
          </p>
      </div>
    </div>
</footer>
 
</body>
</html>
 