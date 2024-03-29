<?php
//SET UP PHP SESSION
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);


define('PREFIX', 'boiler');
session_name(PREFIX);


//THIS IS JUST TO REDUCE PHP ERRORS
date_default_timezone_set("America/Chicago");

session_save_path("../");

//START THE SESSION
session_start();

$app_name = "Students App";

//CREATE VARIABLES FOR ANY EXTERNAL FILES THAT MAY NEED TO BE INCLUDED ON MULTIPLE PAGES
//SO IF THE FILE NEEDS TO BE UPDATED, IT ONLY HAS TO BE UPDATED IN 1 PLACE

//INCLUDE ANY MYSQLI OR ORACLE CLASS HERE:
require_once('mysqli_class.php');
$mysqli = new mysqli_class();