<?php 
error_reporting(0);
include_once 'lib/dao.php';
include 'lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input",$_POST));
if(isset($imageOne) && $imageOne =="imageOne" && isset($promotion_frame_id)) { 
	$promotion_frame_id = implode(",", $_POST['promotion_frame_id']);

	 $promotion_frame_master=$d->select("promotion_frame_master"," status = 0  and promotion_frame_id in($promotion_frame_id) ","");
	 
 //$promotion_frame_master_data = mysqli_fetch_array($promotion_frame_master);
while ($promotion_frame_master_data=mysqli_fetch_array($promotion_frame_master)) {
	 $id=$promotion_frame_master_data['promotion_frame_id'];
 $promotion_frame = $promotion_frame_master_data['promotion_frame'];
$innerHtml .=' <span id="frm_img_'.$id.'"> <a title="Frame '.$id.'" href="../img/promotion/promotion_frames/'.$promotion_frame.'" data-fancybox="images" data-caption="Photo Name : '.$promotion_frame.'"> 
<img  style="height: 50px; width: 50px;" src="../img/promotion/promotion_frames/'.$promotion_frame.'"   alt="" class="lightbox-thumb  img-thumbnail "    >
</a></span>';
       
  }
  echo $innerHtml;

 
  

} else if(isset($imageTwo) && $imageTwo =="imageTwo" && isset($promotion_center_image_id)) { 
	 
	$promotion_center_image_id = implode(",", $_POST['promotion_center_image_id']);
 
     $promotion_center_image_master=$d->select("promotion_center_image_master"," status = 0 and promotion_center_image_id in ($promotion_center_image_id)   ","");
 
 //$promotion_center_image_master = mysqli_fetch_array($promotion_center_image_master);
$innerHtml ="";
 

 while ($promotion_center_image_master_data=mysqli_fetch_array($promotion_center_image_master)) {

 	 
 $id=$promotion_center_image_master_data['promotion_center_image_id'];
 $promotion_center_image = $promotion_center_image_master_data['promotion_center_image'];

$innerHtml .=' <span id="center_img_'.$id.'"> <a title="Center Image '.$id.'" href="../img/promotion/promotion_center_image/'.$promotion_center_image.'" data-fancybox="images" data-caption="Photo Name : '.$promotion_center_image.'"> 
<img  style="height: 50px; width: 50px;" src="../img/promotion/promotion_center_image/'.$promotion_center_image.'"   alt="" class="lightbox-thumb  img-thumbnail "    >
</a></span>';
       
  }
  echo $innerHtml;

} 

   ?>