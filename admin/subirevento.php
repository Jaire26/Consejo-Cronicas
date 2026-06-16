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
<title>Agregar Evento</title>
<link rel="stylesheet" href="../css/subir.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="upload-container">

    <a href="eventosadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>
    <div class="upload-card">

        <h1>Subir Evento</h1>
        <p>
            Agrega nuevos eventos para que el público se entere de todo.
        </p>

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

            <button type="submit" class="btn-upload">
                Publicar Evento
            </button>

        </form>

    </div>
</div>

</body>
</html>