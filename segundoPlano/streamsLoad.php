<?php
require "../conexion.php";
//este archivo es usado en el index, la funcion que lo ejecuta se llama
//LoadStreams();	

$queryBD = mysqli_query($conexion,"SELECT * FROM streams ORDER BY id DESC");

if (mysqli_num_rows($queryBD) > 0) {
	//si hay registros actualizamos elcampo new
	$sqlUpdate = mysqli_query($conexion,"UPDATE streams SET new = '0'");
	//creamos el swhile para cargar los rtegistros
	while($fila = mysqli_fetch_assoc($queryBD)){

			$usersql = mysqli_query($conexion,"SELECT nombre FROM usuario WHERE id = '".$fila['id_usuario']."'");
			$userBD = mysqli_fetch_assoc($usersql);
		?>
		<br><div class="Contenidoslista">
			<div class="tituloStream"><?php echo $fila['titulo'];?></div>
		<table>
			
			<tr>
				<td>
					<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Usuario:</label>
				<label class="streamsLetter"><?php echo $userBD['nombre'];?></label>
				</td>
				<td>
					<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Duracion:</label>
					<label class="streamsLetter"><?php echo $fila['duracion'];?></label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Idioma:</label>&nbsp;
					<label class="streamsLetter">
					<?php
					//mostramos el idioma de la base de datos
					$queryLa = mysqli_query($conexion,"SELECT idioma_name FROM idioma_usuario WHERE id = '".$fila['idioma']."'");
					$idiomaBD = mysqli_fetch_assoc($queryLa);
					echo $idiomaBD['idioma_name'];
					?>
					</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Enlace:</label>
					<a class="enlaceStream" href="<?php echo $fila['link'];?>" target="_blank"><?php echo $fila['link'];?></a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label style="font-size: 13px;font-weight: bold;color:#FECFC3;">Descripcion:</label> 
					<label class="streamsLetter"><?php echo $fila['descripcion'];?></label>
				</td>
			</tr>
		</table>
		</div>
		<?php
	}
}else{
	echo "<div id='thereNotPost'><label>Nadie ha publicado stream</label></div>";
}

mysqli_close($conexion);
?>