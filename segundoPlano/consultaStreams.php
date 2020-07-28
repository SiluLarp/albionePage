<?php
require "../conexion.php";

//funcion quie lo solicita consultaStreams
//se encarga de consultarla tabla streams constantemente para ver si hay nuevos registros
$sql = mysqli_query($conexion,"SELECT * FROM streams WHERE new = '1'");
		
		if ($sql > 0) {
			echo 1;//si hay registros envia 1
		}
?>