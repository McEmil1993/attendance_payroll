<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'lib/autoload.php';
include 'lib/constant.php';

$url = '';
$url = isset($_GET['url']) ? $_GET['url'] : "";	
$route = new route($url);

?>