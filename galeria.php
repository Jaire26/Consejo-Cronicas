<?php 
// Conexión a la base de datos
require_once("conexion/conexion.php");


$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

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
  <link rel="stylesheet" href="css/verfoto.css"> 
</head>
<body>

 <nav id="sidebar">
    <div class="logo">
      <img src="img/<?php echo $config['logo']; ?>" alt="Logo">
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
      <h2>Galería Cultural</h2>
    </div>

    <div class="search-box">
        <input type="text" id="inputBusqueda" placeholder="Buscar por título...">
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

<div class="image-viewer" id="viewer">
    <span id="close-viewer">&times;</span>
    <div class="viewer-content">
        <img id="viewer-img" src="" alt="Visor grande">
        <h2 id="viewer-title"></h2>
        <p id="viewer-description"></p>
    </div>
</div>
  <?php include("componentes/footer.php"); ?>

<script src="js/galeria.js"></script>
<script src="js/buscador.js"></script>
</body>
</html>