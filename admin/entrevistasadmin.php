<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}

include("../conexion/conexion.php");

// 1. Traer la configuración del logo
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// 2. Traer las entrevistas desde la base de datos
$query_entrevistas = "SELECT * FROM entrevistas ORDER BY id DESC";
$res_entrevistas = mysqli_query($conn, $query_entrevistas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrevistas - Admin</title>

    <link rel="stylesheet" href="../css/entrevista.css"> 
    <link rel="stylesheet" href="../css/catalogo.css">
    <link rel="stylesheet" href="../css/galeriaadmin.css">
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
            <h2>Entrevistas</h2>
            <p>Conoce Todo Lo Interesante Sobre Temas Relevantes</p>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar...">
        </div>
        
        <div class="contenido">
            <div class="noticias">
                <?php 
                if (mysqli_num_rows($res_entrevistas) > 0) {
                    while ($entrevista = mysqli_fetch_assoc($res_entrevistas)) { 
                ?>
                        <article class="noticia-principal">
                            <img src="../img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Foto de la entrevista">
                            <div class="info">
                                <h2>
                                    <a href="ver_entrevista.php?id=<?php echo $entrevista['id']; ?>">
                                        "<?php echo htmlspecialchars($entrevista['titulo']); ?>"
                                    </a>
                                </h2>
                                <p>
                                    <?php echo htmlspecialchars($entrevista['subtitulo']); ?>
                                </p>
                            </div>
                        </article>
                <?php 
                    }
                } else {
                    echo "<p style='text-align:center; color:#3E1613;'>No hay entrevistas en la base de datos.</p>";
                } 
                ?>
            </div>
        </div>
        
        <div class="card admin-card">
            <div class="card-content">
                <h3>Agregar Contenido</h3>
                <p>Administre la galería de entrevistas.</p>
                <a href="subirentre.php" class="btn-admin">Agregar</a>
            </div>
        </div>
    </section>
</div>

<?php include("../componentes/footer.php"); ?>
</body>
</html>