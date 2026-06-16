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
    <title>Entrevistas</title>

    <link rel="stylesheet" href="../css/entrevista.css"> 
    <link rel="stylesheet" href="../css/catalogo.css">
    <link rel="stylesheet" href="../css/galeriaadmin.css">
</head>

<body>
    <nav id="sidebar">

        <div class="logo">
            <img src="../img/LogoConsejo-removebg-preview.png" alt="Logo Crónica Huejutlense">
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
        </ul>

    </nav>

<div class="main-content">

    <section id="galeria">

        <div class="section-title">
            <h2>Entrevistas</h2>
            <p>Conoce Todo Lo Interesante Sobre Temas Relevantes</p>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar...">
        </div>
        
        <div class="contenido">
            <div class="noticias">
                <article class="noticia-principal">
                    <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=1200&auto=format&fit=crop">
                    <div class="info">
                        <h2>
                            <a href="entrevista1.html">
                                 "Manuel Bartlett, autor intelectual del asesinato..."
                            </a>
                        </h2>
                        <p>
                            El “Fiscal de Hierro” compartió detalles de las investigaciones.
                        </p>
                    </div>
                </article>
            </div>
        </div>
        
        <div class="card admin-card">
            <div class="card-content">
                <h3>Agregar Contenido</h3>
                <p>Administre la galería.</p>
                <a href="subirentre.php" class="btn-admin">Agregar</a>
            </div>
        </div>

    </section>

</div>

<footer class="footer-global">
    <div class="footer-content">
        <h2>Crónica Huejutlense</h2>

        <div class="footer-contact">
            <p><strong>Correo:</strong> contacto@cronicahuejutla.com</p>
            <p><strong>Teléfono:</strong> +52 775 487 9831</p>
            <p><strong>Ubicación:</strong> Huejutla de Reyes, Hidalgo</p>
        </div>
    </div>
</footer>
</body>
</html>