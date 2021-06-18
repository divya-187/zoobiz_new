<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once '../zooAdmin/lib/dao.php';
include_once '../zooAdmin/lib/model.php';
include_once '../zooAdmin/fcm_file/user_fcm.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

$d = new dao();
$m = new model();

$nResident = new firebase_resident();
$con = $d->dbCon();

header('Access-Control-Allow-Origin: *'); //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
$base_url = $m->base_url();
$keydb = $m->api_key();
extract(array_map("test_input", $headers));
$key = $_SERVER['HTTP_KEY'];

 if(isset($_SERVER['HTTP_KEY1'])){
 	$app_version_code = $_SERVER['HTTP_KEY1'];
 }

extract(array_map("test_input" , $_POST)); 
//9dec2020
 //NEWAPI

 
 if(isset($user_register) || isset($user_register_new) || isset($user_login) || isset($getPackage)  || isset($user_register_temp)  || isset($user_register_temp_new)   || 
 	(isset($user_verify) && !$isfirst ) ||  ( isset($get_cities) && !isset($user_id) ) || isset($couponCodeValidity) || isset($user_logout)   ){
 
 } else  if(isset($getZooMembers)  &&  $_SERVER['PHP_AUTH_USER'] =="ZooBiz" && $_SERVER['PHP_AUTH_PW']=="000@000"    ){
 
 } else  { 
		$response_err = array();
		if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])  ){
			$auth_user_name= $_SERVER['PHP_AUTH_USER'];
			$auth_password= $_SERVER['PHP_AUTH_PW'];

		//	echo $auth_user_name.','.$auth_password;exit;
			$auth_check = $d->check_auth($auth_user_name,$auth_password);
		 if(!$auth_check){
		$response_err = array();
			 	//$response_err["message"]="Please provide correct auth user and auth password key. auth_user_name =".$auth_user_name." , auth_password=".$auth_password;
		$response_err["message"]="Please provide correct auth user and auth password key.";
			    $response_err["status"]="201";
			    echo json_encode($response_err);
			    exit;
		 } 
		} else {
			$response_err = array();
			$response_err["message"]="Please provide auth user and auth password key.";
		    $response_err["status"]="201";
		    echo json_encode($response_err);
		    exit;
		}

 }
//NEWAPI
/*$secret = $_SERVER['HTTP_SECRET'];
if($secret=="" || !isset($secret)){
	$response["message"]="Please provide Secret key.";
        $response["status"]="201";
        echo json_encode($response);
        exit;
} 



$resultKey = substr($secret, 3, 8);

$keyUser1 = substr($resultKey, 0, 4);
$keyUser = ltrim($keyUser1, '0');
 $keyMobile = substr($resultKey, 4, 4);


 
 
$users_master=$d->selectRow("user_id,user_mobile","users_master","user_id=$keyUser");
$users_master_data=mysqli_fetch_array($users_master);


$user_mobile =$users_master_data['user_mobile'];
$user_mobile2=substr($user_mobile, -4);

 
$user_id_secret = sprintf("%04d", $users_master_data['user_id']);
 
 
if($keyUser1.$keyMobile  !=  $user_id_secret.$user_mobile2  ) {
	 $response["message"]="wrong secret key.";
     $response["status"]="201";
     echo json_encode($response);
}*/

//9dec2020
 
?>