<?php
include("TTSService.php");
$host = 'tema4server.mysql.database.azure.com';
$username = 'lucaiustin96@tema4server';
$password = 'parolaluca123iustin-123';
$db_name = 'sampledb';

Establishes the connection
$conn = mysqli_init();
//mysqli_ssl_set($conn,NULL,NULL, "C:\ssl\BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
//mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306);
if (mysqli_connect_errno($conn)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

// Run the create table query
if (mysqli_query($conn, '
CREATE TABLE People (
`Id` INT NOT NULL AUTO_INCREMENT ,
`Name` VARCHAR(200) NOT NULL ,
`Gender` VARCHAR(200) NOT NULL ,
`Age` Int NOT NULL ,
`anger` DOUBLE NOT NULL ,
`contempt` DOUBLE NOT NULL ,
`disgust` DOUBLE NOT NULL ,
`fear` DOUBLE NOT NULL ,
`happiness` DOUBLE NOT NULL ,
`neutral` DOUBLE NOT NULL ,
`sadness` DOUBLE NOT NULL ,
`surprise` DOUBLE NOT NULL ,

PRIMARY KEY (`Id`)
);
')) {
printf("Table created\n");
}

//Close the connection
mysqli_close($conn);
?>
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