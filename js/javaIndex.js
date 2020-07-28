//funcion encargada de eliminar las publicaciones
setInterval(eliminarPorFecha,100);
function eliminarPorFecha()//elimina las publicaciones con mas de 2 dias
{
	$.ajax({
		url: 'segundoPlano/limpiadorP.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {
				//si se eliminan los registros madamos a llamar la funcion para mostrar de nuevo los disponibles
				//cargar de nuevo la lista de publicaciones
				cargarTodos();
			}
		}
	});
}
//funcion para eliminar los streams que ya cumplieron su hora de duracion.
setInterval(streamsHoraFin,1000);
function streamsHoraFin()
{
	$.ajax({
		url: 'segundoPlano/limpiadorStream.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {
				//al eliminarse volvemos a cargar la lista de streams
				LoadStreams();
			}
		}
	});
}

//funcion para eliminar los mensajes con mas de 28 dias de antiguedad
setInterval(eliminarMSJTotal,1000);
function eliminarMSJTotal()
{
	$.ajax({
		url: 'segundoPlano/limpiadorMSJ.php',
		type: 'post',
		success: function (respuesta) {
			//en el menu del administrador se muestra el total de mensajes borrados
			//funcion () se llamara para recargar el total de eliminados de mensajes
		}
	});
}
function datosNew()
{
	var nombre = $("#txtNewname").val();
	var password = $("#txtNewpass").val();
	var nick = $("#txtNick").val();
	var ciudad = $("#ciudadSelect").val();
	var idioma = $("#selectIdioma").val();

	if (nombre && password && nick) 
	{
		//si los campos estan llenos hay que enviar los datos
		var parametros = {
        	"nombre" : nombre,
        	"pass" : password,
        	"nick" : nick,
        	"ciudad" : ciudad,
        	"idioma" : idioma
        }
		$.ajax({
			data: parametros,
			url: "saveNew.php",
			type: "post",
			success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                     if (response == 1) {
                     	//ya hay un registro con ese nombre 
                     	document.getElementById("msjyauser").style.display = "block";
                     	document.getElementById("msjReport").style.display = "block";
                     	document.getElementById("msjEmergente").style.display = "block";
                     }
                     if (response == 2) {
                     	//el registro fue guardad, nueva cuenta creada msjReport
                     	document.getElementById("msjEmergente").style.display = "block";
                     	document.getElementById("msjReport").style.display = "block";
                     	document.getElementById("msjSave").style.display = "block";
                     }
                     if (response == 3) {
                     	//ocurrio un error de guardado, no se guardo el registro secuencia de SQL mal msjError
						document.getElementById("msjEmergente").style.display = "block";
						document.getElementById("msjReport").style.display = "block";
                     	document.getElementById("msjError").style.display = "block";
                     }
                     	
                     
			}
		});
	}else{
		//alert('vacio');
		document.getElementById("msjEmergente").style.display = "block";
		document.getElementById("msjReport").style.display = "block";
		document.getElementById("msjCampos").style.display = "block";
	}
}
function ocultarMSJ()//ocultar los mensajes una vez que ya fueron vistos
{
	document.getElementById("msjEmergente").style.display = "none";//div contenedor de los mensajes
	document.getElementById("msjReport").style.display = "none";
	document.getElementById("msjCampos").style.display = "none";//campos vacios

	document.getElementById("msjyauser").style.display = "none";//mensaje  de usuario ya en uso
	document.getElementById("msjError").style.display = "none";//mensaje de error de guardado en SQL secuencia
	
	document.getElementById("msjSesionname").style.display = "none";//mensaje de nombre de usuario incorrecto
	document.getElementById("msjSesionPass").style.display = "none";//mensaje de contraseña incorrecta
}

function inicioSesion()//boton inicio de sesion
{
	//txtName txtPass
	var nameUser = $("#txtName").val();
	var passUser = $("#txtPass").val();

	if (!nameUser || !passUser) {//si estan vacios ambos campos
		document.getElementById("txtName").style.background = "#FF6767";
		document.getElementById("txtPass").style.background = "#FF6767";
	}else{
		var parametrosSesion = {
		"userSesion" : nameUser,
		"passSesion" : passUser
	}
	$.ajax({
		data: parametrosSesion,
		url: "sesionInicio.php",
		type: "post",
		success : function (responseSesion) {
			//recibiendo los resultados 
			if (responseSesion == 1) {
				//contraseña incorrecta
				document.getElementById("msjEmergente").style.display = "block";
				document.getElementById("msjSesionPass").style.display = "block";//mensaje de contraseña incorrecta
			}
			if (responseSesion == 2) {
				//nombre de usuario incorrecto
				document.getElementById("msjEmergente").style.display = "block";
				document.getElementById("msjSesionname").style.display = "block";//mensaje de nombre de usuario incorrecto
			}
			if (responseSesion == 3) {
				//la sesion se inicio correctamente, asi que redireccionaremos
				window.location="index.php";
			}
			if (responseSesion == 9) {
				//la sesion se inicio correctamente, asi que redireccionaremos
				window.location="base.php";
			}
		}
	});
	}//fin del else de compas vacios
	
}

