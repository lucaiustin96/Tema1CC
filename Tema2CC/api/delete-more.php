<?php 
	//Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
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

	if(!checkIfJson(file_get_contents("php://input")))
	{
		header("HTTP/1.1 415 Unsupported Media Type");
	}else{
		$data = json_decode(file_get_contents("php://input"));

		foreach($data as $idStud){
			$queries->delete($idStud->id);
		}
	}
?>