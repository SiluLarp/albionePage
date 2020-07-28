<?php
	//conexion a base de datos
		$servidor = "bbhjlrzzsm74vrwmugf0-mysql.services.clever-cloud.com";
		$usuario = "urcwshiksnrsggn7";
		$pass = "DtXAFrnqbX4S7GOcm7w0";
		$nombreBD = "bbhjlrzzsm74vrwmugf0";

		$conexion = mysqli_connect($servidor, $usuario, $pass, $nombreBD)
					or die("Ocurrio un error con la conexion a la base de datos.");

?>
