<?php 
include '../common/objectController.php'; 
// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
// add main menu
  $society_id = $_SESSION['society_id'];
  $soc = $d->select("society_master","society_id='$society_id'");
  $data = mysqli_fetch_array($soc);
  $society_name = $data['society_name'];
  if(isset($_POST['user_first_name'])){

    $qselect=$d->select("users_master","user_mobile='$user_mobile' AND user_mobile!=''");
    $user_data = mysqli_fetch_array($qselect);
    if($user_data==true){
      $_SESSION['msg1']="Mobile is Already Registered.";
      header("location:../viewOwner?id=$parent_id");
      exit();
    }

    $user_profile_pic="user.png";

    $m->set_data('society_id',$society_id);
    $m->set_data('parent_id',$parent_id);
    $m->set_data('user_profile_pic',$user_profile_pic);
    $m->set_data('user_full_name',$user_first_name." ".$user_last_name);
    $m->set_data('user_first_name',$user_first_name);
    $m->set_data('user_last_name',$user_last_name);
    $m->set_data('user_mobile',$user_mobile);
    $m->set_data('member_relation_name',$member_relation_name);
    $m->set_data('user_type',$user_type);
    $m->set_data('unit_status',$unit_status);
    $m->set_data('block_id',$block_id);
    $m->set_data('floor_id',$floor_id);
    $m->set_data('unit_id',$unit_id);
    $m->set_data('member_status',1);
    $m->set_data('installed_by',$_SESSION['zoobiz_admin_id']);
     $m->set_data('register_date',date('Y-m-d H:i:s'));
    if ($user_mobile=='') {
      $m->set_data('user_status',2);
    }else{
      $m->set_data('user_status',1);
    }

    $a =array(
      'society_id'=> $m->get_data('society_id'),
      'parent_id'=> $m->get_data('parent_id'),
      'user_profile_pic'=> $m->get_data('user_profile_pic'),
      'user_full_name'=> $m->get_data('user_full_name'),
      'user_first_name'=> $m->get_data('user_first_name'),
      'user_last_name'=> $m->get_data('user_last_name'),
      'user_mobile'=> $m->get_data('user_mobile'),
      'member_relation_name'=> $m->get_data('member_relation_name'),
      'user_type'=> $m->get_data('user_type'),
      'block_id'=> $m->get_data('block_id'),
      'floor_id'=> $m->get_data('floor_id'),
      'unit_id'=> $m->get_data('unit_id'),
      'user_status'=> $m->get_data('user_status'),
      'member_status'=> $m->get_data('member_status'),
      'installed_by'=> $m->get_data('installed_by'),
      'register_date'=> $m->get_data('register_date'),
    );

    $q=$d->insert("users_master",$a);
    if($q>0) {
      $_SESSION['msg']="User Added";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../viewOwner?id=$parent_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../viewOwner?id=$parent_id");
    }
  
  }

}
else{
  header('location:../login');
}
?>