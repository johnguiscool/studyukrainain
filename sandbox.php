<?php

include $_SERVER['DOCUMENT_ROOT'].'/php/utility.php';

$test1 = check_against_whitelist('asbdc');
$test2 = check_against_whitelist('asbdc1222');
$test3 = check_against_whitelist('asbdc%*1222');


?>

<html>
<body>

<?

echo 'asbdc'.' '.$test1;
echo '<p>';
echo 'asbdc1222'.' '.$test2;
echo '<p>';
echo 'asbdc%*1222'.' '.$test3;
echo '<p>';


?>


</body>
</html>