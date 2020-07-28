<?php
require "conexion.php";
session_start();

$sesionON = &$_SESSION["useronline"];

if (!$sesionON) {
	//sino hay sesion
	$acceso = "";
	header("Location: Acceso-Denegado.php");
}else{
		$acceso = $sesionON;
		$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$acceso'");
		$valor = mysqli_fetch_assoc($sql);
		$idSesion = $valor['id'];
		if ($valor['estatus'] == 0) {
		header("Location: Acceso-Denegado.php");		
		}

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
//----------------------------------------------------------
//buscador
function BuscadorAdmin(parametroSearch)
{
	$.ajax({
		url: 'archivos49313/buscadorP.php',
		type: 'POST',
		dataType : 'html',
		data: { parametroSearch: parametroSearch},
	})

	.done(function(resultado){
		$("#llenarLista").html(resultado);
	})
}

$(document).on('keyup', '#txtBuscadorAdmin', function()
{
	var valorBusqueda=$(this).val();
	if (valorBusqueda!="")
	{
		BuscadorAdmin(valorBusqueda);
	}else{
		loadListaPublicacion();//al quedar vacio el buscador debe mostrar la primera linea de registros
		//BuscadorAdmin();
	}
});
</script>
<body id="cuerpoAdmin">
	<form method="POST" name="frmAdmin" id="frmAdmin" enctype="multipart/form-data">
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
		<div id="contenedorTodo">
			<table>
				<tr>
					<td width="25%" style="vertical-align: baseline;"><!--td de las publicaciones-->
					<div id="PaisesContador"><label id="clickIdioma" style="cursor: pointer;" onclick="contadorList(1);">CARGAR</label></div><br>	<!--barra que muestra el total de usuarios por idioma-->
					<div id="publicaiconesAdmin">
						<div id="leyendaPublicacionAdmin"><label onclick="loadListaPublicacion();" style="cursor: pointer;">Publicaciones</label><br><input type='text' id='txtBuscadorAdmin'></div><br>
						<div id="llenarLista">
							<!--lista de las publicaciones-->
						</div>
					</div>
					<br>
					<div id="userregistros">
						<div id="leyendaRegistros">Registro de estrellas</div>
						<img src="img/estrellas/1estrella.png" onclick="estrellasTotal('positivo');" style="width: 20px;cursor: pointer;">&nbsp;&nbsp;&nbsp;Nick | estrellas | publicaciones&nbsp;&nbsp;&nbsp;<img src="img/estrellas/1estrellaRoja.png" onclick="estrellasTotal('negativo');" style="width: 20px;cursor: pointer;">
						<div id="ListaUserEstrellas">
							<!--Aqui se cargar la lista de usuario con nestrellas ordenados de mayor estrellas a menor-->
							
						</div>
					</div>
					</td>
					<td width="30%" style="vertical-align: baseline;"><!--streams-->
						<div id="buzonAdmin"><label onclick="contadorList(2);" style="cursor: pointer;">BUZON:</label>&nbsp;<label id="clickBuzon"></label></div><br><!--div donde se carga el total de registro de tabal buzon-->
						<div id="streamsbyAdmin">
							<div id="streamsLeyendabyAdmin"><label onclick="loadStreamsAdmin();" style="cursor: pointer;">Streams</label></div><br>
							<div id="streamsListaByAdmin">
							<!--Aqui se carga la lista de streams online-->
								
							</div>
						</div><br>
						<div id="limpiezaTablas" title="buzon,publicacion,streams,total_publicaciones,usuario,borrados">
							Limpiar Tablas: <input type="text" style="width: 100px;outline: none;font-weight: bold;font-size: 16px;padding: 3px;border-style: none;" id="txtTruncate" onkeyup = "if(event.keyCode == 13) ejecutadorTB()"><br><br>
							
							<br><br>
							<center>
								<img src="img/checkOK.png" id="okBorrado" style="display: none; width: 20%;">
							</center>
						</div>
					</td><!--fin streams-->
					<td style="vertical-align: baseline;">
						<div id="contadoruserAdmin"><label style="cursor: pointer;" onclick="contadorList(3);">Usuarios:</label>&nbsp;(<label id="contadorUsers"></label>)</div>
						<br>
						<div class="contAddNew">
							<div class="leyendaAddNew"><label>Mensaje del administrador</label></div><br>
							<table id="saveNewmsj" style="display: none;">
								<tr><td>Titulo: <input type="text" class="txtadminbase" id="txttitulomsjAdmin"><br><br>Encuesta:
									<input type="radio" name="rdoQues" value="1"> On &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="rdoQues" value="2" checked> Off
								</td></tr>
								<tr><td>Descripcion:<br><textarea class="txtadminbase" id="txtDescripcionAdmin"></textarea></td></tr>
								<tr><td><input type="file" id="fileAdminMSJ" accept="image/*"></td></tr>
								<tr><td><input type="button" class="btnAdmin" value="Publicar" onclick="SendmsjAdmin();">&nbsp;&nbsp;&nbsp;<img src="img/cargandoShort.gif" id="GifCargandoAdmin" style="width: 30px; float: right;display: none;"></td></tr>
							</table>
							<div id="nuevoMSJAdmin" style="text-align: center;display: none;">
								<label id="btnNewMSJ" class="btnMSJAdminNEW" onclick="borradoMsjAdmin();">Nuevo mensaje</label>
							</div>
						</div><br>
						<!--campos para crear nuesvos idiomas y ciudades-->
						<div class="contAddNew">
							<div class="leyendaAddNew">Agregar nuevo idioma</div>
							<table>
								<tr><td>Nombre idioma: <input type="text" class="txtadminbase" id="txtIdiomaNuevo"></td></tr>
								<tr><td><input type="file" id="fileAdminIdioma" accept="image/*"></td></tr>
								<tr><td>
									<input type="button" class="btnAdmin" value="Crear" onclick="NewLanguage();">
									<img src="img/checkOK.png" id="okSave" style="display:none;float: right;width: 30px;">
								</td></tr>
								<tr><td><label>La imagen de la bandera del idioma debe tener el mismo nombre al momento de subirla (Ejem: ruso.png)</label></td></tr>
							</table>
						</div><br>
						<!--campos para crear nuevas ciudades-->
						<div class="contAddNew">
							<div class="leyendaAddNew">Agregar nueva categoria</div>
							<table>
								<tr><td>Nombre categoria: <input type="text" class="txtadminbase" id="txtCateNuevo"></td></tr>
								<tr><td><input type="file" id="fileAdminCate" accept="image/*"></td></tr>
								<tr><td>
									<input type="button" class="btnAdmin" value="Crear" onclick="NewCategory();">
									<img src="img/checkOK.png" id="okSaveCate" style="display:none;float: right;width: 30px;">
								</td></tr>
								<tr><td><label>La imagen de la categoria debe tener el mismo nombre de la misma (Ejem:  armadura.png)</label></td></tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
			<br><br><br><br><br><br><br><br>
		</div>
	</form>
</body>
</html>
