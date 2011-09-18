<?php
include('mysqlsettings.php');

$name = $_POST['name'];
$pass = $_POST['pass'];

$link = mysql_connect('localhost', $DBuser, $DBpass)or die('unable to connect: ' . mysql_error());

$db_selected = mysql_select_db($DBname, $link)or die('unable to select table: ' . mysql_error());

if (isset($_POST['Join'])) {
	echo "join";
	$salt = rand();
	$hash = hash('sha256', $pass . $salt);
	$query = "INSERT INTO userTable (username, hash, salt) 
				VALUES('$name', '$hash', '$salt')";
	$result = mysql_query($query) or die(mysql_error());

} else {
	$query = "SELECT * FROM userTable WHERE username = '$name'";
	$result = mysql_query($query);
	if (!$result) {
		die('bad query: ' . mysql_error());
	}
	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$salt = $row['salt'];
	$phash = hash('sha256', $pass . $salt);

	if ($phash == $row['hash']) {
		session_start();
		$_SESSION['verified'] = true;
		header('Location: index.php');				
	} else {
		if (isset($_SESSION)) {
			$_SESSION['verified'] = NULL;
		}
		header('Location: signin.php');
	}			
}


?>
