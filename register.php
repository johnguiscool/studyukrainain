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
<link rel="stylesheet" type="text/css" href="/css/style4.css">
<title> Register </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>

</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>

<div class="toptext"> A free website for learning the Ukrainian language.</div>

<div class = "relative">

<h1>Register Your Account</h1>


<form action="success.php" onsubmit="return validateForm()" method="post">
<table>
<tr>
<td>Username:</td> <td><input type="text" name="username" id="username"> <a id="error_message" style="color:#FF0000"> </a></td>
</tr>
<tr>
<td>Password:</td> <td><input type="password" name="password"></td>
</tr>
<tr>
<td><input type="submit" value="Submit"></td>
</tr>
</form>

</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>




<script>

//////////////////////////////////////////////////////////////////////////////////////////
//
//  THIS FUNCTION TESTS WHETHER THE INPUT USERNAME FIELD IS ONLY ALPHANUMERIC OR NOT
//
//////////////////////////////////////////////////////////////////////////////////////////

function validateForm() 
{
    var x, text;

    // Get the value of the input field with id="username"
    x = document.getElementById("username").value;

    // If x is Not a Number or less than one or greater than 10
    if (isAlphaNumeric(x)) 
    {
        
        return true;
    } 
    
    else 
    {
        text = "Username must not contain any special characters.";
        document.getElementById("error_message").innerHTML = text;
        return false;
    }
    
}



//////////////////////////////////////////////////////////////////////////////////////////
//
//  THIS IS A UTILITY FUNCTION TO TEST WHETHER A GIVEN INPUT STRING IS ALPHANUMERIC OR NOT
//
//////////////////////////////////////////////////////////////////////////////////////////


function isAlphaNumeric(str)
 {
  var code, i, len;

  for (i = 0, len = str.length; i < len; i++) 
  {
    code = str.charCodeAt(i);
    if (!(code > 47 && code < 58) && // numeric (0-9)
        !(code > 64 && code < 91) && // upper alpha (A-Z)
        !(code > 96 && code < 123)) 
        { // lower alpha (a-z)
      		return false;
    	}
  }
  
  return true;
};

</script>



</body>
</html>