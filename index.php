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


//codigo para la paguinacion
$result = $conexion->query('SELECT COUNT(*) as total_products FROM publicacion');
$row = $result->fetch_assoc();
$num_total_rows = $row['total_products'];

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
/*---------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------*/
$(document).ready(function() {
    $('.pagination li a').on('click', function(){
        $('#ListaPublic').html('<div class="loading"><img src="img/load.gif" width="100px" height="100px"/><br/>Un momento por favor...</div>');

        var page = $(this).attr('data');		
        var dataString = 'page='+page;

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: dataString,
            success: function(data) {
                $('#ListaPublic').fadeIn(2000).html(data);
                $('.pagination li').removeClass('active');
                $('.pagination li a[data="'+page+'"]').parent().addClass('active');
            }
        });
        return false;
    });              
});
/*---------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------*/
function loadCategoria(id){
var dataCat = 'idCatego='+id;

        $.ajax({
            type: "POST",
            url: "segundoPlano/cargarPublicaciones.php",
            data: dataCat,
            success: function(data) {
                $('#ListaPublic').fadeIn(2000).html(data);
            }
        });
}
function cargarTodos(){
	$('#ListaPublic').html('<div class="loading"><img src="img/load.gif" width="100px" height="100px"/><br/>Un momento por favor...</div>');

        var page = 1;		
        var dataString = 'page='+page;

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: dataString,
            success: function(data) {
                $('#ListaPublic').fadeIn(2000).html(data);
                $('.pagination li').removeClass('active');
                $('.pagination li a[data="'+page+'"]').parent().addClass('active');
            }
        });
        return false;
}
//codigo del buscador de usuarios
//$(obtener_registros());

function obtener_registros(parametroSearch)
{
	$.ajax({
		url: 'segundoPlano/buscadorIndex.php',
		type: 'POST',
		dataType : 'html',
		data: { parametroSearch: parametroSearch},
	})

	.done(function(resultado){
		$("#ListaPublic").html(resultado);
	})
}

$(document).on('keyup', '#txtBuscador', function()
{
	var valorBusqueda=$(this).val();
	if (valorBusqueda!="")
	{
		obtener_registros(valorBusqueda);
	}else{
		cargarTodos();//al quedar vacio el buscador debe mostrar la primera linea de registros
		//obtener_registros();
	}
});

