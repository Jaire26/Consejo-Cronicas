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