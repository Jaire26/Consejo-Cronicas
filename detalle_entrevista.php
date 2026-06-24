
<?php
// Vista pública - No requiere sesión de administrador
include("conexion/conexion.php");
 
// 1. Traer la configuración del logo y footer
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
 
// 2. Validar y obtener el ID de la entrevista
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
 
$entrevista = null;
if ($id > 0) {
    $query_entrevista = "SELECT * FROM entrevistas WHERE id = $id LIMIT 1";
    $res_entrevista = mysqli_query($conn, $query_entrevista);
    if ($res_entrevista && mysqli_num_rows($res_entrevista) > 0) {
        $entrevista = mysqli_fetch_assoc($res_entrevista);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $entrevista ? htmlspecialchars($entrevista['titulo']) : 'Entrevista no encontrada'; ?></title>
    <link rel="stylesheet" href="css/entrevista.css"> 
    <link rel="stylesheet" href="css/catalogo.css">
    <style>
        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #7C3F20;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 25px;
            transition: color 0.25s ease;
        }
        .btn-volver:hover {
            color: #3E1613;
        }
        .detalle-fecha {
            color: #a87a55;
            font-size: 0.9rem;
            margin: 0 0 20px 0;
            font-style: italic;
        }
        .detalle-subtitulo {
            color: #7C3F20;
            font-size: 1.15rem;
            font-style: italic;
            line-height: 1.6;
            margin: 0 0 25px 0;
            border-left: 4px solid #f1ddc4;
            padding-left: 18px;
        }
        .detalle-contenido {
            color: #3E1613;
            font-size: 1.05rem;
            line-height: 1.9;
            text-align: justify;
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
        <div class="contenido" style="width: 100%; max-width: 100%; display: block; box-sizing: border-box;">
            <div style="width: 95%; max-width: 950px; margin: 0 auto; box-sizing: border-box;">
 
                <a href="entrevistas.php" class="btn-volver">&larr; Volver a Entrevistas</a>
 
                <?php if ($entrevista) { ?>
 
                    <article style="background: #ffffff; padding: 35px 40px; border-radius: 15px; box-shadow: 0 4px 15px rgba(62, 22, 19, 0.05); border: 1px solid #f1ddc4; box-sizing: border-box;">
 
                        <h1 style="margin: 0 0 8px 0; font-family: 'Playfair Display', serif; font-size: 2.3rem; line-height: 1.25; color: #3E1613;">
                            <?php echo htmlspecialchars($entrevista['titulo']); ?>
                        </h1>
 
                        <p class="detalle-fecha">
                            <?php echo date('d/m/Y', strtotime($entrevista['fecha_registro'])); ?>
                        </p>
 
                        <div style="width: 100%; max-height: 480px; overflow: hidden; border-radius: 10px; margin-bottom: 25px;">
                            <img src="img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Imagen" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>
 
                        <?php if (!empty($entrevista['subtitulo'])) { ?>
                            <p class="detalle-subtitulo">
                                <?php echo nl2br(htmlspecialchars($entrevista['subtitulo'])); ?>
                            </p>
                        <?php } ?>
 
                        <div class="detalle-contenido">
                            <?php echo nl2br(htmlspecialchars($entrevista['contenido'])); ?>
                        </div>
 
                    </article>
 
                <?php } else { ?>
 
                    <div style="background: #ffffff; padding: 40px; border-radius: 15px; text-align: center; border: 1px solid #f1ddc4;">
                        <p style="color: #3E1613; font-size: 1.1rem; margin: 0 0 15px 0;">No se encontró la entrevista solicitada.</p>
                        <a href="entrevistas.php" class="btn-leer-mas" style="background-color:#7C3F20; color:#fff; text-decoration:none; padding:10px 22px; border-radius:30px; display:inline-block;">Volver al listado</a>
                    </div>
 
                <?php } ?>
 
            </div>
        </div>
    </section>
</div>
 
<?php include("componentes/footer.php"); ?>
</body>
</html>
 