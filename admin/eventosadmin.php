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
  <title>Eventos</title>

  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
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
  <section class="feed-section">
    
    <div class="section-title">
      <h2>Eventos</h2>
      <p>Entérate de las últimas novedades</p>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>

    <div class="feed-container">
      
      <div class="feed-card">
        <div class="feed-image">
          <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600" alt="Evento Cultural">
        </div>
        <div class="feed-info">
          <span class="tag tag-evento">Próximo Evento</span>
          <h3>Encuentro Anual de Huapango</h3>
          <p>Un espacio donde la música y el zapateado tradicional de la Huasteca se reúnen para celebrar nuestras raíces este fin de semana en la plaza principal.</p>
        </div>
      </div>

      <div class="card admin-card">
        <div class="card-content">
            <h3>Agregar Contenido</h3>
            <p>Administre la galería.</p>
            <a href="../subir/subirevento.html" class="btn-admin">Agregar</a>
        </div>
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
</body>
</html>