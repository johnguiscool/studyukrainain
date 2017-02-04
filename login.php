<?php

session_start();

$username = $_SESSION['username'];

if(isset($username))
{
	$html_code = "You are logged in as ".$username.".  Click <a href = \"dialogue01.php\"> here </a> to go to the lessons.  Click <a href = \"logout.php\"> here </a> to log out."; 
	
}

else{

	$html_code = "
	
			<table>
			<h1>Login</h1>
			
			<form action=\"loginattempt.php\" method=\"post\">
			
			<tr>
			<td>
			Username:</td> <td> <input type=\"text\" name=\"username\"></td>
			
			</td>
			</tr>
			<tr>
			<td>
			Password:</td> <td> <input type=\"password\" name=\"password\"></td>
			</td>
			</tr>
			<tr>
			<td>
			<input type=\"submit\" value =\"Submit\">
			</td>
			</tr>
			</table>
			</form>";

}

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message($username);

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="/css/style4.css">
<title> Login </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>
</head>

<body>


<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>

<div class="toptext"> A free website for learning the Ukrainian language.</div>

<div class = "relative">
<? echo $html_code; ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>
</html>