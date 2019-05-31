<html>
	<head>
		<title>Proiect | Cautari recente</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class = "content-full">
			<?php 
				include("header.php");
				include("database.php");
				SelectFromDatabase();
			?>
		</div>
	</body>
</html>