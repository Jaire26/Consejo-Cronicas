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
<title>Agregar Perfil</title>
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="upload-container">

    <a href="perfilesadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>

    <div class="upload-card">

        <h1>Subir Nuevo Perfil</h1>
        <p>
            Agrega un nuevo integrante al equipo.
        </p>

        <form method="POST" enctype="multipart/form-data">

            <div class="input-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" required placeholder="Ej. Prof. Alejandro Martínez">
            </div>

            <div class="input-group">
                <label>Descripción / Biografía</label>
                <textarea name="descripcion" required placeholder="Escribe una breve semblanza o trayectoria del integrante..."></textarea>
            </div>

            <div class="input-group">
                <label>Seleccionar Imagen de Perfil</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <button type="submit" class="btn-upload">
                Subir Perfil
            </button>

        </form>

    </div>
</div>

</body>
</html> 