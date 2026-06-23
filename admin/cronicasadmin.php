<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

// 1. PRIMERO LO PRIMERO: Conectar e ir por los datos
include("../conexion/conexion.php");

// TRAEMOS LA CONFIGURACIÓN (Para el logo que se pinta abajo)
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// TRAEMOS LAS CRÓNICAS
$sql = "SELECT * FROM cronicas ORDER BY id_cronica DESC"; 
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crónicas - Admin</title>

  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="stylesheet" href="../css/vercronica.css">
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
      <li><a href="editar_footer.php">Editar footer</a></li>
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

    <div class="cards">
    <?php 
    $meses_es = array("Jan" => "Ene", "Feb" => "Feb", "Mar" => "Mar", "Apr" => "Abr", "May" => "May", "Jun" => "Jun", "Jul" => "Jul", "Aug" => "Ago", "Sep" => "Sep", "Oct" => "Oct", "Nov" => "Nov", "Dec" => "Dic");

    while($cronicas = mysqli_fetch_assoc($resultado)) { 
        $fecha_en = date("d M Y", strtotime($cronicas['fecha']));
        $mes_en = date("M", strtotime($cronicas['fecha']));
        $fecha_es = str_replace($mes_en, $meses_es[$mes_en], $fecha_en);
    ?>
        <div class="card cronica-card">
            <img src="../img/<?php echo $cronicas['imagen']; ?>" alt="Crónica">

            <div class="card-content">
                <span class="cronica-fecha">
                    <?php echo $fecha_es; ?>
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

                <button class="btn-cronica" 
                        onclick="mostrarCronica(this)"
                        data-titulo="<?php echo htmlspecialchars($cronicas['titulo']); ?>"
                        data-autor="<?php echo htmlspecialchars($cronicas['autor']); ?>"
                        data-fecha="<?php echo $fecha_es; ?>"
                        data-contenido="<?php echo htmlspecialchars($cronicas['contenido']); ?>">
                    Leer Crónica
                </button>
            </div>
        </div>
    <?php } ?>

        <div class="card admin-card">
          <div class="card-content">
              <h3>Agregar Contenido</h3>
              <p>Administre las crónicas.</p>
              <a href="subircronica.php" class="btn-admin">Agregar</a>
          </div>
        </div>

    </div> 
  </section>
</div>

<?php include("../componentes/footer.php"); ?>
<script src="../js/leercronica.js"></script>
</body>
</html>