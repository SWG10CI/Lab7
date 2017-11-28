<!DOCTYPE html>
<?php
session_start ();
header('Content-type: text/html; charset=utf-8');
?>
<html>
  <head>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Login</title>
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

		<form enctype="multipart/form-data" style="float: left" id='flogin' name='flogin' action=login.php method="post">

			<table>	
				
				<tr>
					<td>
					<span>Email*: </span>
			   		</td>
			   		<td><input type="text" id="mail" name="mail"></td>

				</tr>
				<tr>
					<td><span>Password*: </span></td>
					<td><input type="password" id="pass" name="pass">	</td>
				</tr>	

			</table>

			<br>

				<input style="margin-top: 20px" id="submit" type="submit" value="Iniciar sesión"></td>
				<input style="margin-top: 20px" id="rst" type="reset" value="Borrar campos"></td>

		</form>


		<?php


			if(isset($_POST['mail'],$_POST['pass'])){

				//Contectar con la base de datos 

				$link = mysqli_connect("localhost", "id2956012_swg10", "SWG10", "id2956012_quiz");
				if (!$link)
				{
				 echo "Fallo al conectar a MySQL: " . $link->connect_error;
				}


				$sql= "SELECT pass,img,rol FROM usuario WHERE mail='".$_POST['mail']."'";


				//Ejecutar consulta
				$usuario=mysqli_query($link,$sql);

				while ($fila = mysqli_fetch_array($usuario)) {

						$try=crypt($_POST['pass']);
						echo $try;
						echo"<br>";
    					echo $fila["pass"];

    				if(hash_equals($fila["pass"] , $try)){
    					echo $try;
    					echo $fila["pass"];
    					session_start();
    					$_SESSION["autentificado"]= "SI";

    					if($fila["rol"]=="profesor"){
    						$_SESSION["profesor"]= "SI";
    						header ("Location: RevisarPreguntas.php");
    					}
    					else{
    						$_SESSION["profesor"]= "NO";
    						header ("Location: GestionPreguntas.php");
    						
    					}








    					
    					echo'Te has logeado correctamente <br>';
    					echo'Puedes <a href="GestionPreguntas.php?mail='. $_POST['mail'] . '">Gestionar Preguntas
    					</a>';

    					echo'<img style="width:50px;height:50px;float: left; border:2px solid black ; margin-left: 3px" src="data:image/jpeg;base64,'.base64_encode( $fila['img'] ).'"/>';

    					break;
    				}
    				else{
    					echo'La contraseña o el correo son incorrectos';
    					break;
    				}
				}


				//Error al consultar
				if (!$usuario)
				 { 	
					die('Error: ' . mysqli_error($link));
					echo "No se ha podido insertar";
				 }

				 

				// Cerrar conexión
				mysqli_close($link);
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

</script>


</body>
</html>
