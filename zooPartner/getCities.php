<?php  
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
?>
<option value="">-- Select --</option>

<?php   
if(isset($partnerNumber) && $partnerNumber!=""){
	$zoobiz_partner_master=$d->select("zoobiz_partner_master","partner_mobile='$partnerNumber'   ","");
	$zoobiz_partner_master_data=mysqli_fetch_array($zoobiz_partner_master);
$city_id_partner  =  $zoobiz_partner_master_data['city_id'];
//echo "state_id='$state_id' and  cities in ($city_id_partner)  ";exit;
$q3=$d->select("cities","state_id='$state_id' and  city_id in ($city_id_partner)  ","");
while ($blockRow=mysqli_fetch_array($q3)) {
 ?>
 <option value="<?php echo $blockRow['city_id'];?>"><?php echo $blockRow['city_name'];?></option>

<?php } 

} else { 
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

<?php } 
} ?>
