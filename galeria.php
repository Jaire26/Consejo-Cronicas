<?php 
// 1. Conectamos a la base de datos de MariaDB
require_once("conexion/conexion.php"); 

// 2. Traemos todas las fotos de la tabla galeria
$query = "SELECT * FROM galeria ORDER BY id_foto DESC";
$resultado = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería - Consejo de la Crónica</title>
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="css/galeriaadmin.css"> </head>
<body>

<section class="gallery-container">
    <h2>Galería Fotográfica de Huejutla</h2>

    <div class="gallery">
        <?php 
        // 3. El ciclo PHP genera cada imagen extrayendo los datos de la BD
        while($foto = mysqli_fetch_assoc($resultado)) { 
        ?>
            <img 
                src="img/<?php echo htmlspecialchars($foto['archivo_imagen']); ?>" 
                alt="Imagen de la galería"
                data-title="<?php echo htmlspecialchars($foto['titulo']); ?>" 
                data-description="<?php echo htmlspecialchars($foto['descripcion']); ?>"
            >
        <?php 
        } 
        ?>
    </div>
</section>

<div id="viewer" style="display: none;">
    <span id="close-viewer">&times;</span>
    <img id="viewer-img" src="" alt="Visor grande">
    <h3 id="viewer-title"></h3>
    <p id="viewer-description"></p>
</div>

<script src="js/galeria.js"></script>
</body>
</html>