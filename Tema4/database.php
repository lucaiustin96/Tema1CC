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
	//if ($stmt = mysqli_prepare($conn, "INSERT INTO People (Name, Gender, Age, anger, contempt, disgust, fear, happiness, neutral, sadness, surprise) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
	$sql = "INSERT INTO People (Name, Gender, Age, anger, contempt, disgust, fear, happiness, neutral, sadness, surprise) VALUES ('". $Name . "', '" . $Gender. "', " .$Age. ", " . $anger. ", ".$contempt.", ".$disgust.", ".$fear.", ".$happiness.", ".$neutral.", ".$sadness.", ".$surprise.")";
	//echo $sql;
	if ($stmt = mysqli_prepare($conn, $sql)) {
	//mysqli_stmt_bind_param($stmt, 'ssd', $Name, $Gender, $Age, $anger, $contempt, $disgust, $fear, $happiness, $neutral, $sadness, $surprise);
	mysqli_stmt_execute($stmt);
	//printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
	mysqli_stmt_close($stmt);
	}
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

	//Run the Select query
	//printf("Reading data from table: \n");
	$res = mysqli_query($conn, 'SELECT * FROM People');
	while ($row = mysqli_fetch_assoc($res)) {
		echo "<hr>";
		echo '<div class = "image-info-2">';
			//var_dump($row);
			foreach ($row as $key => $value)
				echo '<div class = "person-info">'.$key. ' : ' . $value .'</div>';
		echo "</div>";
	}

}
//InsertIntoDatabase("name", "male", 1, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1); 

?>




<!-- //$conn = mysqli_init();
//mysqli_ssl_set($conn,NULL,NULL, "C:\ssl\BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
//mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
// mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
// if (mysqli_connect_errno($conn)) {
// die('Failed to connect to MySQL: '.mysqli_connect_error());
// }

// // Run the create table query
// if (mysqli_query($conn, '
// CREATE TABLE People (
// `Id` INT NOT NULL AUTO_INCREMENT ,
// `Name` VARCHAR(200) NOT NULL ,
// `Gender` VARCHAR(200) NOT NULL ,
// `Age` Int NOT NULL ,
// `anger` DOUBLE NOT NULL ,
// `contempt` DOUBLE NOT NULL ,
// `disgust` DOUBLE NOT NULL ,
// `fear` DOUBLE NOT NULL ,
// `happiness` DOUBLE NOT NULL ,
// `neutral` DOUBLE NOT NULL ,
// `sadness` DOUBLE NOT NULL ,
// `surprise` DOUBLE NOT NULL ,

// PRIMARY KEY (`Id`)
// );
// ')) {
// printf("Table created\n");
// }

//Close the connection
//mysqli_close($conn);
//?> -->
<!-- //Establishes the connection
$conn = mysqli_init();
mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
if (mysqli_connect_errno($conn)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

//Create an Insert prepared statement and run it
$product_name = 'BrandNewProduct';
$product_color = 'Blue';
$product_price = 15.5;
if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Color, Price) VALUES (?, ?, ?)")) {
mysqli_stmt_bind_param($stmt, 'ssd', $product_name, $product_color, $product_price);
mysqli_stmt_execute($stmt);
printf("Insert: Affected %d rows\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn); -->