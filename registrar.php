<!DOCTYPE html>
<html>
  <head>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Registro</title>
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
		<span class="right"><a href="registrar.php">Registrarse</a></span>
      		<span class="right"><a href="login.php">Login</a></span>
      		<span class="right" style="display:none;"><a href="/logout">Logout</a></span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layout.html'>Inicio</a></spam>
		<span><a href='creditos.html'>Creditos</a></spam>
	</nav>
    <section class="main" id="s1">
    
	<div>

		<form enctype="multipart/form-data" style="float: left" id='fregistro' name='fregistro' action=registrar.php method="post">

			<table>	
				
				<tr>
					<td>
					<span>Email*: </span>
			   		</td>
			   		<td><input autocomplete="false" onkeyup="checkVIP()" type="text" id="mail" name="mail"></td>


				</tr>
				<tr>
					<td>
					<span>Nombre y Apellidos*: </span>
					</td>
					<td>
					<input type="text" id="nom" name="nom">
					</td>
				</tr>
				<tr>
					<td><span>Nick*: </span></td>
					<td><input type="text" id="nick"  name="nick"></td>
				</tr>
				<tr>
					<td><span>Password*: </span></td>
					<td><input type="password" id="pass" name="pass">	</td>
				</tr>	
				
				<tr>
					<td><span>Repetir Password*: </span></td>
					<td><input type="password" id="pass2" name="pass2"></td>		
				</tr>


			</table>
			<div id="res" style=" color: white ;border-radius: 5px;background-color: #67809F; width : 25%"></div>
			<div id="res2" style=" color: white ;border-radius: 5px;background-color: #67809F; width : 25%"></div>
			<br>

				<span id="hldr"></span>
				<input id="fileChos" type="file" name="img" accept="image/*"  onchange="showImg(this)">
				<br>
				<input  style="margin-top: 20px" id="submit" type="submit" value="Enviar"></td>
				<input style="margin-top: 20px" id="rst" type="reset" value="Borrar campos e imagen"></td>

		</form>


		




		<?php

				require_once($_SERVER['DOCUMENT_ROOT'] .'/Lab5/lib/nusoap.php');
				require_once($_SERVER['DOCUMENT_ROOT'] .'/Lab5/lib/class.wsdlcache.php');


                if(isset($_POST['mail'],$_POST['nom'], $_POST['nick'], $_POST['pass'])){


                				$soapclient = new nusoap_client( 'https://iv27c.000webhostapp.com/Lab5/ComprobarContrasena.php?wsdl',true);
								$result = $soapclient->call('comprobar',array( 'x'=>$_POST['pass']));

								
								

								if($result=='VALIDA'){

											
		                                //Contectar con la base de datos 

		                                $link = mysqli_connect("localhost", "id2956012_swg10", "SWG10", "id2956012_quiz");
		                                if (!$link)
		                                {
		                                 echo "Fallo al conectar a MySQL: " . $link->connect_error;
		                                }


		                                //Insertar los datos

		                                if ($_FILES['img']['size'] == 0 ){
		                                    $pic = addslashes(file_get_contents("img/imgPrev.png"));
		                                }
		                                else{
		                                    $pic = addslashes(file_get_contents($_FILES['img']['tmp_name']));
		                                }

		                                $hashed_password = crypt($_POST['pass'],"SWG10");


		                                $sql= "INSERT INTO usuario(mail, nom, nick, pass, rol, img) VALUES ('$_POST[mail]','$_POST[nom]','$_POST[nick]','$hashed_password','alumno', '$pic')";

		                                //Error al insertar
		                                if (!mysqli_query($link ,$sql))
		                                 {
		                                 	echo "No se ha podido insertar";
		                                    die('Error: ' . mysqli_error($link));
		                                    
		                                 }
		                                 else{

		                                 	echo("Registro completado correctamente");

		                                 }

		                                // Cerrar conexión
		                                mysqli_close($link);

                                }
                                else{
                            		echo('<script>
											$("#res2").html("La contraseña no es valida");

										</script>'
								);


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

	var VIP= false;

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


	$(document).ready(function() {
			 $('#submit').click(function(){


			if ($("#mail").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#nom").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#nick").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#pass").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}
			if ($("#pass2").val() == ""){
				alert("No se permiten campos vacios");
				return false;
			}		

			var ok = $("#mail").val().match(/^([a-zA-Z])+([0-9]{3})+(@ikasle.ehu.)+(es|eus)$/);
			
			if(!(ok)){
				alert("El correo introducido no tiene la estructura adecuada");
				return false;
			}

			if ($("#pass").val().length<6 ){
				alert("El Password tiene que tener al menos 6 caracteres");
				return false;
			}

			
			if(($("#pass").val()) != ($("#pass2").val())){
				alert("Los Passwords introducidos son diferentes");
				return false;
			}

			
			var ok = $("#nick").val().match(/^([A-Za-z0-9áéíóúÁÉÍÓÚ]{1,})$/);

			if(!(ok)){
				alert("El Nick es solo una palabra");
				return false;
			}


			var ok = $("#nom").val().match(/^([a-zA-ZáéíóúÁÉÍÓÚ])+((([ ])+([a-zA-ZáéíóúÁÉÍÓÚ]{1,})){1,})$/);
			if(!(ok)){
				alert("Nombre y Apellido");
				return false;
			}

			if(VIP)
				return true;
			else{
				alert("El mail no esta matriculado")
				return false;
			}

			});


		});




	function checkVIP(){

		var mail= $("#mail").val();

		$.ajax({
		 url: 'checkVIP.php?mail='+ mail ,
		 success:function(datos){
		 

		 if(datos=="SI"){
		 	 $("#mail").css({"color" : "green"});
		 	 $("#res").html("El mail esta matriculado");
		 	 VIP=true;
		 }
		 else{
		 	 $("#mail").css({"color" : "red"});
		 	 $("#res").html("El mail no esta matriculado");
		 	 VIF=false;
		 }
		
		}


		 }
		);


	}





</script>


</body>
</html>
