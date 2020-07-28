<?php
//cuenta.php
//funcion eliminarPublicacion del lado del administrador
require "../conexion.php";
//id de la publicacion
$id = $_POST['id'];
$url = $_POST['url'];

if ($url <> "0") {
	unlink($url);//con este codigo se elimina la imagen de el almacenamiento
}

//se borra de 2 tablas la de ciudades y la principal de la publicacion
$borradoCiudades = mysqli_query($conexion,"DELETE FROM ciudades WHERE id_publicacion = '$id'");
$borrado = mysqli_query($conexion,"DELETE FROM publicacion WHERE id = '$id'");
if ($borrado) {
	echo 1;
}
?>