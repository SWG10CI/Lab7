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

								$link = mysqli_connect("localhost", "id2956012_swg10", "SWG10", "id2956012_quiz");
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

								



								$sql= "INSERT INTO preguntas(email, enunciado,correcta,incorrecta1,incorrecta2,incorrecta3,complejidad,tema,img) VALUES ('$_POST[mail]','$_POST[enunciado]','$_POST[Rcor]','$_POST[RIncor1]','$_POST[RIncor2]','$_POST[RIncor3]',$_POST[complej],'$_POST[tema]', '$pic')";

								//Error al insertar
								if (!mysqli_query($link ,$sql))
								 { 	
									die('Error: ' . mysqli_error($link));
									echo "No se ha podido insertar";
								 }


								 echo 'Se ha guardado la pregunta correctamente en la BD <br> <br>';

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

						 		
						        echo'Se ha añadido la pregunta al xml correctamente';


        						
							}


				}
				

		?>