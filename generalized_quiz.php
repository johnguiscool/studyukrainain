<?php session_start();

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';


/////////////////////////////////////////////////////////////////
//
//  SET SESSION VARIABLES
//
/////////////////////////////////////////////////////////////////

$user_table = $_SESSION['username'];
$php_debug_message = "";
$dialogue_items = array();
$dialogue_items_length = 0;
$debug = "";

//////////////////////////////////////////////////////////
//
//  CONNECT TO THE DATABASE
//
///////////////////////////////////////////////////////////

$servername = "localhost";
$username = "learnukr_admin";
$password = "LearnUkrainian!";
$dbname = "learnukr_membership";


// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());}

$php_debug_message = $php_debug_message."Connected successfully  ";



///////////////////////////////////////////////////////////////
//
//   USERNAME CHECK
//
///////////////////////////////////////////////////////////////

$php_debug_message = $php_debug_message.$user_table;



//////////////////////////////////////////////////////
//
//   CHECK IF USER HAS ADDED ANY DIALOGUE PHRASES AT ALL
//
/////////////////////////////////////////////////////


//Pull all rows from the user table
$sql = "SELECT * FROM ".$user_table." ;";

$result = $conn->query($sql);



//If there are no rows, have an error flag
if ($result->num_rows > 0) 
	{
		$has_phrases_flag = True;
	
	}

else
	{
		$has_phrases_flag = False;
	}
	
if($has_phrases_flag == TRUE)
{
	$html_query_language = "<i><p>How do you say?</p></i>";

}
else
{
	$html_query_language = "<i><p>It looks like you haven't added any phrases to your phrasebook yet.<p>  To be quizzed on the phrases you have learned, add phrases to your <br>phrasebook by clicking on the \"Add Dialogue Phrases to Phrasebook\" <br>link in the sidebar of each dialogue.</p></i>";
}

	
//////////////////////////////////////
//
//   GET CURRENT TIME
//
//////////////////////////////////////

$current_time = date('Y-m-d G:i:s');






///////////////////////////////////////////////////////////////
//
//   GATHER INDIVIDUAL USER TABLE
//
///////////////////////////////////////////////////////////////

$sql = "SELECT * FROM ".$user_table." WHERE next_quiz_date <= '".$current_time."';";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $php_debug_message = $php_debug_message."id: " . $row["id"]. " - Dialogue Number: " . $row["dialogue_number"]. " Line Number: " . $row["row_number"]. "<br>";
        array_push($dialogue_items, array($row["dialogue_number"],$row["row_number"]));
        $dialogue_items_length = count($dialogue_items);
    }
} else {
    $php_debug_message = $php_debug_message."0 results ";
    
}
$conn->close();



/////////////////////////////////////////////////////////
//
//   PULL THE DIALOGUES INTO A TABLE
//
/////////////////////////////////////////////////////////

$dialogue_number=1;
$row_number=0;

// All the phrases to be quizzed on will be put into these arrays
$quizzed_phrases_array_english = [];
$quizzed_phrases_array_ukrainian = [];
$quizzed_phrases_array_audio = [];



////////////
/// Loop starts here
///////////

