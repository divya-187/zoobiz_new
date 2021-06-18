<?php
date_default_timezone_set('Asia/Calcutta');
include '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
include '../zooAdmin/fcm_file/user_fcm.php';
$d = new dao();
$m = new model();
$nResident = new firebase_resident();
$con = $d->dbCon();
extract(array_map("test_input", $_POST));
$base_url = $m->base_url(); 
header('Access-Control-Allow-Origin: *'); //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
extract(array_map("test_input", $_POST));
$response = array();
 $d->sms_to_user_on_account_approval_request('9725528865','Demo Cron');
  $d->sms_to_user_on_account_approval_request('9726686576','Demo Cron');
  $response["status"] = 200;
  $response["message"] = "Cron run Successfully";
  echo json_encode($response);
 
?>