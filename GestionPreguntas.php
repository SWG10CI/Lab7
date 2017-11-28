<!DOCTYPE html>
<?php
session_start ();
if(!isset($_SESSION['autentificado'])){
	header ("Location: layout.html");
}


?>

<html>
  <head>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Gestión Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide2.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
      		<span class="right"><a href="logout.php">Logout</a></span>
    
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layoutlogged.html'>Inicio</a></spam>
		<span><a href='creditoslogged.html'>Creditos</a></spam>
	</nav>
    <section class="main" id="s1">
    
	

		
			

		<div style="margin: 1%;">
			<fieldset style="border: 1px solid black">
				<legend style="border: 1px solid black ;margin:15px;padding: 0.5%">Usuarios conectados</legend>

				<span id = "uConectados"></span>

			</fieldset>
		</div>

		<div style="margin: 1%">
			<fieldset style="border: 1px solid black">
				<legend style="border: 1px solid black ;margin:15px;padding: 0.5%">Estadísticas</legend>
				<table>
					<th>Tus Preguntas</th>
					<th>Total de Preguntas</th>
					<tr>
						<td id ="tusPreg"></td>
						<td id ="totPreg"></td>
					</tr>
				</table>

			</fieldset>
		</div>



		<div  style="margin: 1%">

				<fieldset style="border: 1px solid black">
				<legend style="border: 1px solid black ;margin:15px;padding: 0.5%">Formulario</legend>

			<form enctype="multipart/form-data" onreset="rmvImg()" style="float: left" id='fpreguntas' name='fpreguntas' action=pregunta.php? method="post">

				<table>	
					
					<tr>
						<td>
						<span>Email*: </span>
				   		</td>
				   		<td>
				   			<input type="text"  id="mail" name="mail">
				   		</td>
					</tr>
					<tr>
						<td>
						<span>Enunciado*: </span>
						</td>
						<td>
						<input type="text" id=enunciado name="enunciado">
						</td>
					</tr>
					<tr>
						<td><span>Repuesta Correcta*: </span></td>
						<td><input type="text" id="Rcor"  name="Rcor"></td>
					</tr>
					<tr>
						<td><span>Repuesta Incorrecta 1*: </span></td>
						<td><input type="text" id="RIncor1" name="RIncor1">	</td>
					</tr>	
					
					<tr>
						<td><span>Repuesta Incorrecta 2*: </span></td>
						<td><input type="text" id="RIncor2" name="RIncor2"></td>		
					</tr>

					<tr>
						<td><span>Repuesta Incorrecta 3*: </span></td>
						<td><input type="text" id="RIncor3" name="RIncor3"></td>
					</tr>

					<tr>
						<td><span>Complejidad (1-5)*: </span></td>
						<td><input type="text" id="complej" name="complej"></td>
					</tr>

					<tr>
						<td><span>Tema de la pregunta*: </span></td>
						<td><input type="text"  id ="tema" name="tema"></td>
					</tr>

				</table>

				<br>

					<input onclick="enviarPregunta()" style="margin-top: 20px" id="submit" type="button" value="Enviar Pregunta"></td>
					<input style="margin-top: 20px" id="rst" type="reset" value="Borrar campos e imagen"></td>

			</form>


			<div id = formResponse></div>


	</fieldset>
			</div>


	<div id = tpreg style="margin: 1%">
	</div>


    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com/SWG10CI/Lab4'>Link GITHUB</a>
	</footer>
</div>


<script>

	conectarse();

	setInterval(obtenerPreguntas, 1000);
	setInterval(mostrarTotal, 1000);
	setInterval(mostrarTuyas, 1000);
	setInterval(mostrarUsuarios, 1000);
	httpRSet= new XMLHttpRequest();

	httpRSet.onreadystatechange = function()
	 {
		if (httpRSet.readyState==4)
			{
				document.getElementById("formResponse").innerHTML=httpRSet.responseText;
			}
	};

	httpRGet = new XMLHttpRequest();

	httpRGet.onreadystatechange = function()
	 {
		if (httpRGet.readyState==4)
			{

				document.getElementById("tpreg").innerHTML=httpRGet.responseText;
			}
	};

	function obtenerPreguntas()
	{
	 httpRGet.open("GET","getPreguntas.php");
	 httpRGet.send(null);
	} 

	function enviarPregunta(){
		httpRSet.open("POST","addPregunta.php",true);
			 var s =$("form").serialize();
			 httpRSet.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	 		 httpRSet.send(s);
	}

	function mostrarTotal(){
		$.ajax({
		 url: 'ContarPreguntas.php',
		 success:function(datos){
		 $('#totPreg').html(datos);}
		 }
		);
	}

	function mostrarTuyas(){

		var url_string = window.location.href;
		var url = new URL(url_string);
		var elem = url.searchParams.get("mail");
		$.ajax({
		 url: 'ContarTusPreguntas.php?mail='+ elem,
		 success:function(datos){
		 $('#tusPreg').html(datos);}
		 }
		);
	}


	function mostrarUsuarios(){

		$.ajax({
		 url: 'contador.php',
		 success:function(datos){
		 $('#uConectados').html(datos);}
		 }
		);


	}


	function conectarse(){

		$.ajax({
		 url: 'contador.php?op=1',
		 success:function(datos){
		 $('#uConectados').html(datos);}
		 }
		);


	}

	function desconectarse(){

		$.ajax({
		 url: 'contador.php?op=0',
		 success:function(datos){
		 $('#uConectados').html(datos);}
		 }
		);


	}







</script>


</body>
</html>
