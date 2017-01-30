<?php

///////////////////////////////////////////////////////////
//
//  INITIALIZE DIALOGUE VARIABLE
//
////////////////////////////////////////////////////////////


$dialogue_number = 30;
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



$audio_path	 = "/audio/dialogue".$dialogue_index;
$pics_path	 = "/pictures/".$dialogue_index.".png";
$texts_path	 = $_SERVER['DOCUMENT_ROOT']."/texts/";

$english_path      =$texts_path."englishphrases".$dialogue_index.".txt";
$ukrainian_path    =$texts_path."ukrainianphrases".$dialogue_index.".txt";
$speaker_path      =$texts_path."speaker".$dialogue_index.".txt";


////////////////////////////////////////////////////////
//
//  SESSION SPECIFIC STUFF
//
///////////////////////////////////////////////////////

session_start();
$username = $_SESSION['username'];

if(isset($username))
{

	

	$login_message = "<div class = \"right\">";

	$login_message = $login_message."Logged in as: ".$username;
	$login_message = $login_message."<p> <a href=\"/generalized_quiz.php\"> Daily Personal Quiz</a>";
	$login_message = $login_message."<p> <a href=\"/logout.php\">Logout </a>";
	
	//note that <div> is never closed
}
else
{
	$login_message ="";
}


include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';
$header_login_message =  generate_login_message($username);

/////////////////////////////////////////////////////
//
//	ENGLISH
//
///////////////////////////////////////////////////////

$phrases_english       = file_get_contents($english_path,true);
$phrases_english_array = explode("\r\n", $phrases_english);
$phrases_english_total ="";

foreach ($phrases_english_array as $value) 
{
    $phrases_english_total = $phrases_english_total."\"".$value."\",";
} 

$phrases_english_total = chop($phrases_english_total,",");


////////////////////////////////////////////////////////
//
//	UKRAINIAN
//
/////////////////////////////////////////////////////////

$phrases_ukrainian       = file_get_contents($ukrainian_path,true);
$phrases_ukrainian_array = explode("\r\n", $phrases_ukrainian);
$phrases_ukrainian_total ="";

foreach ($phrases_ukrainian_array as $value) 
{
    $phrases_ukrainian_total = $phrases_ukrainian_total."\"".$value."\",";
} 

$phrases_ukrainian_total = chop($phrases_ukrainian_total,",");


/////////////////////////////////////////////////////
//
//	SPEAKER
//
///////////////////////////////////////////////////////

$speaker         = file_get_contents($speaker_path,true);
$speaker_array = explode("\r\n", $speaker);
$speaker_total ="";

foreach ($speaker_array as $value) 
{
    $speaker_total = $speaker_total."\"".$value."\",";
} 

$speaker_total = chop($speaker_total,",");



if(isset($username)){

		$user_table = $username;
		
		/////////////////////////////////////////
		//
		//  LOG INTO THE DATABASE
		//
		///////////////////////////////////////
		
		$servername = "localhost";
		
		//username for database login, this is a confusing variable name usage
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
		
		/////////////////////////////////////////////
		//
		//  USE SQL TO CHECK THE DATABASE
		//
		////////////////////////////////////////////
	
			
			// Check if there any phrases from this dialogue in the user's table
			$sql = 
			"SELECT id FROM ".$user_table." WHERE dialogue_number = ".$dialogue_number.";";
		
			$result = $conn->query($sql);
		
			if($result->num_rows == 0)
			{
		
					$login_message = $login_message."<p> <a href=\"review.php?id=".$dialogue_number."\">Add Dialogue ".$dialogue_number."<br>  Phrases to <br> Phrasebook </a>";

			
			}

		
		$conn->close();
}
?>
































﻿<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style2.css">
</head>
<body> 

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/header.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/banner.php' ?>



<!--------------------------------------------->
<!--------------------------------------------->
<!-- LEFT DIV/PANEL, LINKS TO OTHER DIALOGUES-->
<!--------------------------------------------->
<!--------------------------------------------->


<div> <iframe src="links.html" scrolling="no" > </iframe></div>



<!------------------------------------->
<!------------------------------------->
<!-- MIDDLE DIV/PANEL, DIALOGUES/PICS-->
<!------------------------------------->
<!------------------------------------->


<div class = "relative">

<img src= "<?=$pics_path ?>">

<p>

<b>
Dialogue <?= $dialogue_index ?></b>
<br>

<p>

<audio id="player" controls>
  <source src="<?=$audio_path?>-01.wav" type="audio/wav">
Your browser does not support the audio element.
</audio>
<p>

<table style="width:640" id="dialogueTable">

</table>


<p align = "middle">

<a href="dialogue<?=$dialogue_next_index?>.php">  Next Dialogue</a>

</p>

</div>



<!--------------------------------------------------->
<!--------------------------------------------------->
<!-- RIGHT DIV/PANEL, USER INFORMATION IF LOGGED IN-->
<!--------------------------------------------------->
<!--------------------------------------------------->


<? echo $login_message;?>
















<script>

var englishPhrase= [<?= $phrases_english_total ?>];

var speaker = [<?= $speaker_total ?>];

var ukrainianPhrase = [<?= $phrases_ukrainian_total ?>];



///////////////////////////////////////////////
///////////////////////////////////////////////
//
// VARIABLE INITILIAZATIONS
//
///////////////////////////////////////////////
///////////////////////////////////////////////

var i =0;
var dialogueLength = ukrainianPhrase.length;
var speakerDisplayed = speaker[0];
var ukrainianPhraseDisplayed = ukrainianPhrase[0];
var englishPhraseDisplayed = englishPhrase[0];
var cumulativeTableEntries="";
var audioID = "audio";
var audioSource = ".wav";



/////////////////////////////////////////////////
/////////////////////////////////////////////////
//
// LOOP THAT BUILDS TABLE CODE
//
///////////////////////////////////////////////
///////////////////////////////////////////////

for (i=0; i<dialogueLength;i++)
{

	var speakerDisplayed = speaker[i];
	var ukrainianPhraseDisplayed = ukrainianPhrase[i];
	var englishPhraseDisplayed = englishPhrase[i];
	cumulativeTableEntries= cumulativeTableEntries+"  <tr onclick=\"myFunction(" + i + ")\"> 	<td><b>" + speakerDisplayed + "</b></td> <td>" + ukrainianPhraseDisplayed+ "</td> <td>"+englishPhraseDisplayed+"</td>  </tr> ";

}

document.getElementById("dialogueTable").innerHTML = cumulativeTableEntries;


function myFunction() 
{
	var audioID = arguments[0] +2;

	audioID = String(audioID);


	if(audioID < 10)
	{
	audioID = "0" + audioID; 
	}

	audioSource = "<?=$audio_path?>-" + audioID +".wav"; 
	var audios = new Audio(audioSource);

	audios.load();
	audios.play();
	
}





</script>







</body>
</html>