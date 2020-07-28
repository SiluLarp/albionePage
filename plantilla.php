
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
		echo "<input type='text' value='".$idSesion."' id='idSesionglobal' style='display:none;'>";
		
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
	<title>Simplici</title>
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
	<form method="POST">
		<header>
			<section id="menu">
					<a href="https://albiononline.com/" target="_blank"><img id="logo" src="img/Albion_logo.png" style="width: 8%;"></a>
					<img id="logo2" src="img/logo-market.png" style="width: 8%;">
				<ul id="twoption">
					<li><a href="#">Inicio</a></li>
					<li><a href="#">Acerca de</a></li>
					<li><a href="#">Streams (0)</a></li>
				</ul>
			</section>
			<!------------------- prueba nuevo menu ----------------------------->
			<div id="calificacionFull">
				<ul>
					<li>
						<label onclick="calificaiconClick();" style="font-size: 14px;cursor: pointer;" id="CalifiShow">Calificacion</label> | <label onclick="calificarClick();" style="font-size: 14px;cursor: pointer;">Calificar</label>&nbsp;&nbsp;
						<ul id="UsuarioCalificacion" style="display: none;">
							<li id="subUserCallifi">
								<label class="labelCalifica">Positivos:</label>&nbsp;&nbsp;<label style="font-size: 12px;">(5 Votos)</label>
								<br>
								<label class="labelCalifica">Negativos:</label>&nbsp;&nbsp;<label style="font-size: 12px;">(0 Votos)</label>
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
									<img src="img/checkOK.png" style="width: 25px;cursor: pointer;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="img/checkNot.png" style="width: 25px;cursor: pointer;">
								</div>
							</li>
						</ul>
					</li>
				</ul>
				
			</div>
			<!------------------- prueba nuevo menu ----------------------------->
			<div id="sesion">
				<ul>
					<li>
						<label id="leyendaSesion" onclick="aparecer();">Iniciar sesión</label>
						<label id="activoLabel"><?php echo "<a href='cuenta.php'>" . $acceso . "</a>";?> | <a href="destruir_sesion.php">Salir</a></label>
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
					<li id="mensajeNuevos" style="display: none;">
						<img src="img/msjNew.png" style="width: 30px;cursor: pointer;" id="mensajeIMG" onclick="mostrarLista()">
						<img src="img/msj.png" style="width: 30px;cursor: pointer; display: none;" id="mensajenew" onclick="mostrarLista()">
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
		
	</form>
</body>
</html>
