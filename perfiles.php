<?php
include("conexion/conexion.php");

// Traemos los datos para que el logo funcione en el index
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfiles</title>

  <!-- Corregido: Rutas directas desde la raíz para las hojas de estilo -->
  <link rel="stylesheet" href="css/catalogo.css">
  <link rel="stylesheet" href="css/perfiles.css">
</head>
<body>

 <nav id="sidebar">
    <div class="logo">
      <img src="img/<?php echo $config['logo']; ?>" alt="Logo">

    <ul class="menu">
        <!-- Corregido: Enlaces limpios en la raíz y actualizados a .php -->
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
  <section id="galeria">

    <div class="section-title">
      <h2>Perfiles</h2>
      <p>Conoce A Nuestro Equipo De Trabajo</p>
    </div>

    <div class="search-box">
       <input type="text" placeholder="Buscar...">
    </div>
    
    <div class="cards">
      <div class="card">
        <img src="https://images.unsplash.com/photo-1518991791750-749a6b7c6e0d?q=80&w=1200&auto=format&fit=crop" alt="Orígenes">
        <div class="card-content">
          <h3>Orígenes</h3>
          <p>Huejutla posee una gran riqueza cultural heredada de la Huasteca.</p>
        </div>
      </div>

      <div class="card">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1200&auto=format&fit=crop" alt="Tradiciones">
        <div class="card-content">
          <h3>Tradiciones</h3>
          <p>El Xantolo representa una de las celebraciones más importantes.</p>
        </div>
      </div>
    </div>

  </section> <!-- Corregido: Cierre de sección dentro de main-content -->
</div> <!-- Corregido: Cierre de main-content -->

<?php include("componentes/footer.php"); ?>

</body>
</html>