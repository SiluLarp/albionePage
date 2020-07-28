<?php
require "../conexion.php";
//con este codigo cargamos la lista de mensajes en el icono de mensaje
//javascript linea de codigo --- 163 funcion UpdateFuntion()

	//sacar la id del usuario
$nombre = $_POST["namebd"];
$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nombre'");
$valor = mysqli_fetch_assoc($sql);
$idSesion = $valor['id'];

		//acutalizamos para registrar que ya vimos la lista de mensajes
		$sqlUpdate = mysqli_query($conexion,"UPDATE buzon SET new = '1' WHERE recibidoPor = '".$idSesion."'");

		//ahora consultamos la tabla de mensajes
		$sqlmsj = mysqli_query($conexion,"SELECT * FROM buzon WHERE recibidoPor = '".$idSesion."' AND visto='0'");
			if ($sqlmsj) {
			while ($fila = mysqli_fetch_assoc($sqlmsj)) {
				$idRemitente = $fila['enviadoPor'];

				//aqui borrarimos el registro de la tabla borrados que contenga la id de sesiony la idenviadopor
				//donde el valor de la columan estado sea = 1 (1 representa esta borrado)
				$borador = mysqli_query($conexion,"DELETE FROM borrados WHERE user1 = '$idSesion' AND user2 = '$idRemitente'");

				$sqlremitente = mysqli_query($conexion,"SELECT * FROM usuario WHERE id='$idRemitente'");
				$valor2 = mysqli_fetch_assoc($sqlremitente);

				echo "<label id='".$valor2['id']."' onclick='verChat(".$valor2['id'].")'>".$valor2['nick']."</label><hr>";
			}//del while
		}			

?>