<?php

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';


///////////////////////////////////////////////////////////
//
//  INITIALIZE DIALOGUE VARIABLE
//
////////////////////////////////////////////////////////////


$dialogue_number = 1;

// Set the $dialogue_number variable to the value passed through the URL.  If no value is set, use the default value =1 from above.
$dialogue_number_try = $_GET["dialogue"];

if(isset($dialogue_number_try))
{
	$dialogue_number = $dialogue_number_try;
} 


$dialogue_next   = $dialogue_number + 1;


// Appends a zero "0" before the dialogue number if it's less than 10.  For example, "5" => "05", etc.
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



$texts_path	 = $_SERVER['DOCUMENT_ROOT']."/texts/";

$content_path      =$texts_path."grammarexplanation".$dialogue_index.".txt";



/////////////////////////////////////////////////////
//
//	CONTENTS
//
///////////////////////////////////////////////////////


$contents       = file_get_contents($content_path,true);

$phrase_transliteration = new TranslitUk();
$contents_transliterated = $phrase_transliteration->convert($contents);



?>
































﻿<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/style2.css">
<title> Lessons - Dialogue <?php $dialogue_number?> - Grammar Explanation</title>
<?php include $_SERVER['DOCUMENT_ROOT'].'/php/meta.php'; ?>

</head>
<body> 


<div id="HTML Content"> <?php echo $contents_transliterated ?> </div>



<p align = "middle">
<button type="button" onclick="toggleTransliteration()" id="toggleTransliterationButton">Show Cyrillic</button>
<p align = "middle">

</p>

</div>




<script>


var currentTransliterationDisplay = "latin";

function toggleTransliteration()
{



	if(currentTransliterationDisplay == "latin")
	{
		document.getElementById("HTML Content").innerHTML = <?php echo json_encode($contents) ?>;
		currentTransliterationDisplay = "cyrillic";
		document.getElementById("toggleTransliterationButton").innerHTML = "Show Transcription in Latin Letters";	
	}
	else if(currentTransliterationDisplay == "cyrillic")
	{
	
		document.getElementById("HTML Content").innerHTML = <?php echo json_encode($contents_transliterated) ?>;		
		currentTransliterationDisplay = "latin";
		document.getElementById("toggleTransliterationButton").innerHTML = "Show Cyrillic";	

	
	}
	
}


</script>







</body>
</html>