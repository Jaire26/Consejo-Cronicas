<?php
session_start();
 
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $contenido = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $categoria = mysqli_real_escape_string($conn, $_POST["categoria"]);
    $fecha_publicacion = date("Y-m-d");
    $id_usuario = $_SESSION["id_usuario"];
 
    $carpeta = "../img/noticias/";
 
    if(!file_exists($carpeta)){
        mkdir($carpeta, 0777, true);
    }
 
    // Imagen de portada (la que se ve en el feed)
    $imagen = "";
 
    if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0){
        $imagen = time() . "_" . basename($_FILES["imagen"]["name"]);
        move_uploaded_file(
            $_FILES["imagen"]["tmp_name"],
            $carpeta . $imagen
        );
    }
    $sql = "INSERT INTO noticias
        (titulo, contenido, imagen, fecha_publicacion, categoria, id_usuario)
        VALUES
        ('$titulo', '$contenido', '$imagen', '$fecha_publicacion', '$categoria', '$id_usuario')";
 
    if(mysqli_query($conn, $sql)){
 
        $id_noticia_nueva = mysqli_insert_id($conn);
 
        // Imágenes adicionales para la galería (campo múltiple "imagenes[]")
        if (isset($_FILES["imagenes"])) {
            $total = count($_FILES["imagenes"]["name"]);
            for ($i = 0; $i < $total; $i++) {
                if ($_FILES["imagenes"]["error"][$i] == 0) {
                    $nombreImg = time() . "_" . $i . "_" . basename($_FILES["imagenes"]["name"][$i]);
                    if (move_uploaded_file($_FILES["imagenes"]["tmp_name"][$i], $carpeta . $nombreImg)) {
                        $nombreImgEscapado = mysqli_real_escape_string($conn, $nombreImg);
                        mysqli_query($conn, "INSERT INTO noticias_imagenes (id_noticia, imagen, orden) VALUES ($id_noticia_nueva, '$nombreImgEscapado', $i)");
                    }
                }
            }
        }
 
        header("Location: noticiasadmin.php");
        exit();
    }else{
        echo "Error al guardar: " . mysqli_error($conn);
    }
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Agregar Noticia</title>
<link rel="stylesheet" href="../css/subir.css">
<link rel="stylesheet" href="../css/galeriaadmin.css">
<link rel="stylesheet" href="../css/subir.css">
<style>
.main-content{
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:40px;
}

.upload-card{
    width:100%;
    max-width:700px;
}
</style>


</head>
<body>
 
<div class="upload-container">
 
    <a href="noticiasadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>
 
    <div class="upload-card">
 
        <h1>Subir Una Nueva Noticia</h1>
        <p>Agrega nuevo contenido al feed informativo.</p>
 
        <form method="POST" enctype="multipart/form-data">
 
            <div class="input-group">
                <label>Título</label>
                <input type="text" name="titulo" required>
            </div>
 
            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" required></textarea>
            </div>
            <div class="input-group">
                <label>Categoría</label>
                <select name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <option value="Historia">Historia</option>
                <option value="Cultura">Cultura</option>
                <option value="Eventos">Eventos</option>
                <option value="Turismo">Turismo</option>
                <option value="Educación">Educación</option>
                </select>
            </div>
            <div class="input-group">
                <label>Imagen principal (portada)</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>
 
            <div class="input-group">
                <label>Imágenes adicionales (galería, opcional)</label>
                <input type="file" name="imagenes[]" accept="image/*" multiple>
            </div>
 
            <button type="submit" class="btn-upload">
                Subir Noticia
            </button>
 
        </form>
 
    </div>
</div>
 
</body>
</html>