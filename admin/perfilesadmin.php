<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
if ($_SESSION["id_rol"] != 1) {
    header("Location: ../admin/index.php");
    exit();
}

include("../conexion/conexion.php");

// 1. Traer la configuración saliendo un nivel
$query_conf = "SELECT * FROM configuracion WHERE id = 1";
$res_conf = mysqli_query($conn, $query_conf);
$config = mysqli_fetch_assoc($res_conf);
require_once(__DIR__ . "/../conexion/conexion.php");
$mensaje = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "registrar") {
 
    $nombre   = trim($_POST["nombre"]);
    $paterno  = trim($_POST["paterno"]);
    $materno  = trim($_POST["materno"]);
    $cargo    = trim($_POST["cargo"]);
    $telefono = trim($_POST["telefono"]);
    $correo   = trim($_POST["correo"]);
    $password = trim($_POST["password"]);
    $id_rol   = intval($_POST["id_rol"]);
 
    $check = mysqli_prepare($conn, "SELECT id_usuario FROM usuarios WHERE correo = ?");
    mysqli_stmt_bind_param($check, "s", $correo);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);
 
    if (mysqli_stmt_num_rows($check) > 0) {
        $error = "Ya existe un usuario con ese correo.";
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
 
        $sql = "INSERT INTO usuarios (nombre, paterno, materno, cargo, telefono, correo, password_hash, id_rol, estado, fecha_registro)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'activo', NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssis", $nombre, $paterno, $materno, $cargo, $telefono, $correo, $hash, $id_rol);
 
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Usuario registrado correctamente.";
        } else {
            $error = "Error al registrar: " . mysqli_error($conn);
        }
    }
}

//eliminar usuario
if (isset($_GET["eliminar"])) {
    $id = intval($_GET["eliminar"]);
    if ($id != $_SESSION["id_usuario"]) {
        $sql = mysqli_prepare($conn, "DELETE FROM usuarios WHERE id_usuario = ?");
        mysqli_stmt_bind_param($sql, "i", $id);
        mysqli_stmt_execute($sql);
        $mensaje = "Usuario eliminado.";
    } else {
        $error = "No puedes eliminar tu propia cuenta.";
    }
}
//Pra obtener lista de usuarios
$usuarios = mysqli_query($conn, "
    SELECT u.id_usuario, u.nombre, u.paterno, u.materno, u.cargo, u.correo, u.telefono, u.estado, u.id_rol, r.nombre_rol
    FROM usuarios u
    LEFT JOIN roles r ON u.id_rol = r.id_rol
    ORDER BY u.fecha_registro DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfiles - Admin</title>
 
  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/perfiles.css">
  <link rel="stylesheet" href="../css/galeriaadmin.css">
  <link rel="stylesheet" href="../css/usuarios.css">
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
 
  <section id="perfiles">
 
    <div class="section-title">
      <h2>Gestión de Usuarios</h2>
      <p>Administra los cronistas y administradores del sistema</p>
    </div>
 
    <?php if ($mensaje): ?>
      <div class="alerta alerta-ok"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alerta alerta-error"><?php echo $error; ?></div>
    <?php endif; ?>
 
    <div class="form-registro" id="form-registro" style="display:none;">
      <h3>Nuevo usuario</h3>
      <form method="POST">
        <input type="hidden" name="accion" value="registrar">
        <div class="form-grid">
 
          <div class="form-group">
            <label>Nombre *</label>
            <input type="text" name="nombre" required placeholder="Nombre(s)">
          </div>
 
          <div class="form-group">
            <label>Apellido paterno</label>
            <input type="text" name="paterno" placeholder="Apellido paterno">
          </div>
 
          <div class="form-group">
            <label>Apellido materno</label>
            <input type="text" name="materno" placeholder="Apellido materno">
          </div>
 
          <div class="form-group">
            <label>Cargo</label>
            <input type="text" name="cargo" placeholder="Ej. Cronista Municipal">
          </div>
 
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" placeholder="10 dígitos">
          </div>
 
          <div class="form-group">
            <label>Correo electrónico *</label>
            <input type="email" name="correo" required placeholder="correo@ejemplo.com">
          </div>
 
          <div class="form-group">
            <label>Contraseña *</label>
            <input type="password" name="password" required placeholder="Mínimo 6 caracteres" minlength="6">
          </div>
 
          <div class="form-group">
            <label>Rol *</label>
            <select name="id_rol" required>
              <option value="2">Cronista (Usuario)</option>
              <option value="1">Administrador</option>
            </select>
          </div>
 
        </div>
        <button type="submit" class="btn-guardar">Guardar usuario</button>
      </form>
    </div>

    <table class="tabla-usuarios">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre completo</th>
          <th>Cargo</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Rol</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($usuarios) > 0): ?>
          <?php while ($u = mysqli_fetch_assoc($usuarios)): ?>
            <tr>
              <td><?php echo $u["id_usuario"]; ?></td>
              <td><?php echo htmlspecialchars($u["nombre"] . " " . $u["paterno"] . " " . $u["materno"]); ?></td>
              <td><?php echo htmlspecialchars($u["cargo"] ?? "—"); ?></td>
              <td><?php echo htmlspecialchars($u["correo"]); ?></td>
              <td><?php echo htmlspecialchars($u["telefono"] ?? "—"); ?></td>
              <td>
                <span class="badge <?php echo $u['id_rol'] == 1 ? 'badge-admin' : 'badge-usuario'; ?>">
                  <?php echo htmlspecialchars($u["nombre_rol"]); ?>
                </span>
              </td>
              <td>
                <span class="badge <?php echo $u['estado'] == 'activo' ? 'badge-activo' : 'badge-inactivo'; ?>">
                  <?php echo ucfirst($u["estado"]); ?>
                </span>
              </td>
              <td>
                <?php if ($u["id_usuario"] != $_SESSION["id_usuario"]): ?>
                  <a href="?eliminar=<?php echo $u['id_usuario']; ?>"
                     class="btn-eliminar"
                     onclick="return confirm('¿Eliminar a <?php echo htmlspecialchars($u['nombre']); ?>?')">
                    Eliminar
                  </a>
                <?php else: ?>
                  <span style="color:#aaa; font-size:0.82rem;">Tu cuenta</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" style="text-align:center; color:#aaa; padding:2rem;">
              No hay usuarios registrados aún.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
 
  </section>
 
</div>
 
<script>
function toggleFormulario() {
    const form = document.getElementById("form-registro");
    form.style.display = form.style.display === "none" ? "block" : "none";
}
</script>
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