<?php

////////////////////////////////////////////////////////
//
//  SESSION SPECIFIC STUFF
//
///////////////////////////////////////////////////////

session_start();
$username = $_SESSION['username'];

$body_login_message = "<a href=\"login.php\"> Log in </a> to your account. <a href=\"register.php\"> Register </a>an account. </div>";

if(isset($username))
{

	$body_login_message = "";

}
else
{

}

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message($username);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style1.css">
<title> Study Ukrainian </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>


  <meta name="description" content="A free website for learning the Ukrainian language">
  <meta name="keywords" content="Ukraine,Ukrainian,language">

</head>
<body> 

<!--googleoff: all-->
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<!--googleon: all-->

<!--------------------------------------------->
<!--------------------------------------------->
<!-- PAGE CONTENTS ------------------------------>
<!--------------------------------------------->
<!--------------------------------------------->

<img class="banner" src="/website_pictures/alternate.png" style="width:700px;">

<div class="toptext"> A free website for learning the Ukrainian language. <p> 

<!--googleoff: all-->
<? echo $body_login_message; ?>
<!--googleon: all-->

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>
</html>