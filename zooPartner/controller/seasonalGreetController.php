<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

 //echo "<pre>";print_r($_POST);exit;

 if(isset($_POST['addSeasonalGreet'])){
   $m->set_data('title',ucfirst($title));
   $m->set_data('is_expiry',$is_expiry);
   $m->set_data('start_date',date("Y-m-d",strtotime($start_date)));
  $m->set_data('end_date',date("Y-m-d",strtotime($end_date)));
  $m->set_data('order_date',date("Y-m-d",strtotime($order_date)));
  $m->set_data('status',$status);
 $m->set_data('created_by',$_SESSION[zoobiz_admin_id]);
   $created_at = date('Y-m-d H:i:s');
   $m->set_data('created_at',$created_at);
  
  $a =array(
    'title'=> $m->get_data('title'),
    'is_expiry'=> $m->get_data('is_expiry'),
    'status'=> $m->get_data('status'),
    'start_date'=> $m->get_data('start_date'),
    'end_date'=> $m->get_data('end_date'),
    'order_date' => $m->get_data('order_date'),
    'created_by'=> $m->get_data('created_by')  ,
    'created_at'=> $m->get_data('created_at') 
  );
  $q=$d->insert("seasonal_greet_master",$a);
 if($q>0) {
    $_SESSION['msg']=ucfirst($title)." Seasonal Greeting Added";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../seasonalGreetList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../seasonalGreetList");
  } 
} else if(isset($_POST['updateSeasonalGreet'])){
   $m->set_data('title',ucfirst($title));
   $m->set_data('is_expiry',$is_expiry);
      $m->set_data('start_date',date("Y-m-d",strtotime($start_date)));
  $m->set_data('end_date',date("Y-m-d",strtotime($end_date)));
  $m->set_data('status',$status);
 $m->set_data('created_by',$_SESSION[zoobiz_admin_id]);
   $created_at = date('Y-m-d H:i:s');
   
  
  $m->set_data('order_date',date("Y-m-d",strtotime($order_date)));

    
  $a =array(
    'title'=> $m->get_data('title'),
    'is_expiry'=> $m->get_data('is_expiry'),
    'status'=> $m->get_data('status'),
    'start_date'=> $m->get_data('start_date'),
    'order_date' => $m->get_data('order_date'),
    'end_date'=> $m->get_data('end_date'),
    'created_by'=> $m->get_data('created_by')  
  );
  $q=$d->update("seasonal_greet_master",$a,"seasonal_greet_id ='$seasonal_greet_id'");
 if($q>0) {
    $_SESSION['msg']=ucfirst($title)." Seasonal Greeting Updated";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../seasonalGreetList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../seasonalGreetList");
  }

}  


