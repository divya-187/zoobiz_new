<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

   


 
 if(isset($_POST['prtAddBtn'])){
    
    $m->set_data('role_id',$role_id);
    $m->set_data('country_id',$country_id);
    $m->set_data('state_id',$state_id);

$city_id = implode(",", $_POST['city_id']);
    $m->set_data('city_id',$city_id);

    $m->set_data('partner_name',ucfirst($partner_name)); 
    $m->set_data('partner_mobile',$partner_mobile); 
    
   
    $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
      $uploadedFile = $_FILES['partner_profile']['tmp_name'];
      $ext = pathinfo($_FILES['partner_profile']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {

          $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand();
          $dirPath = "../img/profile/";

          move_uploaded_file($_FILES["partner_profile"]["tmp_name"], "../img/profile/".$newFileName. "_admin.". $ext);

          $partner_profile= $newFileName."_admin.".$ext;
         } else {
          $_SESSION['msg1']="Invalid Photo";
          header("location:../partner");
          exit();
         }
        } else {
          $partner_profile= $admin_profile_old;
        }          
 $m->set_data("partner_profile",test_input($partner_profile));

$created_date = date("Y-m-d H:i:s");
 $m->set_data("created_date",test_input($created_date));
$a =array(
    'partner_profile'=> $m->get_data('partner_profile'),
    'role_id'=> $m->get_data('role_id'),
    'partner_name'=> $m->get_data('partner_name'),
    'partner_mobile'=> $m->get_data('partner_mobile'), 
    'country_id' => $m->get_data('country_id'), 
    'state_id' => $m->get_data('state_id'), 
    'city_id' => $m->get_data('city_id'), 
    'created_date'=> $m->get_data('created_date') 
  );

 
  $q=$d->insert("zoobiz_partner_master",$a);

  
  if($q>0) {
 
    $_SESSION['msg']= ucfirst($partner_name)." Partner Added";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../partnerList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../partner");
  }

  
    
}  else if(isset($_POST['prtEditBtn'])){




   
    $m->set_data('role_id',$role_id);
    $m->set_data('partner_name',ucfirst($partner_name)); 
    $m->set_data('partner_mobile',$partner_mobile); 
   $m->set_data('country_id',$country_id);
    $m->set_data('state_id',$state_id);

$city_id = implode(",", $_POST['city_id']);
    $m->set_data('city_id',$city_id);

    $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
      $uploadedFile = $_FILES['partner_profile']['tmp_name'];
      $ext = pathinfo($_FILES['partner_profile']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {

          $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand();
          $dirPath = "../img/profile/";

          move_uploaded_file($_FILES["partner_profile"]["tmp_name"], "../img/profile/".$newFileName. "_partner.". $ext);

          $partner_profile= $newFileName."_partner.".$ext;
         } else {
          $_SESSION['msg1']="Invalid Photo";
          header("location:../partner");
          exit();
         }
        } else {
          $partner_profile= $partner_profile_old;
        }     

 $m->set_data("partner_profile",test_input($partner_profile));

$created_date = date("Y-m-d H:i:s");
 $m->set_data("created_date",test_input($created_date));
$a =array(
    'partner_profile'=> $m->get_data('partner_profile'),
    'role_id'=> $m->get_data('role_id'),
    'partner_name'=> $m->get_data('partner_name'),
    'partner_mobile'=> $m->get_data('partner_mobile'), 
    'country_id' => $m->get_data('country_id'), 
    'state_id' => $m->get_data('state_id'), 
    'city_id' => $m->get_data('city_id'), 
    'created_date'=> $m->get_data('created_date') 
  );
 
$q=$d->update("zoobiz_partner_master",$a,"zoobiz_partner_id = '$zoobiz_partner_id_edit'");
  
  if($q>0) {
    $_SESSION['msg']=ucfirst($partner_name) ." Partner Updated";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../partnerList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../partner");
  }

   
     

}        

}else{
  header('location:../login');
}
?>