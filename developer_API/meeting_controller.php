<?php
include_once 'lib.php';
if (isset($_POST) && !empty($_POST)) {

  if ($key == $keydb) {

    $response = array();
    extract(array_map("test_input" , $_POST));

    if ($_POST['addMeeting'] == "addMeeting" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($member_id, FILTER_VALIDATE_INT) == true) {

      $date = str_replace("/", "-",$date);

      $meeting_date = date("Y-m-d", strtotime($date));

      $m->set_data('date', $meeting_date);
      $m->set_data('time', $time);
      $m->set_data('place', $place);
      $m->set_data('agenda', $agenda);
      $m->set_data('user_id', $user_id);
      $m->set_data('member_id', $member_id); 
      $a = array(
        'date' => $m->get_data('date'), 
        'time' => $m->get_data('time'), 
        'place' => $m->get_data('place'), 
        'agenda' => $m->get_data('agenda'), 
        'user_id' => $m->get_data('user_id'), 
        'member_id' => $m->get_data('member_id') ,
        'action_user_id' =>$m->get_data('user_id')
      );
      $q = $d->insert("meeting_master",$a);


      $meeting_master_qry = $d->select("meeting_master", "date='$meeting_date' and time='$time' and user_id='$user_id' and member_id='$member_id' and action_user_id ='$user_id' and place = '$place' order by  meeting_id desc limit 0,1  ");
      $meeting_master_data = mysqli_fetch_array($meeting_master_qry);
      $latest_meeting_id = $meeting_master_data['meeting_id'];
      
      if ($q == true) {



        $qUserToken = $d->select("users_master", "user_id='$member_id'");
        $userData = mysqli_fetch_array($qUserToken);

        $user_token=$userData['user_token'];
        $device=$userData['device'];
        $feed_user_id=$userData['user_id'];
        
        $user_name = $userData['user_full_name'];
        $title = "$user_name ";
        $msg = "Let's Meet";

        $qUserTokenN = $d->select("users_master", "user_id='$user_id'  ");
        $userDataN = mysqli_fetch_array($qUserTokenN);

        $cities = $d->select("cities,business_adress_master", "business_adress_master.user_id='$user_id' and cities.city_id = business_adress_master.city_id and business_adress_master.adress_type=0  ");
        $cities_data = mysqli_fetch_array($cities);
      $title="Meetup Scheduled";//$userDataN['user_full_name']. "  member from ".$cities_data['city_name']." has requested for a meeting.";
      $msg =$userDataN['user_full_name']." From ".$cities_data['city_name']." is Requesting for a meeting on ".date("d F Y",strtotime($date)).", ".$time." @ ".$place; 
      
    // $msg ="Congratulations! ".$userDataN['user_full_name']." ready for a Meet Up on ".date("d F Y",strtotime($date)).", ".$time." @ ".$place; 




      $notiAry = array(
        'user_id' => $feed_user_id,
        'notification_title' => $title,
        'notification_desc' => $msg ,
        'notification_date' => date('Y-m-d H:i'),
        'notification_action' => 'meetup',
        'notification_logo' => 'meetup.png',
        'notification_type' => '10',
        'other_user_id' => $user_id ,
        'timeline_id' =>$latest_meeting_id
      );
      
      $d->insert("user_notification", $notiAry);
      


      if($userDataN['user_profile_pic']!=""){
        $img = $base_url . "img/users/members_profile/" . $userDataN['user_profile_pic'];
      } else {
        $img ="https://zoobiz.in/img/user.png";
      }
      $meetup_date = $meeting_date;
      $notAry = array(
        'meetup_date' => $meetup_date
      );


      if (strtolower($device)=='android') {
        $nResident->noti("meetup","",0,$user_token,"Meetup" ,$msg,$notAry,1,$img);
      }  else if(strtolower($device) =='ios') {
       $nResident->noti_ios("meetup","",0,$user_token,"Meetup",$msg,$notAry,1,$img);
     }


     $d->insert_myactivity($user_id,"0","", "Meetup Scheduled with ".$userData['user_full_name'],"activity.png");
     $response["message"] = "Meetup Scheduled";
     $response["status"] = "200";
     echo json_encode($response);
     exit();
   } else {
     $response["message"] = "Meetup Schedule Failed.";
     $response["status"] = "201";
     echo json_encode($response);
   }
   
   

   

   



 }

 else if ($_POST['deleteMeeting'] == "deleteMeeting" && filter_var($meeting_id, FILTER_VALIDATE_INT) == true && filter_var($user_id, FILTER_VALIDATE_INT) == true  ){
   $gu=$d->select("meeting_master","meeting_id ='$meeting_id'");
   $meetingData=mysqli_fetch_array($gu);

 //  $q = $d->delete("meeting_master","meeting_id='$meeting_id'");
$a = array(
    'status' => 'Deleted' 
   );
  $q = $d->update("meeting_master",$a,"meeting_id ='$meeting_id'" );
   if($q>0) {
     $d->insert_myactivity($user_id,"0","", "Rejected Meetup Deleted - ".$meetingData['date'].' '.$meetingData['time'],"activity.png");
     $response["message"] = "Meetup Deleted";
     $response["status"] = "200";
     echo json_encode($response);
     exit();
   } else {
     $response["message"] = "Something Went Wrong";
     $response["status"] = "201";
     echo json_encode($response);
   }


 }
 else if ($_POST['updateMeeting'] == "updateMeeting" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($member_id, FILTER_VALIDATE_INT) == true) {

  $date = str_replace("/", "-",$date);
  
  $meeting_date = date("Y-m-d", strtotime($date));

  $m->set_data('date', $meeting_date);
  $m->set_data('time', $time);
  $m->set_data('place', $place);
  $m->set_data('agenda', $agenda);
  $m->set_data('user_id', $user_id);
  $m->set_data('member_id', $member_id); 
  $a = array(
    'date' => $m->get_data('date'), 
    'time' => $m->get_data('time'), 
    'place' => $m->get_data('place'), 
    'agenda' => $m->get_data('agenda'), 
    'user_id' => $m->get_data('user_id'), 
    'member_id' => $m->get_data('member_id') 
  );
  $q = $d->update("meeting_master",$a,"meeting_id ='$meeting_id'" );

  if ($q == true) {
    $qUserToken = $d->select("users_master", "user_id='$member_id'");
    $userData = mysqli_fetch_array($qUserToken);

    $user_token=$userData['user_token'];
    $device=$userData['device'];
    $feed_user_id=$userData['user_id'];
    if (strtolower($device)=='android') {
      $nResident->noti("meetup","",0,$user_token,"Meetup",$agenda,'');
    }  else if(strtolower($device)=='ios') {
     $nResident->noti_ios("meetup","",0,$user_token,"Meetup",$agenda,'');
   }
   $d->insert_myactivity($user_id,"0","", "You set meeting with ".$userData['user_full_name'],"activity.png");
   $response["message"] = "Updated Successfully";
   $response["status"] = "200";
   echo json_encode($response);
   exit();
 } else {
   $response["message"] = "Fail to Update Meeting.";
   $response["status"] = "201";
   echo json_encode($response);
 } 
} else if ($_POST['approveMeeting'] == "approveMeeting" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($meeting_id, FILTER_VALIDATE_INT) == true) {




  $qUserToken = $d->select("users_master,meeting_master", " users_master.user_id =meeting_master.user_id and   meeting_master.meeting_id='$meeting_id'");
  $userData = mysqli_fetch_array($qUserToken);
  $status  = $userData['status'];

  if($userData['user_id']==$user_id){
    $opp_user_id = $userData['member_id']; 
  } else {
    $opp_user_id = $userData['user_id']; 
  }
  $m->set_data('status', "Approve"); 
  $m->set_data('reason', $reason); 
  $m->set_data('action_user_id', $user_id); 

  $a = array(
    'status' => $m->get_data('status'),
    'reason' => $m->get_data('reason') ,
    'action_user_id' => $m->get_data('action_user_id') 
  );
  $q = $d->update("meeting_master",$a,"meeting_id ='$meeting_id'" );


  if ($q == true) {

    $uquery5 = $d->select("users_master", "  user_id = '$user_id'");
    $u_data5 = mysqli_fetch_array($uquery5);



    if($status=="Reschedule"){
      $user_id = $userData[member_id]; 
    }
    $uquery = $d->select("users_master", "  user_id = '$user_id'");
    $u_data = mysqli_fetch_array($uquery);




    $member_id_n = $userData[user_id];
    $uquery2 = $d->select("users_master", "  user_id = '$member_id_n'");
    $u_data2 = mysqli_fetch_array($uquery2);
              // $user_name = $userData['user_full_name'];
      /*$title = "$user_name ";
      $msg = "Let's Meet";*/




      $opp_user = $d->select("users_master", "  user_id = '$opp_user_id'");
      $opp_user_data = mysqli_fetch_array($opp_user);

      $user_token=$opp_user_data['user_token'];
      $device=$opp_user_data['device'];
      $feed_user_id=$opp_user_data['user_id'];


      $title ="Meetup" ; 
    //  $msg = $u_data5['user_full_name']. " is Asking, Lets Meet on ". date("d F Y",strtotime($userData['date'])).", ".$userData['time']." @ ".$userData['place'];//$u_data5['user_full_name']. " has accepted your request for meeting on ". date("d F Y",strtotime($userData['date']))." at ".$userData['time'].". Happy Networking";

      $msg ="Congratulations! ".$u_data5['user_full_name']." ready for a Meet Up on ".date("d F Y",strtotime($userData['date'])).", ".$userData['time']." @ ".$userData['place']; 

      $notiAry = array(

        'user_id' => $feed_user_id,
        'notification_title' => $title,
        'notification_desc' => $msg   ,
        'notification_date' => date('Y-m-d H:i'),
        'notification_action' => 'meetup',
        'notification_logo' => 'meetup.png',
        'notification_type' => '10',
        'other_user_id' => $user_id ,
        'timeline_id' =>$meeting_id
      );
      $d->insert("user_notification", $notiAry);



      if($u_data5['user_profile_pic']!=""){
        $img = $base_url . "img/users/members_profile/" . $u_data5['user_profile_pic'];
      } else {
        $img ="https://zoobiz.in/img/user.png";
      }


      $meeting_master_qry = $d->select("meeting_master", "meeting_id='$meeting_id'   ");
      $meeting_master_data = mysqli_fetch_array($meeting_master_qry);
      $meetup_date = $meeting_master_data['date'];

      $time11= date("H:i", strtotime($userData['time']));
      $time4 = explode(" ", $userData['time']);
      $date1  =$userData['date'].' '.$time11;

      $timestamp = strtotime($time11) + 60*60;

     $time_end =$time11;//date('H:i', $timestamp);
     $date2  =$userData['date'].' '.$time_end;
//$date2  =strtotime($date2) + 60*60;


     $newDate = strtotime($date2) + 60*60;
     $meetup_date1 =date( "Y-m-d H:i",strtotime($date1)); 
     $meetup_date2 =date( "Y-m-d H:i",$newDate); 


$date_before_1_day = date("Y-m-d", strtotime($date1."-1 day"));
$currDate = date("Y-m-d");
if(strtotime($date_before_1_day) < strtotime($currDate) ){
  $date_before_1_day =$currDate;
}


$minus1hr = strtotime($date2) - 60*60;
$meetup_date_minus1hr =date( "Y-m-d H:i",$minus1hr); 

     $m->set_data('modify_date',date('Y-m-d H:i:s'));

     $aMain = array(
       'admin_id'=>'1',
       'feed_type'=>'6',
       'timeline_text'=>'',
       'send_notification_to_user'=>'1',
       'user_id'=>'0',
       'created_date'=>$m->get_data('modify_date'),
       'meetup_user_id2'=>$userData['member_id'],
       'meetup_user_id1'=>$userData['user_id']
     );
     $qwer=$d->insert("timeline_master",$aMain);



$msgRes1 = "You have meeting with ".$u_data['user_full_name']." on ".date("d F Y h:i A",strtotime($userData['date'] .' '. $userData['time']))." @ ".$userData['place']." for ".$userData['agenda'];

if($u_data['user_profile_pic']!=""){
        $m_profile = $base_url . "img/users/members_profile/" . $u_data['user_profile_pic'];
      } else {
        $m_profile ="https://zoobiz.in/img/user.png";
      }


     $notAry = array(
      'date_before_1_day' => $date_before_1_day,
      'meetup_date' => $meetup_date,
      'meeting_id' => $meeting_id,
      'fcm_message' => $msgRes1,
      'm_date' => date("Y-m-d",  strtotime($userData['date']) ),
      'm_profile' =>$m_profile ,
      'm_time' =>date("H:i", strtotime($meetup_date_minus1hr)) ,// $time11,
      'date' => $meetup_date1,
      'end_date' => $meetup_date2,
      'place' => $userData['place'],
      'meetup_with' =>"Meetup With ". $u_data5['user_full_name'],
      'agenda' => $userData['agenda'],
      'user_id' => $userData['user_id'],
      'member_id' => $userData['member_id'],
      'action_user_id' => $userData['action_user_id']
    );

     if (strtolower($device)=='android') {
      $nResident->noti("meetup","",0,$opp_user_data['user_token'],"Meetup",$msg,$notAry,1,$img);
    }  else if(strtolower($device)=='ios') {
     $nResident->noti_ios("meetup","",0,$opp_user_data['user_token'],"Meetup",$msg,$notAry,1,$img);
   }

    // echo $q.'test';exit;
   $d->insert_myactivity($user_id,"0","", "You Approved meeting with ".$opp_user_data['user_full_name'],"activity.png");

if($opp_user_data['user_profile_pic']!=""){
        $m_profile2 = $base_url . "img/users/members_profile/" . $opp_user_data['user_profile_pic'];
      } else {
        $m_profile2 ="https://zoobiz.in/img/user.png";
      }
 $msgRes = "You have meeting with ".$opp_user_data['user_full_name']." on ".date("d F Y h:i A",strtotime($userData['date'] .' '. $userData['time']))." @ ".$userData['place']." for ".$userData['agenda'];

   $response["date_before_1_day"] = $date_before_1_day; 
   $response["meeting_id"] = $meeting_id; 
   $response["fcm_message"] = $msgRes;
   $response["date"] = $meetup_date1;
   $response["end_date"] = $meetup_date2;
$response["m_profile"] = $m_profile2;
    $response["m_date"] = date("Y-m-d", strtotime($userData['date']));
   $response["m_time"] = date("H:i", strtotime($meetup_date_minus1hr)) ;// $time11;




   $response["place"] =$userData['place'];
   $response["meetup_with"] ="Meetup With ". $opp_user_data['user_full_name'];
   $response["agenda"] =$userData['agenda'];
   $response["user_id"] =$userData['user_id'];
   $response["member_id"] =$userData['member_id'];
   $response["action_user_id"] =$userData['action_user_id'];

   $response["message"] = "Meetup Approved";
   $response["status"] = "200";
   echo json_encode($response);
   exit();
 } else {
   $response["message"] = "Meetup Approval Failed.";
   $response["status"] = "201";
   echo json_encode($response);
 } 

} else if ($_POST['rejectMeeting'] == "rejectMeeting" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($meeting_id, FILTER_VALIDATE_INT) == true) {

  $qUserToken = $d->select("users_master,meeting_master", " users_master.user_id =meeting_master.user_id and   meeting_master.meeting_id='$meeting_id'");
  $userData = mysqli_fetch_array($qUserToken);
  if($userData['user_id']==$user_id){
    $opp_user_id = $userData['member_id']; 
  } else {
    $opp_user_id = $userData['user_id']; 
  }

  $m->set_data('status', "Reject"); 
  $m->set_data('reason', $reason); 
  $m->set_data('action_user_id', $user_id); 

  $a = array(
    'status' => $m->get_data('status'),
    'reason' => $m->get_data('reason'),
    'action_user_id' => $m->get_data('action_user_id')   
  );
  $q = $d->update("meeting_master",$a,"meeting_id ='$meeting_id'" );
  if ($q == true) {



    $member_id_n = $userData[user_id];
    $uquery2 = $d->select("users_master", "  user_id = '$member_id_n'");
    $u_data2 = mysqli_fetch_array($uquery2);
           //   $user_name = $userData['user_full_name'];
    $title = "$user_name ";
    $msg = "Let's Meet";

    $uquery = $d->select("users_master", "  user_id = '$user_id'");
    $u_data = mysqli_fetch_array($uquery);


    $opp_user = $d->select("users_master", "  user_id = '$opp_user_id'");
    $opp_user_data = mysqli_fetch_array($opp_user);

    $user_token=$opp_user_data['user_token'];
    $device=$opp_user_data['device'];
    $feed_user_id=$opp_user_data['user_id'];

    
                  $title ="Meetup" ;//"Meeting Rejected";
      $msg =$u_data['user_full_name']." is Suggesting, Lets Meet Later!";//$u_data['user_full_name']. " has some other schedule and cannot accept your request for meeting on ". date("d F Y",strtotime($userData['date']))." at ".$userData['time'].". Happy Networking";


      $notiAry = array(
        'user_id' => $feed_user_id,
        'notification_title' => $title,
        'notification_desc' => $msg   ,
        'notification_date' => date('Y-m-d H:i'),
        'notification_action' => 'meetup',
        'notification_logo' => 'meetup.png',
        'notification_type' => '10',
        'other_user_id' => $user_id ,
        'timeline_id' =>$meeting_id
      );
      $d->insert("user_notification", $notiAry);
      if($u_data['user_profile_pic']!=""){
        $img = $base_url . "img/users/members_profile/" . $u_data['user_profile_pic'];
      } else {
        $img ="https://zoobiz.in/img/user.png";
      }
      $meeting_master_qry = $d->select("meeting_master", "meeting_id='$meeting_id'   ");
      $meeting_master_data = mysqli_fetch_array($meeting_master_qry);
      $meetup_date = $meeting_master_data['date'];
      $notAry = array(
        'meetup_date' => $meetup_date
      );
      if (strtolower($device)=='android') {
        $nResident->noti("meetup","",0,$user_token,"Meetup",$msg,$notAry,1,$img);
      }  else if(strtolower($device)=='ios') {
       $nResident->noti_ios("meetup","",0,$user_token,"Meetup",$msg,$notAry,1,$img);
     }
     $d->insert_myactivity($user_id,"0","", "Meetup Rejected with ".$opp_user_data['user_full_name'],"activity.png");
     $response["message"] = "Meetup Rejected";
     $response["status"] = "200";
     echo json_encode($response);
     exit();
   } else {
     $response["message"] = "Meetup Rejection Failed";
     $response["status"] = "201";
     echo json_encode($response);
   } 
 } else if ($_POST['rescheduleMeeting'] == "rescheduleMeeting" && filter_var($user_id, FILTER_VALIDATE_INT) == true && filter_var($meeting_id, FILTER_VALIDATE_INT) == true) {
   $date = str_replace("/", "-",$date);
   $meeting_date = date("Y-m-d", strtotime($date));

   $m->set_data('date', $meeting_date);
   $m->set_data('time', $time);
   $m->set_data('place', $place);
   $m->set_data('agenda', $agenda); 
   $m->set_data('reason', $reason); 
   $m->set_data('status', "Reschedule"); 
   $m->set_data('action_user_id', $user_id); 

   $a = array(
    'date' => $m->get_data('date'), 
    'time' => $m->get_data('time'), 
    'place' => $m->get_data('place'), 
    'agenda' => $m->get_data('agenda'), 
    'reason' => $m->get_data('reason') , 
    'status' => $m->get_data('status') ,
    'action_user_id' => $m->get_data('action_user_id') 
  );
   $q = $d->update("meeting_master",$a,"meeting_id ='$meeting_id'" );

   if ($q == true) {

    $meeting_master = $d->selectRow("user_id,member_id","meeting_master", "meeting_id='$meeting_id'");
    $meeting_master_data = mysqli_fetch_array($meeting_master);


    $member_id_n = $meeting_master_data[user_id];
    $uquery2 = $d->select("users_master", "  user_id = '$member_id_n'");
    $u_data2 = mysqli_fetch_array($uquery2);
    if($meeting_master_data['user_id'] == $user_id){
      $uid= $meeting_master_data['member_id'];
    } else {
      $uid= $meeting_master_data['user_id'];
    }

    $qUserToken = $d->select("users_master", "user_id='$uid'");
    $userData = mysqli_fetch_array($qUserToken);

    $user_token=$userData['user_token'];
    $device=$userData['device'];
    $feed_user_id=$userData['user_id'];

    $user_name = $userData['user_full_name'];
    $title = "$user_name ";
    $msg = "Let's Meet";

    $uquery = $d->select("users_master", "  user_id = '$user_id'");
    $u_data = mysqli_fetch_array($uquery);

    if($u_data['user_profile_pic']!=""){
      $img = $base_url . "img/users/members_profile/" . $u_data['user_profile_pic'];
    } else {
      $img ="https://zoobiz.in/img/user.png";
    }


      //$title =$u_data['user_full_name']. " has some other schedule and has requested for meeting with revised schedule";
$title ="Meetup";//$u_data['user_full_name']." Rescheduled Meeting";
      $msg =$u_data['user_full_name']. " has a schedule already and asking to reschedule meeting to ".date("d F Y",strtotime($date)).", ".$time." @".$place;//$u_data['user_full_name']. " has some other schedule and has requested for meeting with revised schedule. ".strtoupper(" Schedule: "). date("d F Y",strtotime($date))." at ".$time.", would you like to confirm the meeting?";

      $notiAry = array(
        'user_id' => $feed_user_id,
        'notification_title' =>$title,
        'notification_desc' => $msg   ,
        'notification_date' => date('Y-m-d H:i'),
        'notification_action' => 'meetup',
        'notification_logo' => 'meetup.png',
        'notification_type' => '10',
        'other_user_id' => $user_id ,
        'timeline_id' =>$meeting_id
      );
      $d->insert("user_notification", $notiAry);


      $meeting_master_qry = $d->select("meeting_master", "meeting_id='$meeting_id'   ");
      $meeting_master_data = mysqli_fetch_array($meeting_master_qry);
      $meetup_date = $meeting_master_data['date'];
      $notAry = array(
        'meetup_date' => $meetup_date
      );
      
      if (strtolower($device)=='android') {
        $nResident->noti("meetup",'',0,$user_token,"Meetup",$msg,$notAry,1,$img);
      }  else if(strtolower($device)=='ios') {
        $nResident->noti_ios("meetup",'',0,$user_token,"Meetup",$msg,$notAry,1,$img);
      }


      $d->insert_myactivity($user_id,"0","", "You reschedule meeting with ".$u_data2['user_full_name'],"activity.png");
      $response["message"] = "Meetup Rescheduled";
      $response["status"] = "200";
      echo json_encode($response);
      exit();
    } else {
     $response["message"] = "Meetup Rescheduled Failed";
     $response["status"] = "201";
     echo json_encode($response);
   }
 } else if ($_POST['getMeetings'] == "getMeetings" && filter_var($user_id, FILTER_VALIDATE_INT) == true  ) {

  $q3=$d->selectRow("meeting_master.meeting_id ,meeting_master.member_id,users_master.user_profile_pic,users_master.user_full_name,meeting_master.date,meeting_master.time,meeting_master.place, meeting_master.agenda, meeting_master.status,meeting_master.reason,user_employment_details.company_name,user_employment_details.designation","users_master,meeting_master,user_employment_details","user_employment_details.user_id = users_master.user_id and meeting_master.member_id = users_master.user_id and meeting_master.user_id = '$user_id'
    ","ORDER BY meeting_master.date desc ");
  if (mysqli_num_rows($q3)>0) {
    $response["meetings"]=array();
    while ($data = mysqli_fetch_array($q3)) { 
      $member = array(); 
      $member["user_id"]=$data['member_id'];
      $member["meeting_id"]=$data['meeting_id'];
      $member["user_full_name"]=$data['user_full_name'];
      $curr_date = date("Y-m-d");
      if(strtotime($curr_date) > strtotime($data['date'])){
        $member["is_past"]=true;
      } else {
        $member["is_past"]= false;
      }
      $member["date"]=date("Y-m-d",strtotime($data['date']));
      $member["time"]=$data['time'];
      $member["place"]=$data['place'];
      $member["agenda"]=html_entity_decode($data['agenda']);
      $member["designation"]=html_entity_decode($data['designation']);
      $member["company_name"]=html_entity_decode($data['company_name']);
      $member["status"]="Meeting ".$data['status'];
      $member["reason"]=$data['reason']; 

      $member["user_profile_pic"]=$base_url."img/users/members_profile/".$data['user_profile_pic'];
      if($data['user_profile_pic'] ==""){
        $member["user_profile_pic"] ="";
      } else {
        $member["user_profile_pic"] = $base_url."img/users/members_profile/".$data['user_profile_pic'];
      }
      array_push($response["meetings"], $member); 
    }

    $response["message"]="Meetings List";
    $response["status"]="200";

    echo json_encode($response);
  }else{
    $response["message"]="No Meetings Found!";
    $response["status"]="201";
    echo json_encode($response);
  }

} 
else if ($_POST['getAprrovedMeetings'] == "getAprrovedMeetings" && filter_var($user_id, FILTER_VALIDATE_INT) == true  ) {



  $active_usr_qry=$d->select("users_master","active_status=0");
  $active_user_arr = array();
  while($active_usr_data=mysqli_fetch_array($active_usr_qry)) { 
    $active_user_arr[] = $active_usr_data['user_id'];
  }

  $q3=$d->selectRow("meeting_master.action_user_id, meeting_master.meeting_id ,meeting_master.user_id,meeting_master.member_id,users_master.user_profile_pic,users_master.user_full_name,meeting_master.date,meeting_master.time,meeting_master.place, meeting_master.agenda, meeting_master.status,meeting_master.reason,user_employment_details.company_name,user_employment_details.designation","user_employment_details, users_master,meeting_master","user_employment_details.user_id = users_master.user_id and   meeting_master.user_id = users_master.user_id  AND users_master.active_status=0     and (  meeting_master.member_id = '$user_id' OR  meeting_master.user_id = '$user_id' ) 
    "," group by meeting_master.meeting_id ORDER BY meeting_master.date desc ");

  $response['approvedMeeting'] = array();
  if(mysqli_num_rows($q3)>0){ 
   while ($q3_data=mysqli_fetch_array($q3)) {

if($q3_data['member_id'] == $user_id){

 $member_id = $q3_data['user_id'];
} else {
   $member_id = $q3_data['member_id'];
}
$ios_op_u_data = $d->select("users_master", "  user_id = '$member_id'");
$ios_op_u = mysqli_fetch_array($ios_op_u_data);


      $approvedMeeting = array();
      $meetup_date = $q3_data['date'];
      $time11= date("H:i", strtotime($q3_data['time']));
      $time4 = explode(" ", $q3_data['time']);
      $date1  =$q3_data['date'].' '.$time11;
      $timestamp = strtotime($time11) + 60*60;
      $time_end =$time11; 
      $date2  =$q3_data['date'].' '.$time_end;
      $newDate = strtotime($date2) + 60*60;
      $meetup_date1 =date( "Y-m-d H:i",strtotime($date1)); 
      $meetup_date2 =date( "Y-m-d H:i",$newDate); 
$date_before_1_day = date("Y-m-d", strtotime($date1."-1 day"));
$currDate = date("Y-m-d");
if(strtotime($date_before_1_day) < strtotime($currDate) ){
  $date_before_1_day =$currDate;
}


$minus1hr = strtotime($date2) - 60*60;
$meetup_date_minus1hr =date( "Y-m-d H:i",$minus1hr); 



      $curr_date = date("Y-m-d H:i");

    if( strtotime($meetup_date1) >= strtotime($curr_date) &&  in_array($q3_data['member_id'], $active_user_arr) && in_array($q3_data['user_id'], $active_user_arr)  ){

$member_id = $q3_data['member_id'];
$opp_user = $d->select("users_master", "  user_id = '$member_id'");
      $opp_user_data = mysqli_fetch_array($opp_user);


 

     
      $approvedMeeting["date"] = $meetup_date1;
      $approvedMeeting["end_date"] = $meetup_date2;
      $approvedMeeting["place"] =$q3_data['place'];
      $approvedMeeting["meetup_with"] ="Meetup With ". $opp_user_data['user_full_name'];

      $approvedMeeting["meetup_with_ios"] ="Meetup With ". $ios_op_u['user_full_name'];
      $approvedMeeting["agenda"] =$q3_data['agenda'];
      $approvedMeeting["user_id"] =$q3_data['user_id'];
      $approvedMeeting["member_id"] =$q3_data['member_id'];
      $approvedMeeting["action_user_id"] =$q3_data['action_user_id'];
      array_push($response["approvedMeeting"], $approvedMeeting); 

    }

     

  }
  $response["message"]="Approved Meeting List.";
      $response["status"]="200";
      echo json_encode($response);
}else{
  $response["message"]="No Meetings Found!";
  $response["status"]="201";
  echo json_encode($response);
}
}


else if ($_POST['getMyMeetings'] == "getMyMeetings" && filter_var($user_id, FILTER_VALIDATE_INT) == true  ) {



  $active_usr_qry=$d->select("users_master","active_status=0");
  $active_user_arr = array();
  while($active_usr_data=mysqli_fetch_array($active_usr_qry)) { 
    $active_user_arr[] = $active_usr_data['user_id'];
  }



  $q3=$d->selectRow("meeting_master.action_user_id, meeting_master.meeting_id ,meeting_master.user_id,meeting_master.member_id,users_master.user_profile_pic,users_master.user_full_name,meeting_master.date,meeting_master.time,meeting_master.place, meeting_master.agenda, meeting_master.status,meeting_master.reason,user_employment_details.company_name,user_employment_details.designation","user_employment_details, users_master,meeting_master","user_employment_details.user_id = users_master.user_id and   meeting_master.user_id = users_master.user_id  AND users_master.active_status=0 and meeting_master.status !='Deleted'    and (  meeting_master.member_id = '$user_id' OR  meeting_master.user_id = '$user_id' ) 
    "," group by meeting_master.meeting_id ORDER BY meeting_master.date desc ");



  $app_data_new=$d->selectRow("is_seen,user_id,user_notification_id,user_id,notification_title,notification_desc,other_user_id,notification_logo,notification_date,notification_status,timeline_id,notification_action,notification_type,timeline_id","user_notification"," user_id='$user_id'  AND  notification_type=10  and is_seen=0  and status='Active'     ","ORDER BY user_notification_id DESC");

  $response["unread_meetup_notification"]= (string)mysqli_num_rows($app_data_new); 


  $dataArray = array();
  $counter = 0 ;
  foreach ($q3 as  $value) {
    foreach ($value as $key => $valueNew) {
      $dataArray[$counter][$key] = $valueNew;
    }
    $counter++;
  }

  
  $member_id_array = array('0');
  $action_id_array = array('0');;
  for ($l=0; $l < count($dataArray) ; $l++) {

  	

    $member_id_array[] = $dataArray[$l]['member_id'];
    $member_id_array[] = $dataArray[$l]['user_id'];
    $action_id_array[] = $dataArray[$l]['action_user_id'];

  }
  $member_id_array = implode(",", $member_id_array);

  $member_qry=$d->selectRow("users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,user_employment_details.designation,user_employment_details.company_name","users_master,user_employment_details","user_employment_details.user_id = users_master.user_id and users_master.user_id in($member_id_array) ");

  $BArray = array();
  $Bcounter = 0 ;
  foreach ($member_qry as  $value) {
    foreach ($value as $key => $valueNew) {
      $BArray[$Bcounter][$key] = $valueNew;
    }
    $Bcounter++;
  }
  $member_arr = array();
  for ($l=0; $l < count($BArray) ; $l++) {
    $member_arr[$BArray[$l]['user_id']] = $BArray[$l]; 
  }

  $action_id_array = implode(",", $action_id_array);
  $act_qry=$d->selectRow("user_full_name,user_id","users_master"," user_id in($action_id_array) ");

  $VArray = array();
  $Vcounter = 0 ;
  foreach ($act_qry as  $value) {
    foreach ($value as $key => $valueNew) {
      $VArray[$Vcounter][$key] = $valueNew;
    }
    $Vcounter++;
  }
  $acc_arr = array();
  for ($l=0; $l < count($VArray) ; $l++) {
    $acc_arr[$VArray[$l]['user_id']] = $VArray[$l]; 
  }
// print_r($dataN = $acc_arr['188']);exit;

  if (count($dataArray)>0) {
    $response["MyMeetings"]=array();
    for ($l=0; $l < count($dataArray) ; $l++) {

      if(in_array($dataArray[$l]['member_id'], $active_user_arr) && in_array($dataArray[$l]['user_id'], $active_user_arr)  ){

        $data =$dataArray[$l];

        $member = array(); 
        $dataN = $acc_arr[$data['action_user_id']];
        if(!empty($dataN)){
          $member["by_user"]=$dataN['user_full_name'];
        } else {
          $member["by_user"]="";
        }
        $member["action_user_id"]=$data['action_user_id'];

        $member["meeting_id"]=$data['meeting_id'];
        $member["member_id"]=$data['member_id'];
        $member["user_id"]=$data['user_id'];
        if($data['user_id']==$user_id){
          $member_d = $member_arr[$data['member_id']];
        } else {
          $member_d = $member_arr[$data['user_id']];
        }

        $member["user_full_name"]=$member_d['user_full_name'];
        $curr_date = date("Y-m-d");
        if(strtotime($curr_date) > strtotime($data['date'])){
          $member["is_past"]=true;
        } else {
          $member["is_past"]= false;
        }
        $member["date"]=date("Y-m-d",strtotime($data['date']));
        $member["meeting_date"]=date("d",strtotime($data['date']));
        $member["meeting_month"]=date("M",strtotime($data['date']));
        $member["time"]=$data['time'];
        $member["place"]=$data['place'];
        $member["agenda"]=html_entity_decode($data['agenda']);
        $member["status"]="Meeting ".$data['status'];
        $member["reason"]=$data['reason'];
        $member["designation"]=html_entity_decode($member_d['designation']);
        $member["company_name"]=html_entity_decode($member_d['company_name']); 

        $member["user_profile_pic"]=$base_url."img/users/members_profile/".$member_d['user_profile_pic'];

        if($member_d['user_profile_pic'] ==""){
          $member["user_profile_pic"] ="";
        } else {
          $member["user_profile_pic"] = $base_url."img/users/members_profile/".$member_d['user_profile_pic'];
        }


        array_push($response["MyMeetings"], $member); 
      }
    }

    $response["message"]="Meeting List.";
    $response["status"]="200";

    echo json_encode($response);
  }else{
    $response["message"]="No Meetings Found!";
    $response["status"]="201";
    echo json_encode($response);
  }

}

else if ($_POST['getUserMeetings'] == "getUserMeetings" && filter_var($user_id, FILTER_VALIDATE_INT) == true  ) {
  $today = date("Y-m-d");
  $q3=$d->selectRow("meeting_master.action_user_id, meeting_master.meeting_id ,meeting_master.user_id,meeting_master.member_id,users_master.user_profile_pic,users_master.user_full_name,meeting_master.date,meeting_master.time,meeting_master.place, meeting_master.agenda, meeting_master.status,meeting_master.reason,user_employment_details.company_name,user_employment_details.designation","user_employment_details, users_master,meeting_master","user_employment_details.user_id = users_master.user_id and   meeting_master.member_id = users_master.user_id       and (  meeting_master.member_id = '$user_id' OR  meeting_master.user_id = '$user_id' ) and  meeting_master.date >= '$today' and meeting_master.status in ('Reschedule','Pending')
    "," group by meeting_master.meeting_id ORDER BY meeting_master.date desc ");

  if(isset($debug)){
    echo "user_employment_details, users_master,meeting_master","user_employment_details.user_id = users_master.user_id and   meeting_master.member_id = users_master.user_id       and (  meeting_master.member_id = '$user_id' OR  meeting_master.user_id = '$user_id' ) and  meeting_master.date >= '$today' and meeting_master.status in ('Reschedule','Pending')
    ";exit;
  }

  $dataArray = array();
  $counter = 0 ;
  foreach ($q3 as  $value) {
    foreach ($value as $key => $valueNew) {
      $dataArray[$counter][$key] = $valueNew;
    }
    $counter++;
  }

  
  $member_id_array = array('0');
  $action_id_array = array('0');;
  for ($l=0; $l < count($dataArray) ; $l++) {
    $member_id_array[] = $dataArray[$l]['member_id'];
    $member_id_array[] = $dataArray[$l]['user_id'];
    $action_id_array[] = $dataArray[$l]['action_user_id'];
  }
  $member_id_array = implode(",", $member_id_array);

  $member_qry=$d->selectRow("users_master.user_full_name,users_master.user_id,users_master.user_profile_pic,user_employment_details.designation,user_employment_details.company_name","users_master,user_employment_details","user_employment_details.user_id = users_master.user_id and users_master.user_id in($member_id_array) ");

  $BArray = array();
  $Bcounter = 0 ;
  foreach ($member_qry as  $value) {
    foreach ($value as $key => $valueNew) {
      $BArray[$Bcounter][$key] = $valueNew;
    }
    $Bcounter++;
  }
  $member_arr = array();
  for ($l=0; $l < count($BArray) ; $l++) {
    $member_arr[$BArray[$l]['user_id']] = $BArray[$l]; 
  }

  $action_id_array = implode(",", $action_id_array);
  $act_qry=$d->selectRow("user_full_name,user_id","users_master"," user_id in($action_id_array) ");

  $VArray = array();
  $Vcounter = 0 ;
  foreach ($act_qry as  $value) {
    foreach ($value as $key => $valueNew) {
      $VArray[$Vcounter][$key] = $valueNew;
    }
    $Vcounter++;
  }
  $acc_arr = array();
  for ($l=0; $l < count($VArray) ; $l++) {
    $acc_arr[$VArray[$l]['user_id']] = $VArray[$l]; 
  }
// print_r($dataN = $acc_arr['188']);exit;

  if (count($dataArray)>0) {
    $response["MyMeetings"]=array();
    for ($l=0; $l < count($dataArray) ; $l++) {
      $data =$dataArray[$l];
      
      $member = array(); 
      $dataN = $acc_arr[$data['action_user_id']];
      if(!empty($dataN)){
        $member["by_user"]=$dataN['user_full_name'];
      } else {
        $member["by_user"]="";
      }
      $member["action_user_id"]=$data['action_user_id'];

      $member["meeting_id"]=$data['meeting_id'];
      $member["member_id"]=$data['member_id'];
      $member["user_id"]=$data['user_id'];
      if($data['user_id']==$user_id){
        $member_d = $member_arr[$data['member_id']];
      } else {
        $member_d = $member_arr[$data['user_id']];
      }
      
      $member["user_full_name"]=$member_d['user_full_name'];
      $curr_date = date("Y-m-d");
      if(strtotime($curr_date) > strtotime($data['date'])){
        $member["is_past"]=true;
      } else {
        $member["is_past"]= false;
      }
      $member["date"]=date("Y-m-d",strtotime($data['date']));
      $member["meeting_date"]=date("d",strtotime($data['date']));
      $member["meeting_month"]=date("M",strtotime($data['date']));
      $member["time"]=$data['time'];
      $member["place"]=$data['place'];
      $member["agenda"]=html_entity_decode($data['agenda']);
      $member["status"]="Meeting ".$data['status'];
      $member["reason"]=$data['reason'];
      $member["designation"]=html_entity_decode($member_d['designation']);
      $member["company_name"]=html_entity_decode($member_d['company_name']); 

      $member["user_profile_pic"]=$base_url."img/users/members_profile/".$member_d['user_profile_pic'];

      if($member_d['user_profile_pic'] ==""){
        $member["user_profile_pic"] ="";
      } else {
        $member["user_profile_pic"] = $base_url."img/users/members_profile/".$member_d['user_profile_pic'];
      }

      
      array_push($response["MyMeetings"], $member); 
    }

    $response["message"]="Meeting List.";
    $response["status"]="200";

    echo json_encode($response);
  }else{
    $response["message"]="No Meetings Found!";
    $response["status"]="201";
    echo json_encode($response);
  }

}



else {
  $response["message"] = "Wrong tag";
  $response["status"] = "201";
  echo json_encode($response);
}
} else {
  $response["message"] = "wrong api key.";
  $response["status"] = "201";
  echo json_encode($response);
}
} 
