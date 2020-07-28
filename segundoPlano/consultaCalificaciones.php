<?php
require "../conexion.php";
//archivo para consultar constantemente si hay uevas calificaciones para el usuario
//variable usuario
$nombreUser = $_POST['sesionUser'];
$sqluser = mysqli_query($conexion,"SELECT id FROM usuario WHERE nombre = '$nombreUser'");
$usuarioBD = mysqli_fetch_assoc($sqluser);
$id = $usuarioBD['id'];

//SQL para consultar si hay nuevos valores
$sqlConsulta = mysqli_query($conexion,"SELECT * FROM calificaciones WHERE id_usuario = '$id' AND new = '1'");

if (mysqli_num_rows($sqlConsulta) > 0) {
	echo 1;//hay nuevas calificaciones
}


mysqli_close($conexion);
?>