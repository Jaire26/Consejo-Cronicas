<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
// Borrar noticia si llega la petición desde el botón "Borrar"
if (isset($_GET["borrar"])) {
    $id_borrar = intval($_GET["borrar"]);
 
    // Buscar la imagen para eliminarla del servidor también
    $sql_img = "SELECT imagen FROM noticias WHERE id_noticia = $id_borrar";
    $res_img = mysqli_query($conn, $sql_img);
    if ($res_img && $fila_img = mysqli_fetch_assoc($res_img)) {
        if (!empty($fila_img["imagen"])) {
            $ruta_img = "../img/noticias/" . $fila_img["imagen"];
            if (file_exists($ruta_img)) {
                unlink($ruta_img);
            }
        }
    }
 
    mysqli_query($conn, "DELETE FROM noticias WHERE id_noticia = $id_borrar");
    header("Location: noticiasadmin.php");
    exit();
}
 
// Traer la configuración (para el logo dinámico)
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
 
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
  <section class="feed-section">
 
    <div class="section-title">
      <h2>Noticias</h2>
      <p>Entérate de las últimas novedades</p>
    </div>

    <div class="search-box">
        <input type="text" id="inputBusqueda" placeholder="Buscar por título...">
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
 
              <?php
              $resumen = mb_strlen($contenido) > 160 ? mb_substr($contenido, 0, 160) . "..." : $contenido;
              ?>
 
              <div class="feed-card">
                <div class="feed-image">
                  <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $titulo; ?>">
                </div>
                <div class="feed-info">
                  <span class="tag tag-evento">Noticia</span>
                  <h3><?php echo $titulo; ?></h3>
                  <p><?php echo $resumen; ?></p>
 
                  <div class="feed-actions">
                    <a href="editar_noticia.php?id=<?php echo $noticia['id_noticia']; ?>" class="btn-editar">Editar</a>
                    <a href="noticiasadmin.php?borrar=<?php echo $noticia['id_noticia']; ?>"
                       class="btn-borrar"
                       onclick="return confirm('¿Seguro que quieres borrar esta noticia? Esta acción no se puede deshacer.');">
                       Borrar
                    </a>
                  </div>
 
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
 
<?php include("../componentes/footer.php"); ?>

<script src="js/buscador.js"></script>
</body>
</html>