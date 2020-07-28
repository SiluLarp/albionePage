<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="ie-edge">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<title>ERROR</title>
	<script type="text/javascript">
		function redireccionarPagina() {
 			 window.location = "index.php";
		}
setTimeout("redireccionarPagina()", 3000);
	</script>
	<style type="text/css">
body{
	background: #000000;
	padding: 0px;
	margin: 0px;
}
#contenedorGlobal{
	display: table;/*centramos el contenido dentro del div*/
	margin: 0 auto;
}
#imagen img{
	width: 35%;
	height: 50%;
	border-radius: 10px;
		
}
#central{
	background: rgb(255,255,255,0.8);
	width: 90%;
	text-align: center;
	height: 100vh;/*con esto conseguimos expandir al pie de la paguina el height*/
}
#letras p{
	font-size: 20px;
	font-style:italic;
	font-family:Trebuchet MS;
}

	</style>
</head>
	<body>
		<div id="contenedorGlobal">
			<div id="central">
				<br><br><br>
				<section id="imagen"><img src="img/fbi-girl.jpg"></section>
				<hr>
				<br>
				<section id="letras"> <p>Que estas haciendo?.</p> </section>
			</div>
		</div>
	</body>
</html>
