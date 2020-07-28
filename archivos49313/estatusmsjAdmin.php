<?php
require "../conexion.php";
//aqui comprobamos si el estatus del mensaje del administrador es 1
$sqlmsj = mysqli_query($conexion,"SELECT * FROM admin_msj WHERE encuesta_estatus = '1'");
if (mysqli_num_rows($sqlmsj) > 0) {
	//si hay registro mandamos 1
	echo 1;
}else{
	echo 2;
}
?>