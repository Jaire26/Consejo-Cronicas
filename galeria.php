<?php 
// 1. Conectamos a la base de datos de MariaDB
require_once("conexion/conexion.php"); 

// 2. CORREGIDO: Cambiado 'galeria' por 'galerias' (en plural)
$query = "SELECT * FROM galerias ORDER BY id_galeria DESC";
$resultado = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería - Consejo de la Crónica</title>
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="css/galeriaadmin.css"> 
    <link rel="stylesheet" href="css/catalogo.css">
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
    <section class="gallery-container">
        <h2>Galería Fotográfica de Huejutla</h2>

        <div class="gallery">
            <?php 
            // 3. El ciclo PHP genera cada imagen extrayendo los datos de tu BD
            while($foto = mysqli_fetch_assoc($resultado)) { 
            ?>
                <!-- CORREGIDO: Se cambiaron los campos para que coincidan con tus columnas de SQLyog -->
                <img 
                    src="img/<?php echo htmlspecialchars($foto['nombre']); ?>.jpg" 
                    alt="Imagen de la galería"
                    data-title="<?php echo htmlspecialchars($foto['nombre']); ?>" 
                    data-description="<?php echo htmlspecialchars($foto['descripcion']); ?>"
                >
            <?php 
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