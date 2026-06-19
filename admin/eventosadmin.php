<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

$query = "SELECT * FROM eventos ORDER BY id_evento DESC";
$resultado = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventos - Admin</title>
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
      <h2>Panel de Eventos</h2>
      <p>Administra las novedades culturales</p>
    </div>
      <div class="cards">

      <?php while($evento = mysqli_fetch_assoc($resultado)) { ?>
          
            <div class="card cronica-card evento-foto-clic" 
         data-src="<?php echo htmlspecialchars($evento['imagen']); ?>" 
         style="cursor: pointer;">
         
      <img src="img/<?php echo htmlspecialchars($evento['imagen']); ?>" alt="Evento">
      
      <div class="card-content">
        <span class="cronica-fecha"><?php echo date("d M Y", strtotime($evento['fecha'])); ?></span>
        <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>
        <h4>Por: Consejo Huejutlense</h4>
        <p class="cronica-resumen">
          <strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['lugar']); ?><br>
          <?php echo htmlspecialchars($evento['descripcion']); ?>
        </p>
      </div>
    </div>
      <?php } ?>

      <div class="feed-container">
      
      <div class="card admin-card">
        <div class="card-content">
            <h3>Agregar Contenido</h3>
            <p>Administre los eventos de la plataforma.</p>
            <a href="subirevento.php" class="btn-admin">Agregar</a>
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

<div class="image-viewer" id="viewer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;">
    <span id="close-viewer" style="position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; cursor: pointer; font-weight: bold;">&times;</span>
    <img id="viewer-img" src="" alt="Imagen Ampliada" style="max-width: 90%; max-height: 90%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
</div>

<script src="../js/visualizoreventos.js"></script>
</body>
</html>