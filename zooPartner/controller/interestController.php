<?php
include '../common/objectController.php';
if(isset($_REQUEST) && !empty($_REQUEST) )//it can be $_GET doesn't matter
{


if(isset($appInterest) && $appInterest=="Approve") {
   
    $interest_name= ucfirst($interest_name);
 
    $a1= array (

      'interest_id'=> $interest_id, 
      'member_id'=> $user_id, 
      'created_at'=> date('Y-m-d H:i:s') 
    );

    $q=$d->insert("interest_relation_master",$a1);


    if($q==TRUE) {
$m->set_data('interest_name',$interest_name); 
      $a1= array (
       'interest_name'=> $m->get_data('interest_name'), 
       'int_status'=> 'Admin Approved',
       'added_by' =>$_SESSION[zoobiz_admin_id]
      );
      $q=$d->update("interest_master",$a1,"interest_id='$interest_id'");



                $title = 'Interest Approved';
                $msg ='Interest "'.$interest_name.'" Approved';
                $notiAry = array(
                  'user_id' => $user_id,
                  'notification_title' => $title,
                  'notification_desc' => $msg,
                  'notification_date' => date('Y-m-d H:i'),
                  'notification_action' => 'custom_notification',
                  'notification_logo' => 'profile.png',
                  'notification_type' => '5'
                );
                $d->insert("user_notification", $notiAry);

 
                $u_dta_qry = $d->selectRow("*","users_master", "user_token!='' AND user_id ='$user_id'    ");
                $u_dta = mysqli_fetch_array($u_dta_qry);

   $fcm_data_array = array(
            'img' =>"https://zoobiz.in/img/logo.png",
            'title' =>$title,
            'desc' => $msg,
            'time' =>date("d M Y h:i A")
          );

              if (strtolower($u_dta['device']) =='android') {
                $nResident->noti("custom_notification","",0,$u_dta['user_token'],$title,$msg,$fcm_data_array);
              }  else if(strtolower($u_dta['device']) =='ios') {
                $nResident->noti_ios("custom_notification","",0,$u_dta['user_token'],$title,$msg,$fcm_data_array);
              }
 

      $_SESSION['msg']=$interest_name." Interest Approved";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../welcome");
    } else {
      header("Location: ../welcome");
    }
  }

  if(isset($_REQUEST['rejInterest']) && $_REQUEST['rejInterest']=="Reject") {
   
    $interest_id =$_REQUEST['interest_id'];
 $user_id =$_REQUEST['user_id'];
    $int_data=$d->select("interest_master","interest_id='$interest_id'","");
    $int_details=mysqli_fetch_array($int_data);
extract($int_details);
 $q=$d->delete("interest_master","interest_id='$interest_id'");


    if($q==TRUE) {

                $title = 'Interest Not Approved';
                $msg ='Interest "'.$interest_name.'" Not Approved';
                $notiAry = array(
                  'user_id' => $added_by_member_id,
                  'notification_title' => $title,
                  'notification_desc' => $msg,
                  'notification_date' => date('Y-m-d H:i'),
                  'notification_action' => 'custom_notification',
                  'notification_logo' => 'profile.png',
                  'notification_type' => '5'
                );
                $d->insert("user_notification", $notiAry);

 
                $u_dta_qry = $d->selectRow("*","users_master", "user_token!='' AND user_id ='$added_by_member_id'    ");
                $u_dta = mysqli_fetch_array($u_dta_qry);


              $fcm_data_array = array(
            'img' =>"https://zoobiz.in/img/logo.png",
            'title' =>$title,
            'desc' => $msg,
            'time' =>date("d M Y h:i A")
          );

              if (strtolower($u_dta['device']) =='android') {
                $nResident->noti("custom_notification","",0,$u_dta['user_token'],$title,$msg,$fcm_data_array);
              }  else if(strtolower($u_dta['device']) =='ios') {
                $nResident->noti_ios("custom_notification","",0,$u_dta['user_token'],$title,$msg,$fcm_data_array);
              }




      $_SESSION['msg']=$interest_name." Interest Rejected";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../welcome");
    } else {
      header("Location: ../welcome");
    }
  }

  if(isset($addinterest)) {
   
    $interest_name= ucfirst($interest_name);

    $m->set_data('interest_name',$interest_name); 
    $a1= array (

      'interest_name'=> $m->get_data('interest_name'), 
      'int_status'=> 'Admin Added',
      
      'created_at' =>date("Y-m-d H:i:s")
    );
    $q=$d->insert("interest_master",$a1);
    if($q==TRUE) {
      $_SESSION['msg']=$interest_name." Interest Added";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../interests");
    } else {
      header("Location: ../interests");
    }
  }
  if(isset($editInterest)) {
   
    $interest_name= ucfirst($interest_name);

    $m->set_data('interest_name',$interest_name); 
    $a1= array (

      'interest_name'=> $m->get_data('interest_name')
    );


    $q=$d->update("interest_master",$a1,"interest_id='$interest_id'");
    if($q==TRUE) {
      $_SESSION['msg']=$interest_name. " Interest Updated";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../interests");
    } else {
      header("Location: ../interests");
    }
  }
  
}
?>