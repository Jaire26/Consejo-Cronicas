<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// Verificamos que venga un ID válido
if (!isset($_GET['id'])) {
    header("Location: historiaadmin.php");
    exit();
}

$id = intval($_GET['id']);

// Obtener datos actuales de la historia
$query = "SELECT * FROM historias WHERE id = $id";
$resultado = mysqli_query($conn, $query);
$historia = mysqli_fetch_assoc($resultado);

if (!$historia) {
    echo "<script>alert('La historia no existe.'); window.location.href='historiaadmin.php';</script>";
    exit();
}

// Procesar el formulario al enviar (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_with_str = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $nombre_imagen = $historia['imagen']; // Dejar la imagen actual por defecto

    // Si subieron una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $permitidos = array("jpg", "jpeg", "png", "gif", "webp");
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), $permitidos)) {
            // Generamos un nombre único para evitar duplicados
            $nuevo_nombre = time() . "_" . $_FILES['imagen']['name'];
            $ruta_destino = "../img/" . $nuevo_nombre;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_temp'] ?? $_FILES['imagen']['tmp_name'], $ruta_destino)) {
                // Borramos la imagen vieja física
                if (!empty($historia['imagen']) && file_exists("../img/" . $historia['imagen'])) {
                    unlink("../img/" . $historia['imagen']);
                }
                $nombre_imagen = $nuevo_nombre;
            }
        }
    }

    // Actualizar base de datos
    $sql_update = "UPDATE historias SET titulo='$titulo', descripcion='$descripcion', imagen='$nombre_imagen' WHERE id=$id";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Historia actualizada con éxito.'); window.location.href='historiaadmin.php';</script>";
        exit();
    } else {
        $error = "Error al actualizar los datos: " . mysqli_error($conn);
    }
}

// Configuración general para el diseño base
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Historia</title>
  <link rel="stylesheet" href="../css/catalogo.css">
  <style>
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      margin: 20px auto;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #444; }
    .form-group input[type="text"], .form-group textarea {
      width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
    }
    .img-preview { width: 150px; display: block; margin-top: 10px; border-radius: 4px; }
    .btn-submit {
      background: #ffc107; color: #000; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;
    }
    .btn-cancel {
      background: #6c757d; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; font-weight: bold; margin-left: 10px;
    }
  </style>
</head>
<body>

  <div class="main-content" style="margin-left: 0; padding: 20px;">
    <div class="form-container">
      <h2>Modificar Historia</h2>
      <p style="color: #666; margin-bottom: 25px;">Edita los campos necesarios de la publicación.</p>

      <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="titulo">Título de la Historia</label>
          <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($historia['titulo']); ?>" required>
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción / Contenido</label>
          <textarea id="descripcion" name="descripcion" rows="6" required><?php echo htmlspecialchars($historia['descripcion']); ?></textarea>
        </div>

        <div class="form-group">
          <label for="imagen">Imagen Ilustrativa</label>
          <input type="file" id="imagen" name="imagen" accept="image/*">
          <small style="display:block; color:#777; margin-top:5px;">Deja este espacio vacío si no deseas cambiar la imagen actual.</small>
          <img src="../img/<?php echo $historia['imagen']; ?>" class="img-preview" alt="Vista previa actual">
        </div>

        <button type="submit" class="btn-submit">Guardar Cambios</button>
        <a href="historiaadmin.php" class="btn-cancel">Cancelar</a>
      </form>
    </div>
  </div>

</body>
</html>