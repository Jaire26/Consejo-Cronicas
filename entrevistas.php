<?php
// Vista pública - No requiere sesión de administrador
include("conexion/conexion.php");

// 1. Traer la configuración del logo y footer
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// 2. Lógica del Buscador
$buscar = "";
if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
    $buscar = mysqli_real_escape_string($conn, $_GET['buscar']);
    $query_entrevistas = "SELECT * FROM entrevistas 
                          WHERE titulo LIKE '%$buscar%' OR subtitulo LIKE '%$buscar%' 
                          ORDER BY id DESC";
} else {
    $query_entrevistas = "SELECT * FROM entrevistas ORDER BY id DESC";
}

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
            <form method="GET" action="entrevistas.php">
                <input type="text" name="buscar" placeholder="Buscar..." value="<?php echo htmlspecialchars($buscar); ?>">
                <button type="submit" style="display:none;"></button>
            </form>
        </div>
        
        <div class="contenido">
            <div class="noticias">
            <?php 
                if (mysqli_num_rows($res_entrevistas) > 0) {
                    while ($entrevista = mysqli_fetch_assoc($res_entrevistas)) { 
            ?>
                        <article class="noticia-principal" style="display: flex; gap: 30px; margin-bottom: 40px; background: #ffffff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(62, 22, 19, 0.05); align-items: flex-start; border: 1px solid #f1ddc4;">
                            <div style="flex-shrink: 0; width: 280px; height: 190px; overflow: hidden; border-radius: 10px;">
                                <img src="img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Imagen" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div class="info" style="flex-grow: 1;">
                                <h2 style="margin: 0 0 12px 0; font-family: 'Playfair Display', serif; font-size: 1.8rem; line-height: 1.3;">
                                    <a href="detalle_entrevista.php?id=<?php echo $entrevista['id']; ?>" style="color: #3E1613; text-decoration: none; transition: 0.3s;">
                                        <?php echo htmlspecialchars($entrevista['titulo']); ?>
                                    </a>
                                </h2>
                                <p style="color: #7C3F20; font-size: 1rem; line-height: 1.6; margin: 0; text-align: justify;">
                                    <?php echo htmlspecialchars($entrevista['subtitulo']); ?>
                                </p>
                            </div>
                        </article>
            <?php 
                    }
                } else {
                    echo "<p style='text-align:center; color:#3E1613; grid-column: 1/-1;'>No se encontraron entrevistas que coincidan con la búsqueda.</p>";
                } 
            ?>
            </div>
        </div>
    </section>
</div>

<?php include("componentes/footer.php"); ?>
</body>
</html>