
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
 
// 3. Función para generar el resumen corto de cada entrevista (mismo criterio que la vista pública)
function generarResumen($texto, $limite = 160) {
    $texto = trim(strip_tags($texto));
    if (mb_strlen($texto) <= $limite) {
        return htmlspecialchars($texto);
    }
    $cortado = mb_substr($texto, 0, $limite);
    $ultimoEspacio = mb_strrpos($cortado, ' ');
    if ($ultimoEspacio !== false) {
        $cortado = mb_substr($cortado, 0, $ultimoEspacio);
    }
    return htmlspecialchars($cortado) . '…';
}
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
        .tarjeta-admin {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .tarjeta-admin:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(62, 22, 19, 0.1);
        }
        .resumen-admin {
            color: #7C3F20;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0 0 16px 0;
        }
        .acciones-admin-card {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .acciones-admin-card a {
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.2s ease;
        }
        .btn-ver-card {
            background-color: #f1ddc4;
            color: #3E1613;
        }
        .btn-ver-card:hover {
            background-color: #e7c9a4;
        }
        .btn-editar-card {
            background-color: #7C3F20;
            color: #ffffff;
        }
        .btn-editar-card:hover {
            background-color: #3E1613;
        }
        .btn-borrar-card {
            background-color: #ffffff;
            color: #c0392b;
            border: 1px solid #c0392b;
        }
        .btn-borrar-card:hover {
            background-color: #c0392b;
            color: #ffffff;
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
        <input type="text" id="inputBusqueda" placeholder="Buscar por título...">
      </div>

        <div class="contenido" style="width: 100%; max-width: 100%; display: block; box-sizing: border-box;">
            <div class="noticias" style="width: 100%; max-width: 100%; display: flex; flex-direction: column; align-items: center; box-sizing: border-box;">
                <?php 
                if (mysqli_num_rows($res_entrevistas) > 0) {
                    while ($entrevista = mysqli_fetch_assoc($res_entrevistas)) { 
                ?>

                        <article class="feed-card tarjeta-admin" style="display: flex; gap: 35px; margin-bottom: 30px; background: #ffffff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(62, 22, 19, 0.05); align-items: flex-start; border: 1px solid #f1ddc4; width: 95%; max-width: 1150px; box-sizing: border-box;">
                            <div style="flex-shrink: 0; width: 280px; height: 190px; overflow: hidden; border-radius: 10px;">
                                <img src="../img/entrevistas/<?php echo $entrevista['imagen']; ?>" alt="Foto de la entrevista" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="info" style="flex-grow: 1;">
                                <h2 style="margin: 0 0 10px 0; font-family: 'Playfair Display', serif; font-size: 1.6rem; line-height: 1.3;">
                                    <a href="ver_entrevista.php?id=<?php echo $entrevista['id']; ?>" style="color: #3E1613; text-decoration: none;">
                                        "<?php echo htmlspecialchars($entrevista['titulo']); ?>"
                                    </a>
                                </h2>
 
                                <p class="resumen-admin">
                                    <?php echo generarResumen($entrevista['subtitulo'], 160); ?>
                                </p>
 
                                <div class="acciones-admin-card">
                                    <a href="ver_entrevista.php?id=<?php echo $entrevista['id']; ?>" class="btn-ver-card">Ver</a>
                                    <a href="editar_entrevista.php?id=<?php echo $entrevista['id']; ?>" class="btn-editar-card">Editar</a>
                                    <a href="borrar_entrevista.php?id=<?php echo $entrevista['id']; ?>" class="btn-borrar-card" onclick="return confirm('¿Seguro que quieres borrar esta entrevista? Esta acción no se puede deshacer.');">Borrar</a>
                                </div>
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


<script src="../js/buscador.js"></script>

</body>
</html>