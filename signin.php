<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<title>Signin</title>
	
</head>
<body>
	<?php include("header.php"); ?>

	<form action="verification.php" method="post" accept-charset="utf-8">
		<input type="text" name="name" value="username"> <br />
		<input type="password" name="pass" value="">
	
	<p><input type="submit" value="Continue &rarr;"></p>
	<p><input type="submit" name="Join" value="Sign Up">
	</form>
	<?php include("footer.html"); ?>
</body>
</html>
