<?php

////////////////////////////////////////////////////////
//
//  SESSION SPECIFIC STUFF
//
///////////////////////////////////////////////////////

session_start();
$username = $_SESSION['username'];


include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message($username);
 

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style2.css">
<title> About </title>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>


</head>
<body> 

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>


<!--------------------------------------------->
<!--------------------------------------------->
<!-- PAGE CONTENTS ---------------------------->
<!--------------------------------------------->
<!--------------------------------------------->


<div class = "relative">

<h2> The Learn Ukrainian Team</h2>


<u>Art</u>
<br> Nataliya Astaptseva<p>

<u>Voice Actors</u>
<br> Nataliya Astaptseva
<br> Oleksandr Bratashov
<br> Hanna Karpenko
<br> Rostyslav Zhuravchak

<p>
<u>Website Design</u>
<br> John Gu<p>

 

</body>
</html>