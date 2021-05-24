<?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
?>
<?php 
  $eqm2 = $d->select("frame_master","frame_id='$frame_id' ");

                 
$frame_master_data2 = mysqli_fetch_assoc($eqm2);
?>
<img src="../img/frames/<?php  echo $frame_master_data2['frame_image']; ?>" alt="<?php echo $frame_name; ?>" class="lightbox-thumb img-thumbnail"  style="height: 100%;width: 100%;" >