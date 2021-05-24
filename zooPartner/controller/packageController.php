<?php 
 include '../common/objectController.php';


// delete user
if(isset($deletepackage)) {

   $adm_data=$d->selectRow("package_name","package_master"," package_id='$package_id'");
        $data_q=mysqli_fetch_array($adm_data); 

        
  $q=$d->delete("package_master","package_id='$package_id'");
  if($q==TRUE) {
     $_SESSION['msg']=$data_q['package_name']." Package Deleted";
     
     $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("Location: ../plans");
  } else {
     $_SESSION['msg1']="Package Not Deleted";
    header("Location: ../plans");
  }
}

// add new user
if(isset($addpackage)) {

    $menu_id_package= implode(",", $_POST['menu_id']);
    $page_id_package= implode(",", $_POST['pagePrivilege']);
 $m->set_data('time_slab',$time_slab);
    $m->set_data('package_name',$package_name);
    $m->set_data('packaage_description',$packaage_description);
    $m->set_data('package_amount',$package_amount);
    $m->set_data('gst_slab_id',$gst_slab_id);
    $m->set_data('is_cpn_package',$is_cpn_package);
    
    $m->set_data('no_of_month',$no_of_month);
    $m->set_data('menu_id_package',$menu_id_package);
    $m->set_data('page_id_package',$page_id_package);
    $m->set_data('inapp_ios_purchase_id',$inapp_ios_purchase_id);
        
         $a1= array (
           
           'time_slab'=> $m->get_data('time_slab'),
           'inapp_ios_purchase_id' =>$m->get_data('inapp_ios_purchase_id'),
            'package_name'=> $m->get_data('package_name'),
            'packaage_description'=> $m->get_data('packaage_description'),
            'package_amount'=> $m->get_data('package_amount'),
            'gst_slab_id'=> $m->get_data('gst_slab_id'),
            'is_cpn_package'=> $m->get_data('is_cpn_package'),
            'no_of_month'=> $m->get_data('no_of_month'),
            'menu_id_package'=> $m->get_data('menu_id_package'),
            'page_id_package'=> $m->get_data('page_id_package'),
        );

    $q=$d->insert("package_master",$a1);
  if($q==TRUE) {
      $_SESSION['msg']=$package_name." Package Added";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);

    header("Location: ../plans");
  } else {
    header("Location: ../plans");
  }
}


// Update  user
if(isset($updatepackage)) {
   $menu_id_package= implode(",", $_POST['menu_id']);
    $page_id_package= implode(",", $_POST['pagePrivilege']);
$m->set_data('time_slab',$time_slab);
           
    $m->set_data('package_name',$package_name);
    $m->set_data('packaage_description',$packaage_description);
    $m->set_data('package_amount',$package_amount);
    $m->set_data('gst_slab_id',$gst_slab_id);
    
    $m->set_data('is_cpn_package',$is_cpn_package);

           
    $m->set_data('no_of_month',$no_of_month);
     $m->set_data('menu_id_package',$menu_id_package);
    $m->set_data('page_id_package',$page_id_package);    
     

         $a1= array (
          'time_slab'=> $m->get_data('time_slab'),
            'package_name'=> $m->get_data('package_name'),
            'packaage_description'=> $m->get_data('packaage_description'),
            'package_amount'=> $m->get_data('package_amount'),
            'gst_slab_id'=> $m->get_data('gst_slab_id'),
             'is_cpn_package'=> $m->get_data('is_cpn_package'),
            'no_of_month'=> $m->get_data('no_of_month'),
            'menu_id_package'=> $m->get_data('menu_id_package'),
            'page_id_package'=> $m->get_data('page_id_package'),
        );

    $q=$d->update("package_master",$a1,"package_id='$package_id'");
  if($q==TRUE) {
      $_SESSION['msg']=$package_name." Package Updated";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("Location: ../plans");
  } else {
    header("Location: ../plans");
  }
}

 ?>