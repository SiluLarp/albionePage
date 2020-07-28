<?php
require "../conexion.php";

$id = $_POST['id'];
//se borrara el stream con la id
$sqlBorrar = mysqli_query($conexion,"DELETE FROM streams WHERE id = '$id'");
if ($sqlBorrar) {
	echo 1;
}
?>