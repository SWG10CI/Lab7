<?php

	
			$preguntas = simplexml_load_file('preguntas.xml');
			$count = $preguntas->children()->count();
			echo $count;
?>			