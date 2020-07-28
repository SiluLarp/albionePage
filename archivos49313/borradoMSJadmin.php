<?php
require "../conexion.php";

//borrar la imagen
$sqlsacar = mysqli_query($conexion,"SELECT imagen FROM admin_msj");
$sacar = mysqli_fetch_assoc($sqlsacar);
$imagenUrl = "../" . $sacar['imagen'];

unlink($imagenUrl);
if (mysqli_num_rows($sqlsacar) > 0) {
	$sqlborrar = mysqli_query($conexion,"DELETE FROM admin_msj");
	$sqlreinicio = mysqli_query($conexion,"TRUNCATE TABLE encuesta");

if ($sqlborrar) {
	echo 1;//borrado exitoso
}else{
	echo 2;//error
}

}

mysqli_close($conexion);
?>