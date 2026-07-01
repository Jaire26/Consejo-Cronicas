<?php
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);

// Detecta automáticamente la ruta correcta del logo
$rutaLogo = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? "../img/" : "img/";
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<footer class="footer-global">

    <div class="footer-franja"></div>

    <div class="footer-content">

        <img src="<?php echo $rutaLogo . $config['logo']; ?>" class="footer-logo" alt="Logo">

        <h2>Crónica Huejutlense</h2>

        <p class="footer-slogan">
            Preservando la historia, cultura y memoria colectiva de Huejutla de Reyes.
        </p>

        <div class="footer-redes">

            <a href="#"><i class="fab fa-facebook-f"></i></a>

            <a href="#"><i class="fab fa-instagram"></i></a>

            <a href="#"><i class="fab fa-tiktok"></i></a>

            <a href="#"><i class="fab fa-youtube"></i></a>

        </div>

        <div class="footer-contact">

            <p><strong>Correo:</strong>
                <?php echo htmlspecialchars($config['correo']); ?>
            </p>

            <p><strong>Teléfono:</strong>
                <?php echo htmlspecialchars($config['telefono']); ?>
            </p>

            <p><strong>Ubicación:</strong>
                <?php echo htmlspecialchars($config['ubicacion']); ?>
            </p>

        </div>

        <div class="footer-copy">
            © 2026 Crónica Huejutlense | Todos los derechos reservados.
        </div>

    </div>

</footer>