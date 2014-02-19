<?php
//require_once"config.php";


if(!isset($ADDONDIR)) {
	require "config.php";
}
if(!isset($roomid)) {
	$roomid = $_SESSION['room'];
}

$addonDIRarray = scandir($ADDONDIR);

array_splice($addonDIRarray, 0, 1);
array_splice($addonDIRarray, 0, 1);
	
$addonarray = array();
$availableaddons = array();
	
   for ($i = 0; $i < count($addonDIRarray); ++$i) {
		$thisxml = $ADDONDIR . $addonDIRarray[$i] . "/addon.xml";
		$response = simplexml_load_file($thisxml);

		$arr = explode(".", $addonDIRarray[$i], 2);
		$thisclassification = $arr[0];
		$thistitle = $arr[1];

		$result = $response->metadata;
		
		if($result->id != $addonDIRarray[$i] && $thisclassification != "disabled") { $thisclassification = "error"; }
		
		$addonarray["$thisclassification"]["$thistitle"]['id'] = "$result->id";
		$addonarray["$thisclassification"]["$thistitle"]['version'] = "$result->version";
		$addonarray["$thisclassification"]["$thistitle"]['name'] = "$result->name";
		$addonarray["$thisclassification"]["$thistitle"]['author'] = "$result->author";	
		$addonarray["$thisclassification"]["$thistitle"]['summary'] = "$result->summary";
		$addonarray["$thisclassification"]["$thistitle"]['description'] = "$result->description";
		$addonarray["$thisclassification"]["$thistitle"]['path'] = "$ADDONDIR$addonDIRarray[$i]/";

		if($thisclassification != 'error' && $thisclassification != 'disabled') {
			$availableaddons[] = "$result->id";
		}
    }
		if(isset($theroom) && $theroom != '' ) {
			$roomid = $theroom;
		}	
		if(isset($THISROOMID) && $THISROOMID != '' ) {
			$roomid = $THISROOMID;
		}
		if(!isset($roomid) && isset($_SESSION['room'])) {
			$roomid = $_SESSION['room'];		
		}
		if(isset($roomid)) {
			$enabledaddons = '';
			$sql2 = "SELECT addons FROM rooms WHERE roomid = $roomid LIMIT 1";
			foreach ($configdb->query($sql2) as $row2){
				$enabledaddons = $row2['addons'];
				//echo $enabledaddons."<br>";
			}
			$enabledaddonsarray = array();
			// run through enabledaddons array and create new array with settings

			
			$allenabledaddons = explode(",", $enabledaddons);
									
			foreach($allenabledaddons as $theaddon) {
				$allenabledaddons = explode(".", $theaddon, 2);
				$classification = $allenabledaddons[0];
				$title = $allenabledaddons[1];
			
			
				$sql3 = "SELECT * FROM rooms_addons WHERE roomid = $roomid AND addonid = '$theaddon' LIMIT 1";
				foreach ($configdb->query($sql3) as $addonSettings) {
					$enabledaddonsarray["$roomid"]["$theaddon"]['classification'] = $classification;
					$enabledaddonsarray["$roomid"]["$theaddon"]['title'] = $title;
					$enabledaddonsarray["$roomid"]["$theaddon"]['ADDONIP'] = $addonSettings['ip'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['MAC'] = $addonSettings['mac'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting1'] = $addonSettings['setting1'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting2'] = $addonSettings['setting2'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting3'] = $addonSettings['setting3'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting4'] = $addonSettings['setting4'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting5'] = $addonSettings['setting5'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting6'] = $addonSettings['setting6'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting7'] = $addonSettings['setting7'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting8'] = $addonSettings['setting8'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting9'] = $addonSettings['setting9'];
					$enabledaddonsarray["$roomid"]["$theaddon"]['setting10'] = $addonSettings['setting10'];
				}
			
			}

		}
	
/*
	echo "<pre>";
print_r($addonarray);	
	echo "</pre>";
	echo "<pre>";
print_r($availableaddons);	
	echo "</pre>";	
	*/
	
?>