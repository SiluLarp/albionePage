<?php
require "../conexion.php";
//codigo que muestra la mensajeria en el chat
//javascript lineade codigo ---- 191 funcion vrChat(variable)
//variable del boton sesio
$idremitenteMSJ = $_POST["idremitente"];
//id de sesion
$nameuser = $_POST["nameUser"];

$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$nameuser'");
		$valor = mysqli_fetch_assoc($sql);
		$idSesion = $valor['id'];

//primero actualizamos la BD para colocar que ya hemos visto el mensaje
$sqlUpdate = mysqli_query($conexion,"UPDATE buzon SET visto = '1' WHERE recibidoPor = '$idSesion' AND enviadoPor = '$idremitenteMSJ'");

//sacamos los tados de ese chat para regresarlos y cargarlos
$sqlmsj = mysqli_query($conexion,"SELECT * FROM buzon WHERE recibidoPor = '$idSesion' AND enviadoPor = '$idremitenteMSJ' OR enviadoPor = '$idSesion' AND recibidoPor = '$idremitenteMSJ'");
//id recibidoPor enviadoPor mensaje visto new
//creamos un while para sacar cada mensaje
while ($fila = mysqli_fetch_assoc($sqlmsj)) {
$recibido = $fila["recibidoPor"];
$enviado = $fila["enviadoPor"];
$textoChat = $fila["mensaje"];

if ($recibido == $idSesion) {
	//$textoRecibido = $textoChat;
	echo "<label id='remitente' class='txtchat' style='float: left;background: #6790C4;width: 70%;'>".$textoChat."</label>";//mensaje recibido
	
}else{
	echo "<label id='recetor' class='txtchat' style='float: right; background: #164B8E;width: 70%;'>".$textoChat."</label>";//mensaje enviado
}

}
echo "<input type='text' value='".$idremitenteMSJ."' id='txtIdEscritor' style='display:none'>";
	

?>