//variable de comprobacion de sesion en javascript
var activoUser = $("#cuentaLock").val();
window.onload = function cargar(){
	//al cargar llama a la funcion de cargar lista de cuenta de usuario
	loadMiList();
	//llamado a la funcion para cargar todas las publicaciones en index
	LoadStreams();

}
//funcion para cargar el mensaje del administrador
setInterval(cargarAdmin,2000);
//ADMINISTRADOR
function cargarAdmin(){

	$.ajax({
		url: 'segundoPlano/msjAdmin.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta) {
				document.getElementById("msjAdmin").innerHTML = respuesta;
				setTimeout(function() {
    					$('#msjAdmin').fadeIn('slow');
				}, 2000);
			}else{
				setTimeout(function() {
    					$('#msjAdmin').fadeOut('slow');
				}, 2000);
			}
			
		}
	});
}

//codigo para mostrar y ocultar con un solo click
function mostrarLista(){
	
	$("#msjDesplegable").slideToggle("slow");
}

//funcion al pasar el mouse sobre la el mensaje
function pasarMouseMsj(){
	UpdateFuntion();
}
//ejecutmaos la funcion para mostrar la lista
//se ejecuta cada segundo la funcion para revisar si hay nuevos mensajes
setInterval(UpdateReload,1000);

function UpdateReload()
{
	var nombreUser = activoUser;
	var parameUpdate = {
		"namesend" : nombreUser
	}
	$.ajax({
		data: parameUpdate,
		url: "segundoPlano/consultamsj.php",
		type: 'post',
		success: function (respuesta) {
			//si la respuesta es 1 afirmando que hubo cambio en la base de datos ejecutara la funcion para mostrar de nuevo los registros de racciones
			if (respuesta == 1) {
				document.getElementById("mensajeIMG").style.display = "none";
				document.getElementById("mensajenew").style.display = "block";
				//UpdateFuntion();
			}
			if (respuesta == 0) {
				document.getElementById("mensajeIMG").style.display = "block";
				document.getElementById("mensajenew").style.display = "none";
				//var divVacio = document.getElementById('newmsjList');
				//divVacio.innerHTML = "<label>No hay mensajes</label>";
			}
		}
	});
		//si la consulta devuelve positivo llenaremos ell text con un 1
}

 function UpdateFuntion(){
	//funcion que se ejecutara si el valor del text cambia a 1
	var namecon = activoUser;
	var paremetrosShow = {
		"namebd" : namecon
	}
	$.ajax({
		data: paremetrosShow,
		url: 'segundoPlano/cargarMsj.php',
		type: 'post',
		success: function (respuesta) {
			if (!respuesta) {
				document.getElementById('newmsjList').innerHTML = "<label onclick='VerChatVaco()'>No hay mensajes</label>";
						
			}else{

				var divContenido = document.getElementById('newmsjList');
						divContenido.innerHTML = respuesta;
			}
			
			//var reaccionShow = document.getElementById('ComentariosDiv');
			//reaccionShow.innerHTML = respuesta;
		}
	});
       
}

//visualizador del chat
function verChat(idRemitente)
{
	//ocultamos y mostramos div 
	document.getElementById("msjDesplegable").style.display = "none";//e ul de la lista de mensajes nuevso sin ver
	document.getElementById("msjEmergente").style.display = "block";
	document.getElementById("msjReport").style.display = "none";
	document.getElementById("chatView").style.display = "block";

	//enviamos la id del usuario remitente para cargarlo en el panel de chat
	var idRemi = idRemitente;
	var nameUserON = activoUser;

	var paremetros3 = {
		"idremitente" : idRemi,
		"nameUser" : nameUserON
	}
	$.ajax({
		data: paremetros3,
		url: 'segundoPlano/loadMSJ.php',
		type: 'post',
		success: function (respuesta) {
			//se llenara el chat
				var divContenido = document.getElementById('ContendorMSJ');
						divContenido.innerHTML = respuesta;
			//la siguiente funcion hace un scroll BOTTOM hasta el final del div
			scrollToBottom(divContenido);
			//se llama a la funcion para llenar la lista del buzon
			VerChatVaco();

			//var reaccionShow = document.getElementById('ComentariosDiv');
			//reaccionShow.innerHTML = respuesta;
		}
	});
}

