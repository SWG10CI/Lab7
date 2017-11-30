<?php
			
			$preguntas = simplexml_load_file('preguntas.xml');
			$count=0;

			if(!isset($_GET["mail"]))
				echo "MAL";

			else

			{

			foreach ($preguntas->children() as $pregunta){
				if(($pregunta->attributes()->author)==$_GET["mail"]){
					$count =$count+1;
				}		
			}

			echo $count;

		}
?>			