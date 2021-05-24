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


if(isset($category_name) && isset($business_category_id)){ 
  $category_name = strtolower(trim($category_name));
$q=$d->select("business_categories",'lower(category_name)="'.$category_name.'"  and business_category_id != '.$business_category_id.' and category_status=0  ');
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}else if(isset($category_name)){
$category_name =strtolower(trim($category_name));
$q=$d->select("business_categories",'lower(category_name)="'.$category_name.'"   and category_status=0 ');
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}

else if(isset($sub_category_name)  && isset($business_category_id)  && isset($business_sub_category_id) ){
$sub_category_name = strtolower(trim($sub_category_name));
$q=$d->select("business_sub_categories",'lower(sub_category_name)="'.$sub_category_name.'" and business_category_id = '.$business_category_id.'  and business_sub_category_id != '.$business_sub_category_id.' and sub_category_status=0 ');
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}


else if(isset($sub_category_name)  && isset($business_category_id) ){
//$sub_category_name2 = mysqli_real_escape_string(strtolower(trim($sub_category_name)));

$sub_category_name2 =strtolower(trim($sub_category_name));

$q=$d->select("business_sub_categories",'lower(sub_category_name)="'.$sub_category_name2.'" and business_category_id = '.$business_category_id.' and sub_category_status=0 ');
     
 
   if(mysqli_num_rows($q) >0 ){
      echo "false";
   } else {
    echo "true";
   }  

}   ?>