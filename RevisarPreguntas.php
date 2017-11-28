<!DOCTYPE html>
<?php
session_start ();

if(!isset($_SESSION['autentificado'])){
	header ("Location: layout.html");
}

if(!isset($_SESSION['profesor'])){
	header ("Location: layout.html");
}

if($_SESSION['profesor']=="NO"){
	header ("Location: layout.html");
}


?>
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

      		<span class="right"><a href="logout.php">Logout</a></span>

		<h2>Quiz: el juego de las preguntas</h2>

    </header>

	<nav class='main' id='n1' role='navigation'>

		<span><a href='layoutlogged.html'>Inicio</a></spam>



		<span><a href='creditoslogged.html'>Creditos</a></spam>

	</nav>

    <section class="main" id="s1">

    

	<div style="float: left; overflow: scroll; height: 300px; ">

		

		<?php



			//Contectar con la base de datos 



			$link = mysqli_connect("localhost", "root", "", "quiz");

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



			 echo '<table class = "hoverTable" id="tPreguntas" border=1> 
			 	 <tr>
			 	 <th> ID </th>
			 	 <th> Email </th>
			 	 <th> Enunciado </th>
			 	 <th> RCorrecta </th>
			 	 <th> RIncorrecta1 </th>
			 	 <th> RIncorrecta2 </th>
			 	 <th> RIncorrecta3</th>
			 	 <th> Complejidad </th>
			 	 <th> Tema </th>
				 </tr>';

				 $i = 1;

				while ($row = mysqli_fetch_array($preguntas)) {

				echo '<tr onclick = "editarPregunta(' . $i . ')">
					 <td>' . $row["id"] . '</td>
					 <td>' . $row["email"] . '</td>
					 <td>' . $row["enunciado"] .'</td>
					 <td>' . $row["correcta"] .'</td> 
					 <td>' . $row["incorrecta1"] .'</td>
					 <td>' . $row["incorrecta2"] .'</td>
					 <td>' . $row["incorrecta3"] .'</td>
					 <td>' . $row["complejidad"] .'</td>
					 <td>' . $row["tema"] .'</td>

				</tr>';
				$i = $i + 1;
				}
				echo '</table>';











			// Cerrar conexión

			mysqli_close($link);



		?>





	</div>
	<br><br>


		<div  style="margin: 1%">

				<fieldset style="border: 1px solid black">
				<legend style="border: 1px solid black ;margin:15px;padding: 0.5%">Editar Pregunta</legend>

			<form enctype="multipart/form-data" onreset="rmvImg()" style="float: left" id='fpreguntas' name='fpreguntas' action=pregunta.php? method="post">

				<table>	

					<tr>
						<td>
						<span>ID: </span>
				   		</td>
				   		<td>
				   			<input disabled type="text"  id="id" name="id">
				   		</td>
					</tr>
					
					<tr>
						<td>
						<span>Email*: </span>
				   		</td>
				   		<td>
				   			<input disabled type="text"  id="mail" name="mail">
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







	<script>


	function enviarPregunta(){
		var s =$("#fpreguntas").serialize() + "&id=" + $("#id").val() + "&mail=" + $("#mail").val();
		alert(s);
		$.ajax({
		    type: "post",
		    url: "updatePregunta.php",
		    data: s,
		    success: function( response ) {
        		alert( response );
      		}
    }
		    
		);
	}







		function editarPregunta(index) {
			var table =  document.getElementById("tPreguntas");

			$("#id").val(table.rows[index].cells[0].innerHTML);
			$("#mail").val(table.rows[index].cells[1].innerHTML);
			$("#enunciado").val(table.rows[index].cells[2].innerHTML);
			$("#Rcor").val(table.rows[index].cells[3].innerHTML);
			$("#RIncor1").val(table.rows[index].cells[4].innerHTML);
			$("#RIncor2").val(table.rows[index].cells[5].innerHTML);
			$("#RIncor3").val(table.rows[index].cells[6].innerHTML);
			$("#complej").val(table.rows[index].cells[7].innerHTML);
			$("#tema").val(table.rows[index].cells[8].innerHTML);
			

    	}
	</script>




    </section>

	<footer class='main' id='f1'>

		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>

		<a href='https://github.com/SWG10CI/Lab2A'>Link GITHUB</a>

	</footer>

</div>

</body>

</html>

