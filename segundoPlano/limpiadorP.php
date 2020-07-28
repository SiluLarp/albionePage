<?php
require "../conexion.php";

//vamos a borrar todas las publicaciones con mas de 2 dias de haberse creado
//sacamos las fechas
$sqlD = mysqli_query($conexion,"SELECT * FROM publicacion");
if (mysqli_num_rows($sqlD) > 0) {
	

while ($scan = mysqli_fetch_assoc($sqlD)) {
$daysActive = 2; //Dias que estara activa la publicacion
$creationDate = $scan['fecha_creacion']; //Fecha de publicacion 
$url = "../" . $scan['imagen'];

$deleteAfter = date('Y-m-d', strtotime(date_format(date_create($creationDate), 'Y-m-d')."+$daysActive days"));

$deleteDate = date_create($deleteAfter);
$today = date_create(date("Y-m-d"));
$diff = date_diff($deleteDate,$today);
$daysLeft = $diff->format("%R%a");

if($daysLeft >= 2){ //Si supera la fecha se borra.
    //echo "<br>borrado : " . $scan['id'];
    //se borra imagen de multimedia, tabla de publicacion y ciudades de la tabla ciudades
    $borradoCiudades = mysqli_query($conexion,"DELETE FROM ciudades WHERE id_publicacion = '".$scan['id']."'");
    $sqlBorrar = mysqli_query($conexion,"DELETE FROM publicacion WHERE id = '".$scan['id']."'");
    unlink($url);
    if ($sqlBorrar) {
    	echo 1;
    }
}else{
    //echo "<br><br>Esperando hasta el " . $deleteAfter . " ID: " . $scan['id'];

}
}//while

}
?>