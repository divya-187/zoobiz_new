<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Admin List</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admin List</li>
         </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a href="admin"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
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
                  <th>Admin Role</th>
                  <th>Admin Name</th>
                  <th>Admin Mobile</th>
                  <th>Admin Email</th>
                  <th>Profile</th>
                  <th>Created at</th>
                  <th>Action</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("role_master,zoobiz_admin_master"," role_master.role_id = zoobiz_admin_master.role_id   order by zoobiz_admin_master.admin_name asc   ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $role_name; ?></td>
                    <td><?php echo  $admin_name; ?></td>
                    <td><?php echo  $admin_mobile; ?></td>

                    <td><?php echo  $admin_email; ?></td>
                     <td>
                      <?php if(trim($admin_profile) !=""){ ?>
                      <a href="img/profile/<?php echo $admin_profile; ?>" data-fancybox="images" data-caption="Photo Name : <?php echo $admin_profile; ?>">
                    <img src="img/profile/<?php echo $admin_profile; ?>" alt="<?php echo $admin_profile; ?>" class="lightbox-thumb img-thumbnail" style="width:50px;height:50px;">
                  </a>
                <?php  } ?> 
                 </td>
                     <?php if($created_date !=""){ ?>  
                    <td data-order="<?php echo date("U",strtotime($created_date)); ?>"><?php echo date("d-m-Y h:i:s A", strtotime($created_date)); ?></td>
                  <?php }  else { ?>
                     <td ><?php echo "-"; ?></td>
                  <?php } ?>  
                   <td >
                      <div style="display: inline-block;">
                        <form action="admin" method="post">
                          <input type="hidden" name="zoobiz_admin_id_edit" value="<?php echo $zoobiz_admin_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                      <?php
                      if($status==0 ){
                      ?>
                        <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_admin_id; ?>','adminDeactive');" data-size="small"/>
                        <?php } else { ?>
                       <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $zoobiz_admin_id; ?>','adminActive');" data-size="small"/>
                      <?php } ?>
 
                      <?php /*$transection_master=$d->select("transection_master","  coupon_id= '$coupon_id' ","");
                      if (mysqli_num_rows($transection_master) <= 0 ) { ?>
                        <div style="display: inline-block;">
                        <form  action="controller/couponController.php" method="post">
                          <input type="hidden" name="delete_coupon_id" value="<?php echo $coupon_id; ?>">
                          <button type="submit" name="deleteCmp" class="form-btn btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php } 
                      //24nov2020
                      else { ?>
                        <button type="button"  disabled="" class="form-btn btn btn-danger btn-sm " style="cursor: not-allowed;"> Delete</button>
                       <?php }*/ ?>
                      
                    </td>
                    
                    
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