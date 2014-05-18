<?php

require_once(dirname(__FILE__) . '/../core/importer.php');

function handleImport() {
	
	if(!isset($POST['Submit'])) {
		//throw new exception("Upload file too large");
	}
	
	if ($_FILES['file']['error'] > 0) {
		throw new exception("Could not upload file");
	}
	else {
	    return import($_FILES['file']['tmp_name']);
	}
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>ZeeJong Importer</title>

		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="pure-min.css" rel="stylesheet" type="text/css">
	</head>

	<body>

	<div class="container">
	<h2>Install ZeeJong - Importer</h2>
	<?php
		if(isset($_GET['process'])) {
			try {
				$data = handleImport();
				echo '<p class="notice ok">Successfully imported data!</p>';
			
				echo '<table class="pure-table pure-table-striped"><thead><tr><th>Dataset</th><th>Items</th></tr></thead><tbody>';
				foreach ($data as $table => $count) {
					echo "<tr><td>$table</td><td>$count</td></tr>";
				}
				echo '</tbody></table>';
				
				echo '<p><a href="' . SITE_URL . '" class="pure-button pure-button-primary">View site</a></p>';
				
				
			} catch(Exception $e) {
				echo '<p class="notice error">' . $e->getMessage() .  '</p>';
				include 'importer.tpl.php';
			}
		}
		else {
			include 'importer.tpl.php';
		}
	?>
	</div>

	</body>
</html>
