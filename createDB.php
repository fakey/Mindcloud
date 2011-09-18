<?php


$user 	= 	$_GET['mysqlUser']; 	//mysql username
$pass 	=	$_GET['mysqlPass'];	//mysql password
$DBName	= 	$_GET['databaseName'];	//mysql DBName

$sqlinfo = "mySQLSettings.php";
$fh = fopen($sqlinfo, 'w')or die("can't open file");
$infoString = "<?php \$DBname=\"" . $DBName . "\";\n \$DBuser=\"" . $user . "\";\n \$DBpass=\"" . $pass . "\";\n";
fwrite($fh, $infoString);
fclose($fh);



$link = mysql_connect('localhost', $user, $pass) or	die('unable to connect: ' . mysql_error());

$query = 'CREATE DATABASE ' . $DBName;
$result = mysql_query($query)or die('bad query: ' . mysql_error());

$db_selected = mysql_select_db($DBName, $link)or die('Unable to select Database: ' . mysql_error());

//create user table
$query = "CREATE TABLE userTable
	( id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id),
	username VARCHAR(30),
	hash CHAR(64),
	salt CHAR(64)
)";
mysql_query($query)or die('cannot create userTable' . mysql_error());

//create article table
$query = "CREATE TABLE articleTable
	(id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	title TINYTEXT,
	body LONGBLOB,
	timestamp DATETIME,
	userID INT(11)
)";
mysql_query($query)or die('cannot create articleTable: ' . mysql_error());

//create tag table
$query = "CREATE TABLE tagTable (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	tagName VARCHAR(30)
)";	
$result = mysql_query($query)or die('cannot create tagTable: ' . mysql_error());

//create tags cross reference table
$query = "CREATE TABLE tagXRef (
	articleID INT,
	tagID INT,
	tagName VARCHAR(30)
)";
$result = mysql_query($query)or die('cannot create tagXRef: ' . mysql_error());

echo "everything is A.O.K";	

mysql_close($link);
?>
