<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

include("../conexion/conexion.php");

// TRAEMOS LA CONFIGURACIÓN
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// TRAEMOS LAS CRÓNICAS
$sql = "SELECT * FROM cronicas ORDER BY id_cronica DESC"; 
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crónicas - Admin</title>
  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="stylesheet" href="../css/vercronica.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  
  <style>
    /* Estenedor de acciones para que los botones no se estiren */
    .acciones-cronica {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 15px;
        justify-content: flex-start;
    }

    /* Estilo Base para los botones "Peques" */
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
        width: auto; /* Evita que crezcan a lo ancho */
    }

    /* Colores para LEER (Estilo suave) */
    .btn-leer-cronica {
        background-color: #f0f0f0;
        color: #444;
    }
    .btn-leer-cronica:hover {
        background-color: #e2e2e2;
    }

    /* Colores para EDITAR (Igual a tu imagen) */
    .btn-editar-cronica {
        background-color: #fdf3e7;
        color: #a66b37;
    }
    .btn-editar-cronica:hover {
        background-color: #f8e7d2;
    }

    /* Colores para BORRAR (Igual a tu imagen) */
    .btn-borrar-cronica {
        background-color: #f9ebeb;
        color: #9b4343;
    }
    .btn-borrar-cronica:hover {
        background-color: #f2d7d7;
    }

    .cronica-card .card-content h3 {
        margin: 5px 0;
        font-size: 1.2rem;
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
  <section id="cronicas">

    <div class="section-title">
      <h2>Crónicas y Relatos</h2>
      <p>Historias que mantienen viva la memoria</p>
    </div>

    <div class="search-box">
       <input type="text" id="inputBusqueda" placeholder="Buscar por título...">
    </div>

    <div class="cards">
    <?php 
    $meses_es = array("Jan" => "Ene", "Feb" => "Feb", "Mar" => "Mar", "Apr" => "Abr", "May" => "May", "Jun" => "Jun", "Jul" => "Jul", "Aug" => "Ago", "Sep" => "Sep", "Oct" => "Oct", "Nov" => "Nov", "Dec" => "Dic");

    if ($resultado) {
        while($cronicas = mysqli_fetch_assoc($resultado)) { 
            $fecha_en = date("d M Y", strtotime($cronicas['fecha']));
            $mes_en = date("M", strtotime($cronicas['fecha']));
            $fecha_es = str_replace($mes_en, $meses_es[$mes_en], $fecha_en);
    ?>
            <div class="card cronica-card">
                <img src="../img/<?php echo $cronicas['imagen']; ?>" alt="Crónica">

                <div class="card-content">
                    <span class="cronica-fecha" style="font-size: 0.85rem; color: #888;">
                        <?php echo $fecha_es; ?>
                    </span>
                    <h3 class="cronica-titulo">
                        <?php echo htmlspecialchars($cronicas['titulo']); ?>
                    </h3>
                    <h4 style="font-size: 0.9rem; font-weight: 500;">
                        Por: <?php echo htmlspecialchars($cronicas['autor']); ?>
                    </h4>
                    <p class="cronica-resumen" style="font-size: 0.9rem; color: #666;">
                        <?php echo htmlspecialchars($cronicas['resumen']); ?>
                    </p>

                    <div class="acciones-cronica">
                        <button class="btn-pill btn-leer-cronica" 
                                onclick="mostrarCronica(this)"
                                data-titulo="<?php echo htmlspecialchars($cronicas['titulo']); ?>"
                                data-autor="<?php echo htmlspecialchars($cronicas['autor']); ?>"
                                data-fecha="<?php echo $fecha_es; ?>"
                                data-contenido="<?php echo htmlspecialchars($cronicas['contenido']); ?>">
                            Leer Crónica
                        </button>
                        
                        <a href="editar_cronica.php?id=<?php echo $cronicas['id_cronica']; ?>" class="btn-pill btn-editar-cronica">
                            Editar
                        </a>

                        <a href="eliminar_cronica.php?id=<?php echo $cronicas['id_cronica']; ?>" 
                           class="btn-pill btn-borrar-cronica" 
                           onclick="return confirm('¿Seguro que quieres borrar esta crónica?');">
                            Borrar
                        </a>
                    </div>
                </div>
            </div>
    <?php 
        }
    } 
    ?>

        <div class="card admin-card">
          <div class="card-content">
              <h3>Agregar Contenido</h3>
              <p>Administre las crónicas.</p>
              <a href="subircronica.php" class="btn-admin">Agregar</a>
          </div>
        </div>

    </div> 
  </section>
</div>

<?php include("../componentes/footer.php"); ?>
<script src="../js/leercronica.js"></script>

<script>
  // Buscador
  document.getElementById('inputBusqueda').addEventListener('keyup', function() {
      let filtro = this.value.toLowerCase();
      let tarjetas = document.querySelectorAll('.cronica-card');

      tarjetas.forEach(function(tarjeta) {
          let titulo = tarjeta.querySelector('.cronica-titulo').textContent.toLowerCase();
          if (titulo.includes(filtro)) {
              tarjeta.style.display = "";
          } else {
              tarjeta.style.display = "none";
          }
      });
  });
</script>
</body>
</html>