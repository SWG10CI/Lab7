
<!DOCTYPE html>
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

		<form enctype="multipart/form-data" style="float: left" id='flogin' name='flogin' action=makeLogin.php method="post">

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
