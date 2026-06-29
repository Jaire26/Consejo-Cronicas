
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
 
// 3. Función para generar el resumen corto de cada entrevista
function generarResumen($texto, $limite = 160) {
    $texto = trim(strip_tags($texto));
    if (mb_strlen($texto) <= $limite) {
        return htmlspecialchars($texto);
    }
    $cortado = mb_substr($texto, 0, $limite);
    $ultimoEspacio = mb_strrpos($cortado, ' ');
    if ($ultimoEspacio !== false) {
        $cortado = mb_substr($cortado, 0, $ultimoEspacio);
    }
    return htmlspecialchars($cortado) . '…';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrevistas</title>
    <link rel="stylesheet" href="css/entrevista.css"> 
    <link rel="stylesheet" href="css/catalogo.css">
    <style>
        /* Estilos para las tarjetas resumidas y el botón "Leer más" */
        .tarjeta-entrevista {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .tarjeta-entrevista:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 22px rgba(62, 22, 19, 0.12);
        }
        .resumen-texto {
            color: #7C3F20;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0 0 18px 0;
            text-align: justify;
        }
        .btn-leer-mas {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #7C3F20;
            color: #ffffff !important;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: background-color 0.25s ease, transform 0.2s ease;
        }
        .btn-leer-mas:hover {
            background-color: #3E1613;
            transform: translateX(3px);
        }
        .titulo-entrevista a:hover {
            color: #7C3F20 !important;
        }
    </style>
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
            <input type="text" id="inputBusqueda" placeholder="Buscar por título...">
        </div>

        
        <div class="contenido" style="width: 100%; max-width: 100%; display: block; box-sizing: border-box;">
            <div class="noticias" style="width: 100%; max-width: 100%; display: flex; flex-direction: column; align-items: center; box-sizing: border-box;">
            <?php 
                if (mysqli_num_rows($res_entrevistas) > 0) {
                    while ($entrevista = mysqli_fetch_assoc($res_entrevistas)) { 
            ?>
                        <article class="tarjeta-entrevista" style="display: flex; gap: 35px; margin-bottom: 40px; background: #ffffff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(62, 22, 19, 0.05); align-items: flex-start; border: 1px solid #f1ddc4; width: 95%; max-width: 1150px; box-sizing: border-box;">
                            <div style="flex-shrink: 0; width: 280px; height: 190px; overflow: hidden; border-radius: 10px;">
                                <img src="img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Imagen" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div class="info" style="flex-grow: 1;">
                                <h2 class="titulo-entrevista" style="margin: 0 0 12px 0; font-family: 'Playfair Display', serif; font-size: 1.8rem; line-height: 1.3;">
                                    <a href="detalle_entrevista.php?id=<?php echo $entrevista['id']; ?>" style="color: #3E1613; text-decoration: none; transition: 0.3s;">
                                        <?php echo htmlspecialchars($entrevista['titulo']); ?>
                                    </a>
                                </h2>
 
                                <p class="resumen-texto">
                                    <?php echo generarResumen($entrevista['subtitulo'], 160); ?>
                                </p>
 
                                <a href="detalle_entrevista.php?id=<?php echo $entrevista['id']; ?>" class="btn-leer-mas">
                                    Leer más &rarr;
                                </a>
                            </div>
                        </article>
            <?php 
                    }
                } else {
                    echo "<p style='text-align:center; color:#3E1613; width:100%;'>No se encontraron entrevistas que coincidan con la búsqueda.</p>";
                } 
            ?>
            </div>
        </div>
    </section>
</div>
 
<?php include("componentes/footer.php"); ?>
<script src="js/buscador.js"></script>


</body>
</html>