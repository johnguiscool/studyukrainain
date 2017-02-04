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
<title> How to </title>
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

<h2> How to use this website</h2>

The Ukrainian language course on this website is comprised of 34 lessons in the form of dialogues.  The goal of this course is to teach you conversational Ukrainian by focusing on those words and phrases that come up most typically in everyday conversation.  After completing the 34 lessons of this course, you will be able to have real conversations in the Ukrainain language.  

<p> 

We recommend going through the following process with each lesson:
<ol>

<li> Read the English translation of the dialogue to get an idea of what the dialogue is about. <br>
<img class="howto" src="/website_pictures/howto1.png"></li>
<p>

<li> Listen to the dialogue in its entirety, following along with the script.  To listen to the dialogues, click on the play button on the audio bar under the picture of each dialogue.<br>

<img class="howto" src="/website_pictures/howto2.png"></li>
<p>

<li>  After listening to the dialogue, try to repeat each new phrase of the dialogue aloud.  You can listen to each individual line of a dialogue individually by clicking on that line in the dialogue table.<br>
<img class="howto" src="/website_pictures/howto3.png"></li>
<p>

<li>  If you are logged in to an account, you can add the phrases you learned in the dialogue to your personal phrasebook by clicking on the "Add Dialogue Phrases to Phrasebook" link in the sidebar. <br>
<img class="howto" src="/website_pictures/howto4.png"> </li>

<p>

<li> Once you have added some phrases to your phrasebook, they will start to show up in your daily personal quiz.  During each quiz, you will be prompted on how to say certain phrases in Ukrainian.  Try to speak the phrases aloud and then check your answer against the audio recording.  Don't worry if you struggle with remembering a phrase at first.  Research shows that the best way to learn new words and phrases in a foreign language is by trying to recall these phrases multiple times.  After practicing these phrases many times, they will be cemented in your memory.  Check your daily personal quiz every day by clicking on the "Daily Personal Quiz" link in the sidebar. <br> 
<img class="howto" src="/website_pictures/howto5.png">
</li>

</ol>

<?php include $_SERVER['DOCUMENT_ROOT'].'/php/footer.php' ?>


</body>
</html>