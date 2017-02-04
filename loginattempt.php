<?php

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';


session_start();

//If the user is already logged in, do nothing.

if(isset($_SESSION['username']))
{

	//do nothing;

}

else
{


	//////////////////////////////////////////////////////////////////////////////////
	//
	//   CHECK AGAINST USERNAME AGAINST WHITELIST
	//
	/////////////////////////////////////////////////////////////////////////////////////
	
	if(!check_against_whitelist($_POST['username']))
	{
	
		$login_error_message = "The username or password entered was incorrect.  Click <a href = \"login.php\">here</a> to try again.";
		$javascript_redirect_code="";
	
		// remove all session variables
		session_unset(); 
	
		// destroy the session 
		session_destroy(); 			
	
	}
	
	else
	{
	


		///////////////////////////////////////////////////////////////////////////
		//
		//   LOG INTO THE DATABASE
		//
		/////////////////////////////////////////////////////////////////////////////
		
		$servername = "localhost";
		$username = "learnukr_admin";
		$password = "LearnUkrainian!";
		$dbname = "learnukr_membership";
		
		$php_status_debug = "";
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password,$dbname);
		
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		
		
		
		$javascript_redirect_code="";
		
		
		///////////////////////////////////////////////////////////////////////////
		//
		//   CHECK THE PASSWORD
		//
		/////////////////////////////////////////////////////////////////////////////
		
		$user_submitted_password = "";
		$user_submitted_password = $_POST['password'];
		
		$sql_searched_password = "x";
		
		
		//////////////////////////////////////	
		//
		//   SERIES OF PREPARED STATEMENTS TO PULL PASSWORD
		//
		/////////////////////////////////////////
	
		// final password shows up in the $sql_searched_password variable
	
		if (!($stmt = $conn->prepare("SELECT password from members WHERE username = ?"))) {
		    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		
	
		
		if (!$stmt->bind_param("s",$_POST['username'])){
			echo "Execute failed: ".$conn->errno;
		
		}
		
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
		}
		
	
		
		if (!$stmt->bind_result($result)){
			echo "Bind failed";
		}
		
	
		while ($stmt->fetch()) {
		    $sql_searched_password = $result;
		}
		
		
		/* close statement */
		$stmt->close();
		 			
		  
		  
		  
		//////////////////////////////////////////////////////
		//
		//  SERIES OF PREPARED STATEMENTS TO PULL SALT
		//
		////////////////////////////////////////////////////////
	
	
		if (!($stmt = $conn->prepare("SELECT salt from members WHERE username = ?"))) {
		    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		}
		
	
		
		if (!$stmt->bind_param("s",$_POST['username'])){
			echo "Execute failed: ".$conn->errno;
		
		}
		
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $conn->errno . ") " . $conn->error;
		}
		
	
		
		if (!$stmt->bind_result($result)){
			echo "Bind failed";
		}
		
	
		while ($stmt->fetch()) {
		    $sql_searched_salt = $result;
		}
		
		
		/* close statement */
		$stmt->close();
		 			
	
	
		// If the searched salt was not found, do nothing else
		if(!isset($sql_searched_salt))
		{
		
			$login_error_message = "The username or password entered was incorrect.  Click <a href = \"login.php\">here</a> to try again.";
			$javascript_redirect_code="";
	
			// remove all session variables
			session_unset(); 
	
			// destroy the session 
			session_destroy(); 	
		
		
		} else
		
		{
		 
	
	
	
	
		
			// Build the hashed password
			
			$options = [
			    'cost' => 11,
			    'salt' => $sql_searched_salt,
				];
			
			$hashed_password = password_hash($user_submitted_password, PASSWORD_DEFAULT, $options);
		
		
		
		
		
			//////////////////////////////////////////
			//
			//  CHECK IF THE PASSWORD IS CORRECT  
			//
			//////////////////////////////////////////
			
			
			if ($sql_searched_password == $hashed_password)
			{
				$php_status_debug =  $php_status_debug."Password Match! ";
				$php_status_debug = $php_status_debug."Connected!";
				$_SESSION['username'] = $_POST['username'];
				$username = $_SESSION['username'];
				
				$javascript_redirect_code="window.location.href = 'index.php';";
				
			}
			else
			{
				$login_error_message = "The username or password entered was incorrect.  Click <a href = \"login.php\">here</a> to try again.";			
				$javascript_redirect_code="";
		
		
			}
			
			
			$conn->close();
			
			
			//REDIRECT IF EMPTY USERNAME WAS SENT
			if($_POST['username'] =="")
			{
			$login_error_message = "The username or password entered was incorrect.  Click <a href = \"login.php\">here</a> to try again.";
			$javascript_redirect_code="";
			
			// remove all session variables
			session_unset(); 
			
			// destroy the session 
			session_destroy(); 
			
			}
	
		
		}
	}

}
?>

<script>

<?php echo $javascript_redirect_code ?>

</script>

<html>

<head>
<link rel="stylesheet" type="text/css" href="/css/style1.css">
<title> Study Ukrainian </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>
</head>
<body>


<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>


<div class="toptext"> A free website for learning the Ukrainian language. <p> <? echo $body_login_message; ?>

<?php echo $login_error_message ?>


<!-- ?php echo $php_status_debug; ?><p>

<!-- ?php echo $html_code; ?><p>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>
</html>