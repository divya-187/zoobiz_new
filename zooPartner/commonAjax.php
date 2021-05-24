<?php 
session_start();
$url=$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();

date_default_timezone_set('Asia/Calcutta');
 
 
extract(array_map("test_input" , $_POST));


if(isset($primary_user_mobile) && isset($primary_user_mobile)){ 
 
$q=$d->select("users_master","user_mobile='$primary_user_mobile' and user_id !='$primary_user_id' ");
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}   ?>