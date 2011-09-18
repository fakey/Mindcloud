<?php
include_once "markdown.php";
include("header.php");

$body = Markdown($_POST['body']);

$tags = $_POST['tags'];
$userID = 12345678901; //this results in 2147483647 as the userID ???
$timestamp = date('Y-m-d H:i:s');


$link = mysql_connect('localhost', $DBuser, $DBpass) or die('unable to connect: ' . mysql_error());

$db_selected = mysql_select_db($DBname, $link) or die('unable to select table: ' . mysql_error());


$query = "INSERT INTO articleTable (body, timestamp, userID)
		VALUES( '$body', '$timestamp', '$userID')";
mysql_query($query);

$articleID = mysql_insert_id();
echo $articleID . "<br />";


// filter and store tag data
$cleanTags = preg_replace('/[^[:alnum:]_ ,]+/', "", $tags); //removes punct. except , whitespace _
$tagList = explode(", ", $cleanTags); //separate string into an array divided by commas
for ($i = 0; $i < count($tagList); $i++) {
		$tagList[$i] = trim($tagList[$i]); //removes leading whitespace
	$query = "SELECT id FROM tagTable WHERE tagName='{$tagList[$i]}'";//find id of tag 
	$result = mysql_query($query) or die('bad query: ' . mysql_error());
	$row = mysql_fetch_assoc($result);
	if (mysql_num_rows($result) ==0) {
		$query = "INSERT INTO tagTable (tagName) VALUES('{$tagList[$i]}')";
		mysql_query($query);
		$tagID = mysql_insert_id();
	} else {
		$tagID = $row['id'];
	}
	//insert into cross reference table
	$query = "INSERT INTO tagXRef (articleID, tagID, tagName) VALUES('$articleID', '$tagID', '{$tagList[$i]}')";
	mysql_query($query) or die('bad insertion: ' . mysql_error());
	}


?>