for ($i =0; $i < $dialogue_items_length; $i++)
{

	$dialogue_number = (int) $dialogue_items[$i][0];
	$row_number      = (int) $dialogue_items[$i][1];
	$row_number_audio= $row_number + 1;
	
	if($row_number_audio > 9)
	{
		$row_index_audio  = $row_number_audio;
	}
	
	else 
	{
		$row_index_audio  = "0".$row_number_audio;
	}
	

	// adjust row number so that it is indexed at 0, instead of 1
	$row_number = $row_number - 1;
	
	if($dialogue_number > 9)
	{
		$dialogue_index  = $dialogue_number;
	}
	
	else 
	{
		$dialogue_index  = "0".$dialogue_number;
	}
	
	
	// select the text file by the dialogue number
	$texts_path	 = "./texts/";
	$audio_path	 = "/audio/dialogue".$dialogue_index."-".$row_index_audio.".wav";
	
	$english_path      =$texts_path."englishphrases".$dialogue_index.".txt";
	$ukrainian_path    =$texts_path."ukrainianphrases".$dialogue_index.".txt";
	$speaker_path      =$texts_path."speaker".$dialogue_index.".txt";
	
	$phrases_english         = file_get_contents($english_path,true);
	$phrases_english_array   = explode("\r\n", $phrases_english);
	
	$phrases_ukrainian       = file_get_contents($ukrainian_path,true);
	$phrases_ukrainian_array = explode("\r\n", $phrases_ukrainian);
	
	
	// select the correct line from the text file by the row number
	$selected_phrase_english   = $phrases_english_array[$row_number];
	$selected_phrase_ukrainian = $phrases_ukrainian_array[$row_number];
	
	// add the phrase to the list of phrases that will actually show up on the quiz
	array_push($quizzed_phrases_array_english,$selected_phrase_english);
	array_push($quizzed_phrases_array_ukrainian,$selected_phrase_ukrainian);
	array_push($quizzed_phrases_array_audio, $audio_path);

	$phrase_transliteration = new TranslitUk();


	$transliterated_phrases = $phrase_transliteration->convert($phrases_ukrainian_array[$row_number]);
	//var_dump($transliterated_phrases);	
	
}


//////////
//  Loop ends here
//////////



///////////////////////////////////////////
//
//  BUILD SIDEBAR
//
///////////////////////////////////////////

$header_login_message =  generate_login_message($user_table);

?>


















<html>

<head>

<link rel="stylesheet" type="text/css" href="/css/style2.css">

<title> Quiz </title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>


</head>

<body> 

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>


<div class="relative">


<!-- <?php echo $php_debug_message; ?> -->


<p>
<?php echo $html_query_language; ?>
<p>

<div class="qa">

<h3 color = "blue"><p id="english"> </p></h3>
<h3><p id="answer"> <br> <h3></p>
</div>
<p>
<audio controls id="audio">
  <source id="audioSource" src="dialogue01-01.wav" type="audio/wav">
Your browser does not support the audio element.
</audio>

<p>
<button type="button" onclick="myFunction()" id="buttonLabel">Check Answer</button>

<!-- NEW FORGOT BUTTON -->
<a id="forgotPhrase"></a>
<p>

<font color="white"> <p class="invisible" id="js_debug"> </p></font>



<form action="exitquiz.php" method="POST" id="exit_quiz_form">
  <input type="hidden" id="exit_quiz_parameters"           name="exit_quiz_parameters" value="">
  <input type="hidden" id="exit_quiz_parameters_forgotten" name="exit_quiz_parameters_forgotten" value="">
  
  <input type="submit" value="Exit Quiz and Save Results">
</form>



</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


<script>


//Initialize Values
var m= 2;

var englishPhrase =    <?php echo json_encode($quizzed_phrases_array_english); ?>;
var ukrainianPhrase =  <?php echo json_encode($quizzed_phrases_array_ukrainian); ?>;
var audioPhrase =      <?php echo json_encode($quizzed_phrases_array_audio); ?>;

// Index of phrase tested
// reviewed_indices  => phrases that will be marked as reviewed and whose review date will be pushed to later on.
// forgotten_indices => phrases that will be marked as reviewed and whose review date will be reset
var reviewed_indices = "";
var forgotten_indices = "";

var d_number = "999";
var r_number = "888";

// Debug code to see the "indexed" versions of the arrays pulled in PHP
// <?php echo json_encode( $dialogue_items) ?>;


// 
var updated_indices = <?php echo json_encode( $dialogue_items) ?>;

var updated_indices_as_string = "";

for (i = 0; i <updated_indices.length;i++)
{
	updated_indices_as_string = updated_indices_as_string.concat(updated_indices[i][0]); 
	updated_indices_as_string = updated_indices_as_string.concat(updated_indices[i][1]);
}

