<?php
require "../conexion.php";
//vamos a guardar el voto del usuario en la tabla
//recibimos el voto
$votoSend = $_POST['voto'];
$nombreUser = $_POST['idOn'];

$sqlTB = mysqli_query($conexion,"SELECT * FROM encuesta WHERE nombre_usuario = '$nombreUser'");
if (mysqli_num_rows($sqlTB) > 0) {//si hay registros con ese nombre es porque ya voto
	echo 4;//el usuario ya voto
}else{
	//sino hay registros del usuario, verificamos que tipo de voto es
	// 1 es YES y 2 es NO
	if ($votoSend == 1) {
		$sqlSavePositivo = mysqli_query($conexion,"INSERT INTO encuesta(nombre_usuario,positivo,negativo) VALUES('$nombreUser','1','0')");
		if ($sqlSavePositivo) {
			echo 1;//se ejecuto el SQL con exito positivo
		}else{
			echo 7;
		}
	}
	if ($votoSend == 2) {//el voto es negativo
		$sqlSaveNegativo = mysqli_query($conexion,"INSERT INTO encuesta(nombre_usuario,positivo,negativo) VALUES('$nombreUser','0','1')");
		if ($sqlSaveNegativo) {
			echo 2;//se ejecuto el SQL con exito negativo
		}else{
			echo 6;
		}
	}

}

mysqli_close($conexion);
?>