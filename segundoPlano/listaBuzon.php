<?php
//vajavascrip funcion VerChatVaco()

require "../conexion.php";

//nombre del usuario activo
$nombreu = $_POST["activo"];

$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nombreu'");
		$valor = mysqli_fetch_assoc($sql);
		$idBD = $valor['id'];
//seleccionamos los mesajes con el id de la sesion y que solo se vena los que tengan oculto =0
$sqlList = mysqli_query($conexion,"SELECT DISTINCT enviadoPor FROM buzon WHERE recibidoPor = '$idBD'");
while ($filas = mysqli_fetch_assoc($sqlList)) {
	$idComprador = $filas["enviadoPor"];
//select * from borrado where user2 = idcomprador and user1 = idbd
//si codigoborrado = 1 no se mestra, sino se mostrara. 
	$sqlEraser = mysqli_query($conexion,"SELECT * FROM borrados WHERE user1 = '$idBD' AND user2 = '$idComprador'");
	$valorsql = mysqli_fetch_assoc($sqlEraser);
	$estadoErase = &$valorsql["estado"];
	if ($estadoErase == 1) {
		//si el estaod es igual a 1 no mostramos el registro
	}else{
		//sino hay etado o valor de este registro lo mostramos
		$sqldato = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = '$idComprador'");
		$dato = mysqli_fetch_assoc($sqldato);
		//cargamos el div de la lista de buzon
		echo "<div class='listaBuzon'>
		<label>Nick PJ: ".$dato['nick']."</label><br>
		<label>Ciudad: ".$dato['ciudad']."</label><br><br>
		<center><label class='btnBuzon' onclick='verChat(".$dato['id'].")'>Ver</label>&nbsp;&nbsp;&nbsp;<label class='btnBuzon' onclick='borradoMSJ(".$dato['id'].")'>Borrar</label></center>
		</div>";
	}

	
}
?>