updated_indices_as_string;

console.log(updated_indices_as_string);


var audio = document.getElementById("audio");

var n = 0;


// showAnswerFlag=1 => Displaying the Question only.  When the button is pressed and showAnswerFlag=1, the answer will show up.
// showAnswerFlag=0 => Displaying the Question and Answer.  When the button is pressed and showAnswerFlag=0, the next question will show up.

var showAnswerFlag=1;

	document.getElementById("english").innerHTML = englishPhrase[n];

// Show a "no phrases to test message" if the array of phrases to test is empty
if(englishPhrase == null || typeof englishPhrase == "undefined" || englishPhrase.length <1)
		{
		document.getElementById("english").innerHTML = "No Phrases to Review Today";
		}


function forgotFunction()
{

	/*if(n == englishPhrase.length )
	{
	
		document.getElementById("english").innerHTML = "No More Phrases to Review Today";
		document.getElementById("answer").innerHTML = " <br> ";
		document.getElementById("audio").innerHTML = " <br>";
		
		document.getElementById("buttonLabel").innerHTML = "";
		document.getElementById("forgotPhrase").innerHTML="";
	
		new_index = d_number + r_number;
		forgotten_indices = forgotten_indices + new_index;
	
		document.getElementById("js_debug").innerHTML  = "Indices which have been marked as already reviewed: " + reviewed_indices + "<br> Indices which have been marked as forgotten: " + forgotten_indices;
		document.getElementById("exit_quiz_parameters_forgotten").value = forgotten_indices;
		$("#exit_quiz_parameters_forgotten").val(forgotten_indices);
		
		// Exit the function because the AnswerFlag does not matter;
	
		return;
	}*/
	
	//document.getElementById("english").innerHTML = englishPhrase[n];


// showAnswerFlag=0 => Displaying the Question and Answer.  When the button is pressed and showAnswerFlag=0, the next question will show up.
   if (showAnswerFlag==0)
	{
		document.getElementById("answer").innerHTML = " <br> ";
		document.getElementById("audio").innerHTML = " <br>";
		showAnswerFlag=1;
		document.getElementById("buttonLabel").innerHTML = "Check Answer";
		document.getElementById("forgotPhrase").innerHTML="";

		
		new_index = d_number + r_number;
		forgotten_indices = forgotten_indices + new_index;
		
		if(n+1 <= englishPhrase.length)
		{
			englishPhrase.splice(n+1,0,englishPhrase[n-1]);
			ukrainianPhrase.splice(n+1,0,ukrainianPhrase[n-1]);
			audioPhrase.splice(n+1,0,audioPhrase[n-1]);
			
			/////////////////////////////////////////
			//
			//    THE FOLLOWING CODE EXISTS ONLY TO INSERT THE FORGOTTEN PHRASE INTO THE "updated_indices" ARRAY
			//
			////////////////////////////////////////
			
			empty_array = [["0","0"]];
			empty_array.pop();
			
			console.log(n);
	
			
			for (j=0; j< n+1; j++)
			{
				empty_array.push(updated_indices[j]);
			}
			
			empty_array.push(updated_indices[n-1]);
			
			for (j=n+1; j<englishPhrase.length-1;j++)
			{
				empty_array.push(updated_indices[j])
			}
			
	
			updated_indices = empty_array.slice(0);
	
			console.log(updated_indices);
			
			/////////////////////////////////////////////
			//
			//    END OF COPY CODE
			//
			////////////////////////////////////////////
		} 
		
		else if(n+1 > englishPhrase.length)
		{
		
			englishPhrase.push(englishPhrase[n-1]);
			ukrainianPhrase.push(ukrainianPhrase[n-1]);
			audioPhrase.push(audioPhrase[n-1]);
			updated_indices.push(updated_indices[n-1]);
			console.log(n);
			console.log(updated_indices);
			

		}
		

	}
	
// showAnswerFlag=1 => Displaying the Question only.  When the button is pressed and showAnswerFlag=1, the answer will show up.
   if (showAnswerFlag==1)
	{
		//Do nothing
	}

	document.getElementById("english").innerHTML = englishPhrase[n];


	//document.getElementById("js_debug").innerHTML  = "Indices which have been marked as already reviewed: " + reviewed_indices + "<br> Indices which have been marked as forgotten: " + forgotten_indices;
	document.getElementById("exit_quiz_parameters_forgotten").value = forgotten_indices;
	$("#exit_quiz_parameters_forgotten").val(forgotten_indices);


}



