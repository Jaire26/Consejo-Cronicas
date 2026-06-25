<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Buscar la imagen en el servidor físico para borrarla
    $query_img = "SELECT imagen FROM cronicas WHERE id_cronica = $id";
    $res_img = mysqli_query($conn, $query_img);
    if ($res_img && $row = mysqli_fetch_assoc($res_img)) {
        if (!empty($row['imagen'])) {
            $ruta_imagen = "../img/" . $row['imagen'];
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }
    }

    // Borrar de la base de datos usando id_cronica
    mysqli_query($conn, "DELETE FROM cronicas WHERE id_cronica = $id");
}

header("Location: cronicasadmin.php");
exit();