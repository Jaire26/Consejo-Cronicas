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
    <title>Entrevistas</title>

    <link rel="stylesheet" href="css/entrevista.css">
    <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>
    <nav id="sidebar">
        <div class="logo">
          <img src="img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
        </div>

        <ul class="menu">
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
      <h2>Entrevistas</h2>
      <p>Conoce Todo Lo Interesante Sobre Temas Relevantes</p>
    </div>

    <div class="search-box">
       <input type="text" placeholder="Buscar...">
    </div>
    
    <div class="contenido">
        <div class="noticias">
            <article class="noticia-principal">
                <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=1200&auto=format&fit=crop" alt="Entrevista">

                <div class="info">
                    <h2>
                    <a href="entrevista1.html">
                         Título de la entrevista
                    </a>
                    </h2>

                    <p>
                        Descripción de la entrevista más a fondo...
                    </p>
                </div>
            </article>
        </div>
    </div>

  </section> </div>

     <?php include("componentes/footer.php"); ?>
</body>
</html>