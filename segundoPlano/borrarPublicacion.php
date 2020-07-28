<?php
//cuenta.php
//funcion eliminarPublicacion
require "../conexion.php";
//id de la publicacion
$id = $_POST['idPost'];
$url = $_POST['urlimgSend'];
if ($url <> "0") {
	unlink($url);//con este codigo se elimina la imagen de el almacenamiento
}

//se borra de 2 tablas la de ciudades y la principal de la publicacion
$borradoCiudades = mysqli_query($conexion,"DELETE FROM ciudades WHERE id_publicacion = '$id'");
$borrado = mysqli_query($conexion,"DELETE FROM publicacion WHERE id='$id'");
?>