<?php 
// ini_set('session.cache_limiter','public');
// session_cache_limiter(false);
session_start();
$url=$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();

date_default_timezone_set('Asia/Calcutta');
 
 
extract(array_map("test_input" , $_POST));


if(isset($interest_name) && isset($interest_id)){ 

  $interest_name= strtolower(trim(addslashes($interest_name)));
$q=$d->select("interest_master","lower(interest_name)='$interest_name' and interest_id != '$interest_id' and status=0  and int_status  in('Imported','Admin Approved','Admin Added' )  ");
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}else if(isset($interest_name)){
$interest_name= strtolower(trim(addslashes($interest_name)));
$q=$d->select("interest_master","lower(interest_name)='$interest_name'  and status=0 and int_status  in('Imported','Admin Approved','Admin Added' ) ");
      
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}   ?>