else if(isset($_POST['addSeasonalGreetImage'])){

      $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['cover_image']['tmp_name'];
      $ext = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
         $maxsize = 3000000;
           if (($_FILES['cover_image']['size'] >= $maxsize) || ($_FILES["cover_image"]["size"] == 0)) {
               echo "image too large. Must be less than or equal to 3 MB.";
                exit();
              }
               $newFileName = rand().time();
          move_uploaded_file($_FILES["cover_image"]["tmp_name"], "../../img/promotion/".$newFileName. "_sg.". $ext);
             $cover_image= $newFileName."_sg.".$ext;
            } else{
            $_SESSION['msg1']="Invalid Image";
            header("location:../seasonalGreetImage");
            exit();
          }
        } else {
           $_SESSION['msg1']="Invalid Image";
            header("location:../seasonalGreetImage");
            exit();
        }

         $uploadedFile = $_FILES['background_image']['tmp_name'];
      $ext = pathinfo($_FILES['background_image']['name'], PATHINFO_EXTENSION);
        if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
         $maxsize = 3000000;
           if (($_FILES['background_image']['size'] >= $maxsize) || ($_FILES["background_image"]["size"] == 0)) {
               echo "image too large. Must be less than or equal to 3 MB.";
                exit();
              }
              $newFileName = rand().time();
          move_uploaded_file($_FILES["background_image"]["tmp_name"], "../../img/promotion/".$newFileName. "_sg.". $ext);
             $background_image= $newFileName."_sg.".$ext;
            } else{
            $_SESSION['msg1']="Invalid Image";
            header("location:../seasonalGreetImage");
            exit();
          }
        } else {
           $_SESSION['msg1']="Invalid Image";
            header("location:../seasonalGreetImage");
            exit();
        }

   $m->set_data('seasonal_greet_id',$seasonal_greet_id);
   $m->set_data('cover_image',ucfirst($cover_image));
   $m->set_data('background_image',ucfirst($background_image));
  
   $m->set_data('title_on_image',ucfirst($title_on_image));
   $m->set_data('description_on_image',ucfirst($description_on_image));
   $m->set_data('page_alignment',$page_alignment);
   $m->set_data('title_font_color',$title_font_color);
   $m->set_data('title_font_name',$title_font_name);
   $m->set_data('description_font_color',$description_font_color);
   $m->set_data('description_font_name',$description_font_name);
   $m->set_data('show_to_name',$show_to_name);
   $m->set_data('to_name_font_color',$to_name_font_color);
   $m->set_data('to_name_font_name',$to_name_font_name);
   $m->set_data('to_name_font_size',$to_name_font_size);
   $m->set_data('show_from_name',$show_from_name);

   
     $m->set_data('from_name_font_color',$from_name_font_color);
   
   
   $m->set_data('from_name_font_name',$from_name_font_name); 
   $m->set_data('from_name_font_size',$from_name_font_size); 
    $m->set_data('status',$status); 
   $m->set_data('created_by',$_SESSION[zoobiz_admin_id]);
   $m->set_data('created_at',date('Y-m-d H:i:s'));
   
     $m->set_data('logo_alignment',$logo_alignment);
     $m->set_data('to_text_alignment',$to_text_alignment);
     $m->set_data('from_text_alignment',$from_text_alignment);
     $m->set_data('title_alignment',$title_alignment);
     $m->set_data('description_alignment',$description_alignment);
  $a =array(
    'seasonal_greet_id'=> $m->get_data('seasonal_greet_id'),
    'title_on_image'=> $m->get_data('title_on_image'),
    'description_on_image'=> $m->get_data('description_on_image'),
    'cover_image'=> $m->get_data('cover_image'),
    'background_image'=> $m->get_data('background_image'),
    'page_alignment'=> $m->get_data('page_alignment'),
    'logo_alignment'=> $m->get_data('logo_alignment'),
    'to_text_alignment'=> $m->get_data('to_text_alignment'),
    'from_text_alignment'=> $m->get_data('from_text_alignment'),
    'title_alignment'=> $m->get_data('title_alignment'),
    'description_alignment'=> $m->get_data('description_alignment'),
    'title_font_color'=> $m->get_data('title_font_color'),
    'title_font_name'=> $m->get_data('title_font_name'),
    'description_font_color'=> $m->get_data('description_font_color'),
    'description_font_name'=> $m->get_data('description_font_name'),
    'show_to_name'=> $m->get_data('show_to_name'),
    'to_name_font_color'=> $m->get_data('to_name_font_color'),
    'to_name_font_name'=> $m->get_data('to_name_font_name'),
    'to_name_font_size'=> $m->get_data('to_name_font_size'),
    'show_from_name'=> $m->get_data('show_from_name'),
    'from_name_font_color'=> $m->get_data('from_name_font_color'),
    'from_name_font_name'=> $m->get_data('from_name_font_name'),
    'from_name_font_size' => $m->get_data('from_name_font_size'),
    'status'=> $m->get_data('status'),
    'created_by'=> $m->get_data('created_by'),
    'created_at' =>  $m->get_data('created_at')
  );
  $q=$d->insert("seasonal_greet_image_master",$a);
 if($q>0) {
    $_SESSION['msg']=ucfirst($title_on_image)." Seasonal Greeting Image Added";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../manageSeasonalGreet?seasonal_greet_id=$seasonal_greet_id");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../manageSeasonalGreet?seasonal_greet_id=$seasonal_greet_id");
  }

}   else if(isset($_POST['updateSeasonalGreetImage'])){

 
      $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
      $uploadedFile = $_FILES['cover_image']['tmp_name'];
      $ext = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
      
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
        
               $newFileName = rand().time();
          move_uploaded_file($_FILES["cover_image"]["tmp_name"], "../../img/promotion/".$newFileName. "_sg.". $ext);
               $cover_image= $newFileName."_sg.".$ext;
             $m->set_data('cover_image',$cover_image);

              $a1 =array(
                'cover_image'=> $m->get_data('cover_image')
              );
              $q1=$d->update("seasonal_greet_image_master",$a1,"seasonal_greet_image_id='$seasonal_greet_image_id'");
//echo "seasonal_greet_image_id='$seasonal_greet_image_id'"."here";exit;
            }  
        }  

         $uploadedFile = $_FILES['background_image']['tmp_name'];
      $ext = pathinfo($_FILES['background_image']['name'], PATHINFO_EXTENSION);
        if(file_exists($uploadedFile)) {
          if(in_array($ext,$extension)) {
          $newFileName = rand().time();
          move_uploaded_file($_FILES["background_image"]["tmp_name"], "../../img/promotion/".$newFileName. "_sg.". $ext);
             $background_image= $newFileName."_sg.".$ext;
              $m->set_data('background_image',$background_image);
              $a2 =array(
                'background_image'=> $m->get_data('background_image')
              );
              $q2=$d->update("seasonal_greet_image_master",$a2,"seasonal_greet_image_id='$seasonal_greet_image_id'");


            }  
        }  

  
   $m->set_data('title_on_image',ucfirst($title_on_image));
   $m->set_data('description_on_image',ucfirst($description_on_image));
   $m->set_data('page_alignment',$page_alignment);
   $m->set_data('title_font_color',$title_font_color);
   $m->set_data('title_font_name',$title_font_name);
   $m->set_data('description_font_color',$description_font_color);
   $m->set_data('description_font_name',$description_font_name);
   $m->set_data('show_to_name',$show_to_name);
   $m->set_data('to_name_font_color',$to_name_font_color);
   $m->set_data('to_name_font_name',$to_name_font_name);

   $m->set_data('to_name_font_size',$to_name_font_size);
   $m->set_data('show_from_name',$show_from_name);

  
     $m->set_data('from_name_font_color',$from_name_font_color);
  
   

    
   $m->set_data('from_name_font_name',$from_name_font_name); 
   $m->set_data('from_name_font_size',$from_name_font_size); 

   $m->set_data('status',$status); 
   $m->set_data('created_by',$_SESSION[zoobiz_admin_id]);
   
   $m->set_data('logo_alignment',$logo_alignment);
     $m->set_data('to_text_alignment',$to_text_alignment);
     $m->set_data('from_text_alignment',$from_text_alignment);
     $m->set_data('title_alignment',$title_alignment);
     $m->set_data('description_alignment',$description_alignment);

  $a =array(
    'title_on_image'=> $m->get_data('title_on_image'),
    'description_on_image'=> $m->get_data('description_on_image'),
    'page_alignment'=> $m->get_data('page_alignment'),
    'logo_alignment'=> $m->get_data('logo_alignment'),
    'to_text_alignment'=> $m->get_data('to_text_alignment'),
    'from_text_alignment'=> $m->get_data('from_text_alignment'),
    'title_alignment'=> $m->get_data('title_alignment'),
    'description_alignment'=> $m->get_data('description_alignment'),
    'title_font_color'=> $m->get_data('title_font_color'),
    'title_font_name'=> $m->get_data('title_font_name'),
    'description_font_color'=> $m->get_data('description_font_color'),
    'description_font_name'=> $m->get_data('description_font_name'),
    'show_to_name'=> $m->get_data('show_to_name'),
    'to_name_font_color'=> $m->get_data('to_name_font_color'),
    'to_name_font_name'=> $m->get_data('to_name_font_name'),
    'to_name_font_size'=> $m->get_data('to_name_font_size'),
    'show_from_name'=> $m->get_data('show_from_name'),
    'from_name_font_color'=> $m->get_data('from_name_font_color'),
    'from_name_font_name'=> $m->get_data('from_name_font_name'),
    'from_name_font_size'=> $m->get_data('from_name_font_size'),
    'status'=> $m->get_data('status'),
    'created_by'=> $m->get_data('created_by')
  );
  $q=$d->update("seasonal_greet_image_master",$a,"seasonal_greet_image_id = '$seasonal_greet_image_id'");
 if($q>0) {
    $_SESSION['msg']=ucfirst($title_on_image)." Seasonal Greeting Image Updated";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../manageSeasonalGreet?seasonal_greet_id=$seasonal_greet_id");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../manageSeasonalGreet?seasonal_greet_id=$seasonal_greet_id");
  }

}  



