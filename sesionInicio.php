<?php
require "conexion.php";
session_start();
//recibimos las 2 variables
$nombre = $_POST["userSesion"];
$pass = $_POST["passSesion"];

//buscamos primero si ambo datos estan en la base de datos
	//consultamos
	$consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE nombre = '".$nombre."'");
	$resultado = mysqli_fetch_assoc($consulta);
	if ($resultado > 0) {
			//sacamos la contraseña del la BD
	$cifrado = $resultado["pass"];
	//en la condcion colocamos el codigo para decifrar el password
	if (password_verify($pass, $cifrado)) {
		//si es decifrado iniciamos sesion
		$_SESSION["useronline"] = $resultado['nombre'];
		//header("Location:cuenta.php");
		if ($resultado['estatus'] == 49313) {
			echo 9;
		}else{
			echo 3;	
		}
		
	}else{
		//si las contraseñas no soniguales
		echo 1;
	}	
	}else{
		//sino hay egistros con el nombre de usuario
		echo 2;
	}

mysqli_close($conexion);
?>