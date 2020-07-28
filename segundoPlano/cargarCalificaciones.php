<?php
require "../conexion.php";
//archivo para mostrar las calificaciones cada vez que den click en calificaciones
$nombreUser = $_POST['sesionUser'];
$sqluser = mysqli_query($conexion,"SELECT id FROM usuario WHERE nombre = '$nombreUser'");
$usuarioBD = mysqli_fetch_assoc($sqluser);
$id = $usuarioBD['id'];

//actualizamos la tabla para definir que ya vimos el mensaje de nueva calificacion
$updateTable = mysqli_query($conexion,"UPDATE calificaciones SET new = '0' WHERE id_usuario = '$id'");

$sqlPositivas = mysqli_query($conexion,"SELECT COUNT(*) AS totalPositivas FROM calificaciones WHERE id_usuario = '$id'AND positivo <> '0'");
$positivasTotal = mysqli_fetch_assoc($sqlPositivas);
$totalPo = $positivasTotal['totalPositivas'];//aqui se alamacena el total de las califiaciones positivas

$sqlNegativas = mysqli_query($conexion,"SELECT COUNT(*) AS totalNegativas FROM calificaciones WHERE id_usuario = '$id'AND negativo <> '0'");
$negativasTotal = mysqli_fetch_assoc($sqlNegativas);
$totalNe = $negativasTotal['totalNegativas'];//aqui se alamacena el total de las califiaciones negativas

//ahora con las 2 cantidades hacemos la operacion para determinar el numero de estrellas que tiene
//como claificar
//positivas ::: si es menor o igual a 5 puntos tiene media estrella
if ($totalPo == 0) {
	$positivosEstrellas = "";
}
if ($totalPo > 0 && $totalPo <= 5) {
	$positivosEstrellas = "<img src='img/estrellas/mediaestrella.png' style='width:15px;'>";
}
if ($totalPo > 5 && $totalPo <= 10) {
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'>";	
}
if ($totalPo > 10 && $totalPo <= 19) {// 1 estrella y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-1020.png' style='width:25px;'>";	
}
if ($totalPo >= 20 && $totalPo < 30) { //2 estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";	
}
if ($totalPo >= 30 && $totalPo < 40) {//2 estrellas y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-2030.png' style='width:45px;'>";	
}
if ($totalPo >= 40 && $totalPo < 50){//3 estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";		
}
if ($totalPo >= 50 && $totalPo < 60) {// 3 estrellas y la mitad estrellas-4050
	$positivosEstrellas = "<img src='img/estrellas/estrellas-4050.png' style='width:55px;'>";	
}
if ($totalPo >= 60 && $totalPo < 70) {// 4 cuatro estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";			
}
if ($totalPo >= 70 && $totalPo < 99) {// 4 estrellas y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-6080.png' style='width:65px;'>";
}
if ($totalPo >= 100 ) {
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'><img src='img/estrellas/1estrella.png' style='width:15px;'>";
}
//ahora los votos negativos de 5 en 5
if ($totalNe == 0) {
	$negativasEstrellas = "";
}
if ($totalNe > 0 && $totalNe <= 5) {//1 estrella
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalNe > 5 && $totalNe <= 10) {// 2 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalNe > 10 && $totalNe <= 15) {// 3 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalNe > 15 && $totalNe <= 20) {// 4 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
	}
if ($totalNe > 20) {// 5 estrellas
	$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'><img src='img/estrellas/1estrellaRoja.png' style='width:15px;'>";
		
	}	
?>
<label class="labelCalifica">+</label>&nbsp;&nbsp;<?php echo $positivosEstrellas;?>&nbsp;<label style="font-size: 12px;">(<?php echo $totalPo;?> Votos)</label>
<br>
<label class="labelCalifica">-</label>&nbsp;&nbsp;<?php echo $negativasEstrellas;?>&nbsp;<label style="font-size: 12px;">(<?php echo $totalNe;?> Votos)</label>
<?php




mysqli_close($conexion);
?>