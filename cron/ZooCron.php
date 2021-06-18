<?php
date_default_timezone_set('Asia/Calcutta');

$message = "Cron run Successfully  @ ".date("Y-m-d H:i:s") ;
$fh = fopen('cron_log_php.txt', (file_exists('cron_log_php.txt')) ? 'a' : 'w');
fwrite($fh, $message."\n");
fclose($fh);


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
 //send profile complete reminder SMS start
$todayDate = date('Y-m-d');
$today = date("Y-m-d");
$start = date('Y-m-d 00:00:00');
$end = date('Y-m-d 23:59:59');
$where = " AND log_time BETWEEN '$start' AND '$end'";
$result = 1;
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=0 $where ", ""); 
if (mysqli_num_rows($cron_log_master) == 0   ) {
   $q3 = $d->selectRow(" DATE_ADD( CAST(a.register_date AS DATE) , INTERVAL 1 DAY)  as FirstDay, DATE_ADD( CAST(a.register_date AS DATE) , INTERVAL 3 DAY)  as ThirdDay , DATE_ADD( CAST(a.register_date AS DATE) , INTERVAL 7 DAY)  as SeventhDay, a.user_mobile ","users_master a LEFT JOIN user_employment_details s ON a.user_id = s.user_id", " a.active_status= 0 and    s.user_id IS NULL and (  CAST(a.register_date AS DATE)  = DATE_SUB(CURDATE(), INTERVAL 1 DAY) OR  CAST(a.register_date AS DATE) = DATE_SUB(CURDATE(), INTERVAL 3 DAY) OR  CAST(a.register_date AS DATE) = DATE_SUB(CURDATE(), INTERVAL 7 DAY) )   ", "");
  if (mysqli_num_rows($q3) > 0) {
    $title = "Many Members are waiting to connect with you on Zoobiz. Complete your profile and grow your business. Lets Zoobiz!";
    $title2 = "Completed Profile attracts more business. Fill in your details and make the most of Zoobiz!";
    $title3 = "It takes 30 secs to complete Profile and Grow Business. Why Wait ? Lets Zoobiz!";
    $dataArray = array();
    $counter = 0;
    foreach ($q3 as  $value) {
      foreach ($value as $key => $valueNew) {
        $dataArray[$counter][$key] = $valueNew;
      }
      $counter++;
    }

    $section_1_mobile_number = array();
    $section_3_mobile_number = array();
    $section_7_mobile_number = array();
    for ($l = 0; $l < count($dataArray); $l++) {
     $data = $dataArray[$l];

         if ($todayDate == $data['FirstDay']) {
          $section_1_mobile_number[] = $data['user_mobile'];
          $d->sms_reminder1($data['user_mobile'],'Many');


         } else if ($todayDate == $data['ThirdDay']) {
          $section_3_mobile_number[] = $data['user_mobile'];
           $d->sms_reminder2($data['user_mobile'],'more');
            
         } else if ($todayDate == $data['SeventhDay']) {
          $section_7_mobile_number[] = $data['user_mobile'];
          $d->sms_reminder3($data['user_mobile'],'30');

         }
   }
    
  array_push($response['Success'], "");
  }
  $d->insert_cron_log("Cron Run: Profile complete reminder SMS","0");
}
//send profile complete reminder SMS start
 
