<?php
require "conexion.php";
//funcion de donde se envian los datos nuevaPulicacion()
date_default_timezone_set("America/El_Salvador");

$usuarioName = $_POST['usuario'];
$sql = mysqli_query($conexion,"SELECT * FROM usuario WHERE nombre = '$usuarioName'");
$valor = mysqli_fetch_assoc($sql);
$idSesion = $valor['id'];//id del usuario para guardar en la base de datos
//fecha actual
$fecha = date('Y-m-d');
//recibimos todas las variables
$nombreItem = $_POST['namePost'];
$precio = $_POST['precio'];
$cantidadSend = $_POST['cantidaditem'];
$negociable = $_POST['negociable'];
$categorias = $_POST['catego'];
$txtopcional = $_POST['opcional'];
if (!$txtopcional) {
	$descripcion = "Sin descripcion";
}else{
	$descripcion = $txtopcional;
}
//los checkbox
//las variables tienen  los nombres de las variables o un "0"
$bridgewatch = $_POST['ciudad1'];
$marlock = $_POST['ciudad2'];
$lymhurst = $_POST['ciudad3'];
$Theford = $_POST['ciudad4'];
$Caerleon = $_POST['ciudad5'];
$FortStearling = $_POST['ciudad6'];

//variables para subir la imagen
$nombre_file = &$_FILES['file']['name'];
$tipo = &$_FILES['file']['type'];
$tamano = &$_FILES['file']['size'];

//comenzamos el guardado, primer la imagen
if (($nombre_file == !NULL) && ($tamano <= 209715200))
{	
	//indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo == "image/gif") || ($tipo == "image/jpeg") || ($tipo == "image/jpg") || ($tipo == "image/png"))
   {
   	 // Ruta donde se guardarán videos que subamos
      $directorio = $_SERVER['DOCUMENT_ROOT'].'/AlbionMarketPlayer/Multimedia/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
      move_uploaded_file($_FILES['file']['tmp_name'],$directorio.$nombre_file);
      //$sqlupdate = mysqli_query($conexion, "UPDATE usuario SET foto = 'img/".$nombre_img."' WHERE id='1'");
      //echo "guardado";
      $BD_fileImg = "multimedia/" . $nombre_file;
      
   }
}else{
	$BD_fileImg = "0";
}
//fin del codigo para procesar la imagen. la variable con la direccion del video sera: $BD_fileImg

//iniciamos el guardado en la tablas
//las tablas donde se guardara informacion son las siguientes: publicacion,total_publicaciones,ciudades,

//primero la tabla de la publicacion.
$sqlPublicacion = mysqli_query($conexion,"INSERT INTO 
	publicacion(id_usuario,item_name,imagen,fecha_creacion,precio,negociable,cantidad,id_categoria,descripcion)
	VALUES('$idSesion','$nombreItem','$BD_fileImg','$fecha','$precio','$negociable','$cantidadSend','$categorias','$descripcion')");

if ($sqlPublicacion) {
	echo 1;//la publicacion se guardo con exito
	//necesitamos la id de la publicacion que se acaba de guardar
$sqlSacar = mysqli_query($conexion,"SELECT MAX(id) FROM publicacion WHERE id_usuario ='$idSesion'");
$valorMax = mysqli_fetch_assoc($sqlSacar);
$idPost = $valorMax["MAX(id)"];//id de la publicacion que se acaba de guardar

//Guardamos las ciudades que selecciono
//empleamos una funcion alojada en conexion.php

if ($bridgewatch != "0") {
$sqlcity1 = mysqli_query($conexion,"INSERT INTO ciudades(id_publicacion,nombre) VALUES('$idPost','$bridgewatch')");
}
if ($marlock != "0") {
$sqlcity2 = mysqli_query($conexion,"INSERT INTO ciudades(id_publicacion,nombre) VALUES('$idPost','$marlock')");
}
if ($lymhurst != "0") {
$sqlcity3 = mysqli_query($conexion,"INSERT INTO ciudades(id_publicacion,nombre) VALUES('$idPost','$lymhurst')");
}
if ($Theford != "0") {
$sqlcity4 = mysqli_query($conexion,"INSERT INTO ciudades(id_publicacion,nombre) VALUES('$idPost','$Theford')");
}
if ($Caerleon != "0") {
$sqlcity5 = mysqli_query($conexion,"INSERT INTO ciudades(id_publicacion,nombre) VALUES('$idPost','$Caerleon')");
}
if ($FortStearling != "0") {
$sqlcity6 = mysqli_query($conexion,"INSERT INTO ciudades(id_publicacion,nombre) VALUES('$idPost','$FortStearling')");
}

//con la id en una variable guardamos en las otras tablas.
//sumanos 1 a la tabla de total_publicaciones
$sqlsave3 = mysqli_query($conexion, "SELECT total FROM total_publicaciones WHERE id_usuario = '".$idSesion."'");
	$valorFila = mysqli_fetch_assoc($sqlsave3);
	if (empty($valorFila['total'])) {
		$sqlDiario = mysqli_query($conexion, "INSERT INTO total_publicaciones(id_usuario,total) VALUES('$idSesion','1')");
		if (!$sqlDiario) {
			//echo 5;//ocurrio un error al sumar 1 a la tabla de total_publicaciones
		}
	}else{
		$suma = $valorFila['total'] + 1;
		//ahora lo guardamo una vez sumado la cantidad de la base de datos mas 1
		$sqlDiarioSuma = mysqli_query($conexion, "UPDATE total_publicaciones SET total = '$suma' WHERE id_usuario ='$idSesion'");
		if (!$sqlDiarioSuma) {
			//echo 6;//Error SQL al sumar 1 al actualizar el valor donde ya hay un numero
		}
	}
	
}else{
	echo 2;//error al guardar la publicacion
}



mysqli_close($conexion);
?>