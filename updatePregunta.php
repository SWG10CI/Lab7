<?php
				

				if(isset($_POST['id'], $_POST['mail'],$_POST['enunciado'], $_POST['Rcor'], $_POST['RIncor1'], $_POST['RIncor2'], $_POST['RIncor3'], $_POST['complej'], $_POST['tema'])){

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



								//if ($_FILES['pic']['size'] == 0 ){
									$pic = addslashes(file_get_contents("img/imgPrev.png"));	
								//}			
							//	else{
								//	$pic = addslashes(file_get_contents($_FILES['pic']['tmp_name']));
						//		}

								



								


								$sql="UPDATE preguntas SET 
								email='$_POST[mail]',
								enunciado='$_POST[enunciado]',
								correcta='$_POST[Rcor]',
								incorrecta1='$_POST[RIncor1]',
								incorrecta2='$_POST[RIncor2]',
								incorrecta3='$_POST[RIncor3]',
								complejidad='$_POST[complej]',
								tema='$_POST[tema]'
								WHERE id='$_POST[id]'";

								//Error al insertar
								if (!mysqli_query($link ,$sql))
								 { 	
									die('Error: ' . mysqli_error($link));
									echo "No se ha podido insertar";
								 }


								 echo 'Se ha actualizado la pregunta correctamente en la BD';

								// Cerrar conexión
								mysqli_close($link);



								


        						
							}


				}
				

		?>