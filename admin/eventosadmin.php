<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

// 1. CONSULTA DE CONFIGURACIÓN
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// 2. Consulta de eventos
$query = "SELECT * FROM eventos ORDER BY id_evento DESC";
$resultado = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventos - Admin</title>
  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/eventos.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  
  <style>
    /* Contenedor de acciones para los botones de eventos */
    .acciones-evento {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        justify-content: flex-start;
    }

    /* Estilo Cápsula idéntico a Crónicas e Historias */
    .btn-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 18px;
        border-radius: 50px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        width: auto;
    }

    .btn-editar-evento {
        background-color: #fdf3e7;
        color: #a66b37;
    }
    .btn-editar-evento:hover {
        background-color: #f8e7d2;
    }

    .btn-borrar-evento {
        background-color: #f9ebeb;
        color: #9b4343;
    }
    .btn-borrar-evento:hover {
        background-color: #f2d7d7;
    }
  </style>
</head>
<body>

 <nav id="sidebar">
    <div class="logo">
      <img src="../img/<?php echo $config['logo']; ?>" alt="Logo">
    </div>
    <ul class="menu">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="historiaadmin.php">Historia</a></li>
        <li><a href="cronicasadmin.php">Crónicas</a></li>
        <li><a href="galeriaadmin.php">Galería</a></li>
        <li><a href="eventosadmin.php">Eventos</a></li>
        <li><a href="perfilesadmin.php">Perfiles</a></li>
        <li><a href="noticiasadmin.php">Noticias</a></li>
        <li><a href="entrevistasadmin.php">Entrevistas</a></li>
        <li><a href="editar_footer.php">Editar logo y datos</a></li>
    </ul>
</nav>

<div class="main-content">
  <section class="feed-section">
    
    <div class="section-title">
      <h2>Panel de Eventos</h2>
      <p>Administra las novedades culturales</p>
    </div>

    <div class="feed-container">

      <?php if(mysqli_num_rows($resultado) > 0) { ?>
          <?php while($evento = mysqli_fetch_assoc($resultado)) { ?>
              
              <div class="feed-card">
                <div class="feed-image">
                  <img src="../img/<?php echo htmlspecialchars($evento['imagen']); ?>" 
                       alt="Evento" 
                       class="evento-foto-clic" 
                       data-src="<?php echo htmlspecialchars($evento['imagen']); ?>" 
                       style="cursor: pointer;">
                </div>
                
                <div class="feed-info">
                  <span class="tag tag-evento" style="color: #6F4A33; font-weight: bold; font-size: 15px;">
                    <?php echo date("d M Y", strtotime($evento['fecha'])); ?>
                  </span>
                  <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>
                  <p style="margin: 0 0 8px 0;"><strong>Lugar:</strong> <?php echo htmlspecialchars($evento['lugar']); ?></p>
                  <p style="color: #555; line-height: 1.6; margin: 0;"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                  
                  <div class="acciones-evento">
                      <a href="./editar_evento.php?id=<?php echo $evento['id_evento']; ?>" class="btn-pill btn-editar-evento">
                          Editar
                      </a>
                      <a href="./eliminar_evento.php?id=<?php echo $evento['id_evento']; ?>" 
                         class="btn-pill btn-borrar-evento" 
                         onclick="return confirm('¿Seguro que deseas eliminar este evento?');">
                          Borrar
                      </a>
                  </div>
                </div>
              </div>

          <?php } ?>
      <?php } else { ?>
          <p style="padding: 20px; text-align: center; color: #6F4A33;">No hay eventos registrados en este momento.</p>
      <?php } ?>

    </div> 

    <div class="card admin-card" style="margin-top: 30px;">
        <div class="card-content">
            <h3>Agregar Contenido</h3>
            <p>Administre los eventos de la plataforma.</p>
            <a href="subirevento.php" class="btn-admin">Agregar</a>
        </div>
    </div>
  
  </section>
</div> 

<div class="image-viewer" id="viewer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;">
    <span id="close-viewer" style="position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; cursor: pointer; font-weight: bold;">&times;</span>
    <img id="viewer-img" src="" alt="Imagen Ampliada" style="max-width: 90%; max-height: 90%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
</div>

<?php include("../componentes/footer.php"); ?>

<script>
    // Script funcional para ampliar la foto del evento
    const viewer = document.getElementById('viewer');
    const viewerImg = document.getElementById('viewer-img');
    const closeViewer = document.getElementById('close-viewer');

    document.querySelectorAll('.evento-foto-clic').forEach(img => {
        img.addEventListener('click', function() {
            viewerImg.src = this.src;
            viewer.style.display = 'flex';
        });
    });

    closeViewer.addEventListener('click', () => {
        viewer.style.display = 'none';
    });

    viewer.addEventListener('click', (e) => {
        if(e.target === viewer) {
            viewer.style.display = 'none';
        }
    });
</script>
</body>
</html>