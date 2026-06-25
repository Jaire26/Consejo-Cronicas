<?php
include("conexion/conexion.php");

$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

$sql = "SELECT * FROM historias ORDER BY fecha_creacion DESC";
$resultado = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historia</title>
  <!-- Corregido: Se quitó '../' porque la carpeta css está al lado de este archivo -->
  <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>

  <nav id="sidebar">
    <div class="logo">
  <img src="img/<?php echo $config['logo']; ?>" alt="Logo">
</div>
    <ul class="menu">
        <!-- Corregido: Enlaces limpios sin '../' y actualizados a .php para el público -->
        <li><a href="index.php">Inicio</a></li>
        <li><a href="historia.php">Historia</a></li>
        <li><a href="cronicas.php">Crónicas</a></li>
        <li><a href="galeria.php">Galería</a></li>
        <li><a href="eventos.php">Eventos</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="entrevistas.php">Entrevistas</a></li>
    </ul>
  </nav>

  <div class="main-content">
    <section id="historia">

      <div class="section-title">
        <h2>Historia de Huejutla</h2>
        <p>Conociendo nuestras raíces</p>
      </div>

      <div class="search-box">
        <input type="text" placeholder="Buscar por titulo...">
      </div>

      <div class="cards">

<?php while($historia = mysqli_fetch_assoc($resultado)) { ?>

    <div class="card">

        <img src="img/<?php echo $historia['imagen']; ?>" alt="Historia">

        <div class="card-content">

            <h3>
                <?php echo htmlspecialchars($historia['titulo']); ?>
            </h3>

            <p>
                <?php echo htmlspecialchars($historia['descripcion']); ?>
            </p>

            <small>
                Publicado el
                <?php echo date("d/m/Y", strtotime($historia['fecha_creacion'])); ?>
            </small>

        </div>

    </div>

<?php } ?>

</div>
    </section>
  </div>
  
  <?php include("componentes/footer.php"); ?>

  <script src="../js/buscador.js"></script>
</body>
</html>