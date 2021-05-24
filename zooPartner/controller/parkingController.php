<?php 
 include '../common/objectController.php';

// print_r($_POST);
if(isset($_POST) && !empty($_POST) )//it can be $_GET doesn't matter
{
  // add main menu
  if(isset($_POST['socieaty_parking_name_add'])){

  // $dataCount = count($_POST['block_name']);
      $last_auto_id=$d->last_auto_id("society_parking_master");
      $res=mysqli_fetch_array($last_auto_id);
      $society_parking_id=$res['Auto_increment'];


      $m->set_data('socieaty_parking_name_add',$socieaty_parking_name_add);
      $m->set_data('society_id',$society_id);
      $m->set_data('total_car_parking',$total_car_parking);
      $m->set_data('total_bike_parking',$total_bike_parking);

      $a =array(
        'society_id'=> $m->get_data('society_id'),
        'socieaty_parking_name'=> $m->get_data('socieaty_parking_name_add'),
        'total_car_parking'=> $m->get_data('total_car_parking'),
        'total_bike_parking'=> $m->get_data('total_bike_parking'),
      );
    
      $q=$d->insert("society_parking_master",$a);
    
      if($q>0) {

        for ($i=1; $i <=$total_car_parking ; $i++) { 
            $m->set_data('society_parking_id',$society_parking_id);
            $m->set_data('parking_name',$car_parking_name."-".$i);
            $m->set_data('parking_type',0);

              $a2 =array(
                'society_parking_id'=> $m->get_data('society_parking_id'),
                'society_id'=> $m->get_data('society_id'),
                'parking_name'=> $m->get_data('parking_name'),
                'parking_type'=> $m->get_data('parking_type'),
              );

            $d->insert("parking_master",$a2);

        }

        for ($j=1; $j <=$total_bike_parking ; $j++) { 

            $m->set_data('society_parking_id',$society_parking_id);
            $m->set_data('parking_name',$bike_parking_name."-".$j);
            $m->set_data('parking_type',1);

            $a3 =array(
                'society_parking_id'=> $m->get_data('society_parking_id'),
                'society_id'=> $m->get_data('society_id'),
                'parking_name'=> $m->get_data('parking_name'),
                'parking_type'=> $m->get_data('parking_type'),
              );

            $d->insert("parking_master",$a3);

        }

        $_SESSION['msg']="Parking Added";
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Parking Added");
        header("location:../parkings");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../parkings");
      }
  }


  if (isset($deleteParking)) {

       $q=$d->delete("parking_master","society_parking_id='$society_parking_id' AND society_id='$society_id'");
       $q=$d->delete("society_parking_master","society_parking_id='$society_parking_id' AND society_id='$society_id'");
    
      if($q>0) {
         $_SESSION['msg']="Parking Deleted";
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Parking Deleted");
        header("location:../parkings");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../parkings");
      }
  }

 if (isset($updateParking)) {

       $a1 =array(
                'parking_name'=> $parking_name,
        );

       $q=$d->update("parking_master",$a1,"parking_id='$parking_id' AND society_id='$society_id'");

      if($q>0) {
         $_SESSION['msg']="Parking Name Updated";
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Parking Name Updated");
        header("location:../parkings?society_parking_id=$society_parking_id");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../parkings?society_parking_id=$society_parking_id");
      }
  }


 if (isset($allocateParking)) {
      if ($unit_id=='' && $unit_id==0) {
        $_SESSION['msg1']="Please Select Unit for Allocate";
        header("location:../parkings?society_parking_id=$society_parking_id");
        exit();
      } {
        $qq=$d->select("unit_master,block_master,users_master,floors_master","unit_master.floor_id=floors_master.floor_id AND users_master.unit_id=unit_master.unit_id AND block_master.block_id=unit_master.block_id AND unit_master.society_id='$society_id' AND users_master.unit_id='$unit_id'","");
        $userData=mysqli_fetch_array($qq);

        $m->set_data('block_id',$userData['block_id']);
        $m->set_data('floor_id',$userData['floor_id']);
        $m->set_data('unit_id',$unit_id);
        $m->set_data('parking_status',1);
        $m->set_data('vehicle_no',$vehicle_no);

       $a1 =array(
          'block_id'=> $m->get_data('block_id'),
          'floor_id'=> $m->get_data('floor_id'),
          'unit_id'=> $m->get_data('unit_id'),
          'parking_status'=> $m->get_data('parking_status'),
          'vehicle_no'=> $m->get_data('vehicle_no'),
        );

       $q=$d->update("parking_master",$a1,"parking_id='$parking_id' AND society_id='$society_id'");

      if($q>0) {

         $_SESSION['msg']="Parking Allocated";
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Parking Allocated");

        header("location:../viewOwner?id=$user_id");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../viewOwner?id=$user_id");
      }
    }
  }



 if (isset($removeUserlParking)) {

        $m->set_data('block_id',0);
        $m->set_data('floor_id',0);
        $m->set_data('unit_id',0);
        $m->set_data('vehicle_no',"");
        $m->set_data('parking_status',0);

       $a1 =array(
          'block_id'=> $m->get_data('block_id'),
          'floor_id'=> $m->get_data('floor_id'),
          'unit_id'=> $m->get_data('unit_id'),
          'parking_status'=> $m->get_data('parking_status'),
          'vehicle_no'=> $m->get_data('vehicle_no'),
        );

       $q=$d->update("parking_master",$a1,"parking_id='$parking_id' AND society_id='$society_id'");

      if($q>0) {



         $_SESSION['msg']="Parking Un Allocated";
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Parking Un Allocated");
        header("location:../viewOwner?id=$user_id");
      } else {
        $_SESSION['msg1']="Something Wrong";
        header("location:../viewOwner?id=$user_id");
      }
  }




  if (isset($deleteParking_id)) {

       $q=$d->delete("parking_master","parking_id='$deleteParking_id' AND society_id='$society_id'");
    
      if($q>0) {
        $d->insert_log("","$society_id","$_SESSION[zoobiz_admin_id]","$created_by","Parking Deleted");
        echo "1";
      } else {
        echo 0;
      }
  }
  
}
else{
  header('location:../login');
}
 ?>
