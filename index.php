<?php
	session_start();
	if($_SESSION['verified'] == NULL || ($_SESSION['verified'] == false)) {
		session_destory();	
		header('Location: signin.php');
	}	
	
?>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" charset="utf-8">
	
</head>

<body>
<?php

	include("header.php");
	
	$link = mysql_connect('localhost', $DBuser, $DBpass) or	die('unable to connect: ' . mysql_error());
	$db_selected = mysql_select_db($DBname, $link)or die('unable to select database: ' . mysql_error());

	if (isset($_GET['tag'])) { //get tagID from tagName then search for articleID with that tagID then get articles 
			$queryArticles = "SELECT articleTable.* FROM articleTable
					INNER JOIN tagXRef ON articleTable.id=tagXRef.articleID
					INNER JOIN tagTable ON tagXRef.tagID=tagTable.id
					WHERE tagTable.tagName='{$_GET['tag']}'";
			echo $queryArticles;

	} else {
		$queryArticles = 'SELECT * FROM articleTable ORDER BY timestamp DESC';
	}

	$resultArticles = mysql_query($queryArticles)or die('bad query: ' . mysql_error());
	

	while ($articleRow = mysql_fetch_array($resultArticles, MYSQL_ASSOC)) {

		//find tagIDs that are linked to an article then get the tag names
		$queryTagsForArticle = "SELECT tagTable.tagName FROM tagTable 
					INNER JOIN tagXRef ON tagTable.id=tagXRef.tagID 
					WHERE articleID='{$articleRow["id"]}' ";
		$resultTagsForArticle = mysql_query($queryTagsForArticle) or die(mysql_error());

		echo $articleRow["body"];
		$totalTags = mysql_num_rows($resultTagsForArticle);
		$url = "<a href=home.php?tag=";
		echo "<div id=tags>";

		for ($i = 0; $i < $totalTags; $i++) {
			$tagsRow = mysql_fetch_row($resultTagsForArticle);

			// add comma bewteen tags unless its the last tag.
			if ($i < $totalTags -1) {
					
					$tagStr = str_replace(' ', "%20", $tagsRow[0]);
					echo $url . $tagStr . ">{$tagsRow[0]}, </a>";
					
			} else {
				echo $url . $tagsRow[0] . ">{$tagsRow[0]} </a>";
			}
		}
		echo "</div>\n";


				
	}

	mysql_close($link);
		
	
	
	
	include("footer.html");
	 ?>
</body>

</html>



