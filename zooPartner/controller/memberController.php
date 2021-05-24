<?php 
 include '../common/objectController.php';

if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{

    if(isset($addBusinessHouses)) {

        $m->set_data('user_id',$user_id);
        $m->set_data('order_id',$order_id);
            
             $a1= array (
               
                'user_id'=> $m->get_data('user_id'),
                'order_id'=> $m->get_data('order_id'),
            );
        $qq=$d->selectRow("user_id","business_houses","user_id='$user_id'");
        if (mysqli_num_rows($qq)>0) {
            
           $_SESSION['msg']="Already Added";
           header("Location: ../businesHouses");
           exit();

        } 

        $q=$d->insert("business_houses",$a1);

      if($q==TRUE) {
          $_SESSION['msg']="Business Houses Added Successfully";
          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: $url");
      } else {
        header("Location: $url");
      }
    }

     if(isset($removeBusinesHouses)) {

        $q=$d->delete("business_houses","business_houses_id='$business_houses_id' AND user_id='$user_id'");
      if($q==TRUE) {
          $_SESSION['msg']="Business Houses Removed Successfully";

          $d->insert_log("","0","$_SESSION[zoobiz_admin_id]","$created_by",$_SESSION['msg']);
        header("Location: $url");
      } else {
        header("Location: $url");
      }
    }
    
}

 ?>