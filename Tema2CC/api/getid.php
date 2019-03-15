<?php 
	//Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../database.php';
	include_once '../queries.php';

	$database = new Database();
	$db = $database -> connection();	

	$queries = new Queries($db);

	$id = $_GET['id'];
	if(isset($id))
		$result = $queries -> getid($id);
	
	$num = $result -> rowCount();

	if($num > 0) { 
		$results = $result->fetchAll(PDO::FETCH_ASSOC);
		$json = json_encode($results);
		echo $json;
	}else{
		header("HTTP/1.0 404 Not Found");
		echo "404 Not Found";
	}
?>