<?php
$found2 = false;
$path2 = './sessions';
while(!$found2){
	if(file_exists($path2)){ 
		$found2 = true;
		$sessionsloc = $path2;
	}
	else{ $path2= '../'.$path2; }
}
ini_set('display_errors', 'Off');
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100	);
ini_set('session.save_path', "$sessionsloc");
ini_set('session.cookie_lifetime', 86400);
if(!isset($_SESSION)){session_start();}
 
$found1 = false;
$path1 = './lib/class.settings.php';
while(!$found1){	
	if(file_exists($path1)){ 
		$found1 = true;
                require_once("$path1");
	}
	else{ $path1= '../'.$path1; }
}

$found2 = false;
$path2 = './config/config.ini';
while(!$found2){
	if(file_exists($path2)){ 
		$found2 = true;
		$Config2 = new ConfigMagik( $path2, true, true);
	}
	else{ $path2= '../'.$path2; }
}

	$u = 1;
	$USERNAMES = array("none");
	$HOWMANYUSERS = 0;
	while($u>0) {
		$founduser = $Config2->get('USERNAME',"USER$u");
		if(isset($founduser)) {
			$HOWMANYUSERS = $u;
			$USERNAME = "USERNAME$u";
			${$USERNAME} = $Config2->get('USERNAME',"USER$u");
			array_push($USERNAMES,${$USERNAME});
			$u++;
		} else { $u = -5; }
	}

if($HOWMANYUSERS > 0) {
	if (!isset($_SESSION['usernumber']) || $_SESSION['usernumber'] == "choose") {
		if(isset($_POST['usernumber'])) { $_SESSION['usernumber'] = $_POST['usernumber']; }
		elseif (!$_GET['user']) {
			$thepath = dirname(dirname($_SERVER['PHP_SELF']));
			header("Location: $thepath");
				exit;
		} else {
	   $_SESSION['usernumber'] = $_GET['user']; }
	   $usernumber = $_SESSION['usernumber'];
	} else {
		if (isset($_GET['user']) && $_GET['user']!="choose") {
			$_SESSION['usernumber'] = $_GET['user']; }
			$usernumber = $_SESSION['usernumber'];
	}
}

          $rooms;
	  	  $TOTALROOMS = 0;
          $x = $Config2->get('ROOMS');
          if(!empty($x)){
              foreach ($x as $k=>$e){
                  $k = str_ireplace('_', ' ', $k);
                  $rooms["$k"]         = "$e";
				   $TOTALROOMS++;
		          }
		      }	  

	if(!empty($rooms)){
		$c = 1;
		foreach( $rooms as $roomlabel => $gnavlinks) {
			$ROOMXBMC = "ROOM$c"."XBMC";
			$ROOMXBMCM = "$ROOMXBMC"."M";
			$ROOMname = "ROOM$c"."N";
			$gnavlinks = explode(",",$gnavlinks);
			${$ROOMname} = $gnavlinks[0];
			${$ROOMXBMC} = $gnavlinks[1];
			if(isset($gnavlinks[2]) && $gnavlinks[2] != '') { ${$ROOMXBMCM} = $gnavlinks[2]; } else { ${$ROOMXBMCM} = 0; }
			$c++;
		}
	}

if($usernumber != "choose") {
     $authusername           = $AUTH_USERNAME          = $Config2->get('USERNAME',"USER$usernumber");
     $authpassword           = $AUTH_PASS              = $Config2->get('PASSWORD',"USER$usernumber");
	 if($AUTH_PASS) { $AUTH_ON = 1; } else { $AUTH_ON = 0; }
	 $authsecured            = $AUTH_ON;
     $NAVGROUPS              = $Config2->get("NAVGROUPACCESS","USER$usernumber");
}
   //  $GLOBAL_USER_PASS    = filter_var($Config2->get('AUTHENTICATION','GLOBAL'), FILTER_VALIDATE_BOOLEAN);
   //  $GLOBAL_IP           = $Config2->get('URL','GLOBAL');
   //  $GLOBAL_USER         = $Config2->get('USERNAME','GLOBAL');
   //  $GLOBAL_PASS         = $Config2->get('PASSWORD','GLOBAL');
?>