if(isset($_POST['delete_seasonal_greet_id'])){
 
   $adm_data=$d->selectRow("title","seasonal_greet_master"," seasonal_greet_id='$delete_seasonal_greet_id'");
        $data_q=mysqli_fetch_array($adm_data);
   $q=$d->delete("seasonal_greet_master","seasonal_greet_id='$delete_seasonal_greet_id'  ");
        
  if($q>0 ) {


    $qqq=$d->select("seasonal_greet_image_master","seasonal_greet_id='$delete_seasonal_greet_id' ");
  
   while($iData=mysqli_fetch_array($qqq)) { 
    $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/promotion/".$iData['cover_image'];
    unlink($path);
    $path2 = $abspath."/img/promotion/".$iData['background_image'];
    unlink($path2);

    $q2=$d->delete("seasonal_greet_image_master","seasonal_greet_id='$delete_seasonal_greet_id'  ");
    

  }



    $_SESSION['msg']=$data_q['title']." Seasonal Greeting Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../seasonalGreetList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../seasonalGreetList");
  }


}  

if(isset($_POST['delete_seasonal_greet_image_id'])){
 
   $adm_data=$d->selectRow("*","seasonal_greet_image_master"," seasonal_greet_image_id='$delete_seasonal_greet_image_id'");
        $data_q=mysqli_fetch_array($adm_data);
   $q=$d->delete("seasonal_greet_image_master","seasonal_greet_image_id='$delete_seasonal_greet_image_id'  ");
        
  if($q>0 ) {

    $abspath=$_SERVER['DOCUMENT_ROOT'];
    $path = $abspath."/img/promotion/".$data_q['cover_image'];
    unlink($path);
    $path2 = $abspath."/img/promotion/".$data_q['background_image'];
    unlink($path2);

    $q2=$d->delete("seasonal_greet_image_master","seasonal_greet_id='$delete_seasonal_greet_id'  ");
    
  
    $_SESSION['msg']=$data_q['title_on_image']." Deleted";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../manageSeasonalGreet?seasonal_greet_id=$seasonal_greet_id");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../manageSeasonalGreet?seasonal_greet_id=$seasonal_greet_id");
  }


}  

}else{
  header('location:../login');
}
?>