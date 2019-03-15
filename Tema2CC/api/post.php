<?php 
	//Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Request-With');

	include_once '../database.php';
	include_once '../queries.php';

	function checkIfJson($string) {
	 json_decode($string);
	 return (json_last_error() == JSON_ERROR_NONE);
	}

	$database = new Database();
	$db = $database -> connection();	

	$queries = new Queries($db);

	$data = json_decode(file_get_contents("php://input"));
	if(!checkIfJson($data))
	{
		header("HTTP/1.1 415 Unsupported Media Type");
	}else{
		$results = $queries->getMaxId();

		$queries->post($data->nume, $data->prenume, $data->email, $data->facultate);
		$item_id = $results->fetchColumn();
		
		$result = $queries -> getid($item_id+1);
		
		$num = $result -> rowCount();


		if($num > 0) { 
			header("HTTP/1.1 201 OK");
			$results = $result->fetchAll(PDO::FETCH_ASSOC);
			$json = json_encode($results);
			echo $json;
		}else{
			header("HTTP/1.1 500 Internal Server Error");
		}
	}


?>