<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Buscar y eliminar la imagen física del servidor
    $query_img = "SELECT imagen FROM historias WHERE id = $id";
    $res_img = mysqli_query($conn, $query_img);
    if ($res_img && $row = mysqli_fetch_assoc($res_img)) {
        if (!empty($row['imagen'])) {
            $ruta_imagen = "../img/" . $row['imagen'];
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }
    }

    // Eliminar registro de la base de datos
    mysqli_query($conn, "DELETE FROM historias WHERE id = $id");
}

header("Location: historiaadmin.php");
exit();