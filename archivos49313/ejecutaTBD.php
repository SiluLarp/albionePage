<?php
require "../conexion.php";

//encargado de ejecutar un truncate sobre las tablas para limpiarlas
$sql1 = mysqli_query($conexion,"TRUNCATE TABLE buzon");
$sql2 = mysqli_query($conexion,"TRUNCATE TABLE publicacion");
$sql3 = mysqli_query($conexion,"TRUNCATE TABLE streams");
$sql4 = mysqli_query($conexion,"TRUNCATE TABLE total_publicaciones");
$sql5 = mysqli_query($conexion,"TRUNCATE TABLE usuario");
$sql6 = mysqli_query($conexion,"TRUNCATE TABLE borrados");

if ($sql1 || $sql2 || $sql3 || $sql4 || $sql5 || $sql6) {
	echo 1;
}else{
	echo 2;
}
?>