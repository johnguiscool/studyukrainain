<?php


////////////////////////////////////////////////////////
//
//  SESSION SPECIFIC STUFF
//
///////////////////////////////////////////////////////

session_start();
$username = $_SESSION['username'];

if(isset($username))
{

	$login_message = "<div class = \"right\">";


	$login_message = $login_message."Logged in as: ".$username;
	$login_message = $login_message."<p> <a href=\"generalized_quiz.php\"> Daily Personal Quiz</a>";
	$login_message = $login_message."<p> <a href=\"logout.php\">Logout </a>";
	
}
else
{
	$login_message ="";
}

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message($username);


?>



﻿<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style2.css">
<title> Study Ukrainian </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>

</head>
<body> 

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>

<!--------------------------------------------->
<!--------------------------------------------->
<!-- LEFT DIV/PANEL, LINKS TO OTHER DIALOGUES-->
<!--------------------------------------------->
<!--------------------------------------------->

<div> <iframe src="links.html" scrolling="no" > </iframe></div>

<div class="relative"> </div>

<!--------------------------------------------------->
<!--------------------------------------------------->
<!-- RIGHT DIV/PANEL, USER INFORMATION IF LOGGED IN-->
<!--------------------------------------------------->
<!--------------------------------------------------->

<? echo $login_message;?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>
</html>
