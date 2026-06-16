<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

// 1. Incluimos la conexión a la base de datos cronica_huejutlense
require_once("../conexion/conexion.php");

// 2. Detectamos si el usuario dio clic en "Publicar Historia"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Saneamos las entradas para evitar inyecciones o caracteres raros
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    
    // 3. Procesamos el archivo de la fotografía principal
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombre_original = $_FILES['imagen']['name'];
        $temporal = $_FILES['imagen']['tmp_name'];
        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
        
        // Creamos un nombre único aleatorio para que no se dupliquen archivos en la carpeta fisica img/
        $nuevo_nombre_img = "historia_" . uniqid() . "." . $extension;
        $ruta_destino = "../img/" . $nuevo_nombre_img;
        
        // Movemos el archivo de la memoria temporal a la carpeta real del proyecto
        if (move_uploaded_file($temporal, $ruta_destino)) {
            
            // 4. Insertamos el registro en la tabla exacta de la base de datos
            $sql = "INSERT INTO historias (titulo, descripcion, imagen) VALUES ('$titulo', '$descripcion', '$nuevo_nombre_img')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('¡Historia publicada con éxito!');
                        window.location.href = 'historiaadmin.php';
                      </script>";
                exit();
            } else {
                echo "<script>alert('Error en el registro de la BD: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Error crítico al guardar la imagen en el servidor.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, selecciona un archivo de imagen válido.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Historia</title>
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="upload-container">

    <a href="historiaadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>

    <div class="upload-card">

        <h1>Agregar Historia</h1>
        <p>
            Registra acontecimientos e historias de Huejutla.
        </p>
        <form method="POST" enctype="multipart/form-data">

            <div class="input-group">
                <label>Título de la historia</label>
                <input type="text" name="titulo" required placeholder="Ej. Historia del Xantolo">
            </div>

            <div class="input-group">
                <label>Descripción corta</label>
                <input type="text" name="descripcion" required placeholder="Breve descripción de la historia">
            </div>

            <div class="input-group">
                <label>Fotografía principal</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn-upload">
                Publicar Historia
            </button>

        </form>

    </div>
</div>

</body>
</html>