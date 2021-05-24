<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 


 //echo "<pre>";print_r($_REQUEST);exit;
 if(isset($_POST['promotionAddBtn'])){
   $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
   $uploadedFile = $_FILES['event_image']['tmp_name'];     
   $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);
   $event_image="";
   if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/promotion/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];


      $event_image= $newFileName."_event.".$ext;

      move_uploaded_file($_FILES["event_image"]["tmp_name"], "../../img/promotion/".$event_image);
    }
  }


  $uploadedFile = $_FILES['event_frame']['tmp_name'];     
   $ext = pathinfo($_FILES['event_frame']['name'], PATHINFO_EXTENSION);
   $event_frame="";
   if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/promotion/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];


      $event_frame= $newFileName."_event_frm.".$ext;

      move_uploaded_file($_FILES["event_frame"]["tmp_name"], "../../img/promotion/".$event_frame);
    }
  }

  $m->set_data('event_frame', $event_frame);
  $m->set_data('event_image', $event_image);
  $m->set_data('event_name', $event_name);
  $event_date = date("Y-m-d", strtotime($event_date));   
  $event_end_date = date("Y-m-d", strtotime($event_end_date));   
  $order_date = date("Y-m-d", strtotime($order_date));               
  $m->set_data('event_date',$event_date);  
  $m->set_data('event_end_date',$event_end_date);  
  $m->set_data('order_date',$order_date);  
  $m->set_data('description',$description);  
  $m->set_data('event_status',$event_status);  
   if(!isset($text_color) || $text_color==""){
            $text_color ="#000";
          }
          $m->set_data('text_color', $text_color);

  //10nov
          $m->set_data('auto_expire',$auto_expire);  
  $a =array(
    'event_name'=> $m->get_data('event_name'),
    'event_image'=> $m->get_data('event_image'),
    'event_frame'=> $m->get_data('event_frame'),
    'event_date'=> $m->get_data('event_date'),
    'event_end_date'=> $m->get_data('event_end_date'),
    'order_date'=> $m->get_data('order_date'),
    'description'=> $m->get_data('description'),
    'event_status'=> $m->get_data('event_status'),
    'auto_expire'=> $m->get_data('auto_expire'),
    'text_color' => $m->get_data('text_color'),
    'created_at'=> date("Y-m-d H:i:s"),
    'created_by'=> $_SESSION[zoobiz_admin_id]  
  );
  $q=$d->insert("promotion_master",$a);

  
  if($q>0) {

   $last_auto_id=$d->last_auto_id("promotion_master");
   $res=mysqli_fetch_array($last_auto_id);
   $pro_id=$res['Auto_increment'];
   $pro_id = ($pro_id -1);

  //frame start
   for ($l=0; $l < count($_POST['promotion_frame_id']) ; $l++) {
    $m->set_data('promotion_id',$pro_id);  
    $m->set_data('promotion_frame_id',$_POST['promotion_frame_id'][$l]);  
    $a =array(
      'promotion_id'=> $m->get_data('promotion_id'),
      'promotion_frame_id'=> $m->get_data('promotion_frame_id')  
    );
    $q2=$d->insert("promotion_rel_frame_master",$a);
  }

  for ($x=0; $x < count($_FILES['promotion_frame_new']['name']) ; $x++) { 
    $uploadedFile = $_FILES['promotion_frame_new']['tmp_name'][$x];     
    $ext = pathinfo($_FILES['promotion_frame_new']['name'][$x], PATHINFO_EXTENSION);
    $event_image="";
    if(file_exists($uploadedFile)) {
      if(in_array($ext,$extension)) {
        $sourceProperties = getimagesize($uploadedFile1);
        $newFileName = rand();
        $dirPath = "../../img/promotion/promotion_frames/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];


        $promotion_frame= $newFileName."_frm.".$ext;

        move_uploaded_file($_FILES["promotion_frame_new"]["tmp_name"][$x], "../../img/promotion/promotion_frames/".$promotion_frame);

        
        $m->set_data('promotion_frame',$promotion_frame);  
        $a =array( 
          'promotion_frame'=> $m->get_data('promotion_frame')  
        );
        $qv=$d->insert("promotion_frame_master",$a);

        $last_auto_id=$d->last_auto_id("promotion_frame_master");
        $res=mysqli_fetch_array($last_auto_id);
        $promotion_frame_id=$res['Auto_increment'];
        $promotion_frame_id = ($promotion_frame_id -1);

        $m->set_data('promotion_id',$pro_id);  
        $m->set_data('promotion_frame_id',$promotion_frame_id);  
        $a =array(
          'promotion_id'=> $m->get_data('promotion_id'),
          'promotion_frame_id'=> $m->get_data('promotion_frame_id')  
        );
        $qf=$d->insert("promotion_rel_frame_master",$a);


      }
    }
  }
//frame end
//center start
  for ($p=0; $p < count($_POST['promotion_center_image_id']) ; $p++) {
    $m->set_data('promotion_id',$pro_id);  
    $m->set_data('promotion_center_image_id',$_POST['promotion_center_image_id'][$p]);  
    $a =array(
      'promotion_id'=> $m->get_data('promotion_id'),
      'promotion_center_image_id'=> $m->get_data('promotion_center_image_id')  
    );

    
    $q3=$d->insert("promotion_rel_center_master",$a);
  }
  for ($x=0; $x < count($_FILES['promotion_center_image_new']['name']) ; $x++) { 
    $uploadedFile = $_FILES['promotion_center_image_new']['tmp_name'][$x];     
    $ext = pathinfo($_FILES['promotion_center_image_new']['name'][$x], PATHINFO_EXTENSION);
    $event_image="";
    if(file_exists($uploadedFile)) {
      if(in_array($ext,$extension)) {
        $sourceProperties = getimagesize($uploadedFile1);
        $newFileName = rand();
        $dirPath = "../../img/promotion/promotion_center_image/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];


        $promotion_center_image= $newFileName."_frm.".$ext;

        move_uploaded_file($_FILES["promotion_center_image_new"]["tmp_name"][$x], "../../img/promotion/promotion_center_image/".$promotion_center_image);

        
        $m->set_data('promotion_center_image',$promotion_center_image);  
        $a =array( 
          'promotion_center_image'=> $m->get_data('promotion_center_image')  
        );
        $qv=$d->insert("promotion_center_image_master",$a);

        $last_auto_id=$d->last_auto_id("promotion_center_image_master");
        $res=mysqli_fetch_array($last_auto_id);
        $promotion_center_image_id=$res['Auto_increment'];
        $promotion_center_image_id = ($promotion_center_image_id -1);

        $m->set_data('promotion_id',$pro_id);  
        $m->set_data('promotion_center_image_id',$promotion_center_image_id);  
        $a =array(
          'promotion_id'=> $m->get_data('promotion_id'),
          'promotion_center_image_id'=> $m->get_data('promotion_center_image_id')  
        );
        $qccc=$d->insert("promotion_rel_center_master",$a);


      }
    }
  }
//center end

  $_SESSION['msg']=$event_name." Added";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("location:../promoteBusiness");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../promoteBusiness");
}

}  else if(isset($_POST['promotionEditBtn'])){


//echo "<pre>";print_r($_REQUEST);exit;
 $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
   $uploadedFile = $_FILES['event_image']['tmp_name'];     
   $ext = pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION);

   if(isset($_FILES['event_image']['name']) && $_FILES['event_image']['name'] !=""){
   $event_image="";
   if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/promotion/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];


      $event_image= $newFileName."_event.".$ext;

      move_uploaded_file($_FILES["event_image"]["tmp_name"], "../../img/promotion/".$event_image);
    }
  } 

}else {
    $event_image = $event_image_old;
  }



