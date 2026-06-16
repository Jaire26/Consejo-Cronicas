<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crónicas</title>

  
  <link rel="stylesheet" href="css/catalogo.css">
  <link rel="stylesheet" href="css/galeriaadmin.css">
  <link rel="stylesheet" href="css/vercronica.css">
</head>
<body>

 <nav id="sidebar">
    <div class="logo">
     
      <img src="img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
    </div>

    <ul class="menu">
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

  <section id="cronicas">

    <div class="section-title">
      <h2>Crónicas y Relatos</h2>
      <p>Historias que mantienen viva la memoria</p>
    </div>
    
    <div class="search-box">
       <input type="text" placeholder="Buscar...">
    </div>

    <div class="cards">
      <div class="card cronica-card">
          <img src="https://images.unsplash.com/photo-1524492449090-1abe1e3a209c?q=80&w=1200&auto=format&fit=crop" alt="Imagen de Crónica">

          <div class="card-content">
              <span class="cronica-fecha">
                  24 Mayo 2026
              </span>

              <h3>
                  Historias del Centro
              </h3>

              <h4>
                  Por: Consejo Huejutlense
              </h4>

              <p class="cronica-resumen">
                  Recuerdos y relatos sobre el antiguo Huejutla y las tradiciones que marcaron generaciones enteras.
              </p>

              <button class="btn-cronica" onclick="mostrarCronica(this)">
                 Leer Crónica
              </button>
          </div>
      </div>
    </div>
  </section>

</div>

<footer class="footer-global">
  <div class="footer-content">
    <h2>Crónica Huejutlense</h2>

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
  </div> 
</footer>
  <script src="js/leercronica.js"></script>
</body>
</html>