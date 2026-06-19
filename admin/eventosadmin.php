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
          
            <div class="card">
              <img src="../img/<?php echo htmlspecialchars($evento['imagen']); ?>" alt="Evento">
            </div>
            <div class="card-content">
              <span class="tag tag-evento"><?php echo date("d M Y", strtotime($evento['fecha'])); ?></span>
              <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>
              <p><strong>Lugar:</strong> <?php echo htmlspecialchars($evento['lugar']); ?></p>
              <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
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
</body>
</html>