//send seasonal greetings FCM end 
/*$where = " AND log_time BETWEEN '$start' AND '$end'";
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=1 $where ", "");
if (  mysqli_num_rows($cron_log_master) == 0    ) {
  $promotion_master = $d->selectRow("event_name,event_frame","promotion_master","status=0 and ( event_date = DATE_ADD(CURDATE(), INTERVAL 2 DAY) OR event_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY) OR event_date = DATE_ADD(CURDATE(), INTERVAL 0 DAY) ) ", "");

  $promotion_array = array();
  while ($data = mysqli_fetch_array($promotion_master)) {
    $promotion_array[] = $data;
  }

  
  $fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device)='android' and user_status=0      ");

 // echo "<pre>";print_r( $fcmArray);exit;
  $fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_status=0   ");
  for ($p = 0; $p < count($promotion_array); $p++) {
    $data = $promotion_array[$p];
    $title = $data['event_name'] . " Greeting Creative is Available. Lets Zoobiz!";
    if ($data['event_frame'] != '') {
      $notiUrl = $base_url . 'img/promotion/' . $data['event_frame'];
    } else {
      $notiUrl = $base_url . 'img/app_icon/ic_greetings.png';
    }
    

    $fcm_data_array = array(
            'img' =>$notiUrl,
            'title' =>$title,
            'desc' => '',
            'time' =>date("d M Y h:i A")
          );
 
    $nResident->noti("promote_business",$notiUrl,0,$fcmArray,"Seasonal Greeting",$title,$fcm_data_array);

    $nResident->noti_ios("promote_business",$notiUrl,0,$fcmArrayIos,"Seasonal Greeting",$title,$fcm_data_array);

         


     


  }
  $d->insert_cron_log("Cron Run: Seasonal Greetings Notification","1");
}*/
//send seasonal greetings FCM end


//19April21 new seasonal greetings
//send seasonal greetings FCM end 
$where = " AND log_time BETWEEN '$start' AND '$end'";
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=6 $where ", "");
if (  mysqli_num_rows($cron_log_master) == 0    ) {
  $seasonal_greet_master = $d->selectRow("seasonal_greet_master.title, seasonal_greet_image_master.cover_image","seasonal_greet_master, seasonal_greet_image_master "," seasonal_greet_image_master.seasonal_greet_id =seasonal_greet_master.seasonal_greet_id and    seasonal_greet_master.status='Active' and ( order_date = DATE_ADD(CURDATE(), INTERVAL 2 DAY) OR order_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY) OR order_date = DATE_ADD(CURDATE(), INTERVAL 0 DAY) ) and seasonal_greet_master.is_expiry='Yes' group by seasonal_greet_master.seasonal_greet_id ", "");

  $seasonal_greet_array = array(); 
  while ($data = mysqli_fetch_array($seasonal_greet_master)) {
    $seasonal_greet_array[] = $data;
    
  }
 if (  mysqli_num_rows($cron_log_master) == 0    ) {
  $fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device)='android' and user_status=0      ");
  $fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_status=0   ");
}
  for ($p = 0; $p < count($seasonal_greet_array); $p++) {
    $data = $seasonal_greet_array[$p];
    $title = $data['title'] . " Greeting Creative is Available. Lets Zoobiz!";
    if ($data['cover_image'] != '') {
      $notiUrl = $base_url . 'img/promotion/' . $data['cover_image'];
    } else {
      $notiUrl = $base_url . 'img/app_icon/ic_greetings.png';
    }
  

    $fcm_data_array = array(
            'img' =>$notiUrl,
            'title' =>$title,
            'desc' => '',
            'time' =>date("d M Y h:i A")
          );
 
    $nResident->noti("seasonal_greetings_new",$notiUrl,0,$fcmArray,"Seasonal Greeting",$title,$fcm_data_array);

    $nResident->noti_ios("seasonal_greetings_new",$notiUrl,0,$fcmArrayIos,"Seasonal Greeting",$title,$fcm_data_array);
 
  }
  $d->insert_cron_log("Cron Run: Seasonal Greetings New Notification","6");
}
//send seasonal greetings FCM end
//19april21 new seasonal greetings

