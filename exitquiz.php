<?php

session_start();


include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message($_SESSION['username']);


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




$dialogues_to_update = $_POST['exit_quiz_parameters'];
$dialogues_to_reset  = $_POST['exit_quiz_parameters_forgotten'];


//////////////////////////////////////////////////////////
//
//  FIRST LOOP
//
//  UPDATE THE VOCAB PHRASES THAT THE USER GOT CORRECT
//  INCREASE THE QUIZ INTERVAL BY ONE
//  UPDATE THE NEXT QUIZ DATE FIELD
//
//////////////////////////////////////////////////////////

///////////////////////
//                   //
// loop starts here  //
//                   //
///////////////////////


$loop_length = strlen($dialogues_to_update) / 2;

$n =0;

while($n<$loop_length)
{
	
	// Step 1 Get the right dialogue and row number to update from the POST variables
	
	$dialogue_number_passed = $dialogues_to_update[0].$dialogues_to_update[1];
	$dialogue_number_passed = intval($dialogue_number_passed);
	
	$row_number_passed = $dialogues_to_update[2].$dialogues_to_update[3];
	$row_number_passed = intval($row_number_passed);
	
	
	
	// Step 2 Pull the interval length with SQL
	
	$sql = "SELECT * FROM ".$_SESSION['username']." WHERE dialogue_number = ".$dialogue_number_passed." AND row_number = ".$row_number_passed.";";
	
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
	{
    		while($row = $result->fetch_assoc()) 
    		{
    	    	$old_interval = $row["quiz_interval"];
        	}
        }
	
	
	$new_interval = $old_interval + 1;

	
	
	// Step 3 Updates the table of the user.  (The name of the table is [username] ).
	//        First update the quiz_interval length, this is the time until the next testing
	$sql = "UPDATE ".$_SESSION['username']." SET quiz_interval = ".$new_interval." WHERE dialogue_number = ".$dialogue_number_passed." AND row_number = ".$row_number_passed.";";
		
	$resultb = $conn->query($sql);
	
	
	// Step 4 Then update the TIMESTAMP field
	
	$next_quiz_date = strtotime("now");
	$next_quiz_date = $next_quiz_date + 86400 * (2 ** $old_interval);
	
	$mysqldate = date( 'Y-m-d H:i:s', $next_quiz_date);
	
	$next_quiz_date = date("Y-m-d h:i:sa",$next_quiz_date);
	
	$sql = "UPDATE ".$_SESSION['username']." SET next_quiz_date = '".$mysqldate."' WHERE dialogue_number = ".$dialogue_number_passed." AND row_number = ".$row_number_passed.";";
	$resultc = $conn->query($sql);
	
	
	// Step 5 Chop down string
	$dialogues_to_update = substr($dialogues_to_update,4);
	$n = $n+1;
        
}

////////////////////
///loop ends here
///////////////////




////////////////////////////////////////////////////////
//
//  SECOND LOOP
//
//  UPDATE THE VOCAB PHRASES THAT THE USER GOT WRONG
//  SET THE QUIZ TESTING INTERVAL TO ONE
//  UPDATE THE NEXT QUIZ DATE FIELD TO TOMORROW
//
////////////////////////////////////////////////////////

////////////////////////
//                    //
// loop starts here   //
//                    //
////////////////////////

$loop_length = strlen($dialogues_to_reset) / 2;

$n = 0;

while ($n < $loop_length)
{

	// Step 1:  Get the right dialogue and row number to update from the POST variables
	
	$dialogue_number_passed = $dialogues_to_reset[0].$dialogues_to_reset[1];
	$dialogue_number_passed = intval($dialogue_number_passed);

	$row_number_passed = $dialogues_to_reset[2].$dialogues_to_reset[3];
	$row_number_passed = intval($row_number_passed);



	// Step 2:  Update the table of the user.  Set the quiz interval length to zero.

	$zero = 0;
	$sql = "UPDATE ".$_SESSION['username']." SET quiz_interval = ".$zero." WHERE dialogue_number = ".$dialogue_number_passed." AND row_number = ".$row_number_passed.";";
	$resultd = $conn->query($sql);
	

	// Step 3:  Update the "next_quiz_date" field
	
	$next_quiz_date = strtotime("now");
	$next_quiz_date = $next_quiz_date + 86400;

	$mysqldate = date( 'Y-m-d H:i:s', $next_quiz_date);

	
	$sql = "UPDATE ".$_SESSION['username']." SET next_quiz_date = '".$mysqldate."' WHERE dialogue_number = ".$dialogue_number_passed." AND row_number = ".$row_number_passed.";";

	$resulte = $conn->query($sql);


	// Step 4: Chop down string
	
	$dialogues_to_reset = substr($dialogues_to_reset,4);
	$n = $n + 1;

}



?>





<script>

<?php $javascript_redirect_code ?>

</script>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style1.css" >
<title> Study Ukrainian </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>

</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>

<!- <?php echo $passedvals; ?> ->


<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>

<?php $dialogues_to_reset ?>

<div class="toptext"> A free website for learning the Ukrainian language.


</body>
</html>