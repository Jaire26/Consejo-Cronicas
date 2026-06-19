<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

include("../conexion/conexion.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    
    // Validamos que el archivo se haya recibido bien
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombre_foto = $_FILES['imagen']['name'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $nuevo_nombre_foto = time() . "_" . uniqid() . "." . $extension;
        
        $carpeta_destino = "../img/" . $nuevo_nombre_foto;
        
        if (move_uploaded_file($ruta_temporal, $carpeta_destino)) {
            
            // Esta consulta funcionará perfectamente una vez ejecutes el comando del Paso 1
            $sql = "INSERT INTO galeria (titulo, descripcion, ruta_imagen) VALUES ('$titulo', '$descripcion', '$nuevo_nombre_foto')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('¡Fotografía subida con éxito!'); window.location='galeriaadmin.php';</script>";
                exit();
            } else {
                // Si la base de datos rechaza la consulta, esto te dirá el porqué exacto
                die("Error en la Base de Datos: " . mysqli_error($conn));
            }
        } else {
            echo "<script>alert('Error: El servidor no te permitió guardar el archivo en la carpeta ../img/. Verifica los permisos.'); window.location='subirfoto.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error: No se seleccionó ninguna imagen o el archivo supera el límite del servidor.'); window.location='subirfoto.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Fotografías</title>
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="upload-container">
    <a href="galeriaadmin.php" class="btn-volver-fixed">← Volver</a>
    <div class="upload-card">
        <h1>Subir Fotografías</h1>
        <p>Agrega nuevas imágenes a la galería cultural de Huejutla.</p>

        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label>Título de la fotografía</label>
                <input type="text" name="titulo" required placeholder="Ej. Xantolo 2026">
            </div>

            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" required placeholder="Describe la fotografía..."></textarea>
            </div>

            <div class="input-group">
                <label>Seleccionar imagen</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn-upload">Subir Fotografía</button>
        </form>
    </div>
</div>
</body>
</html>