//meeting reminder before 1 day start
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=2 $where ", ""); 
if (mysqli_num_rows($cron_log_master) == 0    ) {
   $q3 = $d->selectRow(" DATE_SUB( CAST(m.date AS DATE) , INTERVAL 1 DAY)  as beforeOneDay, m.* ","meeting_master m ", " m.status= 'Approve' and   (  CAST(m.date AS DATE)  = DATE_ADD(CURDATE(), INTERVAL 1 DAY)   )      ", "");
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

    $user_id_array = array('0');
    for ($l = 0; $l < count($dataArray); $l++) {
     $data = $dataArray[$l];


if(    in_array($data['member_id'], $active_user_arr) && in_array($data['user_id'], $active_user_arr)  ){
  $user_id_array[] = $data['member_id'];
  $user_id_array[] = $data['user_id'];
$meetup_date = $data['date'];
    /*$time = $data['time'];
    $place =$data['place'];
    $agenda=$data['agenda'];

    $member_data_array = $user_data_array[$data['member_id']];


    $user_data_array = $user_data_array[$data['user_id']];

    $user1=$member_data_array['user_full_name'];
    $user2=$user_data_array['user_full_name'];
      $title1 = "You have meeting tomorrow with ".$user1." on ".$time." @ ".$place." for ".$agenda;

      $title2 = "You have meeting tomorrow with ".$user2." on ".$time." @ ".$place." for ".$agenda;

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



   
   $img2 ="https://zoobiz.in/img/logo.png";
   $title1 = "You have meeting tomorrow ";
    if (strtolower($user_device)=='android') {
      $nResident->noti("meetup","",0,$user_user_token," ",$title1,$notAry,1,$img1);
    }  else if(strtolower($user_device)=='ios') {
     $nResident->noti_ios("meetup","",0,$user_user_token," ",$title1,$notAry,1,$img1);
   } */ 

}

 }
if(count($user_id_array) >1){
  $notAry = array(
        'meetup_date' => $meetup_date
      );
    $user_id_array = implode(",", $user_id_array);
     $title1 = "You have meeting(s) tomorrow";
      $img1 ="https://zoobiz.in/img/logo.png";
    $fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device)='android' and user_status=0 and user_id in ($user_id_array)      ");
     $fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_status=0 and user_id in ($user_id_array)  ");
    $nResident->noti("meetup","",0,$fcmArray,"Meetup",$title1,$notAry,1,$img1);

    $nResident->noti_ios("meetup","",0,$fcmArrayIos,"Meetup",$title1,$notAry,1,$img1);

}


          
  
    
  array_push($response['Success'], "");
  }
  $d->insert_cron_log("Cron Run: Meetup Before one Day Notification","2");
}

//meeting reminder before 1 day end 

  

//Meetup not used from last "N" days

  $settings_qry=$d->select("zoobiz_settings_master","");
  $settings_data=mysqli_fetch_array($settings_qry);
 
 
