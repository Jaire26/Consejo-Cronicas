Noticias · PHP
<?php
include("conexion/conexion.php");
 
// esto es para que mande todas las noticias guardadas, las más nuevas primero
$sql = "SELECT * FROM noticias ORDER BY id_noticia DESC";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Noticias</title>
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
<section class="feed-section">

    <div class="section-title">
        <h2>Noticias y Actualidad</h2>
        <p>
            Información, eventos y acontecimientos de interés
            para la comunidad huejutlense.
        </p>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Buscar noticia...">
        <button>🔍</button>
    </div>

    <div class="feed-container">

    <?php
    if ($resultado && mysqli_num_rows($resultado) > 0) {

        while ($noticia = mysqli_fetch_assoc($resultado)) {

            $titulo = htmlspecialchars($noticia["titulo"]);
            $contenido = htmlspecialchars($noticia["contenido"]);
            $imagen = $noticia["imagen"];

            if (!empty($imagen)) {
                $rutaImagen = "img/noticias/" . htmlspecialchars($imagen);
            } else {
                $rutaImagen = "https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600";
            }
    ?>

        <div class="feed-card">

            <div class="feed-image">
                <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $titulo; ?>">
            </div>

            <div class="feed-info">

                <span class="tag">Noticia</span>

                <h3><?php echo $titulo; ?></h3>

                <p>
                    <?php
                    if (mb_strlen($contenido, 'UTF-8') > 180) {
                        echo mb_substr($contenido, 0, 180, 'UTF-8') . "...";
                    } else {
                        echo $contenido;
                    }
                    ?>
                </p>

                <?php if (!empty($noticia["fecha_publicacion"])) { ?>
                    <div class="feed-date">
                        <?php echo date("d/m/Y", strtotime($noticia["fecha_publicacion"])); ?>
                    </div>
                <?php } ?>

            </div>

        </div>

    <?php
        }

    } else {

        echo "
        <div class='feed-card'>
            <div class='feed-info'>
                <h3>No hay noticias publicadas</h3>
                <p>Próximamente se mostrarán aquí las noticias más recientes.</p>
            </div>
        </div>";

    }
    ?>

    </div>

</section>