<?php
require_once "config.php";
if ($authsecured && (!isset($_SESSION["$authusername"]) || !$_SESSION["$authusername"] || $_SESSION["$authusername"] != $authusername )) {
    header("Location: login.php");
    exit; }
require_once 'controls-include.php';

if(isset($_COOKIE["currentRoom$usernumber"])) {
$roomnum = $_COOKIE["currentRoom$usernumber"];
$theperm = "USRPR$roomnum";

if(${$theperm} == "1") {
$_SESSION['room'] = $roomnum; } }

if(!$_SESSION['room']) {
$roomnum = $HOMEROOMU; 
$_SESSION['room'] = $roomnum; } else {
$roomnum = $_SESSION['room']; } 

header( "Location: ./controls.php" );
exit;
?>