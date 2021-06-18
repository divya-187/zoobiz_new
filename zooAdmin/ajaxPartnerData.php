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
 
extract(array_map("test_input" , $_POST));

if(  isset($zoobiz_partner_id) && $zoobiz_partner_id !="0"  ){
    $partner_mobile = strtolower(trim($partner_mobile));
    $q=$d->select("zoobiz_partner_master","lower(partner_mobile)='$partner_mobile' and zoobiz_partner_id != '$zoobiz_partner_id'  ");
     
  
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}else {

$partner_mobile = strtolower(trim($partner_mobile));
$q=$d->select("zoobiz_partner_master","lower(partner_mobile)='$partner_mobile'    ");
     
  
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}   ?>