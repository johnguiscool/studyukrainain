<?php
session_start();

$output = $_SESSION['username'];

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message("");
?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="/css/style1.css">
<title> Log out </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>

</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>

<?php echo $output; ?>, you have been logged out.  Click <a href = "login.php"> here </a> to log in again.

<div id="color-overlay" padding-left: 100px></div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>

<script>

window.location.href = 'index.php';

</script>

</html>