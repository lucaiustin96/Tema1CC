<?php
//include("TTSService.php");

// $Name = 'Dan';
// $Gender = 'male';
// $Age = 40;
// $anger = 0.1;
// $contempt = 0.1;
// $disgust = 0.1;
// $fear = 0.1;
// $happiness = 0.2;
// $neutral = 0.4;
// $sadness = 0.2;
// $surprise = 0.1;

function InsertIntoDatabase($Name, $Gender, $Age, $anger, $contempt, $disgust, $fear, $happiness, $neutral, $sadness, $surprise)
{
	$host = 'servertema4.mysql.database.azure.com';
	$username = 'lucaiustin96@servertema4';
	$password = 'parolaluca123iustin-123';
	$db_name = 'sampledb';

	$conn = mysqli_init();
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
	if (mysqli_connect_errno($conn)) {
	die('Failed to connect to MySQL: '.mysqli_connect_error());
	}
	
	$sql = "INSERT INTO People (Name, Gender, Age, anger, contempt, disgust, fear, happiness, neutral, sadness, surprise) VALUES ('". $Name . "', '" . $Gender. "', " .$Age. ", " . $anger. ", ".$contempt.", ".$disgust.", ".$fear.", ".$happiness.", ".$neutral.", ".$sadness.", ".$surprise.")";

	//$sql = "CREATE TABLE recent_searches ('Id' INT NOT NULL AUTO_INCREMENT, 'Name' VARCHAR(200) NOT NULL, 'NumberOfSearches' Int NOT NULL, 'NumberOfReports' Int NOT NULL";

	if ($stmt = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	// Close the connection
	mysqli_close($conn);
}

function InsertRecentSearches($Name)
{
	$host = 'servertema4.mysql.database.azure.com';
	$username = 'lucaiustin96@servertema4';
	$password = 'parolaluca123iustin-123';
	$db_name = 'sampledb';

	$conn = mysqli_init();
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
	if (mysqli_connect_errno($conn)) {
	die('Failed to connect to MySQL: '.mysqli_connect_error());
	}
	
	$res = mysqli_query($conn, "SELECT NumberOfSearches FROM recent_searches WHERE Name = '" . $Name . "'");
	if($row = mysqli_fetch_assoc($res)) {
		$nrSearches = (int)$row["NumberOfSearches"];
		$nrSearches++;
		//$sql = "INSERT INTO recent_searches (Name, NumberOfSearches, NumberOfReports) VALUES ('". $Name . "', ". $nrSearches . ", 0)";
		$sql = "UPDATE recent_searches SET NumberOfSearches = " . $nrSearches . " WHERE Name = '" . $Name . "'";	
		if ($stmt_1 = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_execute($stmt_1);
			mysqli_stmt_close($stmt_1);
		}
	}
	else{
		$sql = "INSERT INTO recent_searches (Name, NumberOfSearches, NumberOfReports) VALUES ('". $Name . "', 0, 0)";	
		if ($stmt_1 = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_execute($stmt_1);
			mysqli_stmt_close($stmt_1);
		}
	}
	//$sql = "CREATE TABLE `recent_searches` (`Id` INT NOT NULL AUTO_INCREMENT,`Name` VARCHAR(255),`NumberOfSearches` INT,`NumberOfReports` INT,PRIMARY KEY (`Id`));";
	
	// Close the connection
	mysqli_close($conn);
}

function SelectFromDatabase()
{
	$host = 'servertema4.mysql.database.azure.com';
	$username = 'lucaiustin96@servertema4';
	$password = 'parolaluca123iustin-123';
	$db_name = 'sampledb';

	$conn = mysqli_init();
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
	if (mysqli_connect_errno($conn)) {
	die('Failed to connect to MySQL: '.mysqli_connect_error());
	}

	$res = mysqli_query($conn, 'SELECT * FROM recent_searches WHERE NumberOfReports < 4 ORDER BY NumberOfSearches DESC');
	while ($row = mysqli_fetch_assoc($res)) {
		echo '<div class = "search-result-line">'. $row["Name"] .
		'<form id = "report-form" action="report.php" method="post">
                <input type="hidden" name="cautare" value="' . $row["Name"] . '">
                <input class = "button-report" type="submit" value="Report">
        </form> </div>';
	}
}

function DeleteFromTable($Name)
{
	$host = 'servertema4.mysql.database.azure.com';
	$username = 'lucaiustin96@servertema4';
	$password = 'parolaluca123iustin-123';
	$db_name = 'sampledb';

	$conn = mysqli_init();
	mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
	if (mysqli_connect_errno($conn)) {
	die('Failed to connect to MySQL: '.mysqli_connect_error());
	}
	
	$res = mysqli_query($conn, "SELECT NumberOfReports FROM recent_searches WHERE Name = '" . $Name . "'");
	if($row = mysqli_fetch_assoc($res)) {
		$nrSearches = (int)$row["NumberOfReports"];
		$nrSearches++;
		//$sql = "INSERT INTO recent_searches (Name, NumberOfSearches, NumberOfReports) VALUES ('". $Name . "', ". $nrSearches . ", 0)";
		$sql = "UPDATE recent_searches SET NumberOfReports = " . $nrSearches . " WHERE Name = '" . $Name . "'";	
		if ($stmt_1 = mysqli_prepare($conn, $sql)) {
			mysqli_stmt_execute($stmt_1);
			mysqli_stmt_close($stmt_1);
		}
	}
}
?>
