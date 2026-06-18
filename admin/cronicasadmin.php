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
  <title>Crónicas</title>

  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="stylesheet" href="../css/vercronica.css">
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

  <section id="cronicas">

    <div class="section-title">
      <h2>Crónicas y Relatos</h2>
      <p>Historias que mantienen viva la memoria</p>
    </div>

    <div class="search-box">
       <input type="text" placeholder="Buscar...">
    </div>

    <?php
    include("../conexion/conexion.php");
    // Consultamos la tabla cronicas (Cámbiale el 'id' u orden si lo requieres por fecha)
    $sql = "SELECT * FROM cronicas ORDER BY id_cronica DESC"; 
    $resultado = mysqli_query($conn, $sql);
    ?>

    <div class="cards">
    <?php while($cronicas = mysqli_fetch_assoc($resultado)) { ?>

        <div class="card cronica-card">

            <img src="../img/<?php echo $cronicas['imagen']; ?>" alt="Crónica">

            <div class="card-content">

                <span class="cronica-fecha">
                    <?php echo date("d M Y", strtotime($cronicas['fecha'])); ?>
                </span>

                <h3>
                    <?php echo htmlspecialchars($cronicas['titulo']); ?>
                </h3>

                <h4>
                    Por: <?php echo htmlspecialchars($cronicas['autor']); ?>
                </h4>

                <p class="cronica-resumen">
                    <?php echo htmlspecialchars($cronicas['resumen']); ?>
                </p>

                <button class="btn-cronica" onclick="mostrarCronica(this)">
                   Leer Crónica
                </button>
            </div>

        </div>

    <?php } ?>

        <div class="card admin-card">
          <div class="card-content">
              <h3>Agregar Contenido</h3>
              <p>Administre las crónicas.</p>
              
              <a href="subircronica.php" class="btn-admin">
                  Agregar
              </a>
          </div>
        </div>

    </div> </section>

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

  <script src="../js/leercronica.js"></script>
</body>
</html>