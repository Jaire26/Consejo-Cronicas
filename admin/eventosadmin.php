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
  <link rel="stylesheet" href="../css/eventos.css">
      
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

    <div class="feed-container">

      <?php if(mysqli_num_rows($resultado) > 0) { ?>
          <?php while($evento = mysqli_fetch_assoc($resultado)) { ?>
              
              <div class="feed-card">
                <div class="feed-image">
                  <img src="../img/<?php echo htmlspecialchars($evento['imagen']); ?>" 
                       alt="Evento" 
                       class="evento-foto-clic" 
                       data-src="<?php echo htmlspecialchars($evento['imagen']); ?>" 
                       style="cursor: pointer;">
                </div>
                
                <div class="feed-info">
                  <span class="tag tag-evento" style="color: #6F4A33; font-weight: bold; font-size: 15px;">
                    <?php echo date("d M Y", strtotime($evento['fecha'])); ?>
                  </span>
                  <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>
                  <p style="margin: 0 0 8px 0;"><strong>Lugar:</strong> <?php echo htmlspecialchars($evento['lugar']); ?></p>
                  <p style="color: #555; line-height: 1.6; margin: 0;"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                </div>
              </div>

          <?php } ?>
      <?php } else { ?>
          <p style="padding: 20px; text-align: center; color: #6F4A33;">No hay eventos registrados en este momento.</p>
      <?php } ?>

    </div> 

    <div class="card admin-card" >
        <div class="card-content">
            <h3>Agregar Contenido</h3>
            <p>Administre los eventos de la plataforma.</p>
            <a href="subirevento.php" class="btn-admin">Agregar</a>
        </div>
    </div>
  
  </section>
</div> <div class="image-viewer" id="viewer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;">
    <span id="close-viewer" style="position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; cursor: pointer; font-weight: bold;">&times;</span>
    <img id="viewer-img" src="" alt="Imagen Ampliada" style="max-width: 90%; max-height: 90%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
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