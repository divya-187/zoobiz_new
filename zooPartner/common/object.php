<?php 
$url=$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
$con=$d->dbCon();
$base_url=$m->base_url();
 ?>
 