<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Frame List</h4>
        
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right"> 
          <a href="frame"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
        </button>
      </div>
    </div>
  </div>
  <!-- End Breadcrumb-->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  
                  <th class="text-right">#</th>
                  
                  <th>Frame name</th>
                  <th>Frame layout</th>
                  <th>Frame Image</th>
                  <?php if($_SESSION['role_id'] == 1){  ?>
                  <th>Action</th>
                  <?php } ?> 
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("frame_master"," status!=2 ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $frame_name; ?></td> 
                    <td><?php echo  $layout_name; ?></td> 
                    <td>
                      <?php if(trim($frame_image) !=""){ ?>
                      <a href="../img/frames/<?php echo $frame_image; ?>" data-fancybox="images" data-caption="Photo Name : <?php echo $frame_image; ?>">
                    <img src="../img/frames/<?php echo $frame_image; ?>" alt="<?php echo $frame_name; ?>" class="lightbox-thumb img-thumbnail" style="width:80px;height:80px;">
                  </a>
                <?php  } ?> 
                </td>
                <?php if($_SESSION['role_id'] == 1){  ?>


                    <td>

                      <?php if(   $data['status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $frame_id; ?>','frameDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $frame_id; ?>','frameActive');" data-size="small"/>
                        <?php } ?>
                      <div style="display: inline-block;">
                        <form action="frame" method="post" >
                          <input type="hidden" name="frame_id" value="<?php echo $frame_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                      <?php $payment_getway_master=$d->select("utility_banner_master","  frame_id= '$frame_id' ","");
                      if (mysqli_num_rows($payment_getway_master) <= 0 ) { ?>
                        <div style="display: inline-block;">
                        <form  action="controller/frameController.php" method="post">
                          <input type="hidden" name="frame_id" value="<?php echo $frame_id; ?>">
                          <button type="submit" name="deletefrm" class="btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php }  ?>
                    </td>
                    <?php } ?> 
                    
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->
    <!--Start Back To Top Button-->