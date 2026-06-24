<?php
session_start();
 
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../login.php");
    exit();
}
 
include("../conexion/conexion.php");
 
if (!isset($_GET["id_imagen"]) || !isset($_GET["id_noticia"])) {
    header("Location: noticiasadmin.php");
    exit();
}
 
$id_imagen = intval($_GET["id_imagen"]);
$id_noticia = intval($_GET["id_noticia"]);
 
// Buscar el nombre del archivo para borrarlo del servidor
$sql = "SELECT imagen FROM noticias_imagenes WHERE id_imagen = $id_imagen";
$resultado = mysqli_query($conn, $sql);
 
if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
    $ruta = "../img/noticias/" . $fila["imagen"];
    if (file_exists($ruta)) {
        unlink($ruta);
    }
}
 
mysqli_query($conn, "DELETE FROM noticias_imagenes WHERE id_imagen = $id_imagen");
 
header("Location: editar_noticia.php?id=$id_noticia");
exit();
?>