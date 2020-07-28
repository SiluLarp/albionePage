<?php
//Carga la lista con una categoria en especifico todo en el index
//index.php
//funcion dentro del index
require "../conexion.php";
//id de categoria
$idCatego = $_POST['idCatego'];

$resultadoTDpost = mysqli_query($conexion, "SELECT * FROM publicacion WHERE id_categoria = '$idCatego' ORDER BY id DESC");//seleccionamos todos los reguistros de la tabla post
if (mysqli_num_rows($resultadoTDpost) > 0) {//si hay registros de publicaciones del usuario mostrar los registros


while ($fila = mysqli_fetch_assoc($resultadoTDpost)) 
{
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
<?php echo "<label style='cursor:pointer;font-size: 12px;' onclick=verPublicacionFull(".$fila['id'].",$('#idSesionglobal').val(),".$idUsaerWhile.")>".$fila['item_name']."</label>";?>
		</td>
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

mysqli_close($conexion);
?>