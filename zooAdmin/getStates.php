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
 $q3=$d->select("states","country_id='$country_id'","");
while ($blockRow=mysqli_fetch_array($q3)) {
 ?>
 <option value="<?php echo $blockRow['state_id'];?>"><?php echo $blockRow['state_name'];?></option>

<?php }  ?>