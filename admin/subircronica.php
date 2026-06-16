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
<title>Agregar Crónica</title>
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="upload-container">

    <a href="cronicasadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>

    <div class="upload-card">

        <h1>Agregar Crónica</h1>
        <p>
            Comparte relatos, memorias y acontecimientos importantes de Huejutla.
        </p>

        <form method="POST" enctype="multipart/form-data">

            <div class="input-group">
                <label>Título de la crónica</label>
                <input type="text" name="titulo" required placeholder="Ej. Recuerdos del Xantolo">
            </div>

            <div class="input-group">
                <label>Autor</label>
                <input type="text" name="autor" required placeholder="Nombre del cronista">
            </div>

            <div class="input-group">
                <label>Fecha</label>
                <input type="date" name="fecha" required>
            </div>

            <div class="input-group">
                <label>Resumen</label>
                <input type="text" name="resumen" required placeholder="Breve resumen de la crónica">
            </div>

            <div class="input-group">
                <label>Contenido de la crónica</label>
                <textarea name="contenido" required placeholder="Escribe aquí la crónica completa..."></textarea>
            </div>

            <div class="input-group">
                <label>Imagen principal</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn-upload">
                Publicar Crónica
            </button>

        </form>

    </div>
    <script src="../js/leercronica.js"></script>
</div>

</body>
</html>