<?php
extract(array_map("test_input" , $_POST));
           unset($_SESSION['post']); 

?>
<style type="text/css" media="screen">
 .card-body img {
  width: 280px !important;
 }  
</style>
<link rel="stylesheet" href="assets/plugins/summernote/dist/summernote-bs4.css"/>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9 col-6">
        <h4 class="page-title"> Circulars</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Circulars</li>
         </ol>
     </div>
     <div class="col-sm-3 col-6">
        <div class="btn-group float-sm-right">
          <a href="circular" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New</a>
          <!-- </button> -->
        </div>
      </div>
     </div>
    <!-- End Breadcrumb-->
     <div class="row">
        <?php $q=$d->select("circulars_master","","ORDER BY updated_at DESC");
         if(mysqli_num_rows($q)>0) {
          while($row=mysqli_fetch_array($q)){ ?> 
            <?php  

           /* echo htmlspecialchars_decode($row['circular_description']);;
 
            if (strpos($row['circular_description'], 'img/circuler') !== false) {
    $circular_description = str_replace('"', "'", htmlspecialchars_decode($row['circular_description']));

    echo $circular_description;

}*/

            ?>
             
        <div class="col-lg-4">
          <div class="card">
             <?php //IS_569 title="<?php echo $row['notice_title']; ?>
            <div  class="card-header bg-fincasys text-white" title="<?php echo $row['circular_title'];?>"><i class="fa fa-bullhorn" aria-hidden="true"></i>

              <?php 
            //IS_569
            // echo $row['notice_title'];
            $strlen = strlen($row['circular_title']);
            if($strlen > 40 ){
              $str = substr($row['circular_title'], 0, 30);
              echo $str."...";
            } else {
               echo $row['circular_title'];
            }
             //IS_569
           ?> 
              
          </div>
            <div class="card-body" style="height: 200px !important; overflow-y: auto;">
               <?php //IS_569 <div class="cls-notice-info"> 
               ?>
              <p class="card-text"><div class="cls-notice-info"><?php 


              //echo stripslashes($row['circular_description']);

               echo stripslashes(htmlspecialchars_decode($row['circular_description']));
              ?>

                
                


              </div></p>
            </div>
         
            <div  class="card-footer">
              <?php   //IS_1008
              // Updated on: <?php echo $row['notice_time']; 
               if($row['updated_at'] ==$row['created_date']){ ?>
                Added on: <?php   echo  date("d M Y H:i A", strtotime($row['created_date']));?><br>
              <?php  } else { ?>
                Updated on: <?php   echo  date("d M Y H:i A", strtotime($row['updated_at']));?><br>
              <?php

              } //IS_1008 ?>


           
              <form id="signupForm" style="float: left;" action="controller/circulerController.php" method="post">
                <input type="hidden" name="circular_id_delete" value="<?php echo $row['circular_id']; ?>">
                <button type="submit" class="btn btn-sm btn-danger form-btn"><i class="fa fa-trash-o"></i> Delete</button>
              </form>
              <form style="float: left;margin-left: 15px;" action="circular" method="post">
                <input type="hidden" name="circular_id" value="<?php echo $row['circular_id']; ?>">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i> Edit</button>
              </form>

            </div>
          </div>
        </div>
         <?php } } else {
      echo "<img src='img/no_data_found3.png'>";
    } ?>
      </div>

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
  
