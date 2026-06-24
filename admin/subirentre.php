<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
// Incluimos tu archivo de conexión actual
include("../conexion/conexion.php");
 
// Límite de caracteres permitido para el resumen
$LIMITE_RESUMEN = 200;
 
// Procesar el formulario cuando se haga POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar los caracteres especiales para proteger la consulta
    $titulo      = mysqli_real_escape_string($conn, $_POST['titulo']);
 
    // Respaldo en servidor: recortamos el resumen aunque el navegador ya lo limite
    $resumen_raw = trim($_POST['resumen']);
    if (mb_strlen($resumen_raw) > $LIMITE_RESUMEN) {
        $resumen_raw = mb_substr($resumen_raw, 0, $LIMITE_RESUMEN);
    }
    $subtitulo   = mysqli_real_escape_string($conn, $resumen_raw); // Guardamos 'resumen' como subtitulo
 
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']); // Cuerpo completo de la entrevista
    
    // Tratamiento de la Imagen
    $nombre_imagen = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    
    // Obtener extensión y crear un nombre único (ej. 1719234567_foto.jpg) para evitar archivos duplicados
    $ext = pathinfo($nombre_imagen, PATHINFO_EXTENSION);
    $nuevo_nombre_imagen = time() . "_" . uniqid() . "." . $ext;
    
    // Ruta final donde se guardará físicamente la imagen
    $directorio_destino = "../img/entrevistas/";
    $ruta_final = $directorio_destino . $nuevo_nombre_imagen;
 
    // Crear la carpeta automáticamente si aún no existe en el servidor
    if (!is_dir($directorio_destino)) {
        mkdir($directorio_destino, 0777, true);
    }
 
    // 1. Mover el archivo subido al servidor
    if (move_uploaded_file($ruta_temporal, $ruta_final)) {
        
        // 2. Insertar los campos en la tabla 'entrevistas'
        // NOTA: Ajusta los nombres de tus columnas (titulo, subtitulo, contenido, imagen) si cambian en tu base de datos
        $sql = "INSERT INTO entrevistas (titulo, subtitulo, contenido, imagen) 
                VALUES ('$titulo', '$subtitulo', '$descripcion', '$nuevo_nombre_imagen')";
 
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('¡Entrevista publicada exitosamente!');
                    window.location.href = 'entrevistasadmin.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Error en la base de datos: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Error crítico: No se pudo cargar el archivo de imagen al servidor.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Entrevista</title>
<link rel="stylesheet" href="../css/subir.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<style>
    .contador-caracteres {
        display: block;
        text-align: right;
        font-size: 0.8rem;
        color: #888;
        margin-top: 4px;
    }
    .contador-caracteres.limite-cerca {
        color: #c0392b;
        font-weight: 600;
    }
    .ayuda-texto {
        display: block;
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 6px;
    }
</style>
</head>
<body>
 
<div class="upload-container">
 
    <a href="entrevistasadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>
 
    <div class="upload-card">
 
        <h1>Subir Una Nueva Entrevista</h1>
        <p>Agrega nuevo contenido interesante</p>
 
        <form method="POST" enctype="multipart/form-data">
 
            <div class="input-group">
                <label>Título</label>
                <input type="text" name="titulo" required placeholder="Ej. Entrevista con el Cronista Municipal">
            </div>
            
            <div class="input-group">
                <label>Resumen</label>
                <span class="ayuda-texto">Escribe solo una bajada corta (máx. <?php echo $LIMITE_RESUMEN; ?> caracteres). No pegues aquí el texto completo.</span>
                <textarea name="resumen" id="resumen" rows="3" maxlength="<?php echo $LIMITE_RESUMEN; ?>" required placeholder="Breve introducción o copete de la entrevista..."></textarea>
                <span class="contador-caracteres" id="contador-resumen">0 / <?php echo $LIMITE_RESUMEN; ?></span>
            </div>
 
            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" rows="10" required placeholder="Escribe aquí el cuerpo o la transcripción de la entrevista..."></textarea>
            </div>
 
            <div class="input-group">
                <label>Seleccionar imagen</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>
 
            <button type="submit" class="btn-upload">
                Subir Entrevista
            </button>
 
        </form>
 
    </div>
</div>
 
<script>
    const textareaResumen = document.getElementById('resumen');
    const contador = document.getElementById('contador-resumen');
    const limite = <?php echo $LIMITE_RESUMEN; ?>;
 
    function actualizarContador() {
        const restante = textareaResumen.value.length;
        contador.textContent = restante + ' / ' + limite;
 
        if (restante >= limite * 0.9) {
            contador.classList.add('limite-cerca');
        } else {
            contador.classList.remove('limite-cerca');
        }
    }
 
    textareaResumen.addEventListener('input', actualizarContador);
    actualizarContador();
</script>
 
</body>
</html>