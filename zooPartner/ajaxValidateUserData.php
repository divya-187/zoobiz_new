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
if (isset($_SESSION['bms_admin_id'])) {
  $bms_admin_id = $_SESSION['bms_admin_id'];
}
if (isset($_SESSION['society_id'])) {
  $society_id = $_SESSION['society_id'];
}
extract(array_map("test_input" , $_POST));

if(isset($validateAdmin_email) && $validateAdmin_email=="yes" && isset($zoobiz_admin_id) && $zoobiz_admin_id !="0"  ){
//$zoobiz_admin_id=$_SESSION[zoobiz_admin_id];
    $admin_email = strtolower(trim($admin_email));

$q=$d->select("zoobiz_admin_master","lower(admin_email)='$admin_email' and zoobiz_admin_id != '$zoobiz_admin_id'  ");
     
  
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}else

if(isset($validateAdmin_email) && $validateAdmin_email=="yes"){
//$zoobiz_admin_id=$_SESSION[zoobiz_admin_id];
   $admin_email = strtolower(trim($admin_email));
$q=$d->select("zoobiz_admin_master","lower(admin_email)='$admin_email'    ");
     
  
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}else if(isset($validateAdmin_mobile) && $validateAdmin_mobile=="yes"){

$q=$d->select("bms_admin_master","admin_mobile='$admin_mobile' and admin_id != '$bms_admin_id'  ");
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}   ?>