function VerChatVaco()
{
	document.getElementById("msjDesplegable").style.display = "none";//e ul de la lista de mensajes nuevso sin ver
	document.getElementById("msjEmergente").style.display = "block";
	document.getElementById("msjReport").style.display = "none";
	document.getElementById("chatView").style.display = "block";

	//rellenar la lista del buzon
	var paremetros4 = {
		"activo" : activoUser
	}
	$.ajax({
		data: paremetros4,
		url: 'segundoPlano/listaBuzon.php',
		type: 'post',
		success: function (respuesta) {
				if (respuesta) {

					document.getElementById('Scrollmsj').innerHTML = respuesta;//se llenara la lista de buzon
						//todos los mensajes que tenga el usuario se cargaran

						//se llama a la funcion para hacer scroll bottom
						var listBox = document.getElementById('Scrollmsj');
						scrollToBottom(listBox);
				}else{
					document.getElementById('Scrollmsj').innerHTML = "Definitivamente, no hay mensajes.";
				}
		}
	});
}
function cerrarBuzon()
{
	document.getElementById("msjEmergente").style.display = "none";
	document.getElementById("msjReport").style.display = "none";
	document.getElementById("chatView").style.display = "none";
}


//funcion para guardar mensaje respuesta
function SendMessage(idRespuesta,mensaje)
{

	if (!mensaje || !idRespuesta || !activoUser) {
		document.getElementById("txtRespuesta").style.background = "red";
		document.getElementById("txtRespuesta").style.color = "#fff";
		document.getElementById("txtRespuesta").value = "";
		//otras 3 lines iguales para el area deindex
		document.getElementById("textAreaMSJ").style.background = "#FFBCBC";
		document.getElementById("textAreaMSJ").value = "";
		document.getElementById("textAreaMSJ").placeholder = "¡¡Completa campo,inicia sesión!!";
	}else{
		//variable con la id
	var paremetros4 = {
		"idMail" : idRespuesta,
		"activo" : activoUser,
		"message" : mensaje
	}
	$.ajax({
		data: paremetros4,
		url: 'segundoPlano/responderMSJ.php',
		type: 'post',
		success: function (respuesta) {
				if (respuesta) {
					//el mensaje se envio con exito, hay que recargar el menu llamando a la funcion verChat(idRemitente)
					verChat(respuesta);
					//limpiamos el textarea del texto enviado
					document.getElementById("txtRespuesta").value = "";
				}else{
					//window.location="segundoPlano/responderMSJ.php";
					document.getElementById("txtRespuesta").value = "El mensaje no se envio";//error el mensaje no se envio
					document.getElementById("txtRespuesta").style.background = "#E40000";
				}
		}
	});
	}
	
}
function mensajeAlVendedor(idRespuesta,mensaje)
{

	if (!mensaje || !idRespuesta || !activoUser) {
		//otras 3 lines iguales para el area deindex
		document.getElementById("textAreaMSJ").style.background = "#FFBCBC";
		document.getElementById("textAreaMSJ").value = "";
		document.getElementById("textAreaMSJ").placeholder = "¡¡Completa campo,inicia sesión!!";
	}else{
		//variable con la id
	var paremetros4 = {
		"idMail" : idRespuesta,
		"activo" : activoUser,
		"message" : mensaje
	}
	$.ajax({
		data: paremetros4,
		url: 'segundoPlano/responderMSJ.php',
		type: 'post',
		success: function (respuesta) {
				if (respuesta) {
					//limpiamos el textarea del texto enviado
					document.getElementById("textAreaMSJ").value = "";
					//se debe mostrar primero el icono de mensaje para luego ocultarlo
					document.getElementById("imgSendOK").style.display = "block";
					///mostramos la imagen de mensaje enviado OK 
					setTimeout(function() {
    					$('#imgSendOK').fadeOut('fast');
					}, 2000);
				}else{
					//window.location="segundoPlano/responderMSJ.php";
					document.getElementById("textAreaMSJ").value = "El mensaje no se envio";//error el mensaje no se envio
					document.getElementById("textAreaMSJ").style.background = "#E40000";
				}
		}
	});
	}
	
}
function borradoMSJ(idComprador)
{
	var paremetros3 = {
		"idcompra" : idComprador,
		"nameUser" : activoUser
	}
	$.ajax({
		data: paremetros3,
		url: 'segundoPlano/borrarMSJ.php',
		type: 'post',
		success: function (respuesta) {
				if (respuesta == 1) {
					VerChatVaco();
					document.getElementById('ContendorMSJ').innerHTML = "";
				}
				if (respuesta == 2) {
					//si da error mostramos el mensaje de error en la tabla de vizualizacion de mensajes ContendorMSJ
					document.getElementById('ContendorMSJ').innerHTML = "El mensaje no se pudo borrar.";
				}
		}
	});
}

