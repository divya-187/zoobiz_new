<?php //IS_846
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));
        if (isset($feedback_id)) {
          $q=$d->select("feedback_master"," feedback_id='$feedback_id'");
          $row=mysqli_fetch_array($q);
          extract($row);
        }

?>

<h6>Subject : <?php echo $subject;?></h6>
<p>Message:
   <?php echo $feedback_msg;?>
 </p>
<p>Date Time : <?php echo date("d-m-Y h:i A", strtotime($feedback_date_time)); ?></p>

<?php  if ($attachment!='') { ?>
                     Attachment:  <a target="_blank" href="../img/zoobizz_support/<?php echo $attachment;?>">View </a>
                     <?php } ?>
