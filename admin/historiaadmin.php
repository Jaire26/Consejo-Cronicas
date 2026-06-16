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
  <title>Historia</title>
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
    <section id="historia">

      <div class="section-title">
        <h2>Historia de Huejutla</h2>
        <p>Conociendo nuestras raíces</p>
      </div>

      <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>

      <?php
    include("../conexion/conexion.php");

      $sql = "SELECT * FROM historias ORDER BY fecha_creacion DESC";
      $resultado = mysqli_query($conn, $sql);
      ?>
<div class="cards">
<?php while($historias = mysqli_fetch_assoc($resultado)) { ?>

    <div class="card">

        <img src="../img/<?php echo $historias['imagen']; ?>" alt="Historia">

        <div class="card-content">

            <h3>
                <?php echo htmlspecialchars($historias['titulo']); ?>
            </h3>

            <p>
                <?php echo htmlspecialchars($historias['descripcion']); ?>
            </p>

            <small>
                   Publicado el <?php echo date("d/m/Y", strtotime($historias['fecha_creacion'])); ?>
            </small>

            <small>
                <?php echo $historias['fecha_actualizacion']; ?>
            </small>

        </div>

    </div>

    </div>

<?php } ?>
        <div class="card admin-card">
          <div class="card-content">
              <h3>Agregar Contenido</h3>
              <p>Administre la historia.</p>
              <a href="subirhis.php" class="btn-admin">Agregar</a>
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