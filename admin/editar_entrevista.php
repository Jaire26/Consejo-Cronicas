<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
$LIMITE_RESUMEN = 200;
 
// 1. Obtener y validar el ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: entrevistasadmin.php");
    exit();
}
 
// 2. Traer la entrevista actual
$query = "SELECT * FROM entrevistas WHERE id = $id LIMIT 1";
$res = mysqli_query($conn, $query);
if (!$res || mysqli_num_rows($res) == 0) {
    echo "<script>
            alert('La entrevista no existe.');
            window.location.href = 'entrevistasadmin.php';
          </script>";
    exit();
}
$entrevista = mysqli_fetch_assoc($res);
 
// 3. Procesar la actualización cuando se haga POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
 
    // Respaldo en servidor: recortamos el resumen aunque el navegador ya lo limite
    $resumen_raw = trim($_POST['resumen']);
    if (mb_strlen($resumen_raw) > $LIMITE_RESUMEN) {
        $resumen_raw = mb_substr($resumen_raw, 0, $LIMITE_RESUMEN);
    }
    $subtitulo = mysqli_real_escape_string($conn, $resumen_raw);
 
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
 
    // Por defecto conservamos la imagen actual
    $nombre_imagen_final = $entrevista['imagen'];
 
    // Si se subió una imagen nueva, la procesamos y reemplazamos la anterior
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0 && !empty($_FILES['imagen']['name'])) {
        $nombre_imagen  = $_FILES['imagen']['name'];
        $ruta_temporal  = $_FILES['imagen']['tmp_name'];
        $ext = pathinfo($nombre_imagen, PATHINFO_EXTENSION);
        $nuevo_nombre_imagen = time() . "_" . uniqid() . "." . $ext;
 
        $directorio_destino = "../img/entrevistas/";
        $ruta_final = $directorio_destino . $nuevo_nombre_imagen;
 
        if (!is_dir($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }
 
        if (move_uploaded_file($ruta_temporal, $ruta_final)) {
            // Borramos la imagen anterior del servidor para no dejar archivos huérfanos
            $ruta_anterior = $directorio_destino . $entrevista['imagen'];
            if (!empty($entrevista['imagen']) && file_exists($ruta_anterior)) {
                unlink($ruta_anterior);
            }
            $nombre_imagen_final = $nuevo_nombre_imagen;
        } else {
            echo "<script>alert('No se pudo subir la nueva imagen, se conservó la anterior.');</script>";
        }
    }
 
    $sql = "UPDATE entrevistas 
            SET titulo = '$titulo', subtitulo = '$subtitulo', contenido = '$descripcion', imagen = '$nombre_imagen_final'
            WHERE id = $id";
 
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('¡Entrevista actualizada exitosamente!');
                window.location.href = 'entrevistasadmin.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error en la base de datos: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Entrevista</title>
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
    .preview-imagen-actual {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
    }
    .preview-imagen-actual img {
        width: 90px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #f1ddc4;
    }
    .preview-imagen-actual span {
        font-size: 0.85rem;
        color: #777;
    }
</style>
</head>
<body>
 
<div class="upload-container">
 
    <a href="entrevistasadmin.php" class="btn-volver-fixed">
         ← Volver
    </a>
 
    <div class="upload-card">
 
        <h1>Editar Entrevista</h1>
        <p>Modifica el contenido de esta entrevista</p>
 
        <form method="POST" enctype="multipart/form-data">
 
            <div class="input-group">
                <label>Título</label>
                <input type="text" name="titulo" required value="<?php echo htmlspecialchars($entrevista['titulo']); ?>">
            </div>
            
            <div class="input-group">
                <label>Resumen</label>
                <span class="ayuda-texto">Escribe solo una bajada corta (máx. <?php echo $LIMITE_RESUMEN; ?> caracteres). No pegues aquí el texto completo.</span>
                <textarea name="resumen" id="resumen" rows="3" maxlength="<?php echo $LIMITE_RESUMEN; ?>" required><?php echo htmlspecialchars($entrevista['subtitulo']); ?></textarea>
                <span class="contador-caracteres" id="contador-resumen">0 / <?php echo $LIMITE_RESUMEN; ?></span>
            </div>
 
            <div class="input-group">
                <label>Descripción</label>
                <textarea name="descripcion" rows="10" required><?php echo htmlspecialchars($entrevista['contenido']); ?></textarea>
            </div>
 
            <div class="input-group">
                <label>Imagen actual</label>
                <div class="preview-imagen-actual">
                    <img src="../img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Imagen actual">
                    <span>Déjalo vacío abajo si quieres conservar esta imagen.</span>
                </div>
                <label>Reemplazar imagen (opcional)</label>
                <input type="file" name="imagen" accept="image/*">
            </div>
 
            <button type="submit" class="btn-upload">
                Guardar Cambios
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