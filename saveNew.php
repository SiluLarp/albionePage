<?php
require "conexion.php";

//variables
$nombre = $_POST["nombre"];
$pass = $_POST["pass"];
$nick = $_POST["nick"];
$idioma = $_POST["idioma"];
$ciudad = $_POST["ciudad"];
//contraseña cifrada
$pass_cifrado = password_hash($pass, PASSWORD_DEFAULT);

//hasta aqui todas las variable ya estan asignadas
//empezamos el guardado
$consultaSQLUser = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nombre'");
$existeSQL = mysqli_num_rows($consultaSQLUser);

if ($existeSQL > 0) {
	//ya hay ua cuenta con ese nombre.
	echo 1;
	
}else{
	//con un nombre de usuario libre procedemos a guardar el registro
	$sqlSave = mysqli_query($conexion,"INSERT INTO usuario(nombre,pass,nick,ciudad,idioma,estatus) VALUES('$nombre','$pass_cifrado','$nick','$ciudad','$idioma','0')");

	//cerificamos si se ejecuto la secuencia SQL
	if (!$sqlSave) {
		//el registro no se guardo
		echo 3;

	}else{
		//la nueva cuenta se guardo correctamente
		//iniciamos la sesion
		session_start();
		$_SESSION["useronline"] = $nombre;
		echo 2;
	}
}

mysqli_close($conexion);
?>