$uploadedFile = $_FILES['event_frame']['tmp_name'];     
   $ext = pathinfo($_FILES['event_frame']['name'], PATHINFO_EXTENSION);

   if(isset($_FILES['event_frame']['name']) && $_FILES['event_frame']['name'] !=""){
   
   if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/promotion/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];


      $event_frame= $newFileName."_event_frm.".$ext;

      move_uploaded_file($_FILES["event_frame"]["tmp_name"], "../../img/promotion/".$event_frame);
    }
  } 

}else {
    $event_frame = $event_frame_old;
  }

  $m->set_data('event_frame', $event_frame);
  $m->set_data('event_image', $event_image);
  $m->set_data('event_name', $event_name);
  $event_date = date("Y-m-d", strtotime($event_date)); 
  $event_end_date = date("Y-m-d", strtotime($event_end_date));   
  $order_date = date("Y-m-d", strtotime($order_date));
 $m->set_data('event_end_date',$event_end_date);  
  $m->set_data('order_date',$order_date);  


  $m->set_data('event_date',$event_date);  
  $m->set_data('description',$description);  
  $m->set_data('event_status',$event_status);  
     if(!isset($text_color) || $text_color==""){
            $text_color ="#000";
          }
          $m->set_data('text_color', $text_color);
          //10nov
          $m->set_data('auto_expire',$auto_expire);  

  $a =array(
    'event_name'=> $m->get_data('event_name'),
    
    'event_frame'=> $m->get_data('event_frame'),
    'event_image'=> $m->get_data('event_image'),
    'event_date'=> $m->get_data('event_date'),
    'event_end_date'=> $m->get_data('event_end_date'),
    'order_date'=> $m->get_data('order_date'),
    'description'=> $m->get_data('description'),
    'event_status'=> $m->get_data('event_status'),
    'auto_expire'=> $m->get_data('auto_expire'),
    'text_color'=> $m->get_data('text_color'),
    'updated_at'=> date("Y-m-d H:i:s"),
    'updated_by'=> $_SESSION[zoobiz_admin_id]  
  ); 


 $q=$d->update("promotion_master",$a ,"promotion_id = '$promotion_id' ");
 
 if($q>0 ) {

//delete old data start
 
$q_del=$d->delete("promotion_rel_center_master","promotion_id='$promotion_id'  ");
$q_del2=$d->delete("promotion_rel_frame_master","promotion_id='$promotion_id'  ");
//delete old data end
    $pro_id = $promotion_id;
  //frame start
   for ($l=0; $l < count($_POST['promotion_frame_id']) ; $l++) {
    $m->set_data('promotion_id',$pro_id);  
    $m->set_data('promotion_frame_id',$_POST['promotion_frame_id'][$l]);  
    $a =array(
      'promotion_id'=> $m->get_data('promotion_id'),
      'promotion_frame_id'=> $m->get_data('promotion_frame_id')  
    );
    $q2=$d->insert("promotion_rel_frame_master",$a);
  }

  for ($x=0; $x < count($_FILES['promotion_frame_new']['name']) ; $x++) { 
    $uploadedFile = $_FILES['promotion_frame_new']['tmp_name'][$x];     
    $ext = pathinfo($_FILES['promotion_frame_new']['name'][$x], PATHINFO_EXTENSION);
    $event_image="";
    if(file_exists($uploadedFile)) {
      if(in_array($ext,$extension)) {
        $sourceProperties = getimagesize($uploadedFile1);
        $newFileName = rand();
        $dirPath = "../../img/promotion/promotion_frames/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];


        $promotion_frame= $newFileName."_frm.".$ext;

        move_uploaded_file($_FILES["promotion_frame_new"]["tmp_name"][$x], "../../img/promotion/promotion_frames/".$promotion_frame);

        
        $m->set_data('promotion_frame',$promotion_frame);  
        $a =array( 
          'promotion_frame'=> $m->get_data('promotion_frame')  
        );
        $qv=$d->insert("promotion_frame_master",$a);

        $last_auto_id=$d->last_auto_id("promotion_frame_master");
        $res=mysqli_fetch_array($last_auto_id);
        $promotion_frame_id=$res['Auto_increment'];
        $promotion_frame_id = ($promotion_frame_id -1);

        $m->set_data('promotion_id',$pro_id);  
        $m->set_data('promotion_frame_id',$promotion_frame_id);  
        $a =array(
          'promotion_id'=> $m->get_data('promotion_id'),
          'promotion_frame_id'=> $m->get_data('promotion_frame_id')  
        );
        $qf=$d->insert("promotion_rel_frame_master",$a);


      }
    }
  }
//frame end
//center start
  for ($p=0; $p < count($_POST['promotion_center_image_id']) ; $p++) {
    $m->set_data('promotion_id',$pro_id);  
    $m->set_data('promotion_center_image_id',$_POST['promotion_center_image_id'][$p]);  
    $a =array(
      'promotion_id'=> $m->get_data('promotion_id'),
      'promotion_center_image_id'=> $m->get_data('promotion_center_image_id')  
    );

    
    $q3=$d->insert("promotion_rel_center_master",$a);
  }
  for ($x=0; $x < count($_FILES['promotion_center_image_new']['name']) ; $x++) { 
    $uploadedFile = $_FILES['promotion_center_image_new']['tmp_name'][$x];     
    $ext = pathinfo($_FILES['promotion_center_image_new']['name'][$x], PATHINFO_EXTENSION);
    $event_image="";
    if(file_exists($uploadedFile)) {
      if(in_array($ext,$extension)) {
        $sourceProperties = getimagesize($uploadedFile1);
        $newFileName = rand();
        $dirPath = "../../img/promotion/promotion_center_image/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];


        $promotion_center_image= $newFileName."_frm.".$ext;

        move_uploaded_file($_FILES["promotion_center_image_new"]["tmp_name"][$x], "../../img/promotion/promotion_center_image/".$promotion_center_image);

        
        $m->set_data('promotion_center_image',$promotion_center_image);  
        $a =array( 
          'promotion_center_image'=> $m->get_data('promotion_center_image')  
        );
        $qv=$d->insert("promotion_center_image_master",$a);

        $last_auto_id=$d->last_auto_id("promotion_center_image_master");
        $res=mysqli_fetch_array($last_auto_id);
        $promotion_center_image_id=$res['Auto_increment'];
        $promotion_center_image_id = ($promotion_center_image_id -1);

        $m->set_data('promotion_id',$pro_id);  
        $m->set_data('promotion_center_image_id',$promotion_center_image_id);  
        $a =array(
          'promotion_id'=> $m->get_data('promotion_id'),
          'promotion_center_image_id'=> $m->get_data('promotion_center_image_id')  
        );
        $qccc=$d->insert("promotion_rel_center_master",$a);


      }
    }
  }
//center end
   
  $_SESSION['msg']=$event_name. " Updated";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
  header("location:../promoteBusiness");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../promoteBusiness");
}


}  else   if(isset($updateFrmImg)) {

 $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
//$q_del2=$d->delete("promotion_rel_frame_master","promotion_id='$promotion_id'  ");
//delete old data end
    $pro_id = $promotion_id;
  //frame start
 /*  for ($l=0; $l < count($_POST['promotion_frame_id']) ; $l++) {
    $m->set_data('promotion_id',$pro_id);  
    $m->set_data('promotion_frame_id',$_POST['promotion_frame_id'][$l]);  
    $a =array(
      'promotion_id'=> $m->get_data('promotion_id'),
      'promotion_frame_id'=> $m->get_data('promotion_frame_id')  
    );
    $q2=$d->insert("promotion_rel_frame_master",$a);
  }*/

    
    $uploadedFile = $_FILES['promotion_frame']['tmp_name'];     
    $ext = pathinfo($_FILES['promotion_frame']['name'], PATHINFO_EXTENSION);
    $event_image="";
    if(file_exists($uploadedFile)) {

      if(in_array($ext,$extension)) {

        $sourceProperties = getimagesize($uploadedFile1);
        $newFileName = rand();
        $dirPath = "../../img/promotion/promotion_frames/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];


        $promotion_frame= $newFileName."_frm.".$ext;

        move_uploaded_file($_FILES["promotion_frame"]["tmp_name"], "../../img/promotion/promotion_frames/".$promotion_frame);

        
        $m->set_data('promotion_frame',$promotion_frame);  
        $a =array( 
          'promotion_frame'=> $m->get_data('promotion_frame')  
        );
         

        $qv=$d->insert("promotion_frame_master",$a);

        $last_auto_id=$d->last_auto_id("promotion_frame_master");
        $res=mysqli_fetch_array($last_auto_id);
        $promotion_frame_id=$res['Auto_increment'];
        $promotion_frame_id = ($promotion_frame_id -1);

        $m->set_data('promotion_id',$pro_id);  
        $m->set_data('promotion_frame_id',$promotion_frame_id);   
        $a =array(
          'promotion_id'=> $m->get_data('promotion_id'),
          'promotion_frame_id'=> $m->get_data('promotion_frame_id') 
          
        );
        $qf=$d->update("promotion_rel_frame_master",$a," promotion_id = '$promotion_id' and promotion_rel_frame_id = '$promotion_rel_frame_id' ");


      }
    }
   

    
         $m->set_data('text_color',$text_color);  
         $m->set_data('frame_title',$frame_title);
         
        $a =array(
          
          'text_color'=> $m->get_data('text_color') ,
          'frame_title'=> $m->get_data('frame_title')  
        );
        $qf=$d->update("promotion_rel_frame_master",$a," promotion_id = '$promotion_id' and promotion_rel_frame_id = '$promotion_rel_frame_id' ");

//frame end
if($qf){ 
  $adm_data=$d->selectRow("event_name","promotion_master"," promotion_id='$promotion_id'");
        $data_q=mysqli_fetch_array($adm_data);
    $_SESSION['msg']= $data_q['event_name']." Event Frame Updated";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);

  header("location:../manageFrame?promotion_id=$promotion_id");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../promoteBusiness");
}



} 
      else   if(isset($EditCenterImage)) {
        

 $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
 
    $pro_id = $promotion_id;
 
    $uploadedFile = $_FILES['promotion_center_image']['tmp_name'];     
    $ext = pathinfo($_FILES['promotion_center_image']['name'], PATHINFO_EXTENSION);
    $event_image="";
    if(file_exists($uploadedFile)) {
      if(in_array($ext,$extension)) {
        $sourceProperties = getimagesize($uploadedFile1);
        $newFileName = rand();
        $dirPath = "../../img/promotion/promotion_center_image/";
        $imageType = $sourceProperties[2];
        $imageHeight = $sourceProperties[1];
        $imageWidth = $sourceProperties[0];


        $promotion_center_image= $newFileName."_frm.".$ext;

        move_uploaded_file($_FILES["promotion_center_image"]["tmp_name"], "../../img/promotion/promotion_center_image/".$promotion_center_image);

        
        $m->set_data('promotion_center_image',$promotion_center_image);  
        $a =array( 
          'promotion_center_image'=> $m->get_data('promotion_center_image')  
        );
        $qv=$d->insert("promotion_center_image_master",$a);

        $last_auto_id=$d->last_auto_id("promotion_center_image_master");
        $res=mysqli_fetch_array($last_auto_id);
        $promotion_center_image_id=$res['Auto_increment'];
        $promotion_center_image_id = ($promotion_center_image_id -1);

        $m->set_data('promotion_id',$pro_id);  
        $m->set_data('promotion_center_image_id',$promotion_center_image_id);  
        $a =array(
           
          'promotion_center_image_id'=> $m->get_data('promotion_center_image_id')  
        );
        $qccc=$d->update("promotion_rel_center_master",$a," promotion_id = '$promotion_id' AND promotion_rel_center_id='$promotion_rel_center_id' ");


      }
    }
 
//center end
if($qccc){ 
  
  $adm_data=$d->selectRow("event_name","promotion_master"," promotion_id='$promotion_id'");
        $data_q=mysqli_fetch_array($adm_data);
    $_SESSION['msg']= $data_q['event_name']." Center Image Updated";

   // $_SESSION['msg']="Promotion Center Image Updated";
  $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);

  header("location:../manageCenterImage?promotion_id=$promotion_id");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../promoteBusiness");
}




      }

 else if(isset($_POST['deleteFrameId'])){


     $q=$d->delete("promotion_rel_frame_master","promotion_id='$promotion_id' and promotion_rel_frame_id='$promotion_rel_frame_id'  ");
 
     if($q>0 ) {
     // $_SESSION['msg']="Promotion Frame Deleted";

      $adm_data=$d->selectRow("event_name","promotion_master"," promotion_id='$promotion_id'");
        $data_q=mysqli_fetch_array($adm_data);
    $_SESSION['msg']= $data_q['event_name']." Frame Deleted";

      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../manageFrame?promotion_id=$promotion_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../promoteBusiness");
    }


  }  
