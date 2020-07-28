<?php
require "conexion.php";
session_start();

$sesionON = &$_SESSION["useronline"];

if (!$sesionON) {
	//sino hay sesion
	$acceso = "";
	header("Location: index.php");
}else{
		$acceso = $sesionON;
		$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$acceso'");
		$valor = mysqli_fetch_assoc($sql);
		$idSesion = $valor['id'];

		$sqlidioma = mysqli_query($conexion,"SELECT idioma_name FROM idioma_usuario WHERE id='".$valor['idioma']."'");
		$idiomaSentence = mysqli_fetch_assoc($sqlidioma);

		//total de las publicaciones
		$sqlPu = mysqli_query($conexion,"SELECT total FROM total_publicaciones WHERE id_usuario = '$idSesion'");
		//PENDIENTE esta parte no funciona con mysqli_num_rows porque devuelve vacio la consulta
		$publicacionesT = mysqli_fetch_assoc($sqlPu);
		if (mysqli_num_rows($sqlPu) > 0) {//si la consulta esta llena con valores			
			$totalPublicion = &$publicacionesT["total"];
		}else{//si no hay resultados y la consulta esta vacia
			
			$totalPublicion = "0";
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
	<title>Cuenta</title>
</head>
<script type="text/javascript">
function ocultarSesion(){
	document.getElementById('desplegable').style.display = 'none';
}
function aparecer(){
	div = document.getElementById('desplegable');
            div.style.display = 'block';
}
jQuery(function($){
     $("#txtDuracion").mask("99:99:99");
});

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
					<li id="mensajeNuevos" style="display: block;">
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
									<textarea axlength="300" id="txtRespuesta"></textarea>
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
		<br><br><br><br>
	<div id="desarolloFull">
		<div id="detalleUser">
			<div id="centrador">
			<nav>
				<img src="img/swordAlbion.png" id="imgPerfil" ondblclick="secretoTotal()" style="border-radius: 50%; width: 80px;">
				<input type="text" id="txtSecret" onkeyup = "if(event.keyCode == 13) showTotales()">
			</nav>&nbsp;&nbsp;
			<label>Nick:</label>&nbsp;<?php echo "<label class='datosBD'>".$valor["nick"]. " ( ".$idSesion." )</label>";?>&nbsp;&nbsp;&nbsp;&nbsp;
			<label>Ciudad:</label>&nbsp;<?php echo "<label class='datosBD'>".$valor["ciudad"]."</label>";?>&nbsp;&nbsp;&nbsp;
			<label>Idioma:</label>&nbsp;<?php echo "<label class='datosBD'>".$idiomaSentence["idioma_name"]."</label>&nbsp;&nbsp;&nbsp;";?>
			<!--aparecera cuando de enter junto al codigo/t-->
			<label id="secretShow" style="display: none;">Total de publicaciones: <?php echo "<label class='datosBD'>".$totalPublicion."</label>";?></label>
			&nbsp;&nbsp;<nav>
				<img src="img/swordAlbion.png" id="imgPerfil2" style="border-radius: 50%; width: 80px;">
			</nav>
			</div>
		</div>
		<br>
		<div id="ContenedorTable">
		<table>
			<tr>
				<td>
					<div id="OwnerContenedor">
						<div id="OwnerLeyenda">Tus publicaciones</div><br>
						<center><img src="img/load.gif" id="cargalista" style="display: none; border-radius: 15px; width: 60%;"></center>
						<div id="OwnerList">
							<!--aqui se cargara el div con los datos-->
							
						</div><br>
					</div>
				</td>
				<td>
					<div id="contenidoNEW">
					<div id="leyendapubli">Nueva publicación</div><br>
					<table>
						<tr>
							<td><label class="colorLetras">Imagen del item:</label></td>
							<td>
								<input type="file" id="file-upload" accept="image/*">
								<br><br>
							</td>
						</tr>
						<tr>
							<td><label class="colorLetras">Nombre:</label></td>
							<td><input type="text" id="txtNameItem" class="txtForm" maxlength="40"></td>
						</tr>
						<tr>
							<td><label class="colorLetras">Cantidad de items:</label></td>
							<td><input type="number" id="txtCantidad" class="txtForm" style="width: 130px;"></td>
						</tr>
						<tr>
							<td><label class="colorLetras">Precio por unidad:</label></td>
							<td><input type="number" id="txtPrecio" class="txtForm" style="width: 130px;"></td>
						</tr>
						<tr><td><label class="colorLetras">¿Precio negociable?</label></td>
							<td>
								<select id="selectNegociable" class="txtForm">
									<option value="no">No</option>
									<option value="si">Si</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label class="colorLetras">Categoria:</label></td>
							<td>
							<select id="selectCategoria" class="txtForm"> 
								<?php
								$sql = mysqli_query($conexion,"SELECT * FROM categorias");
								while ($valores = mysqli_fetch_array($sql)) {
                        
 						 		echo '<option value="'.$valores['id'].'">'.$valores['nombre'].'</option>';
								}
						?>
							</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<br><label style="font-size: 20px;color:#DFDFDF;">Ciudades donde puedes hacer el intercambio</label><label style="font-size: 11px;color:#DFDFDF;">(si no puedes ir a otra ciudad aparte de tu ciudad principal, no marques nada)</label><br>
		<input type="checkbox" id="ciudad1">&nbsp;<label style="color:#F9DB57;">Bridgewatch</label>
							<br>
		<input type="checkbox" id="ciudad2">&nbsp;<label style="color:#F9DB57;">Marlock</label>
						<br>
		<input type="checkbox" id="ciudad3">&nbsp;<label style="color:#F9DB57;">Lymhurst</label>
						<br>
		<input type="checkbox" id="ciudad4">&nbsp;<label style="color:#F9DB57;">Thetford</label>
							<br>
		<input type="checkbox" id="ciudad5">&nbsp;<label style="color:#F9DB57;">Caerleon</label>
							<br>
		<input type="checkbox" id="ciudad6">&nbsp;<label style="color:#F9DB57;">Fort Stearling</label>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<label style="font-size: 18px;color:#DFDFDF;">Puedes agregar una breve descripción (opcional):</label><br>
								<center><textarea id="txtOpcional" maxlength="100" placeholder="solo 100 caracteres"></textarea></center>
							</td>
						</tr>
						<tr>
							<td><br>&nbsp;&nbsp;&nbsp;<input type="button" value="Pulicar" id="btnPublicar" class="btnGeneral" onclick="nuevaPulicacion()"><br><br></td>
							<td><label style="font-size: 13px; color:#E8A280;">Las publicaciones duran 2 dias visibles, luego son eliminadas. Los otros usuarios pueden enviarte un mensaje cuando les interese una de tus publicaciones.</label></td>
						</tr>
					</table>
					</div>
				</td>
				<td>
					<div id="streamContenedor">
						<div id="streamLeyenda">Publica tu stream</div>
						<br>
							<div id="streamFormulario">
								<label class="colorLetras">TITULO:</label><br>
								<input type="text" id="txtTitulo" class="txtForm"><br><br>
								<table>
									<tr>
										<td><label class="colorLetras">duración:</label></td>
					<td><input type="text" id="txtDuracion" class="txtForm" style="width: 100px;" onblur="valida(this.value);"></td>
									</tr>
									<tr>
										<td><label class="colorLetras">Enlace:</label></td>
										<td><input type="text" id="txtEnlaceStream" class="txtForm"></td>
									</tr>
									<tr>
										<td><label class="colorLetras">Idioma</label></td>
										<td>
											<select id="selectItidomaStream" class="txtForm">
												<?php
								$sql = mysqli_query($conexion,"SELECT * FROM idioma_usuario");
								while ($valores = mysqli_fetch_array($sql)) {
                        
 						 		echo '<option value="'.$valores['id'].'">'.$valores['idioma_name'].'</option>';
								}
						?>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2"><label class="colorLetras">Descripción</label><br>
											<textarea maxlength="70" id="txtDescripcionStream"></textarea>
										</td>
									</tr>
								</table>
							</div>
						<br><br>
						<div id="botonStream"><input type="button" value="Publicar" id="btStream" class="btnGeneral" onclick="streamPublicacion()"></div>
					</div>
				</td>
			</tr>
		</table>
		<br><br><br><br><br><br>
		</div>
	</div>
	</form>
</body>
</html>