<?php 
include '../common/objectController.php'; 

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{ 

 //echo "<pre>";print_r($_REQUEST);exit;
 if(isset($_POST['currAddBtn'])){
  
  $m->set_data('currency_name',$currency_name); 
  $m->set_data('currency_code',strtoupper($currency_code));
  $m->set_data('currency_symbol',$currency_symbol); 
  $a =array(
    'currency_name'=> $m->get_data('currency_name'),
    'currency_symbol'=> $m->get_data('currency_symbol'),
    'currency_code'=> $m->get_data('currency_code') 
  );
  $q=$d->insert("currency_master",$a);

  
  if($q>0) {
    $_SESSION['msg']="Currency Added";
    header("location:../currencyList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../currencyList");
  }

}  else if(isset($_POST['currEditBtn'])){
 
  
  $m->set_data('currency_name',$currency_name); 
  $m->set_data('currency_code',strtoupper($currency_code));
  $m->set_data('currency_symbol',$currency_symbol); 
  $a =array(
    'currency_name'=> $m->get_data('currency_name'),
    'currency_symbol'=> $m->get_data('currency_symbol') ,
    'currency_code'=> $m->get_data('currency_code') 
  );

  $q=$d->update("currency_master",$a,"currency_id = '$currency_id' ");
  if($q>0 ) {
    $_SESSION['msg']="Currency Updated";
    header("location:../currencyList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../currencyList");
  }


}  
 else if(isset($_POST['deleteCurr'])){
 
  
   $q=$d->delete("currency_master","currency_id='$currency_id'  ");
        
  if($q>0 ) {
    $_SESSION['msg']="Currency Deleted";
    header("location:../currencyList");
  } else {
    $_SESSION['msg1']="Something Wrong";
    header("location:../currencyList");
  }


}  


}else{
  header('location:../login');
}
?>