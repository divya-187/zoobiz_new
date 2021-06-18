<?php 
 include '../common/objectController.php';

   
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
  // add main menu
  if(isset($_POST['appMenuAdd'])){


     $file11 = $_FILES['menu_icon_new']['tmp_name'];
        if(file_exists($file11)) {
          $extension=array("png","jpg","jpeg","PNG","JPG","JPEG");
          $extId = pathinfo($_FILES['menu_icon_new']['name'], PATHINFO_EXTENSION);

           $errors     = array();
            $maxsize    = 10097152;
            
            if(!in_array($extId, $extension) && (!empty($_FILES["menu_icon_new"]["type"]))) {
                 $_SESSION['msg1']="Invalid  File format, Only  JPG,PDF, PNG,Doc are allowed.";
                header("location:../addAppMenu");
                exit();
            }
           if(count($errors) === 0) {
            $image_Arr = $_FILES['menu_icon_new'];   
            $temp = explode(".", $_FILES["menu_icon_new"]["name"]);
            $menu_icon =  'menu_icon_'.round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES["menu_icon_new"]["tmp_name"], "../../img/app_icon/".$menu_icon);
          } 
        } else{
          $menu_icon="";
        }

     $m->set_data('parent_menu_id',$parent_menu_id);
      $m->set_data('menu_title',$menu_title);
      $m->set_data('menu_click',$menu_click);
      $m->set_data('ios_menu_click',$ios_menu_click);
      $m->set_data('menu_sequence',$menu_sequence);
      $m->set_data('is_show',$is_show);
      $m->set_data('tutorial_video',$tutorial_video);
      $m->set_data('menu_icon',$menu_icon);
      $m->set_data('created_by',$created_by);
      $a =array(
        'parent_menu_id'=> $m->get_data('parent_menu_id'),
          'menu_title'=> $m->get_data('menu_title'),
          'menu_click'=>$m->get_data('menu_click'),
          'ios_menu_click'=>$m->get_data('ios_menu_click'),
          'menu_sequence'=>$m->get_data('menu_sequence'),
          'is_show'=>$m->get_data('is_show'),
          'tutorial_video'=>$m->get_data('tutorial_video'),
          'menu_icon'=>$m->get_data('menu_icon'),
          'menu_icon_new'=>$m->get_data('menu_icon'),
          'created_by'=>$m->get_data('created_by'),
          'created_at' =>date("Y-m-d H:i:s")
      );
      $q=$d->insert("resident_app_menu",$a);
      if($q>0) {
       
        $_SESSION['msg']=$menu_title. " New App Menu Added.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../appMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../addAppMenu");
      }
  }
  
  
  // Edit  
  if(isset($_POST['editMenuAdd'])){

 
     $file11 = $_FILES['menu_icon_new']['tmp_name'];
        if(file_exists($file11)) {
          $extension=array("png","jpg","jpeg","PNG","JPG","JPEG");
          $extId = pathinfo($_FILES['menu_icon_new']['name'], PATHINFO_EXTENSION);

           $errors     = array();
            $maxsize    = 10097152;
            
            if(!in_array($extId, $extension) && (!empty($_FILES["menu_icon_new"]["type"]))) {
                 $_SESSION['msg1']="Invalid  File format, Only  JPG,PDF, PNG,Doc are allowed.";
                header("location:../addAppMenu");
                exit();
            }
           if(count($errors) === 0) {
            $image_Arr = $_FILES['menu_icon_new'];   
            $temp = explode(".", $_FILES["menu_icon_new"]["name"]);
            $menu_icon =  'menu_icon_'.round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES["menu_icon_new"]["tmp_name"], "../../img/app_icon/".$menu_icon);
          } 
        } else{
          $menu_icon=$menu_icon_new;
        }

     $m->set_data('parent_menu_id',$parent_menu_id);
      $m->set_data('menu_title',$menu_title);
      $m->set_data('menu_click',$menu_click);
      $m->set_data('ios_menu_click',$ios_menu_click);
      $m->set_data('menu_sequence',$menu_sequence);
      $m->set_data('is_show',$is_show);
      $m->set_data('tutorial_video',$tutorial_video);
      $m->set_data('menu_icon',$menu_icon);
      $m->set_data('created_by',$created_by);
      $a =array(
        'parent_menu_id'=> $m->get_data('parent_menu_id'),
          'menu_title'=> $m->get_data('menu_title'),
          'menu_click'=>$m->get_data('menu_click'),
          'ios_menu_click'=>$m->get_data('ios_menu_click'),
          'menu_sequence'=>$m->get_data('menu_sequence'),
          'is_show'=>$m->get_data('is_show'),
          'tutorial_video'=>$m->get_data('tutorial_video'),
          'menu_icon'=>$m->get_data('menu_icon'),
          'menu_icon_new'=>$m->get_data('menu_icon'),
          'created_by'=>$m->get_data('created_by') 
      );

       $q=$d->update("resident_app_menu",$a,"app_menu_id = '$app_menu_id'");
      if($q>0) {
       
        $_SESSION['msg']=$menu_title. " New App Menu Edited.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../appMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../addAppMenu");
      }
  
 
  }
 
  
  if(isset($_POST['app_menu_id_delete'])) {
 $resident_app_menu_q=$d->select("resident_app_menu","app_menu_id='$app_menu_id_delete'","");
    $resident_app_menu_data=mysqli_fetch_array($resident_app_menu_q);
      $menu_title = $resident_app_menu_data['menu_title'];
    $q=$d->delete("resident_app_menu","app_menu_id = '$app_menu_id_delete'");
      if($q>0) {
         
        $_SESSION['msg']=$menu_title ."App Menu  Deleted.";

    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("location:../appMenu");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../appMenu");
      }
  }
   
   
}
else{
  header('location:../login');
 }
 ?>
