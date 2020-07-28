<?php
require "../conexion.php";
//codigoque consulta a la base de datos si hay nueos mensajes en la tabla buzon
//javascript linea de codigo --- 135 funcion UpdateReload()

//la variable co el nombre
$nombre = $_POST["namesend"];

$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nombre'");
		$valor = mysqli_fetch_assoc($sql);
		$idSesion = $valor['id'];

		$sqlmsj = mysqli_query($conexion,"SELECT * FROM buzon WHERE recibidoPor = '".$idSesion."' AND new = '0'");
		$existeSQL = mysqli_num_rows($sqlmsj);

		if ($existeSQL > 0) {
			echo 1;
			//$sqlmsj = mysqli_query($conexion,"UPDATE buzon SET new = '0' WHERE recibidoPor = '$idSesion'");
		}else{
			echo 0;
		}
?>