<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
if (isset($getArea)) { ?>
?>
<option value="">-- Select --</option>

<?php
 $q3=$d->select("area_master","city_id='$city_id'","");
while ($blockRow=mysqli_fetch_array($q3)) {
 ?>
 <option value="<?php echo $blockRow['area_id'];?>"><?php echo $blockRow['area_name'];?></option>

<?php }  } elseif ($getLatLong) {
 $q3=$d->select("area_master","area_id='$area_id'","");
$blockRow=mysqli_fetch_array($q3);
echo $blockRow['latitude'];
echo "~";
echo $blockRow['longitude'];
} ?>