/*---------con esta funcion se ejecuta un scroll hasta el final o pie en el elemento,div, contenedor con css overflow-----*/
function scrollToBottom(elementoscrol) {/*esta funcion se llama en las funciones al mostrar el mensaje del chat*/
    scrollInterval;
    stopScroll;

    var scrollInterval = setInterval(function () {
        elementoscrol.scrollTop = elementoscrol.scrollHeight;
    }, 50);

    var stopScroll = setInterval(function () {
        clearInterval(scrollInterval);
    }, 100);
}

function secretoTotal()/*con esta funcion mostramos el secreto del TEXTBOX oculto en la imgen user*/
{
	document.getElementById("imgPerfil").style.display = "none";
	document.getElementById("txtSecret").style.display = "block";
}

function showTotales()/*cuenta.php*/
{
	/*al precionar ENTER se ejecutara el codigo para asegurar que la clave sea correcta y mostrar el secreto*/
	var txtSecreto = $('#txtSecret').val();
	if (!txtSecreto) {
		document.getElementById("txtSecret").style.background = "#BF4E00";
	}else{
		if (txtSecreto == "/t") {
			document.getElementById("secretShow").style.display = "block";	
		}
		if (txtSecreto == "/King") {//redireccioin para el administrador
			window.location="base.php";
		}
	}
	
}

/*------------------funcion para guardar la nueva publicacion --------------*/
function nuevaPulicacion()/*cuenta.php*/
{
	//declaramos las variables de los campos
	var usuarioSesion = activoUser;
	var nombreItem = $('#txtNameItem').val();
	var cantidadItem = $('#txtCantidad').val();
	var precioItem = $('#txtPrecio').val();
	var negociable = $('#selectNegociable').val();
	var cateogiras = $('#selectCategoria').val();
	var opcionaltxt = $('#txtOpcional').val();
	
	//variables de los chekbox
	var ciudad1 = document.getElementById("ciudad1").checked;
	var ciudad2 = document.getElementById("ciudad2").checked;
	var ciudad3 = document.getElementById("ciudad3").checked;
	var ciudad4 = document.getElementById("ciudad4").checked;
	var ciudad5 = document.getElementById("ciudad5").checked;
	var ciudad6 = document.getElementById("ciudad6").checked;
	if (ciudad1) {var ciudadBir = "Bridgewatch";}else{ciudadBir = "0";}
	if (ciudad2) {var ciudadmar = "Marlock";}else{ciudadmar = "0";}
	if (ciudad3) {var ciudadlym = "Lymhurst";}else{ciudadlym = "0";}
	if (ciudad4) {var ciudadThe = "Thetford";}else{ciudadThe = "0";}
	if (ciudad5) {var ciudadCa = "Caerleon";}else{ciudadCa = "0";}
	if (ciudad6) {var ciudadste = "Fort Stearling";}else{ciudadste = "0";}
	//verificacion de campos vacios
	if (!nombreItem || !precioItem || !cantidadItem) {
		document.getElementById("txtNameItem").style.border = "solid 2px #FF0000";
		document.getElementById("txtPrecio").style.border = "solid 2px #FF0000";
		document.getElementById("txtCantidad").style.border = "solid 2px #FF0000";
	}else{
		//lo juntamos y enviamos con el siguiente metodo
	var formData = new FormData(document.getElementById("frmCuenta"));
        var files = $('#file-upload')[0].files[0];
        formData.append('file',files);
        formData.append('namePost',nombreItem);
        formData.append('precio',precioItem);
        formData.append('negociable',negociable);
        formData.append('catego',cateogiras);
        formData.append('opcional',opcionaltxt);
        formData.append('ciudad1',ciudadBir);
        formData.append('ciudad2',ciudadmar);
        formData.append('ciudad3',ciudadlym);
        formData.append('ciudad4',ciudadThe);
        formData.append('ciudad5',ciudadCa);
        formData.append('ciudad6',ciudadste);
        formData.append('usuario',usuarioSesion);
        formData.append('cantidaditem',cantidadItem);

        $.ajax({
            url: 'publicacionNueva.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
            	/*mientras espera que se guarde mostramos un img de carga*/
            			document.getElementById("msjEmergente").style.display = "block";
            			document.getElementById("msjCargando").style.display = "block";
                },
            success: function(response) {
            	document.getElementById("msjCargando").style.display = "none";
            	if (response == 1) {//la publicacion se guardo con exito
						document.getElementById("msjEmergente").style.display = "block";
            			document.getElementById("msjPublicado").style.display = "block";
            			
            			setTimeout(function() {
    						$('#msjEmergente').fadeOut('fast');
						}, 3000);
						//limpiamos los campos 
						$("#txtNameItem").val("");
						$("#txtCantidad").val("");
						$("#txtOpcional").val("");
						$("#txtPrecio").val("");
						$("#file-upload").val("")//aqui se limpia el input file;
						document.getElementById("ciudad1").checked = false;//asi se logra limpiar los checkbox
						document.getElementById("ciudad2").checked = false;
						document.getElementById("ciudad3").checked = false;
						document.getElementById("ciudad4").checked = false;
						document.getElementById("ciudad5").checked = false;
						document.getElementById("ciudad6").checked = false;
						loadMiList();//se cargara la lista de publicaciones al guardar una nueva
            	}
            	if (response == 2) {/*error la publicacion no se guardo*/
            		document.getElementById("msjEmergente").style.display = "block";
            		document.getElementById("msjErrorguardado").style.display = "block";
            		setTimeout(function() {
    						$('#msjEmergente').fadeOut('fast');
						}, 3000);
            	}
            }
        });
        return false;
	}
}