function myFunction() 

{
	
	// When you have cycled through all the phrases, then say that there are no more phrases to review, and clear out everything.
	if(n == englishPhrase.length )
	{
	document.getElementById("english").innerHTML = "No More Phrases to Review Today";
	document.getElementById("answer").innerHTML = " <br> ";
	document.getElementById("audio").innerHTML = " <br>";
	
	document.getElementById("buttonLabel").innerHTML = "";
	document.getElementById("forgotPhrase").innerHTML="";

	new_index = d_number + r_number;
	reviewed_indices = reviewed_indices + new_index;

	document.getElementById("js_debug").innerHTML  = "Indices which have been marked as already reviewed: " + reviewed_indices + "<br> Indices which have been marked as forgotten: " + forgotten_indices;
	document.getElementById("exit_quiz_parameters").value = reviewed_indices;
	$("#exit_quiz_parameters").val(reviewed_indices);
	
	// Exit the function because the AnswerFlag does not matter;
	return;
	}
	
	
	document.getElementById("english").innerHTML = englishPhrase[n];
	
// showAnswerFlag=0 => Displaying the Question and Answer.  When the button is pressed and showAnswerFlag=0, the next question will show up.
	if (showAnswerFlag==0)
	{
		document.getElementById("answer").innerHTML = " <br> ";
		document.getElementById("audio").innerHTML = " <br>";
		showAnswerFlag=1;
		document.getElementById("buttonLabel").innerHTML = "Check Answer";
		document.getElementById("forgotPhrase").innerHTML="";
		
		
		
		new_index = d_number + r_number;
		reviewed_indices = reviewed_indices + new_index;


	}

// showAnswerFlag=1 => Displaying the Question only.  When the button is pressed and showAnswerFlag=1, the answer will show up.
	else if (showAnswerFlag==1)
	{
		document.getElementById("answer").innerHTML = ukrainianPhrase[n];
		document.getElementById("audio").innerHTML = " <source src=\""+ audioPhrase[n]+ "\" type=\"audio/wav\">";
		document.getElementById("forgotPhrase").innerHTML="<button type=\"button\" onclick=\"forgotFunction()\">Forgot Phrase</button>";
		
		audio.load();
		audio.play();
		showAnswerFlag=0;
		
		if( parseInt(updated_indices[n][0]) < 10)
			{
			d_number = "0".concat(updated_indices[n][0]);
			}
		else
			{
			d_number = updated_indices[n][0];
			}
			
		if( parseInt(updated_indices[n][1]) < 10)
			{
			r_number = "0".concat(updated_indices[n][1]);
			}
		else
			{
			r_number = updated_indices[n][1];
			}
		
//		new_index = d_number + r_number;
//		reviewed_indices = reviewed_indices + new_index;

		n = n+1;
		document.getElementById("buttonLabel").innerHTML = "Correct - Next Phrase";

	}

	
	//document.getElementById("js_debug").innerHTML  = "Indices which have been marked as already reviewed: " + reviewed_indices + "<br> Indices which have been marked as forgotten: " + forgotten_indices;
	document.getElementById("exit_quiz_parameters").value = reviewed_indices;
	$("#exit_quiz_parameters").val(reviewed_indices);

	

}
//function exit()
//{
//	
//	$.post("exitquiz.php",{reviewed_indices: reviewed_indices});
//	window.location.href = 'exitquiz.php';
//	return false;
//
//}


</script>

</body>
</html>
