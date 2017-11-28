<!DOCTYPE html>
<html>
  <head>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
      		<span class="right"><a href="layout.html">Logout</a></span>
      		<span class="right" style="display:none;"><a href="/logout">Logout</a></span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layoutlogged.html'>Inicio</a></spam>
		<span><a href='pregunta.php'>Preguntas</a></spam>
		<span><a href='VerPreguntasConFoto.php'>Ver Preguntas </a></spam>
		<span><a href='creditoslogged.html'>Creditos</a></spam>
	</nav>
    <section class="main" id="s1">
    
	<div>

		<form enctype="multipart/form-data" onreset="rmvImg()" style="float: left" id='fpreguntas' name='fpreguntas' action=pregunta.php? method="post">

			<table>	
				
				<tr>
					<td>
					<span>Email*: </span>
			   		</td>
			   		<td>

			   			<input type="text"  id="mail" name="mail" value ="<?php 

			   				if(isset($_GET["mail"])){

			   							echo(str_replace(' ', '', $_GET["mail"]));
			   							


			   				}			

			   			


			   			?>">


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



				<span id="hldr"></span>
				<input id="fileChos" type="file" name="pic" accept="image/*"  onchange="showImg(this)">
				<br>
				<input  style="margin-top: 20px" id="submit" type="submit" value="Enviar Pregunta"></td>
				<input style="margin-top: 20px" id="rst" type="reset" value="Borrar campos e imagen"></td>

		</form>


		<?php

				if(isset($_POST['mail'],$_POST['enunciado'], $_POST['Rcor'], $_POST['RIncor1'], $_POST['RIncor2'], $_POST['RIncor3'], $_POST['complej'], $_POST['tema'])){


					//Validacion del servidor

						$erMail = '/^([a-zA-Z])+([0-9]{3})+(@ikasle.ehu.)+(es|eus)$/';
						$erComplej = '/^([1-5])$/';


						if($_POST['mail']=="" || $_POST['enunciado']=="" || $_POST['Rcor']==""|| $_POST['RIncor1']==""|| $_POST['RIncor2']==""|| $_POST['RIncor3']==""|| $_POST['complej']=="" || $_POST['tema']=="")

							
							echo '<span style = "padding:5px" > No se permiten campos vacios </span>';



						elseif (!preg_match($erMail, $_POST['mail'])) {
								
							echo '<span style = "padding:5px" > El correo introducido no tiene la estructura adecuada </span>';
						}
						
						elseif (!preg_match($erComplej, $_POST['complej'])) {
							echo '<span style = "padding:5px" > La complejidad debe ser un número entre 1 y 5 </span>';
						}

						elseif (strlen($_POST['enunciado'])<10) {
							echo '<span style = "padding:5px" > El enunciado debe contener al menos 10 caracteres </span>';
						}


						else{

								//Contectar con la base de datos 

								$link = mysqli_connect("localhost", "root", "", "quiz");
								if (!$link)
								{
								 echo "Fallo al conectar a MySQL: " . $link->connect_error;
								}

								//Insertar los datos



								if ($_FILES['pic']['size'] == 0 ){
									$pic = addslashes(file_get_contents("img/imgPrev.png"));	
								}			
								else{
									$pic = addslashes(file_get_contents($_FILES['pic']['tmp_name']));
								}

								



								$sql= "INSERT INTO preguntas(email, enunciado,correcta,incorrecta1,incorrecta2,incorrecta3,complejidad,tema,img) VALUES ('$_POST[mail]','$_POST[enunciado]','$_POST[Rcor]','$_POST[RIncor1]','$_POST[RIncor2]','$_POST[RIncor3]',$_POST[complej],'$_POST[tema]', '$pic')";

								//Error al insertar
								if (!mysqli_query($link ,$sql))
								 { 	
									die('Error: ' . mysqli_error($link));
									echo "No se ha podido insertar";
								 }


								 echo 'Se ha guardado la pregunta correctamente en la BD <br><br><a href="VerPreguntasConFoto.php">Ver todas las preguntas</a> <br> <br>';

								// Cerrar conexión
								mysqli_close($link);



								//Insertar en preguntas.xml

								$preguntas = simplexml_load_file('preguntas.xml');

								if ($preguntas === false) {
								    echo "Error cargando XML\n";
								    foreach(libxml_get_errors() as $error) {
								        echo "\t", $error->message;
								    }

								}

 
						        $nuevaP = $preguntas->addChild('assessmentItem');
						 
						        $nuevaP->addAttribute('complexity', $_POST['complej']);
						        $nuevaP->addAttribute('subject', $_POST['tema']);
						        $nuevaP->addAttribute('author', $_POST['mail']);
						 
						        $body=$nuevaP->addChild('itemBody');
						 		$body->addChild('p',$_POST['enunciado']);
						        $correcta = $nuevaP->addChild('correctResponse');
						        $correcta->addChild('value', $_POST['Rcor']);
						 
						        $Rincor = $nuevaP->addChild('incorrectResponses');
						 
						        $Rincor->addChild('value', $_POST['RIncor1']);
						        $Rincor->addChild('value', $_POST['RIncor2']);
						        $Rincor->addChild('value', $_POST['RIncor3']);

 								$preguntas->asXML('preguntas.xml');

						 		
						        echo'Se ha añadido la pregunta al xml correctamente<br><br>
						        	 <a href= VerPreguntasXML.php>Ver Preguntas.xml</a><br><br>';

						       echo'<a href= VerPreguntasXLS.php>Ver Transformacion(Opcional 1)</a>';	 

        						
							}


				}

		?>







	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com/SWG10CI/Lab2A'>Link GITHUB</a>
	</footer>
</div>


<script>

	function rmvImg(){
			$('#imgPrev').remove();	   						
	}


	function showImg(input){

		rmvImg();
		$('#hldr').append('<img id="imgPrev" src="img/imgPrev.png" style="width:150px;height:150px;float: left; border:2px solid black ;margin-right:30px ">');
		var reader = new FileReader();
		reader.onload = function (e) {
            $('#imgPrev').attr('src', e.target.result);
        }
		reader.readAsDataURL(input.files[0]);

	}


	/*$(document).ready(function() {
			 $('#submit').click(function(){

			if ($("#enunciado").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#mail").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#Rcor").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#RIncor1").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#RIncor2").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#RIncor3").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#complej").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#tema").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}

			var ok = $("#mail").val().match(/^([a-zA-Z])+([0-9]{3})+(@ikasle.ehu.)+(es|eus)$/);
			
			if(!(ok)){
				alert("El correo introducido no tiene la estructura adecuada");
				return false;
			}

			var ok = $("#complej").val().match(/^([1-5])$/);

			if(!(ok)){
				alert("La complejidad debe ser un número entre 1 y 5");
				return false;
			}	

				
			if ($("#enunciado").val().length<10 ){
				alert("El enunciado debe contener al menos 10 caracteres");
				return false;	
			}

			return true;

			});
		});*/



</script>







</body>
</html>