/*funcion para cargar la lista de publicaciones en la cuenta del usuario*/
function loadMiList()
{
	var paremetrosPost = {
		"useron" : activoUser
	}
	$.ajax({
		data: paremetrosPost,
		url: 'segundoPlano/misPublicaciones.php',
		type: 'post',
		success: function (respuesta) {
				document.getElementById("OwnerList").innerHTML = respuesta;
		}
	});
}
/*funcion para eliminar una publicacionde la lista de la cuenta*/
function eliminarPublicacion(idPubli,urlImg)
{
	var parametroErase = {
		"idPost" : idPubli,//id de la publicacion
		"urlimgSend" : urlImg//url de la imagen de la publicacion
	}
	$.ajax({
		data: parametroErase,
		url: 'segundoPlano/borrarPublicacion.php',
		type: 'post',
		beforeSend: function () {
			document.getElementById("cargalista").style.display = "block";
                },
		success: function (respuesta) {
			document.getElementById("cargalista").style.display = "none";
				loadMiList();
		}
	});
}
/*funcion para publicar el stream*/
function streamPublicacion()
{
	
	//variables
	var tituloStream = $('#txtTitulo').val();//obligatorio *** 
	var duracionStream = $('#txtDuracion').val();//obligatorio ***
	var linkStream = $('#txtEnlaceStream').val();//obligatorio ***
	var idiomaStream = $('#selectItidomaStream').val();
	var descripcionStream = $('#txtDescripcionStream').val();
	//validar los campos vacios
if (!tituloStream || !duracionStream || !linkStream) {
	document.getElementById("txtTitulo").style.border = "solid 2px #FF0000";
	document.getElementById("txtDuracion").style.border = "solid 2px #FF0000";
	document.getElementById("txtEnlaceStream").style.border = "solid 2px #FF0000";
}else{
	//si los campos necesarios estan llenos se procede a enviar los valores
	var parametroStream = {
		"sesionstreamer" : activoUser,
		"titulo" : tituloStream,
		"duracion" : duracionStream,
		"link" : linkStream,
		"idioma" : idiomaStream,
		"info" : descripcionStream
	}
	$.ajax({
		data: parametroStream,
		url: 'segundoPlano/saveStream.php',
		type: 'post',
		beforeSend: function () {
			//codigo reutilizado para mostrar mensaje de cargando
			document.getElementById("msjEmergente").style.display = "block";
            document.getElementById("msjCargando").style.display = "block";
                },
		success: function (respuesta) {
			document.getElementById("msjCargando").style.display = "none";
			if (respuesta == 1) {//la publicaicon de stream se publico con EXITO
			document.getElementById("msjEmergente").style.display = "block";
            document.getElementById("msjPublicado").style.display = "block";
            			
            setTimeout(function() {
    			$('#msjEmergente').fadeOut('fast');
			}, 3000);
			//limpiamos los campos
			$("#txtTitulo").val("");
			$("#txtDuracion").val("");
			$("#txtEnlaceStream").val("");
			$("#txtDescripcionStream").val("");
			}
			if (respuesta == 2) {//error al guardar el registro
				document.getElementById("msjEmergente").style.display = "block";
            	document.getElementById("msjErrorguardado").style.display = "block";
            	setTimeout(function() {
    					$('#msjEmergente').fadeOut('fast');
				}, 3000);
			}
		}
	});
}
}
///con la siguiente funcion se controla que el usuario complete el campo sino se vaciara
function valida(valor){

   //que no existan elementos sin escribir
   if(valor.indexOf("_") == -1)
   {
      var hora = valor.split(":")[0];//validar formato horas
      var minutos = valor.split(":")[1];//formato minutos 59
      var segundos = valor.split(":")[2];//formato segundos 59
      if(parseInt(hora) > 23 || parseInt(minutos) > 59 || parseInt(segundos) > 59)
      {
           $("#txtDuracion").val("");//el campo queda vacio sino cumple con lo necesario
      }
   }
}
/*funcion para cargar la lista completa de todas las publicaciones*/
//setInterval(loadAllPublic,100);
function loadAllPublic()
{
	/*var datos = $.ajax({
		url: "segundoplano/cargarPublicaciones.php",
		dataType: "text",
		async: false
	}).responseText;
		var divAll = document.getElementById('ListaPublic');
		divAll.innerHTML = datos;*/
}
function LoadStreams()
{
	var datos = $.ajax({
	url: "segundoPlano/streamsLoad.php",
	dataType: "text",
	async: false
	}).responseText;

	var divContenido = document.getElementById('streamsLista');
	divContenido.innerHTML = datos;
}
/*se crea una funcion para estar consultando si hay nuevas publicaciones de strwams*/
setInterval(consultaStreams,1000);
function consultaStreams(){

	$.ajax({
		url: "segundoPlano/consultaStreams.php",
		type: 'post',
		success: function (respuesta) {
			//si la respuesta es 1 afirmando que hubo cambio en la base de datos ejecutara la funcion para mostrar de nuevo los registros de racciones
			if (respuesta == 1) {
				LoadStreams();
			}
			
		}
	});
}

