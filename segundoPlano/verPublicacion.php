<?php
require "../conexion.php";
//este archivo carga la tabla de la publicacion para verlo completo
//funcion javascript 
//usado en index.php


$id = @$_POST['idPost'];//id de la publicacion
$idsesion = @$_POST['idsesion'];//id del usuario sesion
$idUservendedor = @$_POST['iduservendedor'];//id del usuario dueño de la publicacion

$query = mysqli_query($conexion,"SELECT * FROM publicacion WHERE id = '$id'");
$valores = mysqli_fetch_assoc($query);

$imgBD = $valores['imagen'];
	if ($imgBD == "0") {
		$imagenVenta = "img/noImg.png";
	}else{
		$imagenVenta = $imgBD;
	}
$sqlcategoria = mysqli_query($conexion,"SELECT nombre FROM categorias WHERE id = '".$valores['id_categoria']."'");
$categoriaBD = mysqli_fetch_assoc($sqlcategoria);

//tabla usuario
$sqluser = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = '".$valores['id_usuario']."'");
$usuarioBD = mysqli_fetch_assoc($sqluser);

//idioma del usuario
$sqlIdioma = mysqli_query($conexion,"SELECT idioma_name FROM idioma_usuario WHERE id = '".$usuarioBD['idioma']."'");
$idiomaBD = mysqli_fetch_assoc($sqlIdioma);
//----------------------------------------------------------------------------------------------------------------------

$sqlPositivas = mysqli_query($conexion,"SELECT COUNT(*) AS totalPositivas FROM calificaciones WHERE id_usuario = '$idUservendedor' AND positivo <> '0'");
$positivasTotal = mysqli_fetch_assoc($sqlPositivas);
$totalPo = $positivasTotal['totalPositivas'];//aqui se alamacena el total de las califiaciones positivas

$sqlNegativas = mysqli_query($conexion,"SELECT COUNT(*) AS totalNegativas FROM calificaciones WHERE id_usuario = '$idUservendedor' AND negativo <> '0'");
$negativasTotal = mysqli_fetch_assoc($sqlNegativas);
$totalNe = $negativasTotal['totalNegativas'];//aqui se alamacena el total de las califiaciones negativas

//ahora con las 2 cantidades hacemos la operacion para determinar el numero de estrellas que tiene
//como claificar
//positivas ::: si es menor o igual a 5 puntos tiene media estrella
if ($totalPo == 0) {
	$positivosEstrellas = "";
}
if ($totalPo > 0 && $totalPo <= 5) {
	$positivosEstrellas = "<img src='img/estrellas/mediaestrella.png' style='width:25px;'>";
}
if ($totalPo > 5 && $totalPo <= 10) {
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:25px;'>";	
}
if ($totalPo > 10 && $totalPo <= 19) {// 1 estrella y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-1020.png' style='width:40px;'>";	
}
if ($totalPo >= 20 && $totalPo < 30) { //2 estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:25px;'><img src='img/estrellas/1estrella.png' style='width:25px;'>";	
}
if ($totalPo >= 30 && $totalPo < 40) {//2 estrellas y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-2030.png' style='width:55px;'>";	
}
if ($totalPo >= 40 && $totalPo < 50){//3 estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:25px;'><img src='img/estrellas/1estrella.png' style='width:25px;'><img src='img/estrellas/1estrella.png' style='width:25px;'>";		
}
if ($totalPo >= 50 && $totalPo < 60) {// 3 estrellas y la mitad estrellas-4050
	$positivosEstrellas = "<img src='img/estrellas/estrellas-4050.png' style='width:77px;'>";	
}
if ($totalPo >= 60 && $totalPo < 70) {// 4 cuatro estrellas
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:25px;'><img src='img/estrellas/1estrella.png' style='width:25px;'><img src='img/estrellas/1estrella.png' style='width:25px;'><img src='img/estrellas/1estrella.png' style='width:25px;'>";			
}
if ($totalPo >= 70 && $totalPo < 99) {// 4 estrellas y la mitad
	$positivosEstrellas = "<img src='img/estrellas/estrellas-6080.png' style='width:105px;'>";
}
if ($totalPo >= 100 ) {
	$positivosEstrellas = "<img src='img/estrellas/1estrella.png' style='width:23px;'><img src='img/estrellas/1estrella.png' style='width:23px;'><img src='img/estrellas/1estrella.png' style='width:23px;'><img src='img/estrellas/1estrella.png' style='width:23px;'><img src='img/estrellas/1estrella.png' style='width:23px;'>";
}
//ahora los votos negativos de 5 en 5
if ($totalNe == 0) {
	$negativasEstrellas = "";
}
if ($totalNe > 0 && $totalNe <= 5) {//1 estrella
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:25px;'>";
	}
