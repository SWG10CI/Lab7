<?php

			$preguntas = simplexml_load_file('preguntas.xml');


			echo'<fieldset style="border: 1px solid black">
			<legend style="border: 1px solid black ;margin:15px;padding: 0.5%">Preguntas</legend>'
			;


			echo '<table border=1> <tr> <th> Enunciado </th><th> Complejidad </th> <th> Tema </th>
				</tr>';

			foreach ($preguntas->children() as $pregunta){

				echo '<tr>';
				echo	'<td>' . $pregunta->itemBody->p . '</td>' ;
				echo	'<td>' . $pregunta->attributes()->complexity . '</td>' ;
				echo	'<td>' . $pregunta->attributes()->subject . '</td>' ;
			echo '</tr>';

			}


			echo '</fieldset>';


		?>