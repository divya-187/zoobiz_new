<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
?>
<option value="">-- Select --</option>

<?php

if(isset($cmp) && $cmp="yes"){
$company_master_qry=$d->select("company_master","status = 0  and is_master= 0  ","");
$company_cities = array('0');
while ($company_master_data=mysqli_fetch_array($company_master_qry)) {
$company_cities[] = $company_master_data['city_id'];
 }

 $company_cities = implode(",", $company_cities); 
 $q3=$d->select("cities","state_id='$state_id' and city_id not in (". $company_cities.") ","");
} else {
	$q3=$d->select("cities","state_id='$state_id'   ","");
}
while ($blockRow=mysqli_fetch_array($q3)) {
 ?>
 <option value="<?php echo $blockRow['city_id'];?>"><?php echo $blockRow['city_name'];?></option>

<?php }  ?>
