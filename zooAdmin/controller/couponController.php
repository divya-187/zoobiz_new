<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

 //echo "<pre>";print_r($_REQUEST);exit;
 if(isset($_POST['cpnAddBtn'])){
   
  
   
  $m->set_data('plan_id',ucfirst($plan_id));
  $m->set_data('coupon_name',ucfirst($coupon_name));
  $m->set_data('coupon_code',strtoupper($coupon_code));
  $m->set_data('coupon_amount',strtoupper($coupon_amount));
  $m->set_data('coupon_per',strtoupper($coupon_per));
  $m->set_data('cpn_expiry',$cpn_expiry);
  if(isset($start_date)){
    $start_date = date("Y-m-d", strtotime($start_date));
  } else {
    $start_date = "0000-00-00";
  }

  if(isset($end_date)){
    $end_date = date("Y-m-d", strtotime($end_date));
  } else {
    $end_date = "0000-00-00";
  }
  $m->set_data('start_date',$start_date);
  $m->set_data('end_date',$end_date);
  $m->set_data('is_unlimited',$is_unlimited);

  if($is_unlimited ==0){
    $m->set_data('coupon_limit',$coupon_limit);
  } else {
    $m->set_data('coupon_limit','0');
  }
  $m->set_data('created_by',$_SESSION[zoobiz_admin_id]);
   $created_at = date('Y-m-d H:i:s');
   $m->set_data('created_at',$created_at);
  
  $a =array(
    
    'plan_id'=> $m->get_data('plan_id'),
    'coupon_name'=> $m->get_data('coupon_name'),
    'coupon_code'=> $m->get_data('coupon_code'),
    'coupon_amount'=> $m->get_data('coupon_amount'),
    'coupon_per'=> $m->get_data('coupon_per'),
    'is_unlimited'=> $m->get_data('is_unlimited'),
    'coupon_limit'=> $m->get_data('coupon_limit'), 
    'cpn_expiry'=> $m->get_data('cpn_expiry'),
    'start_date'=> $m->get_data('start_date'),
    'end_date'=> $m->get_data('end_date'),
    'created_by'=> $m->get_data('created_by')  ,
    'created_at'=> $m->get_data('created_at') 
  );
  $q=$d->insert("coupon_master",$a);

  
  if($q>0) {
    $_SESSION['msg']=ucfirst($coupon_name)." Coupon Added";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../couponList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../couponList");
  }

}  else if(isset($_POST['cpnEditBtn'])){
 $m->set_data('plan_id',ucfirst($plan_id));

   $m->set_data('coupon_name',ucfirst($coupon_name));
  $m->set_data('coupon_code',strtoupper($coupon_code));

   
  $m->set_data('coupon_amount',strtoupper($coupon_amount));
  $m->set_data('coupon_per',strtoupper($coupon_per));



  $m->set_data('is_unlimited',$is_unlimited);
$updated_at = date('Y-m-d H:i:s');
   $m->set_data('updated_at',$updated_at);
  if($is_unlimited ==0){
    $m->set_data('coupon_limit',$coupon_limit);
  } else {
    $m->set_data('coupon_limit','0');
  }
     $m->set_data('updated_by',$_SESSION[zoobiz_admin_id]);
  

  $m->set_data('cpn_expiry',$cpn_expiry);
  if(isset($start_date)){
    $start_date = date("Y-m-d", strtotime($start_date));
  } else {
    $start_date = "0000-00-00";
  }

  if(isset($end_date)){
    $end_date = date("Y-m-d", strtotime($end_date));
  } else {
    $end_date = "0000-00-00";
  }
  $m->set_data('start_date',$start_date);
  $m->set_data('end_date',$end_date);
  $a =array(
    'plan_id'=> $m->get_data('plan_id'),
    'coupon_name'=> $m->get_data('coupon_name'),
   
    'is_unlimited'=> $m->get_data('is_unlimited'),
    'coupon_limit'=> $m->get_data('coupon_limit') ,
    'coupon_amount'=> $m->get_data('coupon_amount'),
    'coupon_per'=> $m->get_data('coupon_per'),
    'cpn_expiry'=> $m->get_data('cpn_expiry'),
    'start_date'=> $m->get_data('start_date'),
    'end_date'=> $m->get_data('end_date'),
    'updated_at'=> $m->get_data('updated_at') ,
    'updated_by'=> $m->get_data('updated_by')
  );

$q1=$d->update("coupon_master",$a,"coupon_id = '$coupon_id'");

  $transection_master=$d->select("transection_master","  coupon_id= '$coupon_id' ","");
  if (mysqli_num_rows($transection_master) <= 0  ) {
     $a =array(
      'coupon_code'=> $m->get_data('coupon_code'),
     );
  $q=$d->update("coupon_master",$a,"coupon_id = '$coupon_id'");
  }
 
if(  $q1>0) {
  $_SESSION['msg']=ucfirst($coupon_name). " Coupon Updated";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("location:../couponList");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../couponList");
}


}     else  if(isset($_POST['delete_coupon_id'])){
 
   $adm_data=$d->selectRow("coupon_name","coupon_master"," coupon_id='$delete_coupon_id'");
        $data_q=mysqli_fetch_array($adm_data);
   $q=$d->delete("coupon_master","coupon_id='$delete_coupon_id'  ");
        
  if($q>0 ) {
    $_SESSION['msg']=$data_q['coupon_name']." Coupon Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../couponList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../couponList");
  }


}  

}else{
  header('location:../login');
}
?>