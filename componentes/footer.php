<?php
// Consultar la configuración global en la Base de Datos
// (Nota: La conexión $conn ya debe estar incluida en el archivo principal antes de llamar a este footer)
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
?>
<footer class="footer-global">
  <div class="footer-content">
    <h2>Crónica Huejutlense</h2>

    <div class="footer-contact">
      <p><strong>Correo:</strong> <?php echo htmlspecialchars($config['correo']); ?></p>
      <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($config['telefono']); ?></p>
      <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($config['ubicacion']); ?></p>
    </div>
  </div> 
</footer>