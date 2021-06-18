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
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
extract(array_map("test_input", $_POST));
$response = array();
  
$todayDate = date('Y-m-d');
$today = date("Y-m-d");
$start = date('Y-m-d H:i');

 

$end  = date('Y-m-d H:i', strtotime("+1 hour"));

//$end = date('Y-m-d H:i:s', strtotime($end2));

  $where = " AND log_time BETWEEN '$start' AND '$end'";
$result = 1;

 
//meeting reminder before 1 day start
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=6 $where ", ""); 

 
if (mysqli_num_rows($cron_log_master) == 0   ) {

  $timeNew = date("H:i A");


   $q3 = $d->selectRow("   m.* ","meeting_master m ", " m.status= 'Approve' and   (  CAST(m.date AS DATE)  = CURDATE()   ) and m.time ='$timeNew'     ", "");
  if (mysqli_num_rows($q3) > 0) {


    $active_usr_qry=$d->select("users_master","active_status=0");
  $active_user_arr = array();
  $user_data_array = array();
  while($active_usr_data=mysqli_fetch_array($active_usr_qry)) { 
    $active_user_arr[] = $active_usr_data['user_id'];
    $user_data_array[$active_usr_data['user_id']]  = $active_usr_data;
  }



   
    
    $dataArray = array();
    $counter = 0;
    foreach ($q3 as  $value) {
      foreach ($value as $key => $valueNew) {
        $dataArray[$counter][$key] = $valueNew;
      }
      $counter++;
    }

    
    for ($l = 0; $l < count($dataArray); $l++) {
     $data = $dataArray[$l];


if(    in_array($data['member_id'], $active_user_arr) && in_array($data['user_id'], $active_user_arr)  ){
  

    $time = $data['time'];
    $place =$data['place'];
    $agenda=$data['agenda'];

    $member_data_array = $user_data_array[$data['member_id']];


    $user_data_array = $user_data_array[$data['user_id']];

    $user1=$member_data_array['user_full_name'];
    $user2=$user_data_array['user_full_name'];
      $title1 = "You have meeting today with ".$user1." on ".$time." @ ".$place." for ".$agenda;

      $title2 = "You have meeting today with ".$user2." on ".$time." @ ".$place." for ".$agenda;

 $meetup_date = $data['date'];
 $notAry = array(
        'meetup_date' => $meetup_date
      );
  
  $memebr_device = $member_data_array['device'];
  $memebr_user_token = $member_data_array['user_token'];

      if($member_data_array['user_profile_pic']!=""){
        $img1 = $base_url . "img/users/members_profile/" . $member_data_array['user_profile_pic'];
      } else {
        $img1 ="https://zoobiz.in/img/user.png";
      }


 $user_device = $user_data_array['device'];
  $user_user_token = $user_data_array['user_token'];
  if($user_data_array['user_profile_pic']!=""){
        $img2 = $base_url . "img/users/members_profile/" . $user_data_array['user_profile_pic'];
      } else {
        $img2 ="https://zoobiz.in/img/user.png";
      }

 
    if (strtolower($memebr_device)=='android') {
      $nResident->noti("meetup","",0,$memebr_user_token," ",$title2,$notAry,1,$img2);
    }  else if(strtolower($memebr_device)=='ios') {
     $nResident->noti_ios("meetup","",0,$memebr_user_token," ",$title2,$notAry,1,$img2);
   } 



   
 

    if (strtolower($user_device)=='android') {
      $nResident->noti("meetup","",0,$user_user_token," ",$title1,$notAry,1,$img1);
    }  else if(strtolower($user_device)=='ios') {
     $nResident->noti_ios("meetup","",0,$user_user_token," ",$title1,$notAry,1,$img1);
   }  

}
          
   }
    
  array_push($response['Success'], "");
  }
  $d->insert_cron_log("Cron Run: Meetup Before one Hour Notification","6");
}

//meeting reminder before 1 day end 

 

if ($result != 1) {
  $response["status"] = 201;
  $response["message"] = "Something went wrong";
  echo json_encode($response);
} else {
  $response["status"] = 200;
  $response["message"] = "Cron run Successfully";
  echo json_encode($response);
}
?>