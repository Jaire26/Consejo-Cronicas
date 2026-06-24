<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
 
if ($id > 0) {
    // 1. Buscar la entrevista para saber qué imagen le corresponde
    $query = "SELECT imagen FROM entrevistas WHERE id = $id LIMIT 1";
    $res = mysqli_query($conn, $query);
 
    if ($res && mysqli_num_rows($res) > 0) {
        $entrevista = mysqli_fetch_assoc($res);
 
        // 2. Borrar el registro de la base de datos
        $sql = "DELETE FROM entrevistas WHERE id = $id";
 
        if (mysqli_query($conn, $sql)) {
            // 3. Borrar también el archivo de imagen físico del servidor
            $ruta_imagen = "../img/entrevistas/" . $entrevista['imagen'];
            if (!empty($entrevista['imagen']) && file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
 
            echo "<script>
                    alert('Entrevista eliminada correctamente.');
                    window.location.href = 'entrevistasadmin.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error al eliminar: " . mysqli_error($conn) . "');
                    window.location.href = 'entrevistasadmin.php';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('La entrevista no existe o ya fue eliminada.');
                window.location.href = 'entrevistasadmin.php';
              </script>";
        exit();
    }
} else {
    header("Location: entrevistasadmin.php");
    exit();
}