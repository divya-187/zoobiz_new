<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

 //echo "<pre>";print_r($_REQUEST);exit;
 if(isset($_POST['compnayAdd'])){
   
   $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
   $uploadedFile = $_FILES['company_logo']['tmp_name'];
   $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
   
   if(file_exists($uploadedFile)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile);
      $newFileName = rand();
      $dirPath = "../../img/company/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];
      
      $company_logo= $newFileName."_comp_profile.".$ext;
      move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../../img/company/".$company_logo);
      
    } else {
      $company_logo="";
    }
  } else {
    $company_logo="";
  }


  $uploadedFile1 = $_FILES['payment_getway_logo']['tmp_name'];
  $ext = pathinfo($_FILES['payment_getway_logo']['name'], PATHINFO_EXTENSION);
  
  if(file_exists($uploadedFile1)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/company/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];
      
      
      $payment_getway_logo= $newFileName."_payment_profile.".$ext;

      move_uploaded_file($_FILES["payment_getway_logo"]["tmp_name"], "../../img/company/".$payment_getway_logo);
    }  else {
      $payment_getway_logo="";
    }
  } else {
    $payment_getway_logo="";
  }

  $m->set_data('company_name',ucfirst($company_name));
  $m->set_data('company_email',$company_email);
  $m->set_data('company_contact_number',$company_contact_number);
  $m->set_data('company_website',$company_website);
  $m->set_data('company_logo',$company_logo);
  $m->set_data('country_id',$country_id);
  $m->set_data('state_id',$state_id);
  $m->set_data('city_id',$city_id);
  $m->set_data('company_address',$company_address);
  $m->set_data('payment_getway_name',$payment_getway_name);
  $m->set_data('merchant_id',$merchant_id);
  $m->set_data('merchant_key',$merchant_key);
  $m->set_data('salt_key',"");
  $m->set_data('payment_getway_email',$payment_getway_email);
  $m->set_data('payment_getway_contact',$payment_getway_contact);
  $m->set_data('payment_getway_logo',$payment_getway_logo); 
  $m->set_data('currency_id',$currency_id);
  $m->set_data('comp_gst_number',strtoupper($comp_gst_number));
  
  $m->set_data('ccav_merchant_id',$ccav_merchant_id);
  $m->set_data('ccav_access_code',$ccav_access_code);
  $m->set_data('ccav_working_key',$ccav_working_key);
  $m->set_data('ccav_live_mode',$ccav_live_mode);


  $m->set_data('paytm_name',$paytm_name);
  $m->set_data('paytm_merchant_id',$paytm_merchant_id);
  $m->set_data('paytm_merrchant_key',$paytm_merrchant_key);
  $m->set_data('paytm_is_live_mode',$paytm_is_live_mode);


  $a =array(
    'company_name'=> $m->get_data('company_name'),
    'company_email'=> $m->get_data('company_email'),
    'company_contact_number'=> $m->get_data('company_contact_number'),
    'company_website'=> $m->get_data('company_website'),
    'company_logo'=> $m->get_data('company_logo'),
    'country_id'=> $m->get_data('country_id'),
    'state_id'=> $m->get_data('state_id'),
    'city_id'=> $m->get_data('city_id'),
    'company_address'=> $m->get_data('company_address') ,
    'comp_gst_number'=> $m->get_data('comp_gst_number') 
  );
  $q=$d->insert("company_master",$a);

