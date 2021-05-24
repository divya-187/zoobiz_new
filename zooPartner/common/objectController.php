<?php 
session_start();
date_default_timezone_set('Asia/Calcutta');
$url=$_SESSION['url'] ; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
 
include '../../zooAdmin/lib/dao.php';
include '../../zooAdmin/lib/model.php'; 
$d = new dao();
$m = new model();
 
$con=$d->dbCon();
 
 

extract(array_map("test_input" , $_POST));


$base_url=$m->base_url();
$androidLink ='https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
 $iosLink='https://apps.apple.com/us/app/zoobiz/id1550560836';
?>