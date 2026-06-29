<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
include("../conexion/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query_img = "SELECT imagen FROM eventos WHERE id_evento = $id";
    $res_img = mysqli_query($conn, $query_img);
    if ($res_img && $row = mysqli_fetch_assoc($res_img)) {
        if (!empty($row['imagen'])) {
            $ruta_completa = "../img/" . $row['imagen'];
            if (file_exists($ruta_completa)) {
                unlink($ruta_completa);
            }
        }
    }

    // Borrado final del registro
    mysqli_query($conn, "DELETE FROM eventos WHERE id_evento = $id");
}

header("Location: eventosadmin.php");
exit();