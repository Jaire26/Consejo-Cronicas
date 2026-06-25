<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // (Opcional) Si deseas borrar la imagen del servidor para no acumular basura:
    $query_img = "SELECT imagen FROM historias WHERE id = $id";
    $res_img = mysqli_query($conn, $query_img);
    if ($row = mysqli_fetch_assoc($res_img)) {
        $ruta_imagen = "../img/" . $row['imagen'];
        if (file_exists($ruta_imagen) && !empty($row['imagen'])) {
            unlink($ruta_imagen);
        }
    }

    // Ejecutar borrado en base de datos
    $sql = "DELETE FROM historias WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Historia eliminada correctamente.'); window.location.href='historiaadmin.php';</script>";
    } else {
        echo "<script>alert('Error al intentar eliminar la historia.'); window.location.href='historiaadmin.php';</script>";
    }
} else {
    header("Location: historiaadmin.php");
}
exit();