//funcion para cargar la publicacion completa en index
function verPublicacionFull(id,idSesion,idUser){
var valorSend = {
		"idPost" : id,//id de la publicacion
		"idsesion" : idSesion,
		"iduservendedor" : idUser
	}
	$.ajax({
		data: valorSend,
		url: 'segundoPlano/verPublicacion.php',
		type: 'post',
		beforeSend: function () {
			document.getElementById("msjCargando").style.display = "block";
                },
		success: function (respuesta) {
			document.getElementById("msjCargando").style.display = "none";
			document.getElementById("msjEmergente").style.display = "block";
			document.getElementById("delimitadorItem").style.display = "block";
			document.getElementById("delimitadorItem").innerHTML = respuesta;
		}
	});

}
//ocultar mensaje emergente que muestra el item completo
function ocultarItemFull(){
	document.getElementById("msjEmergente").style.display = "none";
	document.getElementById("delimitadorItem").style.display = "none";
}
//javascript para la paguinaa admin
function loadListaPublicacion()
{
	$.ajax({
		url: 'archivos49313/loadListP.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta) {
				document.getElementById('llenarLista').innerHTML = respuesta;
			}
		}
	});
}

function loadStreamsAdmin()
{
	$.ajax({
		url: 'archivos49313/loadStreamsAdmin.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta) {
				document.getElementById('streamsListaByAdmin').innerHTML = respuesta;
			}
		}
	});	
}
function borrarStreams(idBorrar)
{
	var valorstream = {
		"id" : idBorrar //id del stream
	}
	$.ajax({
		data: valorstream,
		url: 'archivos49313/borradoStream.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {
				loadStreamsAdmin();
			}
		}
	});
}
//borrado de publicacion
function desaparecerPubli(idPostAdmin,imagenUrl)
{
	
	var valorPost = {
		"id" : idPostAdmin, //id del stream
		"url" : imagenUrl
	}
	$.ajax({
		data: valorPost,
		url: 'archivos49313/borradoPost.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {
				loadListaPublicacion();
			}
		}
	});
}
//funcion para contar requeria en la cuenta de administraodr
function contadorList(peticionAdmin){
	var peticion = {
		"valor" : peticionAdmin
	}
	$.ajax({
		data: peticion,
		url: 'archivos49313/contador.php',
		type: 'post',
		success: function (respuesta) {
			if (peticionAdmin == 1) {//cargar la cantidad de usuarios por idioma
				document.getElementById("clickIdioma").style.display = "none";
				document.getElementById("PaisesContador").innerHTML = respuesta;
			}
			if (peticionAdmin == 2) {//cargar total de mensajes en buzon
				document.getElementById("clickBuzon").innerHTML = respuesta;
			}
			if (peticionAdmin == 3) {//cargar total de usuarios
				document.getElementById("contadorUsers").innerHTML = respuesta;
			}
		}
	});
}

