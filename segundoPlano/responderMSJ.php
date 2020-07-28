<?php
//javascript funcion SendMessage
require "../conexion.php";
date_default_timezone_set("America/El_Salvador");
//variable id remitente
$idSegundo = $_POST["idMail"];
//variable de usuarioi sesion
$nombreON = $_POST["activo"];
$mensaje = $_POST["message"];
$fecha = date('Y-m-d');

$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nombreON'");
		$valor = mysqli_fetch_assoc($sql);
		$idBD = $valor['id'];

//vamos a guardar
$sqlSend = mysqli_query($conexion,"INSERT INTO buzon(enviadoPor,recibidoPor,mensaje,visto,new,fecha_envio) VALUES('$idBD','$idSegundo','$mensaje','0','0','$fecha')");

if ($sqlSend) {
	echo $idSegundo;//el mensaje fue enviado
}
?>