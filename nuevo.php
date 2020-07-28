<?php
require "conexion.php";
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
	<title>Creacion de cuenta</title>
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
					<li><a href="index.php">inicio</a></li>
					<li><a href="acercade.php">Acerca de</a></li>
					<!--<li><a href="#">Streams (0)</a></li>-->
				</ul>
			</section>
			<div id="sesion">
				<ul>
					<li>
						<label id="leyendaSesion" onclick="aparecer();">Iniciar sesión</label>
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
					
				</ul>
			</div>
		</header>
		<!--Aqui empíeza el espacio para el cuerpo de desarrollo-->
		<div id="msjEmergente"><!--mensaje de guardado exitoso-->
			<div id="msjReport">
				<label id="msjSave">Tú cuenta ha sido creada.<br><br><a href="cuenta.php">Ir a inicio.</a></label>
				<nav id="msjCampos">
				<label>Aun no has completado algunos datos.</label><br><br>
				<input type="button" value="OK" class="btnGeneral" onclick="ocultarMSJ();">
				</nav>
				<nav id="msjyauser">
				<label>El nombre de usuario ya esta en uso.</label><br><br>
				<input type="button" value="OK" class="btnGeneral" onclick="ocultarMSJ();">
				</nav>
				<nav id="msjError">
					<label>Ocurrio un error de guardado.SQL secuencia.</label><br><br>
				<input type="button" value="OK" class="btnGeneral" onclick="ocultarMSJ();">
				</nav>
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
		</div><!--fin de mensajes emergentes, mensajes de error sesion, mensajes otros-->
		<br><br><br><br><br><br><br>
		<div id="central">

			<div id="izquierdaDate">
				<center><img src="img/logo-market.png" style="width: 50%;"><br></center>
			<label>Esta es una web realizada por un jugador, con el proposito de facilitar el comercio y unir la comunidad.<br><br>El comercio de items al igual que en el juego es total responsabilidad del jugador, ellos colocan el precio a su conveniencia.<br><hr><br>Version beta 2020 (la continuacion de esta web dependera del apoyo de la comunidad)</label>
		</div>

		<div id="contenedor1">
			<br>
			<label>Bienvenido, porfavor completa los siguientes campos.</label>
			<center><hr style="border: solid 1px #fff;width: 80%;margin-top: 5px;"></center>
			<br><br>
			<center><table>
				<tr>
					<td><label>Nombre: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" id="txtNewname" class="txtNuevo"></td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td><label>Contraseña: </label></td>
					<td><input type="text" id="txtNewpass" class="txtNuevo"></td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td><label>Idioma: </label></td>
					<td>
						<select class="txtNuevo" id="selectIdioma">
							<?php
								$sql = mysqli_query($conexion,"SELECT * FROM idioma_usuario");
								while ($valores = mysqli_fetch_array($sql)) {
                        
 						 		echo '<option value="'.$valores['id'].'">'.$valores['idioma_name'].'</option>';
								}
						?>
						</select>
					</td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td><label>Nick del PJ: </label></td>
					<td><input type="text" id="txtNick" class="txtNuevo"></td>
				</tr>
			</table></center><br>
			<label>Ciudad principal: </label>
			<select id="ciudadSelect" class="txtNuevo">
				<option value="Bridgewatch">Bridgewatch</option>
				<option value="Marlock">Marlock</option>
				<option value="Lymhurst">Lymhurst</option>
				<option value="Caerleon">Caerleon</option>
				<option value="Thetford">Thetford</option>
				<option value="FortSterling">Fort sterling</option>
			</select><br><br>
			<input type="button" value="Registrarse" id="btncreate" class="btnGeneral" onclick="datosNew();">
			<br><br>
			<img src="img/albionG.png" style="width: 50%;">
		</div>
		<!--diviciocn-->
		
		</div>
	</form>
</body>
</html>
