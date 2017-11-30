<?php
			



			if(isset($_POST['mail'],$_POST['pass'])){

				session_start();

					if(!isset($_SESSION[$_POST['mail']]["bloqueado"])){
						$_SESSION[$_POST['mail']]["bloqueado"]="NO";
					}




				if($_SESSION[$_POST['mail']]["bloqueado"]=="SI"){
					echo'Numero de intentos superado';

				}

				else{


						//Contectar con la base de datos 

						$link = mysqli_connect("localhost", "id2956012_swg10", "SWG10", "id2956012_quiz");
						if (!$link)
						{
						 echo "Fallo al conectar a MySQL: " . $link->connect_error;
						}


						$sql= "SELECT pass,img,rol FROM usuario WHERE mail='".$_POST['mail']."'";






						//Ejecutar consulta
						$usuario=mysqli_query($link,$sql);

						if (mysqli_num_rows($usuario)==0) 
							{ 
								echo "El correo no esta registrado";
							}


						while ($fila = mysqli_fetch_array($usuario)) {

								$try=crypt($_POST['pass'],"SWG10");

		    				if(hash_equals($fila["pass"] , $try)){
		    					
		    					$_SESSION["autentificado"]= "SI";

		    					if($fila["rol"]=="profesor"){
		    						$_SESSION["profesor"]= "SI";
		    						header ("Location: RevisarPreguntas.php");
		    					}
		    					else{
		    						$_SESSION["profesor"]= "NO";
		    						header ("Location: GestionPreguntas.php");
		    						
		    					}
		    				}
		    				else{
		    					
		    					if(!isset($_SESSION[$_POST['mail']]["intentos"])){
		    						$_SESSION[$_POST['mail']]["intentos"]= 0;
		    					}

		    					$intentos=(int)$_SESSION[$_POST['mail']]["intentos"];
		    					$intentos++;
		    					$_SESSION[$_POST['mail']]["intentos"]= $intentos;
		    					if($intentos==3){
		    						$_SESSION[$_POST['mail']]["bloqueado"]="SI";
		    					}

		    					echo'La contraseña o el correo son incorrectos (intentos : ' . $intentos .  ' )';
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

			echo "<br>";
			echo '<a href="login.php">Volver</a>';
		}


		?>
