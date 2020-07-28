<?php
require "../conexion.php";
date_default_timezone_set("America/El_Salvador");

//aqui se elimina el stream si cumple con su hora de duracion
$sql = mysqli_query($conexion,"SELECT * FROM streams");
if (mysqli_num_rows($sql) > 0) {

while ($filas = mysqli_fetch_assoc($sql)) {
	$tiempoBD = $filas['duracion'];//hora que el usuario determino que duraria el stream
	$creacion = $filas['hora_creacion'];
$hoy = date("h:i:s"); //la fecha actual

$horaInicio = new DateTime($hoy);
$horaTermino = new DateTime($tiempoBD);

$interval = $horaInicio->diff($horaTermino);
$resultado = $interval->format('%H:%i:%S');

//echo "<br>duracion : " . $tiempoBD;
//echo "<br>hora de reacion " . $creacion;
//echo "<br>Resulado resta: " . $resultado;
 
if ($resultado >= $creacion) {//si el resultado de la resta es mayor a la hora de reacion se borra
	//el stream que cumplio su tiempo es borrado
	$sqlborrar = mysqli_query($conexion,"DELETE FROM streams WHERE id = '".$filas['id']."'");
	if ($sqlborrar) {
		echo 1;
	}
    }    

}//del while

}//del fi num_rows
?>