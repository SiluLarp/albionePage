<?php
require "conexion.php";
session_start();

$sesionON = &$_SESSION["useronline"];

if (!$sesionON) {
	//sino hay sesion
	$acceso = "";
//	header("Location: index.php");
}else{
		$acceso = $sesionON;
		$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$acceso'");
		$valor = mysqli_fetch_assoc($sql);
		$idSesion = $valor['id'];

}

echo "<input type='text' value='".$acceso."' id='cuentaLock' style='display:none;'>";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE html>
<html lang="EN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="ie-edge">
	<LINK REL=StyleSheet HREF="css/style.css" TYPE="text/css" MEDIA=screen></LINK>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<!--<script type="text/javascript" src="jquery-3.5.0.js"></script>-->
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/javaIndex.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
	<!-- codigo de la paguinacion-->
	<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/styles.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<title>Inicio - Mercado</title>
</head>
<script type="text/javascript">
function ocultarSesion(){
	document.getElementById('desplegable').style.display = 'none';
}
function aparecer(){
	div = document.getElementById('desplegable');
            div.style.display = 'block';
}

</script>
<body>
	<form method="POST" name="frmCuenta" id="frmCuenta" enctype="multipart/form-data">
		<header>
			<section id="menu">
					<a href="https://albiononline.com/" target="_blank"><img id="logo" src="img/Albion_logo.png" style="width: 8%;"></a>
					<img id="logo2" src="img/logoMarket.png" style="width: 8%;">
				<ul id="twoption">
					<li><a href="index.php">Inicio</a></li>
					<li><a href="acercade.php">Acerca de</a></li>
					<!--<li><a href="#">Streams (0)</a></li>-->
				</ul>
			</section>
			<div id="sesion">
				<ul>
					<li>
						<?php
						if (!$acceso) {
							echo "<label id='leyendaSesion' onclick='aparecer();'>Iniciar sesión</label>";
						}else{
							echo "<label id='activoLabel'><a href='cuenta.php'>" . $acceso . "</a> | <a href='destruir_sesion.php'>Salir</a></label>";	
						}
						?>
						<ul id="desplegable">
							<li id="submenuSesion">
								<label>Nick: </label><br><input type="text" class="txtinput" id="txtName"><br><br>
								<label>Password:</label><br><input type="text" class="txtinput" id="txtPass">
								<br><br>
								<center><input type="button" id="btnoksesion" value="OK" class="btnSesion" onclick="inicioSesion()">&nbsp;&nbsp;
								<input type="button" id="btnExit" value="Cancel" class="btnSesion" onclick="ocultarSesion()"><br>
								<a href="nuevo.php">Crear cuenta</a></center>
							</li>
						</ul>
					</li>
					<li id="mensajeNuevos" <?php if($acceso){ echo "style='display: block;'";}else{echo "style='display: none;'";}?>>
						<img src="img/msjNew.png" style="width: 30px;cursor: pointer;" id="mensajeIMG" onclick="mostrarLista()" onmouseover="pasarMouseMsj();">
						<img src="img/msj.png" style="width: 30px;cursor: pointer; display: none;" id="mensajenew" onclick="mostrarLista()" onmouseover="pasarMouseMsj();">
						<ul id="msjDesplegable">
							<li id="newmsjList" style="text-align: center;font-weight:bold;">
								
							<!--Aqui se cargara la lista de mensajes recibidos-->
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</header>
		<div id="msjEmergente"><!--mensaje de guardado exitoso-->
			<!--mensaje de carga de paguina-->
		<div id="msjCargando">Publicando<br><img src="img/cargando.gif" style="width: 150px;"></div>
		<div id="msjPublicado"><img src="img/publicado.png" style="width: 200px;"></div>
		<div id="msjErrorguardado">Error: SQL guardado<br><img src="img/exclamacion.png" style="width: 150px;"></div>
			<div id="msjReport">
				<!--mensajes emergentes de inicio de sesion-->
				<nav id="msjSesionname">
					<label>Nombre de usuario incorrecto!</label><br><br>
				<input type="button" value="OK" class="btnGeneral" onclick="ocultarMSJ();">
				</nav>
				<nav id="msjSesionPass">
					<label>Contraseña incorrecta!</label><br><br>
				<input type="button" value="OK" class="btnGeneral" onclick="ocultarMSJ();">
				</nav>

			</div>
			<!--Tablon de mensaje CHAT-->
			<div id="chatView">
				<div id="backContainer">
					<table style="width: 100%;">
						<tr>
							<td style="width: 50%;" >
							<div id="viewmsj">
								<div id="ContendorMSJ">
								<!--aqui se carga el mensaje para visualizar-->
								</div>
								<div id="barraBTN">
									<textarea maxlength="300" id="txtRespuesta"></textarea>
