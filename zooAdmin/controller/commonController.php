<?php 
include '../common/objectController.php'; 
// print_r($_POST);
if(isset($_REQUEST) && !empty($_REQUEST) )//it can be $_GET doesn't matter
{
 

if (isset($temp_user_id)) {
 
  $main_users_master = $d->selectRow("*","users_master_temp", "user_id = '$temp_user_id'    ");
  $main_users_master_data = mysqli_fetch_array($main_users_master);

 $q =  $d->delete("users_master_temp","user_id='$temp_user_id'");
   if($q>0  ) {
 
      $_SESSION['msg']= "Temp User ucfirst($main_users_master_data[user_full_name])  Deleted";

     $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
     if(isset($toDate) && $toDate!='' && isset($from) && $from!='' ){
 
        header("location:../failedRegistration?toDate=$toDate&from=$from");
      } else {
        header("location:../failedRegistration");
     }
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../failedRegistration");
    }


} else if (isset($primary_user_id)) {
  $main_users_master = $d->selectRow("*","users_master", "user_id = '$primary_user_id'    ");
  $main_users_master_data = mysqli_fetch_array($main_users_master);

 if($main_users_master_data[user_mobile] == $primary_user_mobile){
    $_SESSION['msg']= "Nothing to update";
  header("location:../viewMember?id=".$primary_user_id);exit;
 }
  $a =array(
      'user_mobile'=> $primary_user_mobile
    );
 
    $q=$d->update("users_master",$a,"user_id='$primary_user_id'");

   if($q>0  ) {
 
      $_SESSION['msg']= ucfirst($main_users_master_data[user_full_name])." Primary mobile number changed from $main_users_master_data[user_mobile] to  $primary_user_mobile by $created_by";

     $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
     
        header("location:../viewMember?id=".$primary_user_id);
      
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewMember?id=".$primary_user_id);
    }


} else if (isset($addHideNumber)) {
  $main_users_master = $d->selectRow("*","hide_number_master", "mobile_number ='$hide_mobile_number' and status=0   ");
  if (mysqli_num_rows($main_users_master) > 0) {
    $_SESSION['msg']= "Number Already Exists";
  header("location:../hideRegiNotifiation");
  exit;
 }
  $a =array(
      'mobile_number'=> $hide_mobile_number,
      'created_at' =>date('Y-m-d H:i:s')
    );
 $q=$d->insert("hide_number_master",$a);

   if($q>0  ) {
 
      $_SESSION['msg']= $hide_mobile_number." Added ";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../hideRegiNotifiation");
      
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../hideRegiNotifiation");
    }


} else if (isset($editHideNumber)) {
  $main_users_master = $d->selectRow("*","hide_number_master", "mobile_number ='$hide_mobile_number'  and id!='$id' and status=0   ");
  if (mysqli_num_rows($main_users_master) > 0) {
    $_SESSION['msg']= "Number Already Exists";
  header("location:../hideRegiNotifiation");
  exit;
 }
  $a =array(
      'mobile_number'=> $hide_mobile_number 
    );
  $q=$d->update("hide_number_master",$a,"id='$id' ");

   if($q>0  ) {
 
      $_SESSION['msg']= $hide_mobile_number." Updated ";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../hideRegiNotifiation");
      
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../hideRegiNotifiation");
    }


}
//11may21
if(isset($appBusinessName) && $appBusinessName=="Approve") {
   
    $requested_company_name= ucwords($requested_company_name);
 
    $a1= array (

      'company_name'=> $requested_company_name 
    );

    $q=$d->update("user_employment_details",$a1,"user_id = $user_id");


    if($q==TRUE) {
    $m->set_data('requested_company_name',$requested_company_name); 
      $a1= array (
       
       'action_by'=> $created_by,
       'action_at' =>date("Y-m-d H:i:s"),
       'request_status'=>'Approved'
      );
      $q=$d->update("business_name_change_request_masater",$a1,"user_id='$user_id' and business_name_change_request_id='$business_name_change_request_id' ");



                $title = 'Business Name Change Approved';
                $msg ='Business Name Change "'.$requested_company_name.'" Approved';
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
 

      $_SESSION['msg']=$msg;
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../welcome");
    } else {
      header("Location: ../welcome");
    }
  }

   if(isset($_REQUEST['rejBusinessName']) && $_REQUEST['rejBusinessName']=="Reject") {
  
    $business_name_change_request_id =$_REQUEST['business_name_change_request_id'];
 $user_id =$_REQUEST['user_id'];
    $bn_data=$d->select("business_name_change_request_masater","business_name_change_request_id='$business_name_change_request_id'","");
    $bn_details=mysqli_fetch_array($bn_data);
extract($bn_details);
  
  $a1= array (
       
       'action_by'=> $created_by,
       'action_at' =>date("Y-m-d H:i:s"),
       'request_status'=>'Rejected'
      );
      $q=$d->update("business_name_change_request_masater",$a1,"user_id='$user_id' and business_name_change_request_id='$business_name_change_request_id' ");


    if($q==TRUE) {

                 $title = 'Business Name Change Not Approved';
                $msg ='Business Name Change "'.$requested_company_name.'" Not Approved';

                 
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




      $_SESSION['msg']=$msg;
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../welcome");
    } else {
      header("Location: ../welcome");
    }
  }
//11may21
 
 
} else{
  header('location:../login');
}
?>