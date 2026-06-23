<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// Consultamos de la tabla renombrada 'galeria'
$query = "SELECT * FROM galeria ORDER BY id_galeria DESC";
$resultado = mysqli_query($conn, $query);
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
      <img src="../img/<?php echo $config['logo']; ?>" alt="Logo">
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
    <li><a href="editar_footer.php">Editar logo y datos</a></li>
  </ul>
</nav>

<div class="main-content">
  <section id="galeria">

  <div class="section-title">
    <h2>Galería Cultural (Admin)</h2>
    <p>Fotografías y recuerdos de Huejutla</p>
  </div>

  <div class="gallery">
  
    <?php while($foto = mysqli_fetch_assoc($resultado)) { ?>
        <div class="gallery-item-container" style="position:relative; display:inline-block;">
            <img 
              src="../img/<?php echo htmlspecialchars($foto['ruta_imagen']); ?>" 
              data-title="<?php echo htmlspecialchars($foto['titulo']); ?>" 
              data-description="<?php echo htmlspecialchars($foto['descripcion']); ?>"
            >
        </div>
    <?php } ?>
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
        <a href="subirfoto.php" class="btn-admin">Agregar</a>
    </div>
  </div>

</section>
</div>
 
  <?php include("../componentes/footer.php"); ?>
  <script src="../js/galeria.js"></script>
</body>
</html>