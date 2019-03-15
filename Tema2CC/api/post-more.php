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

	
	if(!checkIfJson(file_get_contents("php://input")))
	{
		header("HTTP/1.1 415 Unsupported Media Type");
	}else{		
		$data = json_decode(file_get_contents("php://input"));

		if(count($data) >= 1)
		{
			$nrInserts = 0;
			$nrPosts = 0;
			foreach($data as $student){
				$nrPosts++;
				$nrInserts +=  $queries->post($student->nume, $student->prenume, $student->email, $student->facultate);

			}
			
			if($nrPosts == $nrInserts)
			{
				header("HTTP/1.1 201 OK");
			}
		}else{
			header("HTTP/1.1 400 Bad Request");
		}
	}
	
?>