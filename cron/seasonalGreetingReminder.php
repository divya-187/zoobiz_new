<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
$url=$_SESSION['url'] ; 
$activePage = basename($_SERVER['PHP_SELF'], ".php");
 
include '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
include '../zooAdmin/fcm_file/user_fcm.php';
$d = new dao();
$m = new model();
$nResident = new firebase_resident();
$con=$d->dbCon();

extract(array_map("test_input" , $_POST));
$base_url=$m->base_url();

//session_start();
date_default_timezone_set('Asia/Calcutta');

//include '../zooAdmin/common/objectController.php';
$current_date_time = date('Y-m-d H:i:s');
header('Access-Control-Allow-Origin: *'); //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

$headers = apache_request_headers();
extract(array_map("test_input", $_POST));
extract(array_map("test_input", $headers));
$key = $m->api_key();
$response = array();
$todayDate = date('Y-m-d');
extract($_POST);
$today=date("Y-m-d");
$promotion_master=$d->select("promotion_master","status=0 and event_date>='$today' ","");
$promotion_array = array();
  while ($data=mysqli_fetch_array($promotion_master)) {
        $promotion_array[] =$data;
  }
 
$users_master=$d->select("users_master","user_status=0");

if (mysqli_num_rows($users_master) > 0 && mysqli_num_rows($promotion_master) > 0) {
    
    while ($users_master_data=mysqli_fetch_array($users_master)) {
         
            $response["booking"] = array();
// $incomp_user = array();
            for ($p=0; $p < count($promotion_array) ; $p++) { 
                $data = $promotion_array[$p];
            
                $before_2_days = date('Y-m-d', strtotime($data['event_date'] . ' -2 day'));
                $same_day = date('Y-m-d', strtotime($data['event_date']));

/*echo strtotime($before_2_days) .'=='. strtotime($today) .'||'. strtotime($same_day) .'=='. strtotime($today).'<br>';exit;*/
                if(strtotime($before_2_days) == strtotime($today) || strtotime($same_day) == strtotime($today) ){
                 $title= $data['event_name'];
                 $msg= $data['description'];

                if($data['event_frame']!=''){
                    $notiUrl = $base_url.'img/promotion/'. $data['event_frame'];
                } else {
                    $notiUrl = $base_url.'img/app_icon/ic_greetings.png';
                }
                
           

                if ($users_master_data['device']=='android') {
                     
                   $nResident->noti("viewMemeber",$notiUrl,0,$users_master_data['user_token'],$title,$msg,$users_master_data['user_id']);
                }  else if($users_master_data['device']=='ios') {
                  $nResident->noti_ios("viewMemeber",$notiUrl,0,$users_master_data['user_token'],$title,$msg,$users_master_data['user_id']);
                }

                }
                //array_push($response['booking'], $incomp_user);

            }
           
         
    }
     $response["status"] = 200;
            $response["message"] = "Reminder Send";
            echo json_encode($response);
} else {
    $response["status"] = 201;
    $response["message"] = "No Seasonal Greetings found";
    echo json_encode($response);
}
?>