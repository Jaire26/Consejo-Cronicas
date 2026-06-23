
<?php
// MODO DIAGNÓSTICO TEMPORAL — quitar estas 2 líneas cuando ya funcione
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
session_start();
 
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $contenido = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $id_usuario = $_SESSION["id_usuario"];
 
    $imagen = "";
 
    if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0){
 
        $carpeta = "../img/noticias/";
 
        if(!file_exists($carpeta)){
            mkdir($carpeta, 0777, true);
        }
 
        $imagen = time() . "_" . basename($_FILES["imagen"]["name"]);
 
        move_uploaded_file(
            $_FILES["imagen"]["tmp_name"],
            $carpeta . $imagen
        );
    }
 
    $sql = "INSERT INTO noticias
            (titulo, contenido, imagen, id_usuario)
            VALUES
            ('$titulo', '$contenido', '$imagen', '$id_usuario')";
 
    // DIAGNÓSTICO: mostrar la consulta exacta y el error si falla
    if(mysqli_query($conn, $sql)){
        header("Location: noticiasadmin.php");
        exit();
    }else{
        echo "<h2>Error al guardar:</h2>";
        echo "<p><strong>Mensaje MySQL:</strong> " . mysqli_error($conn) . "</p>";
        echo "<p><strong>Consulta SQL ejecutada:</strong></p>";
        echo "<pre>" . htmlspecialchars($sql) . "</pre>";
        echo "<p><strong>Valor de \$_SESSION['id_usuario']:</strong> ";
        var_dump($id_usuario);
        echo "</p>";
        exit();
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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
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
                <label>Seleccionar imagen</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>
 
            <button type="submit" class="btn-upload">
                Subir Noticia
            </button>
 
        </form>
 
    </div>
</div>
 
</body>
</html>