/*  $last_auto_id=$d->last_auto_id("company_master");
  $res=mysqli_fetch_array($last_auto_id);
  $company_auto_id=$res['Auto_increment'];
  $company_auto_id = ($company_auto_id -1);*/

  $company_id  = $con->insert_id;  

  
  $m->set_data('company_id',$company_id); 
 $m->set_data('upi_id',$upi_id); 
  $m->set_data('upi_name',$upi_name); 


  $m->set_data('test_paytm_merchant_id',$test_paytm_merchant_id);
  $m->set_data('test_paytm_merrchant_key',$test_paytm_merrchant_key);


  $payment_info =array(
    'company_id'=> $m->get_data('company_id'),
    'payment_getway_name'=> $m->get_data('payment_getway_name'),
    'merchant_id'=> $m->get_data('merchant_id'),
    'merchant_key'=> $m->get_data('merchant_key'),
    'salt_key'=> $m->get_data('salt_key'),
    'payment_getway_email'=> $m->get_data('payment_getway_email'),
    'payment_getway_contact'=> $m->get_data('payment_getway_contact'),
    'payment_getway_logo'=> $m->get_data('payment_getway_logo') ,
    'currency_id'=> $m->get_data('currency_id'),
    'upi_id'=> $m->get_data('upi_id') ,
    'upi_name'=> $m->get_data('upi_name'),
    'ccav_merchant_id'=> $m->get_data('ccav_merchant_id') ,
    'ccav_access_code'=> $m->get_data('ccav_access_code') ,
    'ccav_working_key'=> $m->get_data('ccav_working_key') ,
    'ccav_live_mode'=> $m->get_data('ccav_live_mode') ,
    'paytm_name'=> $m->get_data('paytm_name') ,
    'paytm_merchant_id'=> $m->get_data('paytm_merchant_id') ,
    'paytm_merrchant_key'=> $m->get_data('paytm_merrchant_key') ,
    'paytm_is_live_mode'=> $m->get_data('paytm_is_live_mode') ,
    'test_paytm_merchant_id'=> $m->get_data('test_paytm_merchant_id') ,
    'test_paytm_merrchant_key'=> $m->get_data('test_paytm_merrchant_key') 
  );


  $q=$d->insert("payment_getway_master",$payment_info);
  if($q>0) {
    $_SESSION['msg']=ucfirst($company_name)." Company Added";
    $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
    header("location:../companyList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../companyList");
  }

}  else if(isset($_POST['compnayEdit'])){
 
 $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
 $uploadedFile = $_FILES['company_logo']['tmp_name'];
 $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
 
 if(file_exists($uploadedFile)) {

  if(in_array($ext,$extension)) {

    $sourceProperties = getimagesize($uploadedFile);
    $newFileName = rand();
    $dirPath = "../../img/company/";
    $imageType = $sourceProperties[2];
    $imageHeight = $sourceProperties[1];
    $imageWidth = $sourceProperties[0];
    $company_logo= $newFileName."_comp_profile.".$ext;
    move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../../img/company/".$company_logo);

    
    
    
  } else {
    $company_logo=$company_logo_old;
  }
}  else {
  $company_logo=$company_logo_old;
}

$uploadedFile1 = $_FILES['payment_getway_logo']['tmp_name'];
$ext = pathinfo($_FILES['payment_getway_logo']['name'], PATHINFO_EXTENSION);

if(file_exists($uploadedFile1)) {
  if(in_array($ext,$extension)) {
    $sourceProperties = getimagesize($uploadedFile1);
    $newFileName = rand();
    $dirPath = "../../img/company/";
    $imageType = $sourceProperties[2];
    $imageHeight = $sourceProperties[1];
    $imageWidth = $sourceProperties[0];
    
    $payment_getway_logo= $newFileName."_payment_profile.".$ext;
    move_uploaded_file($_FILES["payment_getway_logo"]["tmp_name"], "../../img/company/".$payment_getway_logo);

  }   else{
    $payment_getway_logo= $payment_getway_logo_old;
  }
} else {
  $payment_getway_logo=$payment_getway_logo_old;
}

$m->set_data('company_name',ucfirst($company_name));
$m->set_data('company_email',$company_email);
$m->set_data('company_contact_number',$company_contact_number);
$m->set_data('company_website',$company_website);
$m->set_data('company_logo',$company_logo);
$m->set_data('country_id',$country_id);
$m->set_data('state_id',$state_id);
$m->set_data('city_id',$city_id);
$m->set_data('company_address',$company_address);

  $m->set_data('comp_gst_number', strtoupper($comp_gst_number) );
$m->set_data('payment_getway_name',$payment_getway_name);
$m->set_data('merchant_id',$merchant_id);
$m->set_data('merchant_key',$merchant_key);
$m->set_data('salt_key',"");
$m->set_data('payment_getway_email',$payment_getway_email);
$m->set_data('payment_getway_contact',$payment_getway_contact);
$m->set_data('payment_getway_logo',$payment_getway_logo); 
$m->set_data('currency_id',$currency_id  );

$m->set_data('ccav_merchant_id',$ccav_merchant_id);
  $m->set_data('ccav_access_code',$ccav_access_code);
  $m->set_data('ccav_working_key',$ccav_working_key);
  $m->set_data('ccav_live_mode',$ccav_live_mode);

$a =array(
  'company_name'=> $m->get_data('company_name'),
  'company_email'=> $m->get_data('company_email'),
  'company_contact_number'=> $m->get_data('company_contact_number'),
  'company_website'=> $m->get_data('company_website'),
  'company_logo'=> $m->get_data('company_logo'),
  'country_id'=> $m->get_data('country_id'),
  'state_id'=> $m->get_data('state_id'),
  'city_id'=> $m->get_data('city_id'),
  'company_address'=> $m->get_data('company_address') ,
  'comp_gst_number'=> $m->get_data('comp_gst_number')
);

$q1=$d->update("company_master",$a,"company_id = '$company_id'");



 $m->set_data('upi_id',$upi_id); 
  $m->set_data('upi_name',$upi_name); 

  $m->set_data('paytm_name',$paytm_name);
  $m->set_data('paytm_merchant_id',$paytm_merchant_id);
  $m->set_data('paytm_merrchant_key',$paytm_merrchant_key);
  $m->set_data('paytm_is_live_mode',$paytm_is_live_mode);

  $m->set_data('test_paytm_merchant_id',$test_paytm_merchant_id);
  $m->set_data('test_paytm_merrchant_key',$test_paytm_merrchant_key);

$payment_info =array(
  
  'payment_getway_name'=> $m->get_data('payment_getway_name'),
  'merchant_id'=> $m->get_data('merchant_id'),
  'merchant_key'=> $m->get_data('merchant_key'),
  'salt_key'=> $m->get_data('salt_key'),
  'payment_getway_email'=> $m->get_data('payment_getway_email'),
  'payment_getway_contact'=> $m->get_data('payment_getway_contact'),
  'payment_getway_logo'=> $m->get_data('payment_getway_logo') ,
  'currency_id'=> $m->get_data('currency_id'),
  'upi_id'=> $m->get_data('upi_id') ,
  'upi_name'=> $m->get_data('upi_name') ,
  'ccav_merchant_id'=> $m->get_data('ccav_merchant_id') ,
    'ccav_access_code'=> $m->get_data('ccav_access_code') ,
    'ccav_working_key'=> $m->get_data('ccav_working_key') ,
    'ccav_live_mode'=> $m->get_data('ccav_live_mode') ,
    'paytm_name'=> $m->get_data('paytm_name') ,
    'paytm_merchant_id'=> $m->get_data('paytm_merchant_id') ,
    'paytm_merrchant_key'=> $m->get_data('paytm_merrchant_key') ,
    'paytm_is_live_mode'=> $m->get_data('paytm_is_live_mode'),
    'test_paytm_merchant_id'=> $m->get_data('test_paytm_merchant_id') ,
    'test_paytm_merrchant_key'=> $m->get_data('test_paytm_merrchant_key')
);

$q2=$d->update("payment_getway_master",$payment_info,"company_id = '$company_id'");

if($q2>0 && $q1>0) {
  $_SESSION['msg']=ucfirst($company_name). " Company Updated";
  $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
  header("location:../companyList");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../companyList");
}


} else if(isset($_POST['updateCompDetails'])){

 $extension=array("jpeg","jpg","png","gif","JPG","jpeg","JPEG","PNG");
 $uploadedFile = $_FILES['company_logo']['tmp_name'];
 $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
 
 if(file_exists($uploadedFile)) {

  if(in_array($ext,$extension)) {

    $sourceProperties = getimagesize($uploadedFile);
    $newFileName = rand();
    $dirPath = "../../img/company/";
    $imageType = $sourceProperties[2];
    $imageHeight = $sourceProperties[1];
    $imageWidth = $sourceProperties[0];
    

    $company_logo= $newFileName."_comp_profile.".$ext;
    move_uploaded_file($_FILES["company_logo"]["tmp_name"], "../../img/company/".$company_logo);
    
  } else {
    $company_logo=$company_logo_old;
  }
}  else {
  $company_logo=$company_logo_old;
}


$m->set_data('company_name',ucfirst($company_name));
$m->set_data('company_email',$company_email);
$m->set_data('company_contact_number',$company_contact_number);
$m->set_data('company_website',$company_website);
$m->set_data('company_logo',$company_logo);
$m->set_data('country_id',$country_id);
$m->set_data('state_id',$state_id);
$m->set_data('city_id',$city_id);
$m->set_data('company_address',$company_address);
$m->set_data('comp_gst_number',strtoupper($comp_gst_number));





$a =array(
  'company_name'=> $m->get_data('company_name'),
  'company_email'=> $m->get_data('company_email'),
  'company_contact_number'=> $m->get_data('company_contact_number'),
  'company_website'=> $m->get_data('company_website'),
  'company_logo'=> $m->get_data('company_logo'),
  'country_id'=> $m->get_data('country_id'),
  'state_id'=> $m->get_data('state_id'),
  'city_id'=> $m->get_data('city_id'),
  'company_address'=> $m->get_data('company_address') ,
  'comp_gst_number'=> $m->get_data('comp_gst_number') 
);

$q1=$d->update("company_master",$a,"company_id = '$company_id'");



if(  $q1>0) {
    

  $_SESSION['msg']=ucfirst($company_name). " Company Detail Updated";
  $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
  header("location:../viewCompany?company_id=$company_id");
} else {
  $_SESSION['msg1']="Something Wrong";
  header("location:../viewCompany?company_id=$company_id");
}


} else if(isset($_POST['updatePaymentDetails'])){
 
  
 
  $uploadedFile1 = $_FILES['payment_getway_logo']['tmp_name'];
  $ext = pathinfo($_FILES['payment_getway_logo']['name'], PATHINFO_EXTENSION);
  
  if(file_exists($uploadedFile1)) {
    if(in_array($ext,$extension)) {
      $sourceProperties = getimagesize($uploadedFile1);
      $newFileName = rand();
      $dirPath = "../../img/company/";
      $imageType = $sourceProperties[2];
      $imageHeight = $sourceProperties[1];
      $imageWidth = $sourceProperties[0];
      
      $payment_getway_logo= $newFileName."_payment_profile.".$ext;

      move_uploaded_file($_FILES["payment_getway_logo"]["tmp_name"], "../../img/company/".$payment_getway_logo);
    }   else{
      $payment_getway_logo= $payment_getway_logo_old;
    }
  } else {
    $payment_getway_logo=$payment_getway_logo_old;
  }

  
  $m->set_data('payment_getway_name',$payment_getway_name);
  $m->set_data('merchant_id',$merchant_id);
  $m->set_data('merchant_key',$merchant_key);
  $m->set_data('salt_key',"");
  $m->set_data('payment_getway_email',$payment_getway_email);
  $m->set_data('payment_getway_contact',$payment_getway_contact);
  $m->set_data('payment_getway_logo',$payment_getway_logo); 
  $m->set_data('currency_id',$currency_id); 
  $m->set_data('upi_id',$upi_id); 
  $m->set_data('upi_name',$upi_name);


$m->set_data('ccav_merchant_id',$ccav_merchant_id);
  $m->set_data('ccav_access_code',$ccav_access_code);
  $m->set_data('ccav_working_key',$ccav_working_key);
  $m->set_data('ccav_live_mode',$ccav_live_mode);

   $m->set_data('paytm_name',$paytm_name);
  $m->set_data('paytm_merchant_id',$paytm_merchant_id);
  $m->set_data('paytm_merrchant_key',$paytm_merrchant_key);
  $m->set_data('paytm_is_live_mode',$paytm_is_live_mode);

    $m->set_data('test_paytm_merchant_id',$test_paytm_merchant_id);
  $m->set_data('test_paytm_merrchant_key',$test_paytm_merrchant_key);
  $payment_info =array(
    
    'payment_getway_name'=> $m->get_data('payment_getway_name'),
    'merchant_id'=> $m->get_data('merchant_id'),
    'currency_id'=> $m->get_data('currency_id'),
    'merchant_key'=> $m->get_data('merchant_key'),
    'salt_key'=> $m->get_data('salt_key'),
    'payment_getway_email'=> $m->get_data('payment_getway_email'),
    'payment_getway_contact'=> $m->get_data('payment_getway_contact'),
    'payment_getway_logo'=> $m->get_data('payment_getway_logo') ,
    'upi_id'=> $m->get_data('upi_id'),
    'upi_name'=> $m->get_data('upi_name') ,
  'ccav_merchant_id'=> $m->get_data('ccav_merchant_id') ,
    'ccav_access_code'=> $m->get_data('ccav_access_code') ,
    'ccav_working_key'=> $m->get_data('ccav_working_key') ,
    'ccav_live_mode'=> $m->get_data('ccav_live_mode')  ,
    'paytm_merchant_id'=> $m->get_data('paytm_merchant_id') ,
    'paytm_merrchant_key'=> $m->get_data('paytm_merrchant_key') ,
    'paytm_is_live_mode'=> $m->get_data('paytm_is_live_mode'),
    'test_paytm_merchant_id'=> $m->get_data('test_paytm_merchant_id') ,
    'test_paytm_merrchant_key'=> $m->get_data('test_paytm_merrchant_key')
  );

  $q2=$d->update("payment_getway_master",$payment_info,"company_id = '$company_id'");
  
  if($q2>0  ) {

     $adm_data=$d->selectRow("company_name","company_master"," company_id='$company_id'");
        $data_q=mysqli_fetch_array($adm_data);


    $_SESSION['msg']=$data_q['company_name']. " Payment Details Updated";
    $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
    header("location:../viewCompany?company_id=$company_id");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../viewCompany?company_id=$company_id");
  }

  
} 

/*if(isset($_POST['delete_company_id'])){
 
      
                    

    $q=$d->delete("company_master","company_id='$delete_company_id' ");
    if($q>0) {
      $_SESSION['msg']="Company Deleted";
      header("location:../companyList");
    } else {
      $_SESSION['msg1']="Something Wrong";
      header("location:../companyList");
    }

  }*/


  else  if(isset($_POST['delete_company_id'])){
  $adm_data=$d->selectRow("company_name","company_master"," company_id='$delete_company_id'");
        $data_q=mysqli_fetch_array($adm_data);
  
   $q=$d->delete("company_master","company_id='$delete_company_id'  ");
        
  if($q>0 ) {
    $_SESSION['msg']= $data_q['company_name']. " Company Deleted";
    $d->insert_log("","0","$_SESSION[partner_login_id]","$created_by",$_SESSION['msg']);
    header("location:../companyList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../companyList");
  }


}  

}else{
  header('location:../login');
}
?>