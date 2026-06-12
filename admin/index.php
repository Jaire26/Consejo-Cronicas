<?php
// PUNTO 3: Protección de sesión
// Si el usuario no está logueado, lo manda al login inmediatamente
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
  <title>Panel Admin - Crónica Huejutlense</title>
 
  <link rel="stylesheet" href="../css/inicio.css">
  <link rel="stylesheet" href="../css/inicioadmin.css">
 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
 
<body>
 
<header>
 
  <nav id="navbar">
 
    <div class="logo">
      <img src="../img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
      <span>CRÓNICA HUEJUTLENSE</span>
    </div>
 
    <div class="nav-actions">
 
      <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>
 
      <!-- Muestra el nombre del usuario logueado -->
      <span class="usuario-sesion">
        Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?>
      </span>
 
      <!-- Cerrar sesión ahora apunta al archivo correcto -->
      <a href="../conexion/cerrar_sesion.php" class="btn-login">Cerrar Sesión</a>
 
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
 
    <a href="../admin/historiaadmin.html" class="opcion-card">
      <h3>Historia</h3>
      <p>Consulta y actualiza la información.</p>
    </a>
 
    <a href="../admin/cronicasadmin.html" class="opcion-card">
      <h3>Crónicas</h3>
      <p>Consulta y agrega.</p>
    </a>
 
    <a href="../admin/galeriaadmin.html" class="opcion-card">
      <h3>Galería</h3>
      <p>Administra imágenes y fotografías.</p>
    </a>
 
    <a href="../admin/eventosadmin.html" class="opcion-card">
      <h3>Eventos</h3>
      <p>Agrega eventos importantes.</p>
    </a>
 
    <a href="../admin/perfilesadmin.php" class="opcion-card">
      <h3>Perfiles</h3>
      <p>Gestiona al equipo.</p>
    </a>
 
    <a href="../admin/noticiasadmin.html" class="opcion-card">
      <h3>Noticias</h3>
      <p>Publica noticias y comunicados.</p>
    </a>
 
    <a href="../admin/entrevistasadmin.html" class="opcion-card">
      <h3>Entrevistas</h3>
      <p>Agrega contenido interesante.</p>
    </a>
 
  </div>
 
</section>
 
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
 
<script src="../js/inicio.js"></script>
</body>
</html>