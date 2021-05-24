<div class="content-wrapper">
<div class="container-fluid">
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
<div class="col-sm-9">
<h4 class="page-title">Promotion Images</h4>
 <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           
           <li class="breadcrumb-item"><a href="promoteBusiness">Seasonal Greetings List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Promotion Images</li>
         </ol>
</div>
<div class="col-sm-3">

</div>
</div>
<!-- End Breadcrumb-->
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<ul class="nav nav-tabs nav-tabs-info nav-justified">
  <?php
  $s_time = microtime(true);
  error_reporting(0);
  extract($_REQUEST);
  
  $pending_table="";
  $solved_table="";
  if($tab=="frm_tab"){
  $pending_table="active";
  } else if($tab=="center_tab"){
  $solved_table="active";
  } else {
  $pending_table="active";
  }
  ?>
  
  <li class="nav-item">
    <a class="nav-link <?php echo $pending_table;?>" data-toggle="tab" href="#frm_tab">  <span>Frame Images</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $solved_table;?>" data-toggle="tab" href="#center_tab"> <span >Center Images</span></a>
  </li>
</ul>
<div class="tab-content">
  <div id="frm_tab" class="container tab-pane <?php echo $pending_table;?> show">
<?php
          $q=$d->select("promotion_frame_master","","order by created_at desc limit 1,100"); 
            if (mysqli_num_rows($q) > 0) {
              ?>
    <div class="row">
<div class="col-lg-12">
    
<div class="btn-group float-sm-right">
 <a href="javascript:void(0)" onclick="DeleteAll3('deleteFrmImg');" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
 
</div>
</div>
</div>
<br>
<?php } ?> 
    <div class="table-responsive">
      <table id="default-datatable2"  class="table table-bordered">
        <thead>
          <tr>
            <th >select</th>
            <th>#</th>
            <!-- <th>Association Name</th> -->
            <th>Image</th>
            
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
         
          $i=1;
          
          $dataArray = array();
                $counter = 0 ;
                foreach ($q as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray[$counter][$key] = $valueNew;
                    }
                    $counter++;
                }
                $promotion_frame_id_array = array('0');
               
                for ($l=0; $l < count($dataArray) ; $l++) {
                    $promotion_frame_id_array[] = $dataArray[$l]['promotion_frame_id']; 
                }

                $promotion_frame_id_array = implode(",", $promotion_frame_id_array);

                 $cnt_qry=$d->selectRow("count(*) as cnt, promotion_frame_id ","promotion_rel_frame_master","promotion_frame_id in ($promotion_frame_id_array) group by promotion_frame_id "); 
 
                
                 $dataArray2 = array();
                $counter2 = 0 ;
                foreach ($cnt_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray2[$counter2][$key] = $valueNew;
                    }
                    $counter2++;
                }
                $cnt_array = array();
                for ($k=0; $k < count($dataArray2) ; $k++) {
                  $cnt_array[$dataArray2[$k]['promotion_frame_id']] = $dataArray2[$k]['cnt'];
                }

               // echo "<pre>";print_r($cnt_array);echo "</pre>";

             for ($l=0; $l < count($dataArray) ; $l++) {
              $data = $dataArray[$l];
          extract($data);
          
          ?>
          <tr>
            <td  >
              <?php 
               $counterFrm =0;
               if(!empty($cnt_array[$promotion_frame_id])){
                $counterFrm =   $cnt_array[$promotion_frame_id];
               } 
               if($counterFrm==0){ ?> 
              <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['promotion_frame_id']; ?>">
            <?php } else { ?> 
             <input type="checkbox"  disabled="">
           <?php } ?> 
            </td>
            <td><?php echo $i++; ?></td>
            
            <td >
             
              <a href="../img/promotion/promotion_frames/<?php echo $promotion_frame; ?>" data-fancybox="images" data-caption="Photo Name : <?php echo $promotion_center_image; ?>">
                <img src="../img/promotion/promotion_frames/<?php echo $promotion_frame; ?>" alt="<?php echo $promotion_frame; ?>" class="lightbox-thumb img-thumbnail" style="width:50px;height:50px;">
              </a>
              
            </td>
            <td>
               <?php
             /* $counterFrm = $d->count_data_direct("promotion_rel_frame_id","promotion_rel_frame_master "," promotion_frame_id= '$promotion_frame_id'   "," ");*/
          if($counterFrm==0){ ?>
              <form  action="controller/businessPromotionController.php" method="post"> <input type="hidden" name="deleteSingleFrameImage" value="deleteSingleFrameImage">
              <input type="hidden" name="promotion_frame_id" value="<?php echo $promotion_frame_id; ?>">
              <button type="submit" name="" class=" form-btn btn btn-danger btn-sm "> <i class="fa fa-trash"></i></button>
            </form>
            <?php } else { ?>
            <button type="submit" disabled="" name="" class=" form-btn btn btn-danger btn-sm "> <i class="fa fa-trash"></i></button> 
            <?php } ?>
          </td>
          
        </tr>
        <?php
        
        } ?>
      </tbody>
    </table>
  </div>
