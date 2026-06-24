<?php
// Vista pública - No requiere sesión de administrador
include("conexion/conexion.php");

// 1. Traer la configuración del logo y footer
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// 2. Traer las entrevistas correspondientes
$query_entrevistas = "SELECT * FROM entrevistas ORDER BY id DESC";
$res_entrevistas = mysqli_query($conn, $query_entrevistas);
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
            <img src="img/<?php echo $config['logo']; ?>" alt="Logo">
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
                <?php 
                if (mysqli_num_rows($res_entrevistas) > 0) {
                    while ($entrevista = mysqli_fetch_assoc($res_entrevistas)) { 
                ?>
                        <article class="noticia-principal">
                            <img src="img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Imagen de la entrevista">
                            <div class="info">
                                <h2>
                                    <a href="detalle_entrevista.php?id=<?php echo $entrevista['id']; ?>">
                                        <?php echo htmlspecialchars($entrevista['titulo']); ?>
                                    </a>
                                </h2>
                                <p>
                                    <?php echo htmlspecialchars($entrevista['subtitulo']); ?>
                                </p>
                            </div>
                        </article>
                <?php 
                    }
                } else {
                    echo "<p style='text-align:center; color:#3E1613; grid-column: 1/-1;'>Próximamente más entrevistas interesantes.</p>";
                } 
                ?>
            </div>
        </div>
    </section>
</div>

<?php include("componentes/footer.php"); ?>
</body>
</html>