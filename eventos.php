<?php
include("conexion/conexion.php");

$query = "SELECT * FROM eventos ORDER BY id_evento DESC";
$resultado = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventos</title>
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
  <section class="feed-section">
    <div class="section-title">
      <h2>Eventos en Huejutla</h2>
      <p>Entérate de las últimas novedades</p>
    </div>

    <div class="feed-container">
      <?php if(mysqli_num_rows($resultado) > 0) { ?>
          <?php while($evento = mysqli_fetch_assoc($resultado)) { ?>
              <div class="feed-card">
                <div class="feed-image">
                  <img src="img/<?php echo htmlspecialchars($evento['imagen']); ?>" alt="Evento Cultural">
                </div>
                <div class="feed-info">
                  <span class="tag tag-evento"><?php echo date("d M Y", strtotime($evento['fecha'])); ?></span>
                  <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>
                  <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['lugar']); ?></p>
                  <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                </div>
              </div>
          <?php } ?>
      <?php } else { ?>
          <p>No hay eventos próximos programados en este momento.</p>
      <?php } ?>
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