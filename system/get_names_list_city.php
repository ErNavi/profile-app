<?php
require_once '../common.php';

$city_id = intval($_REQUEST['city_id']);

$city_progress = 0;
$counter = 0;
$verified = 0;
$people = $sql->getById("SELECT id, name,phone,profile_progress,verification_status FROM User WHERE status='1' AND user_type='volunteer' AND city_id=$city_id ORDER BY profile_progress ASC");

if($people) {

	foreach($people as $person) {
		$counter++;
		if( (strpos($person['verification_status'] , "email") !== false ) && (strpos($person['verification_status'] , "sms") !== false ) )
				$verified++;
	}
	
	$percentage = round((($verified/$counter)*100),0,PHP_ROUND_HALF_DOWN);
	
	//print "<h2 class='no_completed'>Email & Phone Verified : $verified/$counter ($percentage%)</h2>";
	
	print "<table>";
	print"<th>Name</th><th>Progress %</th>";
	foreach($people as $person) {
		print "<tr><td>$person[name]</td><td>$person[profile_progress]</td></tr>";
		$city_progress = $city_progress + $person['profile_progress']; 
	
	}

$city_progress = ($city_progress/$counter)/100;
$city_progress_exc_fb = $verified/$counter;

print "</table>";

print "<script type='text/javascript' > loader.setProgress($city_progress_exc_fb); </script>";
//print "<script type='text/javascript'> document.getElementsById('no_completed')[0].innerHTML = 'Completed : $verified/$counter'; </script>";
}

?> 