if ($totalNe > 5 && $totalNe <= 10) {// 2 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'>";
	}
if ($totalNe > 10 && $totalNe <= 15) {// 3 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'>";
	}
if ($totalNe > 15 && $totalNe <= 20) {// 4 estrellas
		$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'>";
	}
if ($totalNe > 20) {// 5 estrellas
	$negativasEstrellas = "<img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'><img src='img/estrellas/1estrellaRoja.png' style='width:25px;'>";
		
	}
?>
<table>
		<tr>
			<td style="text-align: center;"><!--estrellas positivas-->
				<?php echo $positivosEstrellas;?>
			</td>
			<td style="text-align: center;"><!--estrellas negativas-->
				<?php echo $negativasEstrellas;?>
			</td>
		</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
						<img src="<?php echo $imagenVenta;?>" id="imgViewItem"><br>
						<label id="laTitulo"><?php echo $valores['item_name'] . " (" . $categoriaBD['nombre'] . ")";?></label>		
						</td>
					</tr>
					<tr>
						<td><img src="img/precio.png" class="imgTamaño">&nbsp;<?php echo $valores['precio'];?></td>
						<td><label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Idioma:</label>&nbsp;<?php echo $idiomaBD['idioma_name'];?></td>
					</tr>
					<tr>
						<td><img src="img/cantidad.png" class="imgTamaño">&nbsp;<?php echo $valores['cantidad'];?></td>
						<td><label style="font-size: 13px;font-weight: bold;color:#FECFC3;">negociable:</label>&nbsp;<?php echo $valores['negociable'];?></td>
					</tr>
					<tr>
						<td colspan="2">
					<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Nick PJ:</label>&nbsp; <?php echo $usuarioBD['nick'];?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Ciudad natal:</label> <?php echo $usuarioBD['ciudad'];?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Ciudades visitables:</label> <?php
					//ciudades que visitaria el usuario
					$sqlCity = mysqli_query($conexion,"SELECT nombre FROM ciudades WHERE id_publicacion = '$id'");
					if (mysqli_num_rows($sqlCity) > 0) {
						while($filas = mysqli_fetch_assoc($sqlCity)){
							echo $filas['nombre'] . " | ";
						}
					}else{
						echo "Ninguna.";
					}
					?></td></tr>
					<tr>
						<td colspan="2">
							<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Descripcion:</label> <?php echo $valores['descripcion'];?>
						</td>
					</tr>
					<tr><td colspan="2" style="text-align: center;">
						<input type="text" id="txtIdvendedoritem" value="<?php echo $valores['id_usuario'];?>" style="display: none;">
						<?php
						if ($idsesion == $idUservendedor) {
							?>
							<label style="font-size: 15px;font-weight: bold;color:#FECFC3;">Esta es tu publicación.</label>
							<?php
						}else{
							?>
<textarea id="textAreaMSJ" maxlength="200" placeholder="Menciona datos del item en el mensaje."></textarea><br><br>
<label id="labelBTNSend" onclick="mensajeAlVendedor($('#txtIdvendedoritem').val(),$('#textAreaMSJ').val());">enviar</label>
<br><br>
							<?php
						}
						?>

					</td></tr>
					<tr>
						<td style="padding: 10px;"><label id="btnCerraritem" onclick="ocultarItemFull()">CERRAR</label></td>
						<td><img src="img/mensajeOK.png" id="imgSendOK" style="width: 50px;display: none;"></td>
					</tr>
				</table>
<?php

mysqli_close($conexion);
?>