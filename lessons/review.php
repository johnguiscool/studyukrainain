<?php

////////////////////////////////////
//
//  DIALOGUE NUMBER VARIABLE
//
////////////////////////////////////

$dialogue_number = $_GET['id'];

$dialogue_next   = $dialogue_number + 1;



if($dialogue_number > 9)
{
	$dialogue_index  = $dialogue_number;
}

else 
{
	$dialogue_index  = "0".$dialogue_number;
}


if($dialogue_next > 9)
{
	$dialogue_next_index  = $dialogue_next;
}

else 
{
	$dialogue_next_index  = "0".$dialogue_next;
}



/////////////////////////////////////////
//
//  SET SESSION VARIABLES
//
///////////////////////////////////////////

session_start();
$user_table = $_SESSION['username'];


/////////////////////////////////////////
//
//  LOG INTO THE DATABASE
//
///////////////////////////////////////

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


/////////////////////////////////////////////////////////////////////
//
//  GET THE NUMBER OF PHRASES TO TEST
//
///////////////////////////////////////////////////////////////////

$texts_path	 = $_SERVER['DOCUMENT_ROOT']."/texts/";

$ukrainian_path    =$texts_path."ukrainianphrases".$dialogue_index.".txt";

$phrases_ukrainian       = file_get_contents($ukrainian_path,true);
$phrases_ukrainian_array = explode("\r\n", $phrases_ukrainian);

$number_of_phrases       = count($phrases_ukrainian_array);


/////////////////////////////////////////////
//
//  USE SQL TO UPDATE THE DATABASE
//
////////////////////////////////////////////

$n = 0;

for($n=1; $n <= $number_of_phrases; $n++)
{ 

	$sql = 
	"SELECT id FROM ".$user_table." WHERE dialogue_number = ".$dialogue_number." AND row_number = ".$n.";";

	$result = $conn->query($sql);

	if($result->num_rows == 0)
	{

		$sql = 
		"INSERT INTO ".$user_table." (dialogue_number, row_number, next_quiz_date, quiz_interval) VALUES (".$dialogue_number.",".$n.",'2000-01-01 12:00:00',0);";
		
		$result = $conn->query($sql);
		
		
		if ((gettype($result) == "object" && $result->num_rows == 0) || !$result) {
		   $php_debug = "failure"; 
		}
	
	}
}
$conn->close();

?>

<html>
<body>

</body>
</html>

<script>
window.location.href = 'lessons.php?dialogue=<?echo $dialogue_number?>';
</script>