PHP
<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
// Traer todas las noticias guardadas, las más nuevas primero
$sql = "SELECT * FROM noticias ORDER BY id_noticia DESC";
$resultado = mysqli_query($conn, $sql);
 
if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Noticias</title>
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
 
              // Si tiene imagen guardada, la usamos; si no, una de respaldo
              if (!empty($imagen)) {
                  $rutaImagen = "../img/noticias/" . htmlspecialchars($imagen);
              } else {
                  $rutaImagen = "https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600";
              }
              ?>
 
              <div class="feed-card">
                <div class="feed-image">
                  <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $titulo; ?>">
                </div>
                <div class="feed-info">
                  <span class="tag tag-evento">Noticia</span>
                  <h3><?php echo $titulo; ?></h3>
                  <p><?php echo $contenido; ?></p>
                </div>
              </div>
 
              <?php
          }
      } else {
          echo "<p style='padding:20px;'>Aún no hay noticias publicadas.</p>";
      }
      ?>
 
      <div class="card admin-card">
        <div class="card-content">
            <h3>Agregar Contenido</h3>
            <p>Administre las noticias.</p>
            <a href="subirnoti.php" class="btn-admin">Agregar</a>
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
 