<?php 
// Conexión a la base de datos
require_once("conexion/conexion.php"); 

$query = "SELECT * FROM galeria ORDER BY id_galeria DESC";
$resultado = mysqli_query($conn, $query);
$total_imagenes = mysqli_num_rows($resultado);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galería</title>
  <link rel="stylesheet" href="css/catalogo.css">
  <link rel="stylesheet" href="css/galeriaadmin.css"> 
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
        <li><a href="perfiles.php">Perfiles</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="entrevistas.php">Entrevistas</a></li>
    </ul>
</nav>

<div class="main-content">
  <section class="feed-section">
    <div class="section-title">
      <h2>Galería Fotográfica de Huejutla</h2>
    </div>

    <div class="gallery">
      <?php 
      if ($total_imagenes > 0) {
          while($foto = mysqli_fetch_assoc($resultado)) { 
          ?>
              <img 
                  src="img/<?php echo htmlspecialchars($foto['ruta_imagen']); ?>" 
                  alt="Imagen de la galería"
                  data-title="<?php echo htmlspecialchars($foto['titulo']); ?>" 
                  data-description="<?php echo htmlspecialchars($foto['descripcion']); ?>"
              >
          <?php 
          } 
      } 
      
      ?>
    </div>
  </section>
</div>

<div id="viewer" style="display: none;">
    <span id="close-viewer">&times;</span>
    <img id="viewer-img" src="" alt="Visor grande">
    <h3 id="viewer-title"></h3>
    <p id="viewer-description"></p>
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

<script src="js/galeria.js"></script>
</body>
</html>