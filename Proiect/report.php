<?php 
	if(isset($_POST['cautare']))
	{
		include("database.php");
		DeleteFromTable($_POST['cautare']);
	}

	header('Location: index.php');
?>