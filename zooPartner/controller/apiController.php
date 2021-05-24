<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )
{
	 
if(isset($deleteAPI)){

 
 $api_master = $d->selectRow("api_id,api_file,api_version","api_master","api_id ='$api_id'"," ");
      
       $sData = mysqli_fetch_array($api_master);
        $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."../../img/api/".$sData['api_file'];
        unlink($path);
        
        $q_del=$d->delete("api_master","api_id ='$api_id' ");

        if($q_del==TRUE) {
      $_SESSION['msg']=$sData['api_version']." APK Deleted";
       $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../api");
    } else {
       $_SESSION['msg1']="Something Wrong";
      header("Location: ../api");
    }

      
}
  else if (isset($addApi)) {
       $api_master = $d->selectRow("api_id,api_file","api_master",""," ORDER BY api_id DESC LIMIT 9");
      //$data = mysqli_fetch_array($q);
       $ids_array = array();
      while ($sData = mysqli_fetch_array($api_master)) {
        $ids_array[] = $sData['api_id'];
        $abspath=$_SERVER['DOCUMENT_ROOT'];
        $path = $abspath."../../img/api/".$sData['api_file'];
        unlink($path);
 

      }
      if(!empty($ids_array)){
        $ids_array = implode(",", $ids_array);
        $q_del=$d->delete("api_master","api_id NOT IN  ($ids_array) ");
      }
      $extension=array("apk");
      $uploadedFile = $_FILES['api_file']['tmp_name'];
      $ext = pathinfo($_FILES['api_file']['name'], PATHINFO_EXTENSION);
      if(file_exists($uploadedFile)) {
        if(in_array($ext,$extension)) {
        $image_Arr = $_FILES['api_file'];   
            $temp = explode(".", $_FILES["api_file"]["name"]);
            $api_file = 'API_'.rand().'.' . end($temp);
            move_uploaded_file($_FILES["api_file"]["tmp_name"], "../../img/api/".$api_file);
       } else {
          $_SESSION['msg1']="Invalid APK";
          header("location:../api");
          exit();
      } 
    }else {
          $_SESSION['msg1']="Invalid APK";
          header("location:../api");
          exit();
    }

        $m->set_data('created_at',date("Y-m-d H:i:s"));
        $m->set_data('api_version',$api_version);
        $m->set_data('api_file',$api_file);
        $m->set_data('description',$description);
        
         $a1= array (
            
          'api_file'=> $m->get_data('api_file'),
          'api_version'=> $m->get_data('api_version'),
          'created_at'=> $m->get_data('created_at'),
          'description' => $m->get_data('description')
        );


    $q=$d->insert("api_master",$a1);
    if($q==TRUE) {
      $_SESSION['msg']=$api_version." New APK Added";
       $d->insert_log("","$society_id","$_SESSION[bms_admin_id]","$created_by",$_SESSION['msg']);
      header("Location: ../api");
    } else {
       $_SESSION['msg1']="Something Wrong";
      header("Location: ../api");
    }

  }


}
?>