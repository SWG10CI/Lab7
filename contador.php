<?php	
				header("Cache-Control: no-store, no-cache, must-revalidate");
				$xml = simplexml_load_file('contador.xml');

				$cont = $xml->children()[0];


				if (isset($_GET["op"])) {
				

					if($_GET["op"]==0){
						$xml->contador=$xml->contador -1;
						$xml->asXML('contador.xml');
						
					}
					if($_GET["op"]==1){
						$xml->contador=$xml->contador +1;
						$xml->asXML('contador.xml');
				
					}

				}
				echo $xml->asXML();
				

?>			