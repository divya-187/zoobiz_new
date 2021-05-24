<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

    if(isset($updateContry)) {


       
        $country_name= ucfirst($country_name);
       
        $m->set_data('country_name',$country_name);
            
             $a1= array (
               
                'country_name'=> $m->get_data('country_name'),
            );

        $q=$d->update("countries",$a1,"country_id='$country_id'");
      if($q==TRUE) {
          $_SESSION['msg']=$country_name. " Data Updated";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: $url");
      } else {
        header("Location: $url");
      }
    }


    
    if(isset($updateState)) {


       
        $state_name= ucfirst($state_name);
       
        $m->set_data('state_name',$state_name);
            
             $a1= array (
               
                'state_name'=> $m->get_data('state_name'),
            );

        $q=$d->update("states",$a1,"state_id='$state_id'");
      if($q==TRUE) {
          $_SESSION['msg']=$state_name." Data Updated";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: $url");
      } else {
        header("Location: $url");
      }
    }



    if(isset($cityUpdate)) {


       
        $city_name= ucfirst($city_name);
       
        $m->set_data('city_name',$city_name);
            
             $a1= array (
               
                'city_name'=> $m->get_data('city_name'),
            );

        $q=$d->update("cities",$a1,"city_id='$city_id'");
      if($q==TRUE) {
          $_SESSION['msg']=$city_name." Data Updated";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: $url");
      } else {
        header("Location: $url");
      }
    }

     if(isset($deleteArea)) {

      $used=$d->count_data_direct("adress_id","business_adress_master","area_id='$area_id'");
      if ($used>0) {

        $_SESSION['msg1']="This Area Used in Member Address";
        header("Location: $url");
        exit();
       } 
      
 $adm_data=$d->selectRow("area_name","area_master"," area_id='$area_id'");
        $data_q=mysqli_fetch_array($adm_data);


      $q=$d->delete("area_master","area_id='$area_id'");
      if($q==TRUE) {
          $_SESSION['msg']=$data_q['area_name']." Data Deleted";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: $url");
      } else {
        header("Location: $url");
      }
    }


    if(isset($addArea)) {


       
        $area_name= ucfirst($area_name);
       
        $m->set_data('country_id',$country_id);
        $m->set_data('state_id',$state_id);
        $m->set_data('city_id',$city_id);
        $m->set_data('area_name',$area_name);
        $m->set_data('pincode',$pincode);
        $m->set_data('latitude',$latitude);
        $m->set_data('longitude',$longitude);
            
             $a1= array (
               
                'country_id'=> $m->get_data('country_id'),
                'state_id'=> $m->get_data('state_id'),
                'city_id'=> $m->get_data('city_id'),
                'area_name'=> $m->get_data('area_name'),
                'latitude'=> $m->get_data('latitude'),
                'longitude'=> $m->get_data('longitude'),
                'pincode'=> $m->get_data('pincode'),
            );

      if ($area_id!=0 && $area_id!='') {
        $q=$d->update("area_master",$a1,"area_id='$area_id'");
          $_SESSION['msg']=$area_name." Area Updated";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
      } else {

          $_SESSION['msg']=$area_name." Area Added";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        $q=$d->insert("area_master",$a1);
      }

      if($q==TRUE) {
        header("Location: ../areas?cId=$country_id&sId=$state_id&cityId=$city_id");
      } else {
          $_SESSION['msg1']="Something wrong";
        header("Location: ../areas?cId=$country_id&sId=$state_id&cityId=$city_id");
      }
    }


if(isset($importBulkArea)) {

if($isbug=='true'){
   $az= array (
                'is_imported_live'=> '2'
            );
   $qz=$d->update("bizlocation",$az,"id='$id'");

      if($q==TRUE) {
        header("Location: ../importArea");
      } else {
          $_SESSION['msg1']="Something wrong";
        header("Location: ../importArea");
      }
}
       
        $area_name= ucfirst($area_name);
       
        $m->set_data('country_id',$country_id);
        $m->set_data('state_id',$state_id);
        $m->set_data('city_id',$city_id);
        $m->set_data('area_name',$area_name);
        $m->set_data('pincode',$pincode);
        $m->set_data('latitude',$latitude);
        $m->set_data('longitude',$longitude);
            
             $a1= array (
               
                'country_id'=> $m->get_data('country_id'),
                'state_id'=> $m->get_data('state_id'),
                'city_id'=> $m->get_data('city_id'),
                'area_name'=> $m->get_data('area_name'),
                'latitude'=> $m->get_data('latitude'),
                'longitude'=> $m->get_data('longitude'),
                'pincode'=> $m->get_data('pincode'),
                'is_imported' =>'1'
            );

      

          $_SESSION['msg']=$area_name." Area Added";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        $q=$d->insert("area_master",$a1);
   
          
    $az= array (
                'is_imported_live'=> '1'
            );
   $qz=$d->update("bizlocation",$az,"id='$id'");

      if($q==TRUE) {
        header("Location: ../importArea");
      } else {
          $_SESSION['msg1']="Something wrong";
        header("Location: ../importArea");
      }
    }


  if(isset($_POST["ExportArea"])) {
      $i=1;
      $contents="No,Area Name,Latitude,Longitude,Pincode \n";

      
      
      $contents.=$i++.",";
      $contents.=",";
      $contents.=",";
      $contents.=",";
      $contents.="\n";

    $contents = strip_tags($contents); 

    header("Content-Disposition: attachment; filename=AreaImport".date('Y-m-d-h-i').".csv");
    print $contents;
   } 

   if (isset($_POST['importArea'])) {
  $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
  if ($ext=='csv') {
    $flag = true;
    $filename=$_FILES["file"]["tmp_name"];    

     if($_FILES["file"]["size"] > 0)
     {

        $file = fopen($filename, "r");
      
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {

            if($flag) { $flag = false; continue; }
            
            $area_name= $getData[1];
            $latitude= $getData[2];
            $longitude= $getData[3];
            $area_pincode= $getData[4];
            
            
                  
            $area_name= strtolower($area_name);
            $area_name= ucfirst($area_name);
       
            $m->set_data('country_id',$country_id);
            $m->set_data('state_id',$state_id);
            $m->set_data('city_id',$city_id);
            $m->set_data('area_name',$area_name);
            $m->set_data('area_pincode',$area_pincode);
            $m->set_data('latitude',$latitude);
            $m->set_data('longitude',$longitude);
            
             $a1= array (
               
                'country_id'=> $m->get_data('country_id'),
                'state_id'=> $m->get_data('state_id'),
                'city_id'=> $m->get_data('city_id'),
                'area_name'=> $m->get_data('area_name'),
                'latitude'=> $m->get_data('latitude'),
                'longitude'=> $m->get_data('longitude'),
                'pincode'=> $m->get_data('area_pincode'),
            );
        
             if ($area_name!='') {
               $d->insert("area_master",$a1);
             }
                
          
           }
              $_SESSION['msg']="Area CSV Uploaded";
              $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
              header("Location: ../areas?cId=$country_id&sId=$state_id&cityId=$city_id");
      
           fclose($file); 
     } else {
      $_SESSION['msg1']="Please Upload Valid CSV File";
     header("Location: ../areas?cId=$country_id&sId=$state_id&cityId=$city_id");
     }
  } else{
    $_SESSION['msg1']="Please Upload CSV File";
    header("Location: ../areas?cId=$country_id&sId=$state_id&cityId=$city_id");
  }
 }



}

 ?>