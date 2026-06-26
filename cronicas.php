<?php
// 1. Incluimos tu archivo de conexión (ajusta la ruta si en la raíz cambia, por ejemplo a "conexion/conexion.php")
include("conexion/conexion.php");

$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
// 2. Consultamos las crónicas para el público
$sql = "SELECT * FROM cronicas ORDER BY id_cronica DESC"; 
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crónicas</title>

  <link rel="stylesheet" href="css/catalogo.css">
  <link rel="stylesheet" href="css/galeriaadmin.css">
  <link rel="stylesheet" href="css/vercronica.css">

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
    </style>

</head>
<body>

 <nav id="sidebar">
    <div class="logo">
      <img src="img/<?php echo $config['logo']; ?>" alt="Logo">
    </div>

    <ul class="menu">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="historia.php">Historia</a></li>
        <li><a href="cronicas.php">Crónicas</a></li>
        <li><a href="galeria.php">Galería</a></li>
        <li><a href="eventos.php">Eventos</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="entrevistas.php">Entrevistas</a></li>
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

    // 3. Ciclo para mostrar las crónicas de forma dinámica
    if (mysqli_num_rows($resultado) > 0) {
        while($cronicas = mysqli_fetch_assoc($resultado)) { 
            // Procesamos la fecha para traducirla
            $fecha_en = date("d M Y", strtotime($cronicas['fecha']));
            $mes_en = date("M", strtotime($cronicas['fecha']));
            $fecha_es = str_replace($mes_en, $meses_es[$mes_en], $fecha_en);
    ?>
          <div class="card cronica-card">
              <img src="img/<?php echo $cronicas['imagen']; ?>" alt="<?php echo htmlspecialchars($cronicas['titulo']); ?>">

              <div class="card-content">
                  <span class="cronica-fecha">
                      <?php echo $fecha_es; ?>
                  </span>

                  <h3>
                      <?php echo htmlspecialchars($cronicas['titulo']); ?>
                  </h3>

                  <h4>
                      Por: <?php echo htmlspecialchars($cronicas['autor']); ?>
                  </h4>

                  <p class="cronica-resumen">
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
                </div>
              </div>
          </div>
    <?php 
        } 
    } else {
        echo "<p style='grid-column: 1/-1; text-align: center; color: #666;'>Próximamente más crónicas de nuestra región.</p>";
    }
    ?>
    </div>
  </section>

</div>
      <?php include("componentes/footer.php"); ?>

  <script src="js/leercronica.js"></script>
  <script src="js/buscador.js"></script>
</body>
</html>