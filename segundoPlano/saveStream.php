<?php
require "../conexion.php";
//los datos se reciben de la funcion streamPublicacion() de cuenta.php
//variables
date_default_timezone_set("America/El_Salvador");
$hoy = date("h:i:s"); 

$usuarioName = $_POST['sesionstreamer'];
$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$usuarioName'");
$valor = mysqli_fetch_assoc($sql);
$idSesion = $valor['id'];//id del usuario para guardar en la base de datos
$titulo = $_POST['titulo'];
$enlace = $_POST['link'];
$duracion = $_POST['duracion'];
$idioma = $_POST['idioma'];
$descripcion = $_POST['info'];
if (!$descripcion) {
	$infoStream = "No gamer, no play!";
}else{
	$infoStream = $descripcion;
}
//guardamos en la BD, no hay que procesar nada
$sqlStream = mysqli_query($conexion,"INSERT INTO streams(id_usuario,titulo,duracion,hora_creacion,link,idioma,descripcion,new) VALUES('$idSesion','$titulo','$duracion','$hoy','$enlace','$idioma','$infoStream','1')");

if (!$sql) {
	echo 2;//si la secuencia no se ejecuta
}else{
	echo 1;//si la secuenta SQL se ejecuta y guarda los datos
}
?>