else if(isset($_POST['deleteCenterImageId'])){
  

   $q=$d->delete("promotion_rel_center_master","promotion_id='$promotion_id' and promotion_rel_center_id='$promotion_rel_center_id'  ");
 
     if($q>0 ) {
      
       $adm_data=$d->selectRow("event_name","promotion_master"," promotion_id='$promotion_id'");
        $data_q=mysqli_fetch_array($adm_data);
    $_SESSION['msg']= $data_q['event_name']." Center Image Deleted";

      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../manageCenterImage?promotion_id=$promotion_id");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../promoteBusiness");
    }


  }  
    else if(isset($_POST['deletefrm'])){
 
$adm_data=$d->selectRow("event_name","promotion_master"," promotion_id='$promotion_id'");
        $data_q=mysqli_fetch_array($adm_data);
        
     $q=$d->delete("promotion_master","promotion_id='$promotion_id'  ");
     $q_del=$d->delete("promotion_rel_center_master","promotion_id='$promotion_id'  ");
     $q_del2=$d->delete("promotion_rel_frame_master","promotion_id='$promotion_id'  ");
     if($q>0 ) {
     

      
    $_SESSION['msg']= $data_q['event_name']." Deleted";


      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../promoteBusiness");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../promoteBusiness");
    }


  }  

  else if(isset($_POST['deleteSingleFrameImage'])){
 

     $q=$d->delete("promotion_frame_master","promotion_frame_id='$promotion_frame_id'  ");
  
     if($q>0 ) {
      $_SESSION['msg']="Frame Image Deleted";


      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../managePromotionImages?tab=frm_tab");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../managePromotionImages");
    }


  }    else if(isset($_POST['deleteSingleCenterImage'])){
 

     $q=$d->delete("promotion_center_image_master","promotion_center_image_id='$promotion_center_image_id'  ");
  
     if($q>0 ) {
      $_SESSION['msg']="Center Image Deleted";
      $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      header("location:../managePromotionImages?tab=center_tab");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../managePromotionImages");
    }


  }  



}else{
  header('location:../login');
}
?>