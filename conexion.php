<?php

$servidor    = "localhost";
$usuario_bd  = "root";
$clave_bd    = "12345678";   
$nombre_bd   = "consultorio_dental";


$conexion = mysqli_connect($servidor, $usuario_bd, $clave_bd, $nombre_bd);


if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8");
?>
