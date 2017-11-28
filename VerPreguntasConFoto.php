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
		<span><a href='VerPreguntasConFoto.php'>Ver Preguntas</a></spam>
		<span><a href='creditoslogged.html'>Creditos</a></spam>
	</nav>
    <section class="main" id="s1">
    
	<div style="float: left; overflow: scroll; height: 300px; ">
		
		<?php

			//Contectar con la base de datos 

			$link = mysqli_connect("localhost", "id2956012_swg10", "SWG10", "id2956012_quiz");
			if (!$link)
			{
			 echo "Fallo al conectar a MySQL: " . $link->connect_error;
			}

			//Insertar los datos
			$preguntas=mysqli_query($link, "SELECT * FROM preguntas");

			//Error al consultar
			if (!$preguntas)
			 { 	
				die('Error: ' . mysqli_error($link));
				echo "No se ha podido insertar";
			 }

			 //Crear la tabla

			 echo '<table border=1> <tr> <th> Email </th> <th> Enunciado </th><th> RCorrecta </th> <th> RIncorrecta1 </th> <th> RIncorrecta2 </th> <th> RIncorrecta3</th> <th> Complejidad </th> <th> Tema </th><th>Imagen</th>
				</tr>';
				while ($row = mysqli_fetch_array($preguntas)) {
				echo '<tr><td>' . $row["email"] . '</td> <td>' . $row["enunciado"] .'</td> <td>' . $row["correcta"] .'</td> <td>' . $row["incorrecta1"] .'</td> <td>' . $row["incorrecta2"] .'</td> <td>' . $row["incorrecta3"] .'</td> <td>' . $row["complejidad"] .'</td> <td>' . $row["tema"] .'</td>
				 <td>	

				 	
				 	<img style="width:50px;height:50px;float: left; border:2px solid black ; margin-left: 3px" src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>		

				 </td>


				</tr>';
				}
				echo '</table>';



			// Cerrar conexión
			mysqli_close($link);

		?>


	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com/SWG10CI/Lab2A'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>