</div>
<?php if($tab = 'center_tab'){ ?>
<div id="center_tab" class="container tab-pane <?php echo $solved_table;?> fade show">

  <?php
          $q=$d->select("promotion_center_image_master","","order by created_at desc limit 1,100"); 
            if (mysqli_num_rows($q) > 0) {
              ?>
    <div class="row">
<div class="col-lg-12">
    
<div class="btn-group float-sm-right">
 <a href="javascript:void(0)" onclick="DeleteAll2('deleteCenterImg');" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
 
</div>
</div>
</div>
<br>
<?php } ?> 

  <div class="table-responsive">
    <table  id="default-datatable1" class="table table-bordered">
      <thead>
        <tr>
          <th >Select</th>
          <th>#</th>
          
          <th>Image</th>
          
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        
        $dataArray3 = array();
                $counter3 = 0 ;
                foreach ($q as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray3[$counter3][$key] = $valueNew;
                    }
                    $counter3++;
                }

                $promotion_center_image_id_array = array('0');
               
                for ($l=0; $l < count($dataArray3) ; $l++) {
                    $promotion_center_image_id_array[] = $dataArray3[$l]['promotion_center_image_id']; 
                }

                $promotion_center_image_id_array = implode(",", $promotion_center_image_id_array);

                 $cnt_qry=$d->selectRow("count(*) as cnt, promotion_center_image_id ","promotion_rel_center_master","promotion_center_image_id in ($promotion_center_image_id_array) group by promotion_center_image_id "); 
 
                
                 $dataArray4 = array();
                $counter4 = 0 ;
                foreach ($cnt_qry as  $value) {
                    foreach ($value as $key => $valueNew) {
                        $dataArray4[$counter4][$key] = $valueNew;
                    }
                    $counter4++;
                }
                $cnt_array2 = array();
                for ($k=0; $k < count($dataArray4) ; $k++) {
                  $cnt_array2[$dataArray4[$k]['promotion_center_image_id']] = $dataArray4[$k]['cnt'];
                } 

               // echo "<pre>";print_r($cnt_array);echo "</pre>";

             for ($l=0; $l < count($dataArray3) ; $l++) {
              $data = $dataArray3[$l];


       
        extract($data);
        
        ?>
        <tr>
          <td  >
            <?php $counterFrm1 =0;
               if(!empty($cnt_array2[$promotion_center_image_id])){
                $counterFrm1 =   $cnt_array2[$promotion_center_image_id];
               }
               if($counterFrm1==0){  ?> 
            <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['promotion_center_image_id']; ?>">
          <?php } else { ?>
           <input type="checkbox" disabled="">
            <?php } ?> 
          </td>
          <td><?php echo $i++; ?></td>
          <td >

            <a href="../img/promotion/promotion_center_image/<?php echo $promotion_center_image; ?>" data-fancybox="images" data-caption="Photo Name : <?php echo $promotion_center_image; ?>">
              <img src="../img/promotion/promotion_center_image/<?php echo $promotion_center_image; ?>" alt="<?php echo $promotion_center_image; ?>" class="lightbox-thumb img-thumbnail" style="width:50px;height:50px;">
            </a>
          </td>
          <td>
            <?php

            

                /*$counterFrm1 = $d->count_data_direct("promotion_center_image_id","promotion_rel_center_master","promotion_center_image_id= '$promotion_center_image_id'   "," ");*/
        if($counterFrm1==0){ ?> 
            <form  action="controller/businessPromotionController.php" method="post"> <input type="hidden" name="deleteSingleCenterImage" value="deleteSingleCenterImage">
            <input type="hidden" name="promotion_center_image_id" value="<?php echo $promotion_center_image_id; ?>">
            <button type="submit" name="" class=" form-btn btn btn-danger btn-sm "> <i class="fa fa-trash"></i></button>
          </form>
        <?php }  else { ?>
            <button type="submit" disabled="" name="" class=" form-btn btn btn-danger btn-sm "> <i class="fa fa-trash"></i></button> 
            <?php } ?>
          
        </td>
        
      </tr>
      <?php
        } ?>
    </tbody>
  </table>
</div>
</div>
<?php }

$e_time = microtime(true);
if($_SESSION['zoobiz_admin_id'] == 7 ){
echo " <br>Time Taken =". ($e_time - $s_time); 
}
 ?>

</div>
</div>
</div>
</div><!-- End Row-->
</div>
</div>