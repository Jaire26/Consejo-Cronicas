Conexion con la base de datos
<?php

$host = "localhost";
$usuario = "root";
$password = "";
$basedatos = "cronica_huejutlense";

$conn = new mysqli($host, $usuario, $password, $basedatos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>