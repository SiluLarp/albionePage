<?php
//funcion borradoMSJ
require "../conexion.php";

//variables
$idComprador = $_POST["idcompra"];
$nombreUser = $_POST["nameUser"];

$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nombreUser'");
		$valor = mysqli_fetch_assoc($sql);
		$idBD = $valor['id'];//codigo solo para sacar el id

//creamos la secuencia para eliminar
		//para elminar de la lista de buzon el chat, se guardara en la tabla BORRADOS la id del usuario sesion y la id del usuario enviadopor con el estado 1.
		$sqleraser = mysqli_query($conexion,"INSERT INTO borrados(user1,user2,estado) VALUES('$idBD','$idComprador','1')");
	if ($sqleraser) {
		echo 1;//el mensaje se borro
	}else{
		echo 2;//error al borar el mensaje
	}
?>