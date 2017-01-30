<?php

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';



$servername = "localhost";
$username = "learnukr_admin";
$password = "LearnUkrainian!";
$dbname = "learnukr_membership";


// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully  ";


/////////////////////////////////////////////////////////
//
//  STEP 1:  GET USER SUBMITTED INFORMATION
//
//////////////////////////////////////////////////////////


// Get user submitted username (passed from the registration page)

$user_submitted_username = "";
$user_submitted_username = $_POST['username'];

$user_submitted_password = "";
$user_submitted_password = $_POST['password'];


$javascript_redirect_code="";



//////////////////////////////////////////////////////
//
//  STEP 2:  GENERATE HASHED PASSWORD
//
/////////////////////////////////////////////////////////


$salt = genKey(22);

$options = [
    'cost' => 11,
    'salt' => $salt,
];
$hashed_password = password_hash($user_submitted_password, PASSWORD_DEFAULT, $options) ;


// Utilities for generating random values.

function genKey($length) {
  if($length > 0) { 
	  $rand_id="";
		for($i=1; $i <= $length; $i++) {
		 mt_srand((double)microtime() * 1000000);
		 $num = mt_rand(1,72);
		 $rand_id .= assign_rand_value($num);
		}
  }
	return $rand_id;
}

function assign_rand_value($num) {
  switch($num) {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
    case "37":
     $rand_value = "*";
    break;
    case "38":
     $rand_value = "~";
    break;
    case "39":
     $rand_value = "-";
    break;
    case "40":
     $rand_value = "|";
    break;
    case "41":
     $rand_value = "^";
    break;
    case "42":
     $rand_value = "%";
    break;
    case "43":
     $rand_value = " ";
    break;
    case "44":
     $rand_value = "_";
    break;
    case "45":
     $rand_value = "+";
    break;
    case "46":
     $rand_value = "=";
    break;
    case "47":
     $rand_value = "A";
    break;
    case "48":
     $rand_value = "B";
    break;
    case "49":
     $rand_value = "C";
    break;
    case "50":
     $rand_value = "D";
    break;
    case "51":
     $rand_value = "E";
    break;
    case "52":
     $rand_value = "F";
    break;
    case "53":
     $rand_value = "G";
    break;
    case "54":
     $rand_value = "H";
    break;
    case "55":
     $rand_value = "I";
    break;
    case "56":
     $rand_value = "J";
    break;
    case "57":
     $rand_value = "K";
    break;
    case "58":
     $rand_value = "L";
    break;
    case "59":
     $rand_value = "M";
    break;
    case "60":
     $rand_value = "N";
    break;
    case "61":
     $rand_value = "O";
    break;
    case "62":
     $rand_value = "P";
    break;
    case "63":
     $rand_value = "Q";
    break;
    case "64":
     $rand_value = "R";
    break;
    case "65":
     $rand_value = "S";
    break;
    case "66":
     $rand_value = "T";
    break;
    case "67":
     $rand_value = "U";
    break;
    case "68":
     $rand_value = "V";
    break;
    case "69":
     $rand_value = "W";
    break;
    case "70":
     $rand_value = "X";
    break;
    case "71":
     $rand_value = "Y";
    break;
    case "72":
     $rand_value = "Z";
    break;
  }
return $rand_value;
}



/////////////////////////////////////////////////////////
//
//   STEP 3:  CHECK IF USERNAME IS IN THE WHITELIST
//
////////////////////////////////////////////////////////////

if(!check_against_whitelist($user_submitted_username))
{

	$javascript_redirect_code="window.location.href = 'failure.php';";

}

else

{



	////////////////////////////////////////////////
	//
	//  STEP 4
	//
	////////////////////////////////////////////////
	
	
	//  Check SQL code to see if the Username has been submitted before.  If it has, the javascript redirect code will redirect the user to the "failure.php" page, where he will be told that the username is already taken.
	/*
	$sql = 
	
	"SELECT id, username
	FROM members
	WHERE username = '".$user_submitted_username."';";
	
	$result = $conn->query($sql);
	*/
	
	$sql = "SELECT id FROM members WHERE username = ?";
	
	$stmt = $conn->prepare($sql);
	
	$stmt->bind_param('s',$user_submitted_username);
	
	$stmt->execute();
	
	$stmt->bind_result($result);
	
	$from_table_id = -1;
	
	while ($stmt->fetch()) {
		    $from_table_id = $result;
		}
		
	//  The code to insert a new user will only run if the username has not already been taken.  
	
	if ($from_table_id >= 1 || $user_submitted_username == "") 
		{
		
			$javascript_redirect_code="window.location.href = 'failure.php';";
			
		}
	
		else 
		{
	
			/*$sql = "INSERT INTO members (username, password, salt) VALUES ('".$user_submitted_username."', '".$hashed_password."','".$salt."');";*/
			
			$sql = "INSERT INTO members (username, password, salt) VALUES (?,?,?)";
			
			$stmt = $conn->prepare($sql);
			
			$stmt->bind_param('sss',$user_submitted_username, $hashed_password,$salt);
			
			
			
			if ($stmt->execute()) 
				{
				
				$sql = "CREATE TABLE " . $user_submitted_username . " (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, dialogue_number INT(6), row_number INT(6),	next_quiz_date TIMESTAMP, quiz_interval INT(6));";
		 	   	if ($conn->query($sql) === TRUE) 
		 	   		{
		 	   		//echo "New record created successfully";
		 	   		}
		 	   	else
		 	   		{
		 	   		echo "Error: " . $sql . "<br>" . $conn->error;
		 	   		}
		 	   	
				} 
			else 
				{
		    		echo "Error: " . $sql . "<br>" . $conn->error;
				}
		}
	
	
	
	
	
	$conn->close();


}


?>

<script>

<?= $javascript_redirect_code ?>

</script>

<html>

<head>
<link rel="stylesheet" type="text/css" href="/css/style4.css">
<title> Study Ukrainian </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>

</head>

<body>

<div class = "toptext"> A free website for learning the Ukrainian language.</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>

<div class="relative">

Registration successful. <p>

Click <a href="login.php"> here </a> to log in.

</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>
</html>