<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galería</title>

  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="stylesheet" href="../css/verfoto.css">
</head>
<body>

 <nav id="sidebar">

    <div class="logo">
      <img src="../img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
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
  </ul>

</nav>
<div class="main-content">

  <section id="galeria">

  <div class="section-title">
    <h2>Galería Cultural</h2>
    <p>Fotografías y recuerdos de Huejutla</p>
  </div>

  <div class="gallery">
    <img 
      src="xantolo huejutla.jpg" 
      data-title="Xantolo en Huejutla"
      data-description="Celebración tradicional llena de cultura y color.">

    <img 
      src="foto2.jpg"
      data-title="Tradiciones Huastecas"
      data-description="Fotografías históricas de las festividades regionales.">
  </div>
  <div class="image-viewer" id="viewer">
    <span id="close-viewer">&times;</span>
    <div class="viewer-content">
        <img id="viewer-img">
        <h2 id="viewer-title"></h2>
        <p id="viewer-description"></p>
    </div>
  </div>
  <div class="card admin-card">
    <div class="card-content">
        <h3>Agregar Contenido</h3>
        <p>Administre la galeria.</p>
        <a href="../subir/subirfoto.php" class="btn-admin">Agregar</a>
    </div>
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

  <script src="../js/galeria.js"></script>
</body>
</html>