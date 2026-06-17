<?php
 
$host       = "sql301.byetcluster.com";
$usuario    = "if0_42207340";
$password   = "X1CEPCApLwI";
$base_datos = "if0_42207340_cronica_huejutlense";
 
$conn = mysqli_connect($host, $usuario, $password, $base_datos);
 
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
 
mysqli_set_charset($conn, "utf8");
 
?>