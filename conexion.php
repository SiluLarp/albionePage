<?php
	//conexion a base de datos
		$servidor = "localhost";
		$usuario = "root";
		$pass = "";
		$nombreBD = "market_bd";

		$conexion = mysqli_connect($servidor, $usuario, $pass, $nombreBD)
					or die("Ocurrio un error con la conexion a la base de datos.");

?>