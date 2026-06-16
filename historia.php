<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historia</title>
  <!-- Corregido: Se quitó '../' porque la carpeta css está al lado de este archivo -->
  <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>

  <nav id="sidebar">
    <div class="logo">
      <!-- Corregido: Se quitó '../' porque la carpeta img está al lado de este archivo -->
      <img src="img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
    </div>

    <ul class="menu">
        <!-- Corregido: Enlaces limpios sin '../' y actualizados a .php para el público -->
        <li><a href="index.php">Inicio</a></li>
        <li><a href="historia.php">Historia</a></li>
        <li><a href="cronicas.php">Crónicas</a></li>
        <li><a href="galeria.php">Galería</a></li>
        <li><a href="eventos.php">Eventos</a></li>
        <li><a href="perfiles.php">Perfiles</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="entrevistas.php">Entrevistas</a></li>
    </ul>
  </nav>

  <div class="main-content">
    <section id="historia">

      <div class="section-title">
        <h2>Historia de Huejutla</h2>
        <p>Conociendo nuestras raíces</p>
      </div>

      <div class="search-box">
        <input type="text" placeholder="Buscar...">
      </div>

      <div class="cards">
        <div class="card">
          <img src="img/danzas.jpeg" alt="Danzas">
          <div class="card-content">
            <h3>Titulo de contenido</h3>
            <p>Descripción de contenido.</p>
          </div>
        </div>

        <div class="card">
          <img src="img/reloj.webp" alt="Reloj">
          <div class="card-content">
            <h3>Titulo de contenido</h3>
            <p>Descripción de contenido.</p>
          </div>
        </div>
      </div>

    </section>
  </div>
  
  <footer class="footer-global">
    <div class="footer-content">
      <h2>Crónica Huejutlense</h2>

      <!-- Corregido un pequeño detalle de doble comilla en tu etiqueta original -->
      <div class="footer-contact">
        <p>
          <strong>Correo:</strong>
          contacto@cronicahuejutla.com
        </p>

        <p>
          <strong>Teléfono:</strong>
          +52 775 487 9831
        </p>

        <p>
          <strong>Ubicación:</strong>
          Huejutla de Reyes, Hidalgo
        </p>
      </div>
    </div> <!-- Corregido: Faltaba cerrar este div antes del footer -->
  </footer>

</body>
</html>