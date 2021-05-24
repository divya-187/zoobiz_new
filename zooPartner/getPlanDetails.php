<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input",$_POST));
if(isset($plan_id)  ) { 
	 
	 $package_master_qry=$d->select("package_master","package_id='$plan_id' ","");
	 if (mysqli_num_rows($package_master_qry) > 0) {
            $package_master_data=mysqli_fetch_array($package_master_qry);
            echo  $package_master_data['package_amount'].'~'.$package_master_data['is_cpn_package'];
	 }
     else {
        echo "0".'~0';
     }
}  

    ?>