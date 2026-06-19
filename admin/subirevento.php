<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

include("../conexion/conexion.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar los textos para evitar errores por comillas
    $nombre = mysqli_real_escape_string($conn, $_POST['titulo']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $lugar = mysqli_real_escape_string($conn, $_POST['ubicacion']);
    $id_usuario = $_SESSION["id_usuario"];
    
    // Validar archivo de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombre_foto = $_FILES['imagen']['name'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];
        
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $nuevo_nombre_foto = time() . "_" . uniqid() . "." . $extension;
        
        // Carpeta destino (asegúrate de que exista la carpeta 'img' en la raíz)
        $carpeta_destino = "../img/" . $nuevo_nombre_foto;
        
        if (move_uploaded_file($ruta_temporal, $carpeta_destino)) {
            // Insertar en la base de datos usando las columnas reales de tu tabla
            $sql = "INSERT INTO eventos (nombre, fecha, lugar, descripcion, imagen, id_usuario) 
                    VALUES ('$nombre', '$fecha', '$lugar', '$descripcion', '$nuevo_nombre_foto', '$id_usuario')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('¡Evento publicado con éxito!'); window.location='eventosadmin.php';</script>";
                exit();
            } else {
                die("Error en la Base de Datos: " . mysqli_error($conn));
            }
        } else {
            echo "<script>alert('Error: No se pudo guardar la imagen en el servidor.'); window.location='subirevento.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error al cargar la imagen o archivo demasiado pesado.'); window.location='subirevento.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Evento</title>
<link rel="stylesheet" href="../css/subir.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="upload-container">
    <a href="eventosadmin.php" class="btn-volver-fixed">← Volver</a>
    <div class="upload-card">
        <h1>Subir Evento</h1>
        <p>Agrega nuevos eventos para que el público se entere de todo.</p>

        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label>Título del evento</label>
                <input type="text" name="titulo" required placeholder="Ej. Encuentro de Huapango 2026">
            </div>
            
            <div class="input-group">
                <label>Fecha</label>
                <input type="date" name="fecha" required>
            </div>

            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" required placeholder="Escribe los detalles del evento aquí..."></textarea>
            </div>
            
            <div class="input-group">
                <label>Ubicación</label>
                <input type="text" name="ubicacion" required placeholder="Ej. Plaza Principal de Huejutla">
            </div>

            <div class="input-group">
                <label>Seleccionar imagen</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn-upload">Publicar Evento</button>
        </form>
    </div>
</div>

</body>
</html>