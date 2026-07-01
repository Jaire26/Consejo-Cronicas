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
  <title>Voces y crónicas Huejutlenses</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/inicio.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<header>
  <nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid nav-inner">

      <a class="navbar-brand logo" href="index.php">
        <img src="img/<?php echo $config['logo']; ?>" alt="Logo">
      </a>

      <!-- Botón hamburguesa Bootstrap -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">

        <ul class="navbar-nav mx-auto text-center menu">
          <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="historia.php">Historia</a></li>
          <li class="nav-item"><a class="nav-link" href="cronicas.php">Crónicas</a></li>
          <li class="nav-item"><a class="nav-link" href="galeria.php">Galería</a></li>
          <li class="nav-item"><a class="nav-link" href="eventos.php">Eventos</a></li>
          <li class="nav-item"><a class="nav-link" href="noticias.php">Noticias</a></li>
          <li class="nav-item"><a class="nav-link" href="entrevistas.php">Entrevistas</a></li>
        </ul>

        <div class="menu-title d-lg-none">CRÓNICA HUEJUTLENSE</div>

        <div class="nav-actions">
          <div class="search-box">
            <input type="text" id="inputBusqueda" placeholder="Buscar por título...">
          </div>

          <a href="login.php" class="btn-login">Iniciar sesión</a>
        </div>

      </div>

    </div>
  </nav>

  <div class="hero" id="inicio">
    <div class="hero-content">
      <h1>VOCES Y CRONICAS HUEJUTLENSES</h1>
      <p>Preservando la historia, cultura y memoria colectiva.</p>
    </div>
  </div>
</header>

<section id="historia">
  <div class="section-title">
    <p>Conociendo nuestras raíces</p>
  </div>

  <div class="cards">
    <div class="card">
      <img src="img/danzas.jpeg" alt="Misión">
      <div class="card-content">
        <h3>Misión</h3>
        <p>
          Preservar, investigar y difundir la historia, tradiciones y patrimonio cultural
          del municipio, a través de la producción de crónicas, investigaciones y actividades
          que fortalezcan la identidad local y promuevan el conocimiento histórico entre la ciudadanía.
        </p>
      </div>
    </div>

    <div class="card">
      <img src="img/reloj.webp" alt="Visión">
      <div class="card-content">
        <h3>Visión</h3>
        <p>
          Ser un referente en la construcción de la memory histórica del municipio,
          reconocido por su compromiso con la cultura, la educación y la participación
          comunitaria, contribuyendo al fortalecimiento de la identidad y el patrimonio cultural.
        </p>
      </div>
    </div>

    <div class="card">
      <img src="img/Huejutla, Hidalgo.jpg" alt="Propósito">
      <div class="card-content">
        <h3>Propósito</h3>
        <p>
          Promover la conservación, investigación, documentación y difusión de la historia,
          culture, tradiciones y patrimonio de Huejutla de Reyes, fortaleciendo el sentido
          de pertenencia e identidad de la comunidad.
        </p>
      </div>
    </div>
  </div>

  <div class="card identidad-card">
    <img src="https://images.unsplash.com/photo-1516307365426-bea591f05011?q=80&w=1200&auto=format&fit=crop" alt="Identidad">
    <div class="card-content">
      <h3>Nuestra Identidad</h3>
      <p>
        La identidad gráfica del Consejo Huejutlense de la Crónica representa la historia,
        la cultura y la memoria colectiva de Huejutla de Reyes, Hidalgo.
      </p>
      <br>
      <p>
        <strong>El sauce:</strong> inspirado en el significado etimológico de Huejutla
        como "Lugar de Sauces", representa las raíces, la identidad y la conexión con el territorio.
      </p>
      <br>
      <p>
        <strong>El reloj municipal:</strong> símbolo del paso del tiempo y de la preservación
        de los acontecimientos históricos que forman parte de la memoria de la comunidad.
      </p>
      <br>
      <p>
        <strong>El caracol estilizado:</strong> asociado a una de las interpretaciones
        históricas del nombre de Huejutla, simboliza la comunicación, los ciclos de la vida
        y la transmisión del conocimiento entre generaciones.
      </p>
      <br>
      <p>
        En conjunto, estos elementos reflejan el compromiso del Consejo con la conservación,
        investigación y difusión de la historia local, fortaleciendo el sentido de pertenencia
        y el legado cultural de Huejutla de Reyes.
      </p>
    </div>
  </div>
</section>

<?php include("componentes/footer.php"); ?>

<script src="js/inicio.js"></script>

<!-- Bootstrap JS (maneja el toggle del menú, ya no se necesita JS propio) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="../js/buscador.js"></script>

</body>
</html>