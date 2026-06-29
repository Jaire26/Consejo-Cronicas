<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Eliminar archivo del almacenamiento
    $query_img = "SELECT ruta_imagen FROM galeria WHERE id_galeria = $id";
    $res_img = mysqli_query($conn, $query_img);
    if ($res_img && $row = mysqli_fetch_assoc($res_img)) {
        if (!empty($row['ruta_imagen'])) {
            $ruta_completa = "../img/" . $row['ruta_imagen'];
            if (file_exists($ruta_completa)) {
                unlink($ruta_completa);
            }
        }
    }

    // Quitar registro de la tabla
    mysqli_query($conn, "DELETE FROM galeria WHERE id_galeria = $id");
}

header("Location: galeriaadmin.php");
exit();