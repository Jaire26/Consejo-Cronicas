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

// 2. Consultamos de la tabla renombrada 'galeria'
$query = "SELECT * FROM galeria ORDER BY id_galeria DESC";
$resultado = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galería</title>
  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="stylesheet" href="../css/verfoto.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  
  <style>
    /* Contenedor de botones peques estilo cápsula */
    .acciones-galeria {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        margin-bottom: 20px;
        justify-content: center;
        width: 100%;
    }

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

    /* Estilo idéntico a tus capturas */
    .btn-editar-galeria {
        background-color: #fdf3e7;
        color: #a66b37;
    }
    .btn-editar-galeria:hover {
        background-color: #f8e7d2;
    }

    .btn-borrar-galeria {
        background-color: #f9ebeb;
        color: #9b4343;
    }
    .btn-borrar-galeria:hover {
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
  <section id="galeria">

  <div class="section-title">
    <h2>Galería Cultural (Admin)</h2>
    <p>Fotografías y recuerdos de Huejutla</p>
  </div>

  <div class="gallery">
    <?php while($foto = mysqli_fetch_assoc($resultado)) { ?>
        <div class="gallery-item-container" style="display: flex; flex-direction: column; align-items: center;">
            <img 
              src="../img/<?php echo htmlspecialchars($foto['ruta_imagen']); ?>" 
              data-title="<?php echo htmlspecialchars($foto['titulo']); ?>" 
              data-description="<?php echo htmlspecialchars($foto['descripcion']); ?>"
              style="cursor: pointer;"
            >
            <div class="acciones-galeria">
                <a href="editar_galeria.php?id=<?php echo $foto['id_galeria']; ?>" class="btn-pill btn-editar-galeria">
                    Editar
                </a>
                <a href="eliminar_galeria.php?id=<?php echo $foto['id_galeria']; ?>" 
                   class="btn-pill btn-borrar-galeria" 
                   onclick="return confirm('¿Seguro que deseas eliminar esta imagen de la galería?');">
                    Borrar
                </a>
            </div>
        </div>
    <?php } ?>
  </div>

  <div class="image-viewer" id="viewer">
    <span id="close-viewer">&times;</span>
    <div class="viewer-content">
        <img id="viewer-img">
        <h2 id="viewer-title"></h2>
        <p id="viewer-description"></p>
    </div>
  </div>

  <div class="card admin-card" style="margin-top: 30px;">
    <div class="card-content">
        <h3>Agregar Contenido</h3>
        <p>Administre la galeria.</p>
        <a href="subirfoto.php" class="btn-admin">Agregar</a>
    </div>
  </div>

</section>
</div>
 
  <?php include("../componentes/footer.php"); ?>
  <script src="../js/galeria.js"></script>
  <script src="../js/buscador.js"></script>
</body>
</html>