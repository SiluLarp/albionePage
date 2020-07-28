<?php
require "../conexion.php";
//variable que define el tipo de estrellas a mostrar
$tipoEstrella = $_POST['tipoEstrella'];

//aplicamos el for a la tabla de usuario
$sqlEstrellas = mysqli_query($conexion,"SELECT DISTINCT id_usuario FROM calificaciones WHERE ".$tipoEstrella." <> '0'");
?>
<table>
<?php
while ($fila = mysqli_fetch_assoc($sqlEstrellas)) {

	//consultamos la base de datos por el nick
	$sqlUser = mysqli_query($conexion,"SELECT nick FROM usuario WHERE id = '".$fila['id_usuario']."'");
	$userTB = mysqli_fetch_assoc($sqlUser);

	//total de publicaciones del usuario
	$sqlpubl = mysqli_query($conexion,"SELECT total FROM total_publicaciones WHERE id_usuario = '".$fila['id_usuario']."'");
	$publicacionesT = mysqli_fetch_assoc($sqlpubl);

	//contamos el total de de registros de un usuario
	$sqlStars = mysqli_query($conexion,"SELECT COUNT(*) AS totalBD FROM calificaciones WHERE id_usuario = '".$fila['id_usuario']."' AND ".$tipoEstrella." <> '0'");
	$totalStars = mysqli_fetch_assoc($sqlStars);
	$totalRegistros = $totalStars['totalBD'];

if ($tipoEstrella == "positivo") {
	if ($totalRegistros == 0) {
	$positivosEstrellas = "";
}
if ($totalRegistros > 0 && $totalRegistros <= 5) {
	$positivosEstrellas = "<img src='img/estrellas/mediaestrella.png' style='width:15px;'>";
}
if ($totalRegistros > 5 && $totalRegistros <= 10) {
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'>";	
}
if ($totalRegistros > 10 && $totalRegistros <= 19) {// 1 estrella y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-1020.png' style='width:20px;'>";	
}
if ($totalRegistros >= 20 && $totalRegistros < 30) { //2 estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";	
}
if ($totalRegistros >= 30 && $totalRegistros < 40) {//2 estrellas y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-2030.png' style='width:25px;'>";	
}
if ($totalRegistros >= 40 && $totalRegistros < 50){//3 estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";		
}
if ($totalRegistros >= 50 && $totalRegistros < 60) {// 3 estrellas y la mitad estrellas-4050
	$positivosEstrellas = "<img src='img/estrellas/estrellas-4050.png' style='width:30px;'>";	
}
if ($totalRegistros >= 60 && $totalRegistros < 70) {// 4 cuatro estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";			
}
if ($totalRegistros >= 70 && $totalRegistros < 99) {// 4 estrellas y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-6080.png' style='width:50px;'>";
}
if ($totalRegistros >= 100 ) {
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";
}
}else{//del tipo de estrella
	//ahora los votos negativos de 5 en 5
if ($totalRegistros == 0) {
	$negativasEstrellas = "";
}
if ($totalRegistros > 0 && $totalRegistros <= 5) {//1 estrella
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalRegistros > 5 && $totalRegistros <= 10) {// 2 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalRegistros > 10 && $totalRegistros <= 15) {// 3 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalRegistros > 15 && $totalRegistros <= 20) {// 4 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalRegistros > 20) {// 5 estrellas
	$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
		
	}
}//del else de tipo de estrella
	


	?>
	<tr>
		<td><?php echo $userTB['nick'];?></td>
		<td>
				<?php if ($tipoEstrella == "positivo") { echo $positivosEstrellas;}else{ echo $negativasEstrellas;} ?>
		</td>
		<td><?php echo $publicacionesT['total'];?></td>
	</tr>

	<?php
}
?>
</table>