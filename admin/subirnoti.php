<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
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
                <input type="text" name="titulo" required placeholder="Ej. Inauguración del Evento Cultural 2026">
            </div>

            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" required placeholder="Escribe el cuerpo de la noticia aquí..."></textarea>
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