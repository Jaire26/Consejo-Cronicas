<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// 1. Traer la configuración saliendo un nivel
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// 2. Traer las historias
$sql = "SELECT * FROM historias ORDER BY fecha_creacion DESC";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historia - Admin</title>
  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
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
    <section id="historia">

      <div class="section-title">
        <h2>Historia de Huejutla</h2>
        <p>Conociendo nuestras raíces</p>
      </div>

      <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>

      <div class="cards">
        
        <?php 
        // Agregamos la validación idéntica al público para proteger la estructura
        if (mysqli_num_rows($resultado) > 0) {
            while($historias = mysqli_fetch_assoc($resultado)) { 
        ?>
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
                    </div>
                </div>
        <?php 
            } 
        } else {
            echo "<p style='grid-column: 1/-1; text-align: center; color: #666;'>No hay historias registradas.</p>";
        }
        ?>

        <div class="card admin-card">
          <div class="card-content">
              <h3>Agregar Contenido</h3>
              <p>Administre la historia.</p>
              <a href="subirhis.php" class="btn-admin">Agregar</a>
          </div>
        </div>

      </div> </section>
  </div> 

  <?php include("../componentes/footer.php"); ?>

</body>
</html>