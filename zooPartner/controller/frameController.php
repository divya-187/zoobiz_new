<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

 //echo "<pre>";print_r($_REQUEST);exit;
 if(isset($_POST['frameAddBtn'])){
  
  $uploadedFile = $_FILES['frame_image']['tmp_name'];
   $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
     $ext = pathinfo($_FILES['frame_image']['name'], PATHINFO_EXTENSION);
      
if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/frames/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];
      
      
      $frame_image= $newFileName."_frm.".$ext;

      move_uploaded_file($_FILES["frame_image"]["tmp_name"], "../../img/frames/".$frame_image);
    }  else {
      $frame_image="";
    }
  } else {
    $frame_image="";
  }
           
                $m->set_data('frame_image', $frame_image);
                 
  $m->set_data('frame_name',$frame_name);  
  $m->set_data('layout_name',$layout_name);  
  $a =array(
    'frame_name'=> $m->get_data('frame_name'),
    'layout_name'=> $m->get_data('layout_name'),
    'frame_image'=> $m->get_data('frame_image')  
  );
  $q=$d->insert("frame_master",$a);

  
  if($q>0) {
    $_SESSION['msg']="Frame Added";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../frameList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../frameList");
  }

}  else if(isset($_POST['frameEditBtn'])){
 
  $uploadedFile = $_FILES['frame_image_edit']['tmp_name'];
   $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
     $ext = pathinfo($_FILES['frame_image_edit']['name'], PATHINFO_EXTENSION);


if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/frames/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];
      
      
      $frame_image= $newFileName."_frm.".$ext;

      move_uploaded_file($_FILES["frame_image_edit"]["tmp_name"], "../../img/frames/".$frame_image);
    }  else {
      $frame_image="";
    }
  } else {
    $frame_image=$frame_image_old;
  }

    /* if(isset($_FILES['frame_image_edit']['tmp_name']) && $_FILES['frame_image_edit']['tmp_name'] !="" ) {
      if(in_array($ext,$extension)) {

        $sourceProperties = getimagesize($uploadedFile);
        $newFileName = rand();
        $dirPath = "../../img/frames/";

         move_uploaded_file($_FILES['frame_image']['tmp_name'], "../../img/frames/".$newFileName."_frm.".$ext);


         
        } else {
          $_SESSION['msg1']="Invalid Image d....";
          header("Location: ../frameList");
        }
}  else {
  $frame_image= $frame_image_old;
}*/
           
                $m->set_data('frame_image', $frame_image);
  $m->set_data('frame_name',$frame_name);  
  $m->set_data('layout_name',$layout_name); 
  $a =array(
    'frame_image'=> $m->get_data('frame_image'),
    'layout_name'=> $m->get_data('layout_name'),
    'frame_name'=> $m->get_data('frame_name')  
  );

  $q=$d->update("frame_master",$a,"frame_id = '$frame_id' ");
  if($q>0 ) {
    $_SESSION['msg']="Frame Updated";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../frameList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../frameList");
  }


}  
 else if(isset($_POST['deletefrm'])){
 
  
   $q=$d->delete("frame_master","frame_id='$frame_id'  ");
       
  if($q>0 ) {
    $_SESSION['msg']="Frame Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../frameList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../frameList");
  }


}  


}else{
  header('location:../login');
}
?>