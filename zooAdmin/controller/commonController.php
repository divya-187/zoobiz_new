<?php 
include '../common/objectController.php'; 
// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
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
 
 
} else{
  header('location:../login');
}
?>