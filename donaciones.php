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
					<li><a href="donaciones.php">Donar</a></li>
					<!--<li><a href="#">Streams (0)</a></li>-->
				</ul>
			</section>
			<!------------------- menu de calificaciones (inicio) ----------------------------->
			<div id="calificacionFull" <?php if($acceso){ echo "style='display:block'";}?>>
				<ul>
					<li>
						<img src="img/puntoRojo.png" style="width: 10px;display: none;" id="nuevaCalificacionImg">
						<label onclick="calificaiconClick();" onmouseover="pasarMousecali();" style="font-size: 14px;cursor: pointer;" id="CalifiShow">Calificacion</label> | <label onclick="calificarClick();" style="font-size: 14px;cursor: pointer;">Calificar</label>&nbsp;&nbsp;
						<ul id="UsuarioCalificacion" style="display: none;">
							<li id="subUserCallifi">
								<!--aqui se cargan las calificaciones-->
							</li>
						</ul>
						<!--seccion de votacion-->
						<ul id="calificarExterno" style="display: none;">
							<li id="subCalificarEX">
								<label>ID del usuario:</label><br>
								<input type="text" id="txtCalificar">
								<br><br>
								<label>votar:</label><br>
								<div id="votacionSeccion">
									<img src="img/checkOK.png" onclick="calificarUser(1,$('#txtCalificar').val());" style="width: 25px;cursor: pointer;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="img/checkNot.png" onclick="calificarUser(0,$('#txtCalificar').val());" style="width: 25px;cursor: pointer;">
								</div>
								<div id="msjCalificacion" style="display: none;">
									<center><img src="img/mensajeOK.png" id="votoCorrecto" style="width: 40px;display: none;">
									<img src="img/xError.png" id="errorVoto" style="width: 40px;display: none;"></center>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				
			</div>
			<!------------------- menu de calificaciones (final) ----------------------------->
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
		<div id="leyendaDonacion">Gracias por pasar a esta sección de la página. </div><br>
		<div id="informacionDo">
			El objetivo de pedir una donación es por 2 razones.<br>
			La primera es para pagar la mensualidad y si es posible el año de una cuenta premium del servidor donde está guardado la página.<br>
			La segunda razón es para pedir ayuda para que este pobre hombre vuelva a jugar al albion, ya que hace un par de meses mi tostadora murió dejándome con la moral baja.<br><br>
			Confio en el buen uso que le daran a la página, su apoyo me motiva y estare administrándola personalmente, recuerden que esto es trabajo de 1 sola persona. Tratare de colocar una noticia aquí abajo cuando tenga lo suficiente para comprar el siguiente mes o año premium del servidor
			<br><br>
			la donación la pueden hacer en este enlace:&nbsp;&nbsp;&nbsp;
			<a href="https://paypal.me/mydreamGamer?locale.x=es_XC" style="color:#A0F6F6;text-decoration: none;">Enlace paypal.me</a><br><br>
			<center><img src="img/memeWeb.jpg" style="width: 150px;border-radius: 7px;"></center>
		</div><br>
		<div id="imagenesResultado">
			<br>
			<label>Sección de información.</label>
			<img src="" style="width: 150px;display: none;">
			<br>
			<!--solo coloca un img con la imagen-->
		</div>
	</form>
</body>
</html>
