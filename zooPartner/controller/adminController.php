<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

   if(isset($_POST['checkAdminMobile'])){
    $q=$d->select("zoobiz_admin_master","admin_mobile='$admin_mobile'");
    $data=mysqli_fetch_array($q);
    if ($data>0) {
       echo 1;
       exit();
    } else {
      echo 0;
      exit();
    }

  }


 
 if(isset($_POST['admAddBtn'])){
   if ($password== $password2) {
    $m->set_data('role_id',$role_id);
    $m->set_data('admin_name',ucfirst($admin_name));
    $m->set_data('admin_email',$admin_email); 
    $m->set_data('admin_mobile',$admin_mobile); 
 
      
     $org_password = $password;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $m->set_data('password',$password);

    $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
      $uploadedFile = $_FILES['admin_profile']['tmp_name'];
      $ext = pathinfo($_FILES['admin_profile']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {

          $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand();
          $dirPath = "../img/profile/";

          move_uploaded_file($_FILES["admin_profile"]["tmp_name"], "../img/profile/".$newFileName. "_admin.". $ext);

          $admin_profile= $newFileName."_admin.".$ext;
         } else {
          $_SESSION['msg1']="Invalid Photo";
          header("location:../profile");
          exit();
         }
        } else {
          $admin_profile= $admin_profile_old;
        }          
 $m->set_data("admin_profile",test_input($admin_profile));

$created_date = date("Y-m-d H:i:s");
 $m->set_data("created_date",test_input($created_date));
$a =array(
    'admin_profile'=> $m->get_data('admin_profile'),
    'role_id'=> $m->get_data('role_id'),
    'admin_name'=> $m->get_data('admin_name'),
    'admin_email'=> $m->get_data('admin_email'),
    'admin_mobile'=> $m->get_data('admin_mobile'),
    'admin_password'=> $m->get_data('password') ,
    'created_date'=> $m->get_data('created_date') 
  );

 
  $q=$d->insert("zoobiz_admin_master",$a);

  
  if($q>0) {

  $to = $admin_email;
  $forgotLink = $adminpanel_link=$base_url."zooAdmin/welcome";
   
      $subject ="Welcome ".ucfirst($admin_name);
      include('../mail/welcomeMail.php');
      include '../mail.php';


      $role_master_q=$d->select("role_master","role_id='$role_id'  ");
  $role_master_data = mysqli_fetch_array($role_master_q); 
$role_name = $role_master_data['role_name'];
      /*$msg= "Dear $admin_name\n Welcome to Zoobiz! You can manage zoobiz admin panel with your mobile number $admin_mobile and below provided link.\n\n  Use the account credentials given below to login your account. .\n your Username: $admin_email Or $admin_mobile  and your Password : Check provided Email account,  to open admin panel.  \n\n Please change your account password once after login.  \n\n Please click below link to access admin panel.\n\n$adminpanel_link\n\nThanks Team ZooBiz";
        $d->send_sms($admin_mobile,$msg);*/

    $_SESSION['msg']= ucfirst($admin_name)." Admin Added";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../adminList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../Something");
  }

  }else {
      $_SESSION['msg1']= "Comirm Password is wrong";
      header("location:../admin");
    }  
    
}  else if(isset($_POST['cpnEditBtn'])){




   
    $m->set_data('role_id',$role_id);
    $m->set_data('admin_name',ucfirst($admin_name));
    $m->set_data('admin_email',$admin_email); 
    $m->set_data('admin_mobile',$admin_mobile); 
   

    $extension=array("jpeg","jpg","png","gif","JPG","JPEG","PNG");
      $uploadedFile = $_FILES['admin_profile']['tmp_name'];
      $ext = pathinfo($_FILES['admin_profile']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {

          $sourceProperties = getimagesize($uploadedFile);
          $newFileName = rand();
          $dirPath = "../img/profile/";

          move_uploaded_file($_FILES["admin_profile"]["tmp_name"], "../img/profile/".$newFileName. "_admin.". $ext);

          $admin_profile= $newFileName."_admin.".$ext;
         } else {
          $_SESSION['msg1']="Invalid Photo";
          header("location:../profile");
          exit();
         }
        } else {
          $admin_profile= $admin_profile_old;
        }          
 $m->set_data("admin_profile",test_input($admin_profile));

$created_date = date("Y-m-d H:i:s");
 $m->set_data("created_date",test_input($created_date));
$a =array(
    'admin_profile'=> $m->get_data('admin_profile'),
    'role_id'=> $m->get_data('role_id'),
    'admin_name'=> $m->get_data('admin_name'),
    'admin_email'=> $m->get_data('admin_email'),
    'admin_mobile'=> $m->get_data('admin_mobile'), 
    'created_date'=> $m->get_data('created_date') 
  );

 
$q=$d->update("zoobiz_admin_master",$a,"zoobiz_admin_id = '$zoobiz_admin_id_edit'");
  
  if($q>0) {
    $_SESSION['msg']=ucfirst($admin_name) ." Admin Updated";
    $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
    header("location:../adminList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../Something");
  }

   
     

}        

}else{
  header('location:../login');
}
?>