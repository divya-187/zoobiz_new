<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input",$_POST));
if(isset($business_categories)) {  ?>
<option value="">-- Select --</option>
 <?php 
  $q3=$d->select("business_sub_categories","business_category_id='$business_categories'","");
while ($blockRow=mysqli_fetch_array($q3)) {
 ?>
 <option value="<?php echo $blockRow['business_sub_category_id'];?>"><?php echo $blockRow['sub_category_name'];?></option>
<?php } }  ?>