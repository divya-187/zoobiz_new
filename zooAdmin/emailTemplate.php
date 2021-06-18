<?php
error_reporting(0);
extract(array_map("test_input" , $_POST));
if (isset($circular_id)) {
  $q=$d->select("circulars_master","circular_id='$circular_id'");
  $row=mysqli_fetch_array($q);
}

?>

<link rel="stylesheet" href="assets/plugins/summernote/dist/summernote-bs4.css"/>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Add/Edit Circular</h4>
        
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-5">
        <div class="card">
          <form id="noticeBoard" action="controller/circulerController.php" method="post">
            <div class="card-header text-uppercase bg-white">Circular</div>
            
            <div class="card-body">

           <input required="" maxlength="100" class="form-control text-capitalize" type="text" name="circular_title" placeholder="Title" value="<?php echo $row['circular_title'] ?>" >
           <br>
           <textarea required="" id="summernoteImgage" name="circular_description">
            <?php echo $row['circular_description'];?>
          </textarea>
          <br>
         

          <div class="form-footer text-center">
            <?php if (isset($circular_id)) { ?>
              <input type="hidden" name="circular_id" value="<?php echo $circular_id; ?>">
              <button name="" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>Update</button>
              <input type="hidden" name="updateNotice" value="updateNotice">
            <?php } else { ?>
              <input type="hidden" name="addNotice" value="addNotice">
              <button name="" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>Add</button>
            <?php } ?>
            
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->