/*$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=3 $where ", ""); 
if (mysqli_num_rows($cron_log_master) == 0  && $settings_data['meetups_reminder_flag'] == 1 && $settings_data['meetup_reminder_days'] > 0   ) {
 
$meetup_reminder_days = $settings_data['meetup_reminder_days'];
$last_meetup_date =  date('Y-m-d', strtotime('-'.$meetup_reminder_days.' days')); 

 
   $q3 = $d->selectRow(" m.* ","meeting_master m  ", "m.date >='$last_meetup_date' ", "order by date desc");
    $users_arr = array('0');
  if (mysqli_num_rows($q3) > 0) {
      while($data=mysqli_fetch_array($q3)){ 
       $users_arr[]= $data['user_id'];
      }
  }
$users_arr = implode(",", $users_arr);
$fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device)='android' and user_status=0  and user_id not in   ($users_arr)  ");

 $fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_status=0   and user_id not in   ($users_arr) ");
   
   $img= "https://www.zoobiz.in/img/logo.png";
   $title ="";
   $description="Meet-ups open doors to new business. How about meeting a Zoobiz Member today? Schedule Meet-up now.
#iamzoobiz";
          $fcm_data_array = array(
            'img' =>$img,
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );
 $nResident->noti("custom_notification","Meetup",0,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification","Meetup",0,$fcmArrayIos,$title,$description,$fcm_data_array);
   array_push($response['Success'], "");
  
  $d->insert_cron_log("Cron Run: Meetup Reminder Notification","3");
}

//Classifieds not used from last "N" days end
 
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=4 $where ", ""); 
if (mysqli_num_rows($cron_log_master) == 0  && $settings_data['classified_reminder_flag'] == 1 && $settings_data['classified_reminder_days'] > 0    ) {
 
$classified_reminder_days = $settings_data['classified_reminder_days'];
$last_classifieds_date =  date('Y-m-d', strtotime('-'.$classified_reminder_days.' days')); 

   $q3 = $d->selectRow(" m.* ","cllassifieds_master m  ", "m.created_date >='$last_classifieds_date' ", "order by created_date desc");
   $users_arr = array('0');
  if (mysqli_num_rows($q3) > 0) {
      while($data=mysqli_fetch_array($q3)){ 
       $users_arr[]= $data['user_id'];
      }
   }
$users_arr = implode(",", $users_arr);
$fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device)='android' and user_status=0  and user_id not in   ($users_arr)  ");

 
 $fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_status=0   and user_id not in   ($users_arr) ");
 
   $img= "https://www.zoobiz.in/img/logo.png";
   $title ="Classified";
   $description="All your requirements can be met by Zoobiz members. Post a requirement now in Classified section.
#iamzoobiz";
          $fcm_data_array = array(
            'img' =>$img,
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );
 $nResident->noti("custom_notification","",0,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification","",0,$fcmArrayIos,$title,$description,$fcm_data_array);
   array_push($response['Success'], "");

  $d->insert_cron_log("Cron Run: Classifieds Reminder Notification","4");
}

//Classifieds not used from last "N" days end


//Timeline not used from last "N" days end
 
$cron_log_master = $d->selectRow("log_id", "cron_log_master", "type=5 $where ", ""); 
if (mysqli_num_rows($cron_log_master) == 0  && $settings_data['timeline_reminer_flag'] == 1 && $settings_data['timeline_reminder_days'] > 0   ) {
 
$timeline_reminder_days = $settings_data['timeline_reminder_days'];
$last_timeline_date =  date('Y-m-d', strtotime('-'.$timeline_reminder_days.' days')); 

   $q3 = $d->selectRow(" m.* ","timeline_master m  ", "m.created_date >='$last_timeline_date' ", "order by created_date desc");
   $users_arr = array('0');
  if (mysqli_num_rows($q3) > 0) {
      while($data=mysqli_fetch_array($q3)){ 
       $users_arr[]= $data['user_id'];
      }
   }
$users_arr = implode(",", $users_arr);
$fcmArray = $d->get_android_fcm("users_master", "user_token!='' AND  lower(device)='android' and user_status=0  and user_id not in   ($users_arr)  ");

 
 $fcmArrayIos = $d->get_android_fcm("users_master ", " user_token!='' AND  lower(device) ='ios' and user_status=0   and user_id not in   ($users_arr) ");
 
   $img= "https://www.zoobiz.in/img/logo.png";
   $title ="Timeline";
   $description="Build your reputation and let others see your achievements. Post on Zoobiz timeline now.
#iamzoobiz";
          $fcm_data_array = array(
            'img' =>$img,
            'title' =>$title,
            'desc' => $description,
            'time' =>date("d M Y h:i A")
          );
 $nResident->noti("custom_notification","",0,$fcmArray,$title,$description,$fcm_data_array);
         $nResident->noti_ios("custom_notification","",0,$fcmArrayIos,$title,$description,$fcm_data_array);
   array_push($response['Success'], "");

  $d->insert_cron_log("Cron Run: Timeline Reminder Notification","5");
}*/

//Timeline not used from last "N" days end

if ($result != 1) {
  $response["status"] = 201;
  $response["message"] = "Something went wrong";
  echo json_encode($response);
} else {
  $response["status"] = 200;
  $response["message"] = "Cron run Successfully  @ ".date("Y-m-d H:i:s") ;
  echo json_encode($response);
}
?>