//envio del mensaje del administrador
function SendmsjAdmin()
{
	//variables
	var tituloMSJAdmin = $('#txttitulomsjAdmin').val();
	var descripcionMSJadmin = $('#txtDescripcionAdmin').val();
	var radiorecibo = $('input[name=rdoQues]:checked').val();

	if (!tituloMSJAdmin || !descripcionMSJadmin) {
		document.getElementById("txttitulomsjAdmin").style.background = "#FFD89F";
        document.getElementById("txtDescripcionAdmin").style.background = "#FFD89F";
	}else{

		var formData = new FormData(document.getElementById("frmAdmin"));
        var files = $('#fileAdminMSJ')[0].files[0];
        formData.append('file',files);
        formData.append('tituloJava',tituloMSJAdmin);
        formData.append('descripcionJava',descripcionMSJadmin);
        formData.append('encuestaStatus',radiorecibo);

        $.ajax({
            url: 'archivos49313/savemsjAdmin.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
            	document.getElementById("GifCargandoAdmin").style.display = "block";
                },
            success: function(response) {
            	document.getElementById("GifCargandoAdmin").style.display = "none";
            	if (response == 1) {//el registro si se guardo
            		document.getElementById("saveNewmsj").style.display = "none";
            		document.getElementById("nuevoMSJAdmin").style.display = "block";
            		$('#txttitulomsjAdmin').val("");
            		$('#txtDescripcionAdmin').val("");
            	}
            	if (response == 2) {//si no se guardo el mensaje
            		$('#txttitulomsjAdmin').val("");
            		$('#txtDescripcionAdmin').val("");
            		document.getElementById("txttitulomsjAdmin").style.background = "#FF9F9F";
            		document.getElementById("txtDescripcionAdmin").style.background = "#FF9F9F";
            	}
            }
        });
	}//del if de campos vacios
	
}//de la funcion
//funcion ejecutandose para comprobar que hay ,emsaje del admin
setInterval(revisarMSJadmin,2000);
function revisarMSJadmin(){
	$.ajax({
		url: 'archivos49313/estatusmsjAdmin.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {//si hay registro nuevo
				document.getElementById("saveNewmsj").style.display = "none";
				document.getElementById("nuevoMSJAdmin").style.display = "block";
			}
			if (respuesta == 2) {
				document.getElementById("nuevoMSJAdmin").style.display = "none";
				document.getElementById("saveNewmsj").style.display = "block";
			}
		}
	});
}
//funcion para borrar msj administrador
function borradoMsjAdmin()
{
	$.ajax({
		url: 'archivos49313/borradoMSJadmin.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {
				//al eliminarse volvemos a cargar la lista de streams
				document.getElementById("nuevoMSJAdmin").style.display = "none";
				document.getElementById("saveNewmsj").style.display = "block";
			}
			if (respuesta == 2) {
				document.getElementById("btnNewMSJ").style.background = "#FF9F9F";
			}
		}
	});
}

//funcion para el nuevo idioma
function NewLanguage()
{
	var formData = new FormData(document.getElementById("frmAdmin"));
    var files = $('#fileAdminIdioma')[0].files[0];
	var nameIdioma = $('#txtIdiomaNuevo').val();
	if (!nameIdioma || !files) {
		document.getElementById("txtIdiomaNuevo").style.background = "#FFD89F";
	}else{
		
        formData.append('file',files);
        formData.append('nombre',nameIdioma);
        $.ajax({
            url: 'archivos49313/newIdioma.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
            	if (response == 1) {
            		document.getElementById("okSave").style.display = "block";
            	}
            	if (response == 2) {
            		document.getElementById("txtIdiomaNuevo").style.background = "red";
            	}
            }
        });
	}
	
}
//funcion para guardar nueva ciudad
function NewCategory()
{
	var formData = new FormData(document.getElementById("frmAdmin"));
    var files = $('#fileAdminCate')[0].files[0];
	var nameCatego = $('#txtCateNuevo').val();
	if (!nameCatego || !files) {
		document.getElementById("txtCateNuevo").style.background = "#FFD89F";
	}else{
		
        formData.append('file',files);
        formData.append('categoria',nameCatego);
        $.ajax({
            url: 'archivos49313/newCategoria.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
            	if (response == 1) {
            		document.getElementById("okSaveCate").style.display = "block";
            	}
            	if (response == 2) {
            		document.getElementById("txtCateNuevo").style.background = "red";
            	}
            }
        });
	}
	
}
function ejecutadorTB()
{
	var codigoTrunque = $("#txtTruncate").val();
	if (codigoTrunque == "/limpiarBD/") {//codigo de acceso
		
		$.ajax({
		url: 'archivos49313/ejecutaTBD.php',
		type: 'post',
		success: function (respuesta) {
			if(respuesta == 1){//si es correcta la sentencia y se ejecuta mostrmaos mensaje OK
				document.getElementById("txtTruncate").style.background = "#CBFF9F";
			$("#okBorrado").slideDown("slow");
			}
			if(respuesta == 2){//error en la sentencia SQL
			document.getElementById("limpiezaTablas").innerHTML = "Error al limpiar tablas: archivos49313/ejecutaTBD.php";
			}
		}
	});

	}else{
		document.getElementById("txtTruncate").style.background = "#FFD89F";
	}
	

}

