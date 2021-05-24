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


if(isset($sub_category_keyword) && isset($sub_category_keywords_id)){ 
  $sub_category_keyword = strtolower(trim($sub_category_keyword));
$q=$d->select("sub_category_keywords_master",'lower(sub_category_keyword)="'.$sub_category_keyword.'"  and sub_category_keywords_id != '.$sub_category_keywords_id.'  and business_sub_category_id = '.$business_sub_category_id.' ');
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}else if(isset($sub_category_keyword)){
$sub_category_keyword =strtolower(trim($sub_category_keyword));
$q=$d->select("sub_category_keywords_master",'lower(sub_category_keyword)="'.$sub_category_keyword.'"  and business_sub_category_id = '.$business_sub_category_id.' ');
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}
  ?>