<input type="button" value="Enviar" id="btnSend" onclick="SendMessage($('#txtIdEscritor').val(),$('#txtRespuesta').val());">
								</div>
							</div>
							</td>
							<td style="vertical-align: baseline;">
								<div id="MSJlist"><!--Aqui se cargara la lsta de mensajes del buzon-->
									<div id="Scrollmsj">
										<!------------------------------------------------------------>
										<!------------------------------------------------------------>
									</div><!--del div que creara el scroll-->
								</div>

								<center><input type="button" value="CERRAR" id="textCerarMSJ" onclick="cerrarBuzon()"></center>
							</td>
						</tr>
					</table>
					
				</div>
			</div><!--fin del div de chat mensaje-->
		</div><!--fin del codigo de buzon, chat mensajes, y notificaciones-->
		<!--Aqui empíeza el espacio para el cuerpo de desarrollo-->
		<br><br><br><br><br><br>
		<div class="acerca1">
			<center><img src="img/logoMarket.png" style="width: 120px;"></center><br>
			<label>MercadoPlayer AO es una pagina desarrollada por una sola persona, con el fin de ayudar a otros jugadores a tener una comunicacion basada en sus necesidades. como el creador de este sitio tengo la esperanzas puesta en que puedan reunir a la mayoria de la comunidad que esta dispersa en diferentes grupos en las redes sociales.<br>El area de streams es la que mas activa desearia que estuviera donde todos los streamers relacionados con el juego Albion Online se tomaran su tiempo para publicarse y hacer este sitio un punto de encuntro para los deceos de conocimientos.</label>
		</div>
		<br><br>
		<div class="acerca1">
			<label><center><img src="img/copyright.jpg" style="width: 80px;"></center><br>
				Albion Online es un Mmorpg no lineal multiplataforma, de ambientación medieval fantástica, desarrollado por Sandbox Interactive, un estudio independiente Alemán.<br>Todos los derechos a su autores y desarrolladore, esta web solo pretende ser un medio de apoyo entre jugadores.<br><br>
				Descarga el juego desde su pagina oficial:
			</label><br>
			<a id="enlaceAlbion" href="https://albiononline.com/es/home">https://albiononline.com/es/home</a>
		</div><br><br>
		<div class="acerca1">
			<center><img src="img/importante.png" style="width: 100px;"></center>
			<br><br>
			<label>
				Esta página solo ofrece un medio de comunicacion y agrupacion de diferentes personas que desean intercambiar items dentro del mismo juego. El mutuo acuerdo entre comprador y vendedor es responsabilidad externa a este sitio, sean prudentes en sus negocios. <br>Existe la posibilidad de evaluar a cada usuario, esto con la finalidad que cada comprador sienta un nivel de seguridad al momento de negociar con el vendedor. Es facil ganar estrellas rojas(una sola persona que te evalue mal te dara 1 estrella roja), por otro lado ganar estrellas positivas/amarillas require mas esfuerzo pues 5 votos positivos te daran solo media estrella.
			</label><br>
		</div>
		<br><br><br><br><br>
	</form>
</body>
</html>
