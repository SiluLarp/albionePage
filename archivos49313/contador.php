<?php
require "../conexion.php";

$valor = $_POST['valor'];

if ($valor == 1) {
	//se ejecuta el codigo para cargar los paises
	$sql1 = mysqli_query($conexion,"SELECT * FROM idioma_usuario");//id, idioma_name
	while($idiomaBD = mysqli_fetch_assoc($sql1)){
		$contar = mysqli_query($conexion,"SELECT COUNT(*) AS totaluser FROM usuario WHERE idioma = '".$idiomaBD['id']."'");
		$resultcontar = mysqli_fetch_assoc($contar);

		echo "<label>".$idiomaBD['idioma_name']."</label>: <label>" . $resultcontar['totaluser'] . "</label>&nbsp;&nbsp;";
	}	

}

//cargar el buzon con la cantidad de registros
if ($valor == 2) {
	//consultas a tabla buzon
	$sqlBuzon = mysqli_query($conexion,"SELECT COUNT(*) AS buzonTotal FROM buzon");
	$buzonBD = mysqli_fetch_assoc($sqlBuzon);

	echo $buzonBD['buzonTotal'];
}

//contador de usuarios registrador
if ($valor == 3) {
	$sqlUser = mysqli_query($conexion,"SELECT COUNT(*) AS totalUsers FROM usuario");
	$userBD = mysqli_fetch_assoc($sqlUser);

	echo $userBD['totalUsers'];
}

mysqli_close($conexion);
?>