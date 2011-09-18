<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<title>Compose Article</title>
	<body>
		<?php
		include("header.php");
		?>
		
		
		<form action="processArticle.php" method="post" accept-charset="utf-8">
				
			<textarea name="body" rows="8" cols="20">#Heading Here 
Article Here</textarea><br />
			<input type="text" name="tags" value="Use_underscores, and_commas"><br />
		
		<p><input type="submit" value="Submit &rarr;"></p>
		</form>
		<?php
		include("footer.html");
		?>
	</body>
</head>
</html>
