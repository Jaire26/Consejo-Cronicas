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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Admin - Crónica Huejutlense</title>
 
  <link rel="stylesheet" href="../css/inicio.css">
  <link rel="stylesheet" href="../css/inicioadmin.css">
 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2=family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
 
<body>
 
<header>
 
  <nav id="navbar">
 
    <div class="logo">
      <img src="../img/<?php echo $config['logo']; ?>" alt="Logo">
      <span>CRÓNICA HUEJUTLENSE</span>
    </div>
 
    <div class="nav-actions">
       <span class="usuario-sesion">
        Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
      </span>
 
      <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>


      
 
       <a href="../conexion/cerrar_sesion.php" class="btn-login" onclick="return confirmarCerrarSesion()"> Cerrar Sesión
</a>
 
    </div>
 
  </nav>
 
  <div class="hero" id="inicio">
    <div class="hero-content">
      <h1>VOCES Y CRÓNICAS HUEJUTLENSES</h1>
      <p>Preservando la historia, cultura y memoria colectiva.</p>
    </div>
  </div>
 
</header>
 
<section class="panel-opciones">
  <h2>¿Qué desea visitar hoy?</h2>
 
  <div class="opciones-grid">
 
    <a href="historiaadmin.php" class="opcion-card">
      <h3>Historia</h3>
      <p>Consulta y actualiza la información.</p>
    </a>
 
    <a href="cronicasadmin.php" class="opcion-card">
      <h3>Crónicas</h3>
      <p>Consulta y agrega.</p>
    </a>
 
    <a href="galeriaadmin.php" class="opcion-card">
      <h3>Galería</h3>
      <p>Administra imágenes y fotografías.</p>
    </a>
 
    <a href="eventosadmin.php" class="opcion-card">
      <h3>Eventos</h3>
      <p>Agrega eventos importantes.</p>
    </a>
 
    <a href="perfilesadmin.php" class="opcion-card">
      <h3>Perfiles</h3>
      <p>Gestiona al equipo.</p>
    </a>
 
    <a href="noticiasadmin.php" class="opcion-card">
      <h3>Noticias</h3>
      <p>Publica noticias y comunicados.</p>
    </a>
 
    <a href="entrevistasadmin.php" class="opcion-card">
      <h3>Entrevistas</h3>
      <p>Agrega contenido interesante.</p>
    </a>

    <a href="editar_footer.php" class="opcion-card">
      <h3>Editar logo y datos</h3>
      <p>Edita el logo y los datos de la pagina.</p>
    </a>
 
  </div>
 
</section>
 
 <?php include("../componentes/footer.php"); ?>
 
<script src="../js/inicio.js"></script>
<script>
function confirmarCerrarSesion() {
    return confirm("¿Está seguro de que desea cerrar sesión?");
}

</script>
<script src="../js/leercronica.js"></script>
</body>
</html>