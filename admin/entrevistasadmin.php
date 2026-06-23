<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

include("../conexion/conexion.php");

// 1. Traer la configuración saliendo un nivel
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
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
            <img src="../img/<?php echo $config['logo']; ?>" alt="Logo">

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

<?php include("../componentes/footer.php"); ?>
</body>
</html>