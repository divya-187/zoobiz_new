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


}
 
 
} else{
  header('location:../login');
}
?>