//funcion para la encuesta
function votarEncuesta(voto)
{
	if (activoUser) {//si hay sesion iniciada podra votar

	var peticionVoto = {
		"voto" : voto,
		"idOn" : activoUser
	}
	$.ajax({
		data: peticionVoto,
		url: 'archivos49313/votosEncuesta.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 4) {//el usuario ya voto
				document.getElementById("encuestaDiv").style.background = "#B07458";
			}
			if (respuesta == 1) {//el usuario voto positivo
				$("#positivo").fadeTo(100, 0.1).fadeTo(200, 1.0);
				cargarAdmin();
			}
			if (respuesta == 2) {//el usuario voto negativo
				$("#negativo").fadeTo(100, 0.1).fadeTo(200, 1.0);
				cargarAdmin();
			}
			//errores en las consultas
			if (respuesta == 6) {
			document.getElementById("negativo").style.background = "#B07458";		
			}
			if (respuesta == 7) {
			document.getElementById("positivo").style.background = "#B07458";		
			}
		}
	});

	}else{//sino hay seison iniciada
		document.getElementById("encuestaDiv").style.background = "#B07458";
	}
}//de la funcion

//funcion para el nuevo menu de votacion y calificaciones
function calificaiconClick(){
	$("#calificarExterno").slideUp("slow");	
	$("#UsuarioCalificacion").slideToggle("slow");
}

//funcion para cargar las estrellas del usuario al pasar el raton
function pasarMousecali(){
	var peticionShowcalifi = {
		"sesionUser" : activoUser
	}
	$.ajax({
		data: peticionShowcalifi,
		url: 'segundoPlano/cargarCalificaciones.php',
		type: 'post',
		success: function (respuesta) {
			
			document.getElementById("nuevaCalificacionImg").style.display = "none";//ocultmaos el punto rjo de calificaciones nuevas
			document.getElementById("subUserCallifi").innerHTML = respuesta;
		}
	});
}

function calificarClick(){
	$("#UsuarioCalificacion").slideUp("slow");
	$("#calificarExterno").slideToggle("slow");	
}
//funcion para calificar usuario
function calificarUser(calificacion,idcalificado)//si la calificacion es 1 es positivo, si es 0 es negativa
{
	if (!idcalificado) {
		document.getElementById("txtCalificar").style.background = "#EEBDA0";
	}else{
		var peticionCalifi = {
		"calificacion" : calificacion,
		"userCalificado" : idcalificado,
		"sesionUser" : activoUser
	}
	$.ajax({
		data: peticionCalifi,
		url: 'segundoPlano/calificacionUser.php',
		type: 'post',
		success: function (respuesta) {
			//3 y 2 guardado exitoso 1 el usuario ya voto

			if (respuesta == 1) {//ya voto
				$("#votacionSeccion").fadeTo(100, 0.1).fadeTo(200, 1.0);
			}
			if (respuesta == 4) {
				document.getElementById("errorVoto").style.display = "none";
				document.getElementById("votoCorrecto").style.display = "block";
				$("#msjCalificacion").slideDown("slow");
				setTimeout(function() {
    					$('#msjCalificacion').slideUp('slow');
    					
					}, 3000);
			}
			if (respuesta == 7) {//el mismo usuario quiere votar por si mismo
				$("#subCalificarEX").fadeTo(100, 0.1).fadeTo(200, 1.0);
			}
			if (respuesta == 9) {//el usuario no existe
				document.getElementById("msjCalificacion").innerHTML = "<label style='font-size:12px;'>El usuario no existe</label><br><label style='font-size:7px;'>Como el amor de ella...</label>";
				$("#msjCalificacion").slideDown("slow");
				setTimeout(function() {
    					$('#msjCalificacion').slideUp("slow");
					}, 4000);
			}
		}
	});
}//del if de comprovacion de cmapo vacio
	
}//dela funcion

//una funcion que se ejecuta cada 3 segundos para comprobar si hay nuevas calificaciones
setInterval(newCalifi,3000);
function newCalifi()
{
	var peticionNewCali = {
		"sesionUser" : activoUser
	}
	$.ajax({
		data: peticionNewCali,
		url: 'segundoPlano/consultaCalificaciones.php',
		type: 'post',
		success: function (respuesta) {
			if (respuesta == 1) {
				//hay nuevos registros asi que marcamos la leyenda de calificaciones con rojo
				document.getElementById("nuevaCalificacionImg").style.display = "inline-block";
			}
		}
	});
}

//funcion para cargar lista de usuario | estrellas | numero de publicaciones
function estrellasTotal(definir)
{
	var peticionEstrellas = {
		"tipoEstrella" : definir
	}
	$.ajax({
		data: peticionEstrellas,
		url: 'archivos49313/estrellasllamado.php',
		type: 'post',
		success: function (respuesta) {
			document.getElementById("ListaUserEstrellas").innerHTML = respuesta;
		}
	});
}