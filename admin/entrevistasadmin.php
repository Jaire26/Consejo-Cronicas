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
    
    <style>
        body {
            display: flex !important;
            margin: 0 !important;
            padding: 0 !important;
            background-color: #FFF8F1 !important;
        }
        
        #sidebar {
            width: 280px !important;
            min-width: 280px !important;
            max-width: 280px !important;
            height: 100vh !important;
            background-color: #f1ddc4 !important; /* Beige de tu maqueta */
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            padding: 20px 0 !important;
            box-sizing: border-box !important;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.15) !important; 
            z-index: 9999 !important;
        }

        #sidebar .logo {
            text-align: center !important;
            padding: 10px 20px !important;
            margin-bottom: 25px !important;
            display: block !important;
        }

        #sidebar .logo img {
            max-width: 85% !important;
            height: auto !important;
        }

        #sidebar .menu {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        #sidebar .menu li {
            width: 100% !important;
        }

        #sidebar .menu li a {
            display: block !important;
            padding: 12px 35px !important;
            color: #4a2310 !important;
            text-decoration: none !important;
            font-size: 1.1rem !important;
            font-weight: 500 !important;
        }

        #sidebar .menu li a:hover {
            background-color: rgba(74, 35, 16, 0.05) !important;
        }

        /* Empujamos todo el contenido fuera del rango del sidebar fixed */
        .main-content {
            margin-left: 310px !important; 
            padding: 40px !important;
            flex-grow: 1 !important;
            box-sizing: border-box !important;
        }

        .noticia-principal {
            display: flex !important;
            gap: 25px !important;
            background: #ffffff !important;
            padding: 20px !important;
            border-radius: 15px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            margin-bottom: 25px !important;
            align-items: center !important;
        }

        .noticia-principal img {
            width: 260px !important;
            height: 170px !important;
            object-fit: cover !important;
            border-radius: 10px !important;
        }

        .noticia-principal .info h2 a {
            color: #3E1613 !important;
            text-decoration: none !important;
            font-size: 1.6rem !important;
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
                                <p style="color: #7C3F20; margin-top: 8px;">
                                    <?php echo htmlspecialchars($entrevista['subtitulo']); ?>
                                </p>
                            </div>
                        </article>
                <?php 
                    }
                } else {
                    echo "<p style='color: #7C3F20;'>No hay entrevistas en la base de datos.</p>";
                } 
                ?>
            </div>
        </div>
        
        <div class="card admin-card" style="margin-top: 40px;">
            <div class="card-content">
                <h3>Agregar Contenido</h3>
                <p>Administre la galería de entrevistas.</p>
                <a href="subirentre.php" class="btn-admin" style="display: inline-block; background: #3E1613; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 50px; font-weight: 600; margin-top: 10px;">Agregar</a>
            </div>
        </div>
    </section>
</div>

<?php include("../componentes/footer.php"); ?>
</body>
</html>