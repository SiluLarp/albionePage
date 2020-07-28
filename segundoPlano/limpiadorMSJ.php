<?php
require "../conexion.php";

//aqui se eliminaran los mensajes con mas de 15 dias de antiguedad

$sqlintervalo = mysqli_query($conexion,"DELETE FROM buzon WHERE fecha_envio < CURRENT_DATE() - INTERVAL 15 DAY");
if ($sqlintervalo) {
	echo 1;//los registros con mas de 30 dias se borraron

}

mysqli_close($conexion);
?>