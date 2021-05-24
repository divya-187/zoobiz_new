<?php
include '../common/objectController.php';
if(isset($_REQUEST) && !empty($_REQUEST) )//it can be $_GET doesn't matter
{


 
  if(isset($addupi)) {
   
    $app_name= ucfirst($app_name);
    $app_package_name= ucfirst($app_package_name);

    $m->set_data('app_name',$app_name);
    $m->set_data('app_package_name',$app_package_name); 
    $a1= array (
       'app_name'=> $m->get_data('app_name'), 
       'app_package_name'=> $m->get_data('app_package_name'), 
       'added_by_admin'=> $_SESSION[zoobiz_admin_id],
       'created_at' =>date("Y-m-d H:i:s")
    );
    $q=$d->insert("upi_app_master",$a1);
    if($q==TRUE) {
      $_SESSION['msg']=$app_name." UPI Added";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../upiList");
    } else {
      header("Location: ../upiList");
    }
  }
  if(isset($editUpi)) {
   
   $app_name= ucfirst($app_name);
    $app_package_name= ucfirst($app_package_name);

    $m->set_data('app_name',$app_name);
    $m->set_data('app_package_name',$app_package_name); 
    $a1= array (
        'app_name'=> $m->get_data('app_name'), 
        'app_package_name'=> $m->get_data('app_package_name'), 
        'added_by_admin'=> $_SESSION[zoobiz_admin_id],
    );


    $q=$d->update("upi_app_master",$a1,"app_id='$app_id'");
    if($q==TRUE) {
      $_SESSION['msg']=$app_name. " UPI Updated";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../upiList");
    } else {
      header("Location: ../upiList");
    }
  }
  
}
?>