function indicacionesShow(){
document.getElementById("msjEmergente").style.display = "block";
document.getElementById("msjTutorial").style.display = "block";
}
function CerrarVista(){
document.getElementById("msjEmergente").style.display = "none";
document.getElementById("msjTutorial").style.display = "none";	
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
			<!--inicio TABLON ver publicacion-->
			<div id="delimitadorItem">
				<!--Aqui se cargara el contenido de la publicacion-->
			</div>
			<!--Fin TABLON ver publicacion-->
			<div id="msjTutorial"><img src="img/explicacionFunciones.jpg" onclick="CerrarVista();" style="width: 100%; height: 100%;"></div>
			<!--mensaje de carga de paguina-->
		<div id="msjCargando">Cargando<br><img src="img/cargando.gif" style="width: 150px;"></div>
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
		<div id="contendorIndex">
			<table>
				<tr>
					<td style="width: 30%;">
						<div id="publicacionesContenedor">
						<div id="leyendaPublicacion">
						<center><label>Publicaciones</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/intrrogatorio.png" style="cursor: pointer; width: 15px;" onclick="indicacionesShow();"></center>
						<input type="text" placeholder="Buscar..." id="txtBuscador" class="txtForm" style="width: 150px; font-style: italic;margin-top: 10px;margin-bottom: 5px;">
					</div><br>
						<!--<center><img src="img/load.gif" id="cargalista" style="display: none; border-radius: 15px; width: 60%;"></center>-->
						
							<!--aqui se cargara el div con los datos-->
			<?php
            //Si hay registros
            if ($num_total_rows > 0) {
                $num_pages = ceil($num_total_rows / 10);//numero de registros por paguinacion
                $result = $conexion->query(
                    'SELECT * FROM publicacion 
                    ORDER BY id DESC 
                    LIMIT 0, '. 10
                );
                 if ($num_pages > 1) {
                    echo '<div class="row">';
                    echo '<div class="col">';
                    
                    echo '<ul class="pagination">';

                    for ($i=1;$i<=$num_pages;$i++) {
                        $class_active = '';
                        if ($i == 1) {
                            $class_active = 'active';
                        }
                        echo '<li class="page-item '.$class_active.'"><a href="#" data="'.$i.'">'.$i.'</a></li>';
                    }

                    echo '</ul>';

                    echo '</div>';
                    echo '</div>';
                    echo "<br>";
                }
                echo "<div id='ListaPublic'>";//inicio del div contenedor de la lista
                if ($result->num_rows > 0) {
                    
        while ($fila = $result->fetch_assoc()){
	
//la imagen tiene trato especial ya que no pueden subir nada en algunos cass
	$imgBD = $fila['imagen'];
	if ($imgBD == "0") {
		$imagenVenta = "img/noImg.png";
	}else{
		$imagenVenta = $imgBD;
	}

	$idUsaerWhile = $fila['id_usuario'];//id del usuario para sacar el idioma
	$sqlUsuario = mysqli_query($conexion,"SELECT * FROM usuario WHERE id = '$idUsaerWhile'");
	$userTable = mysqli_fetch_assoc($sqlUsuario);
	//sacamos el idioma de su tabla
	$sqlLanguaje = mysqli_query($conexion,"SELECT idioma_name FROM idioma_usuario WHERE id = '".$userTable['idioma']."'");
	$idiomaTable = mysqli_fetch_assoc($sqlLanguaje);
	
	//categoria
	$sqlcate = mysqli_query($conexion,"SELECT nombre FROM categorias WHERE id='".$fila['id_categoria']."'");
	$categoriaBD = mysqli_fetch_assoc($sqlcate);

	//procesamos el precio para modificar su aparicion
	$precioInico = $fila['precio'];
	
	//mmostramos el icono negociable dependiendo el contenido de la bd
	$negociableBD = $fila['negociable'];
	if ($negociableBD == "si") {
		$visible1 = "block";
		$visible2 = "none";
	}
	if ($negociableBD == "no") {
		$visible1 = "none";
		$visible2 = "block";
	}
	?>
<div class="listaPublicacion">
	<div><img src="<?php echo $imagenVenta;?>" onclick="verPublicacionFull(<?php echo $fila['id']; ?>,$('#idSesionglobal').val(),<?php echo $idUsaerWhile; ?>)" style="width: 60px;"></div>
	<table>
		<tr>
<td colspan="2">
	<?php echo "<label style='font-size: 12px;cursor:pointer;' onclick=verPublicacionFull(".$fila['id'].",$('#idSesionglobal').val(),".$idUsaerWhile.")>".$fila['item_name']."</label>";?></td>
		 </tr>
		 <tr>
			<td><img src="img/precio.png" class="imgTamaño" title="<?php echo $fila['precio'];?>">&nbsp;<?php
			//de esta forma se consigue agregarle al fial K o M dependiendo de la cantidad
		if ($precioInico == "000") {
			echo "<img src='img/ofrecer.png' class='imgOfrecer'>";
		}
			if ($precioInico >= "1" && $precioInico < "10000") {
				echo $precioInico;
			}
			if ($precioInico >= "10000" && $precioInico < "100000") {
		$precioInico= substr($precioInico, 0, 2);
		echo $precioInico . "K";
	}
	if ($precioInico >= "100000" && $precioInico < "1000000") {
		$precioInico= substr($precioInico, 0, 3);
		echo $precioInico . "K";
	}
	if ($precioInico >= "1000000" && $precioInico < "10000000") {
				$precioInico= substr($precioInico, 0, 1);
				echo $precioInico . "M";
		}
		if ($precioInico >= "10000000" && $precioInico < "100000000") {
				$precioInico= substr($precioInico, 0, 2);
				echo $precioInico . "M";
		}
	if ($precioInico >= "100000000") {
		$precioInico= substr($precioInico, 0, 3);
				echo $precioInico . "M";
	}
	
			?></td>
			<td><img src="img/paises/<?php echo $idiomaTable['idioma_name'];?>.png" class="imgTamaño" title="<?php echo $idiomaTable['idioma_name'];?>"></td>
		 </tr>
		 <tr>
			<td><img src="img/cantidad.png" class="imgTamaño">&nbsp;<?php echo $fila['cantidad'];?></td>
		 	<td>
<img src="img/negocioSi.png" class="imgTamaño" title="Negociable" style="display: <?php echo $visible1;?>;"> 
<img src="img/prohibidoNegocio.png" class="imgTamaño" title="No negociable" style="display: <?php echo $visible2;?>;">
		 	</td>
		 </tr>
		 <tr>
			<td colspan="2">
				<img src="img/ciudades/<?php echo $userTable['ciudad'];?>-own.png" class="imgciudadPrincipal" title="<?php echo $userTable['ciudad'];?>">
				<?php
				//se crea un while para sacar todas las ciudades a las que esta disponible ir el vendedor
				$sqlCity = mysqli_query($conexion,"SELECT nombre FROM ciudades WHERE id_publicacion='".$fila['id']."'");
				while($cityBD = mysqli_fetch_assoc($sqlCity)){
				?>
		<img src="img/ciudades/<?php echo $cityBD['nombre'];?>.png" class="imgTamaño" title="<?php echo $cityBD['nombre'];?>">
				<?php	
				}
				?>
			
			</td>
		 </tr>
	</table>
		<div><img src="img/categorias/<?php echo $categoriaBD['nombre'];?>.png" class="imgtamacatego" title="<?php echo $categoriaBD['nombre'];?>"></div>
</div>


<?php
}

                }else{
                	echo "<div id='thereNotPost'><label>No hay publicaciones</label></div>";
                }

echo "</div>";//final div carga listas
       }

?>
						<br><!--------------------------------------------------------------->
					</div>
					</td>
					<td style="width: 13%;"><br>
						<div id="outCategorias">
							<div id="centerCategorias">
								<table style="width: 1%;vertical-align: baseline;white-space: nowrap;">
								<?php
								$sqlcate = mysqli_query($conexion,"SELECT * FROM categorias");
								while($rowsC = mysqli_fetch_assoc($sqlcate)){
					$sqlOne =mysqli_query($conexion,"SELECT COUNT(*) AS totales FROM publicacion WHERE id_categoria = '".$rowsC['id']."'");
					$totalCat = mysqli_fetch_assoc($sqlOne);
		echo "<tr><td><img src='img/categorias/".$rowsC['nombre'].".png' class='imgcateList' title='".$totalCat['totales']."'>&nbsp;</td><td style='vertical-align:middle;'><input type='radio' name='radioscat' id='rdo".$rowsC['id']."' value='".$rowsC['id']."' onclick=loadCategoria($('#rdo".$rowsC['id']."').val())></td></tr>";
								}
								?>
								<tr>
									<td><img src="img/categorias/todos.png" class="imgcateList" title="Todos"></td>
									<td style="vertical-align:middle;"><input type="radio" name="radioscat" checked id="rdoTodos" onclick="cargarTodos()"></td></tr>
								</table>
							</div>
						</div>
					</td>
					<td>
						<div id="msjAdmin">
							<!--mensaje del ser superior-->
						</div>
					</td>
					<td style="width: 40%;">
						<div id="streamsContendor">
							<div id="streamsLeyenda">Streams</div>
							<div id="streamsLista">
							<!--Aqui se carga la lista de streams online-->
								
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
</body>
</html>
