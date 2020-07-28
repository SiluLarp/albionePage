<?php
require "../conexion.php";
//funcion para cargar los mensajes del admin (cargarAdmin)
$sql = mysqli_query($conexion,"SELECT * FROM admin_msj");

if (mysqli_num_rows($sql) > 0) {
	$valor = mysqli_fetch_assoc($sql);
	if ($valor['encuesta_estatus'] == 1) {
		$visibilidad = "style='display:inline-block;width:90%;'";
	}else{
		$visibilidad = "style='display:none;'";
	}

	//contar los votos
	$sqlContar = mysqli_query($conexion,"SELECT COUNT(*) AS positivos FROM encuesta WHERE positivo = '1'");
	$positivoTotal = mysqli_fetch_assoc($sqlContar);

	//votos negativos
	$sqlContarN = mysqli_query($conexion,"SELECT COUNT(*) AS negativos FROM encuesta WHERE negativo = '1'");
	$negativoTotal = mysqli_fetch_assoc($sqlContarN);

	/*$resultPositivo = mysql_query('SELECT SUM(positivo) AS totalPosi FROM encuesta'); 
	$rowPosi = mysql_fetch_assoc($resultPositivo); 
	$sumPositivo = $rowPosi['totalPosi'];*/

?>
<div class="adminLeyenda"><?php echo $valor['titulo']?></div>
	<div class="admintxt">
		<?php echo $valor['mensaje']?>
	<br><br>
	<?php
	if ($valor['imagen'] != "0") {
	?>
	<center><img src="<?php echo $valor['imagen'];?>" style="width: 80%;border-radius: 15px;"></center><br><br>
	<?php
	}
	?>
	<div id="encuestaDiv" <?php echo $visibilidad;?>>
		<nav style="float: left;"><img src="img/checkOK.png" onclick="votarEncuesta(1);" style="width: 30px;cursor: pointer;">&nbsp;<?php echo $positivoTotal['positivos'];?></nav>
		<nav style="float: right;"><?php echo $negativoTotal['negativos'];?>&nbsp;<img src="img/checkNot.png" onclick="votarEncuesta(2);" style="width: 30px;cursor: pointer;"></nav>
	</div>
</div>

<?php
}

mysqli_close($conexion);
?>