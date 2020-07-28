<?php
require "../conexion.php";
//archivo php usado en la funcion calificarUser()
//variable del voto y variable del usuario
$calificaiconUser = $_POST['calificacion'];//valor 1 o 0 para definir positivo o negativo
$calificado = $_POST['userCalificado'];//id del textbos osea el id dle usuario para calificar
$usuarioName = $_POST['sesionUser'];//nombre del usuario sesion

$sqluser = mysqli_query($conexion,"SELECT id FROM usuario WHERE nombre = '$usuarioName'");
$usuarioBD = mysqli_fetch_assoc($sqluser);
$id = $usuarioBD['id'];

//hay que comprobar si ese usuario existe
$sqlexiste = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = '$calificado'");
if (mysqli_num_rows($sqlexiste) > 0) {//si el usuario existe procedemos con el codigo
	//se asegura el tipo de voto comprobando la cariable calificarUser
// si es UNO el voto es positivo
//si es CERO el voto es negativo
if ($calificado == $id) {//si el mismo usuaro quiere calificarse
	echo 7;
}else{
	//primero es comprobar si hay registro con el id del usuario que esta votando
$sqlComp = mysqli_query($conexion,"SELECT * FROM calificaciones WHERE id_usuario = '$calificado' AND positivo = '$id' OR negativo = '$id'");

if (mysqli_num_rows($sqlComp) > 0) {
	//si hay registros hay que comprobar si el usuario que quiere votar no lo haya hecho ya.
	echo 1;

}else{
	//sino hay registros de calificaciones para este usuario se guarda asi nada mas
	if ($calificaiconUser == 0) {
		//guardamos la id en el voto negativo
		$sqlsaveNegativo = mysqli_query($conexion,"INSERT INTO calificaciones(id_usuario,positivo,negativo,new) VALUES('$calificado','0','$id','1')");
		if ($sqlsaveNegativo) {
				echo 4;//el voto se guardo
			}
	}//-------------------------------------------------------
	if ($calificaiconUser == 1) {
		//guardamos la id en el voto positivo
		$sqlsavePositivo = mysqli_query($conexion,"INSERT INTO calificaciones(id_usuario,positivo,negativo,new) VALUES('$calificado','$id','0','1')");
		if ($sqlsavePositivo) {
				echo 4;//el voto se guardo
			}
	}//------------------------------------------------------	
}
}//del if de comprovacion de mismo usuario
}else{//else del if de comprobacion si existe el usuario en la tabla usuario
	echo 9;//el usuario no existe
}





mysqli_close($conexion);
?>