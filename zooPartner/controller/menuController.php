<?php 
 include '../common/objectController.php';

// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
  // add main menu
  if(isset($_POST['menu_name'])){
    $m->set_data('menu_name',$menu_name);
      $m->set_data('menu_link',$menu_link);
      $m->set_data('menu_icon',$menu_icon);
      $m->set_data('sub_menu',$sub_menu);
      $m->set_data('status',$status);
      $m->set_data('order_no',$order_no);
      $m->set_data('created_by',$created_by);
      $a =array(
        'menu_name'=> $m->get_data('menu_name'),
          'menu_link'=> $m->get_data('menu_link'),
          'menu_icon'=>$m->get_data('menu_icon'),
          'sub_menu'=>$m->get_data('sub_menu'),
          'status'=>$m->get_data('status'),
          'order_no'=>$m->get_data('order_no'),
          'created_by'=>$m->get_data('created_by'),
      );
      $q=$d->insert("master_menu",$a);
      if($q>0) {
        // create new file for new menu url
        if(!file_exists("../".$menu_link.".php") && $sub_menu==0){
          $myfile = fopen("../".$menu_link.".php", "w"); 
        }
         
        $_SESSION['msg']=$menu_name. " New Menu  added.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../mainMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../menu");
      }
  }
  
  
  // Edit main menu
  if(isset($_POST['menu_nameEdit'])){
    $m->set_data('menu_nameEdit',$menu_nameEdit);
      $m->set_data('menu_link',$menu_link);
      $m->set_data('menu_icon',$menu_icon);
      $m->set_data('sub_menu',$sub_menu);
      $m->set_data('status',$status);
      $m->set_data('order_no',$order_no);
      $m->set_data('updated_by',$updated_by);
      $a =array(
        'menu_name'=> $m->get_data('menu_nameEdit'),
          'menu_link'=> $m->get_data('menu_link'),
          'menu_icon'=>$m->get_data('menu_icon'),
          'sub_menu'=>$m->get_data('sub_menu'),
          'status'=>$m->get_data('status'),
          'order_no'=>$m->get_data('order_no'),
          'updated_by'=>$m->get_data('updated_by'),
      );
      // print_r($a);
      $q=$d->update("master_menu",$a,"menu_id='$menu_id'");
      if($q>0) {
         
        $_SESSION['msg']=$menu_nameEdit." Menu Updated.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../mainMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../menu");
      }
  }
  // add sub menu
  if(isset($_POST['SubmenuAdd'])){
    $m->set_data('parent_menu_id',$parent_menu_id);
    $m->set_data('menu_name',$sub_menu_name);
      $m->set_data('menu_link',$menu_link);
      $m->set_data('status',$status);
      $m->set_data('order_no',$order_no);
      $m->set_data('created_by',$created_by);
      $a =array(
        'parent_menu_id'=> $m->get_data('parent_menu_id'),
        'menu_name'=> $m->get_data('menu_name'),
          'menu_link'=> $m->get_data('menu_link'),
          'status'=>$m->get_data('status'),
          'order_no'=>$m->get_data('order_no'),
          'created_by'=>$m->get_data('created_by'),
      );
      $q=$d->insert("master_menu",$a);
      if($q>0) {
        // create new file
        if(!file_exists("../".$menu_link.".php")){
        $myfile = fopen("../".$menu_link.".php", "w"); 
        }
         
        $_SESSION['msg']=$sub_menu_name." Sub Menu added.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../subMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../addSubMenu");
      }
  }
  // Edit sub menu
  if(isset($_POST['SubmenuEdit'])){
    $m->set_data('parent_menu_id',$parent_menu_id);
    $m->set_data('menu_name',$sub_menu_name);
      $m->set_data('menu_link',$menu_link);
      $m->set_data('status',$status);
      $m->set_data('order_no',$order_no);
      $m->set_data('updated_by',$updated_by);
      $a =array(
        'parent_menu_id'=> $m->get_data('parent_menu_id'),
        'menu_name'=> $m->get_data('menu_name'),
          'menu_link'=> $m->get_data('menu_link'),
          'status'=>$m->get_data('status'),
          'order_no'=>$m->get_data('order_no'),
          'updated_by'=>$m->get_data('updated_by'),
      );
      $q=$d->update("master_menu",$a,"menu_id='$SubmenuEdit'");
      if($q>0) {
        
        $_SESSION['msg']=$sub_menu_name. " Sub Menu Updated.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../subMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../addSubMenu");
      }
  }
  // add new icon
  if(isset($_POST['icon_name'])){
    $m->set_data('icon_name',$icon_name);
    $m->set_data('icon_class',$icon_class);
      $m->set_data('status',$status);
      $m->set_data('created_by',$created_by);
      $a =array(
        'icon_name'=> $m->get_data('icon_name'),
        'icon_class'=> $m->get_data('icon_class'),
          'status'=>$m->get_data('status'),
          'created_by'=>$m->get_data('created_by'),
      );
      $q=$d->insert("icons",$a);
      if($q>0) {
        $_SESSION['msg']="Menu Icon added.";
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../icons");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../icons");
      }
  }
  // delete Icon
  if(isset($_POST['deleteIcon'])) {
    $q=$d->delete("icons","icon_id='$icon_id'");
      if($q>0) {
         
        $_SESSION['msg']="Menu Icon Deleted.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../icons");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../icons");
      }
  }
  // delete Main Menu
  if(isset($_POST['menu_id_delete'])) {
    $q=$d->delete("master_menu","menu_id='$menu_id_delete'");
    $q=$d->delete("master_menu","parent_menu_id='$menu_id_delete'");
      if($q>0) {
        
        $_SESSION['msg']="Menu Deleted.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../mainMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../mainMenu");
      }
  }
 
  // Add user Role
  if(isset($_POST['role_name'])){
    $menu_id= implode(",", $_POST['menu_id']);
    $sub_menu_id= implode(",", $_POST['sub_menu_id']);
    $m->set_data('role_name',$role_name);
      $m->set_data('role_description',$role_description);
      $m->set_data('status',$status);
      $m->set_data('order_no',$order_no);
      $m->set_data('menu_id',$menu_id);
      $m->set_data('created_by',$created_by);
      $a =array(
        'role_name'=> $m->get_data('role_name'),
          'role_description'=> $m->get_data('role_description'),
          'role_status'=>$m->get_data('status'),
          'order_no'=>$m->get_data('order_no'),
          'menu_id'=>$m->get_data('menu_id'),
          'created_by'=>$m->get_data('created_by'),
      );
      $q=$d->insert("role_master",$a);
      if($q>0) {
        
        $_SESSION['msg']=$role_name." New Role Added.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../roleType");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../roleType");
      }
  }
  // Edit user Role
  if(isset($_POST['role_nameEdit'])){
    $menu_id= implode(",", $_POST['menu_id']);
    // $parent_menu_id= implode(",", $_POST['parent_menu_id']);
      $m->set_data('role_nameEdit',$role_nameEdit);
      $m->set_data('role_description',$role_description);
      $m->set_data('status',$status);
      $m->set_data('order_no',$order_no);
      $m->set_data('menu_id',$menu_id);
      // $m->set_data('parent_menu_id',$parent_menu_id);
      $m->set_data('updated_by',$updated_by);
      $a =array(
        'role_name'=> $m->get_data('role_nameEdit'),
          'role_description'=> $m->get_data('role_description'),
          'role_status'=>$m->get_data('status'),
          'order_no'=>$m->get_data('order_no'),
          'menu_id'=>$m->get_data('menu_id'),
          // 'parent_menu_id'=>$m->get_data('parent_menu_id'),
          'updated_by'=>$m->get_data('updated_by'),
      );
     
      $q=$d->update("role_master",$a,"role_id='$role_id'");
      if($q>0) {
         
        $_SESSION['msg']=$role_nameEdit. " Role Updated Added.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../roleType");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../roleType");
      }
  }
  // Delete Role Type
  if(isset($_POST['role_id_delete'])) {
    $adm_data=$d->selectRow("role_name","role_master"," role_id='$role_id_delete'");
        $data_q=mysqli_fetch_array($adm_data);

    $q=$d->delete("role_master","role_id='$role_id_delete'");
    
      if($q>0) {
        $_SESSION['msg']=$data_q['role_name']." Role Type Deleted.";
        $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../roleType");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../roleType");
      }
  }
  //Page Privilege
  if (isset($_POST['pagePri'])) {
    // print_r($_POST);
    $pagePrivilege= implode(",", $_POST['pagePrivilege']);
    $m->set_data('pagePrivilege',$pagePrivilege);
    $a =array(
          'pagePrivilege'=>$m->get_data('pagePrivilege'),
      );
    // print_r($a);
      $q=$d->update("role_master",$a,"role_id='$role_id'");
      if($q>0) {
        
        $_SESSION['msg']="Privileges Updated";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../roleType");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../roleType");
      }
  }
  //Pages
  if(isset($_POST['addPage'])){
    $m->set_data('parent_menu_id',$parent_menu_id);
    $m->set_data('menu_name',$sub_menu_name);
      $m->set_data('menu_link',$menu_link);
      $m->set_data('status',$status);
      $m->set_data('page_status',"1");
      $m->set_data('created_by',$created_by);
      $a =array(
        'parent_menu_id'=> $m->get_data('parent_menu_id'),
        'menu_name'=> $m->get_data('menu_name'),
          'menu_link'=> $m->get_data('menu_link'),
          'page_status'=>$m->get_data('page_status'),
          'status'=>$m->get_data('status'),
          'created_by'=>$m->get_data('created_by'),
      );
      $q=$d->insert("master_menu",$a);
      if($q>0) {
        // create new file
        if(!file_exists("../".$menu_link.".php")){
        $myfile = fopen("../".$menu_link.".php", "w"); 
        } 
        $_SESSION['msg']=$sub_menu_name. " Page added.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../pages");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../pages");
      }
  }
  // Edit Pages
  if(isset($_POST['pagesEdit'])){
    $m->set_data('parent_menu_id',$parent_menu_id);
    $m->set_data('sub_menu_name',$sub_menu_name);
      $m->set_data('menu_link',$menu_link);
      $m->set_data('status',$status);
      $m->set_data('page_status',"1");
      $m->set_data('updated_by',$updated_by);
      $a =array(
        'parent_menu_id'=> $m->get_data('parent_menu_id'),
        'menu_name'=> $m->get_data('sub_menu_name'),
          'menu_link'=> $m->get_data('menu_link'),
          'status'=>$m->get_data('status'),
          'page_status'=>$m->get_data('page_status'),
          'updated_by'=>$m->get_data('updated_by'),
      );
      $q=$d->update("master_menu",$a,"menu_id='$menu_id'");
      if($q>0) {
        
        $_SESSION['msg']=$sub_menu_name." Page Updated.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../pages");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../pages");
      }
  }
  if(isset($_POST['page_id_delete'])) {

     $adm_data=$d->selectRow("menu_name","master_menu"," menu_id='$page_id_delete'");
        $data_q=mysqli_fetch_array($adm_data);


    $q=$d->delete("master_menu","menu_id='$page_id_delete'");
      if($q>0) {
      
        $_SESSION['msg']=$data_q['menu_name']." Page Deleted.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../pages");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../pages");
      }
  }
  //Delete Sub Menu
  if(isset($_POST['sub_menu_id_delete'])) {

    $adm_data=$d->selectRow("menu_name,menu_link","master_menu"," menu_id='$sub_menu_id_delete'");
        $data_q=mysqli_fetch_array($adm_data);


    $q=$d->delete("master_menu","menu_id='$sub_menu_id_delete'");
      if($q>0) {
       //  $myfile = fopen("../".$data_q['menu_link'].".php", "w"); 
         unlink("../".$data_q['menu_link'].".php");


        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Menu Deleted");
        $_SESSION['msg']=$data_q['menu_name']." Menu Deleted.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../subMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../subMenu");
      }
  }
}
else{
  header('location:../login');
 }
 ?>
