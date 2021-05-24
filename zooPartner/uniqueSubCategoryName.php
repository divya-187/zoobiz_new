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


  if(isset($sub_category_name)){
$sub_category_name = strtolower($sub_category_name);
$q=$d->select("business_sub_categories"," lower(sub_category_name)='$sub_category_name' and business_category_id !='-2'");
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}   ?>