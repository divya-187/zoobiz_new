  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title">App Menu</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">App Menu</li>
         </ol>
     </div>
     <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        <a href="addAppMenu" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New</a>
       
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
              <table id="exampleList" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-right">Sr.No</th>
                        <th>App Menu Name</th>
                        <th>App Menu click</th>
                        <th>App Menu Icon</th>
                         <th>IS Parent</th>
                        <th>Status</th>
                        <th class="text-right">Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 <?php 
                  $i=1;
                  $q=$d->select("resident_app_menu"," menu_status_android='0' AND parent_menu_id=0 and menu_icon_new!=''","ORDER BY menu_sequence ASC");
                  while ($data=mysqli_fetch_array($q)) {
                   ?>
                  <tr>
                    <td class="text-right"><?php echo $i++; ?></td>
                  <td><?php echo $data['menu_title']; ?></td>
                    <td><?php echo $data['menu_click']; ?></td>
                    <td><img   src="../img/app_icon/<?php echo $data['menu_icon_new']; ?>"  width="40" height="40"    /></td>


                     <td><?php if($data['parent_menu_id'] == 0 ) { 
                      echo "Yes";} else { echo "No";} ?></td>

                      <td>
                      <b> 

                       <?php if($data['menu_status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['app_menu_id']; ?>','appMenuDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $data['app_menu_id']; ?>','appMenuActive');" data-size="small"/>
                        <?php } ?>


                    </b>
                    </td>
                    <td class="text-right"><?php echo $data['menu_sequence']; ?></td>

                    <td class="">
                       <form style="margin-right: 5px;float: left;" action="addAppMenu" method="post" style ='float: left;'>
                        <input type="hidden" name="app_menu_id" value="<?php echo $data['app_menu_id']; ?>">
                        <button name="editMenu" class="btn btn-primary btn-sm" data-toggle="tooltip" title="edit menu"> <i class="fa fa-pencil"></i></button>
                      </form>
                      <?php if($_SESSION['role_id']==1){ ?> 
                      <form class="deleteForm<?php echo $data['app_menu_id']; ?>" style ='float: left;' action="controller/appMenuController.php" method="post">
                        <input type="hidden" name="app_menu_id_delete" value="<?php echo $data['app_menu_id']; ?>">
                     
                        <button type="submit" name="" class="btn btn-danger btn-sm form-btn"> <i class="fa fa-trash-o"></i></button>

                     
                      </form>
                    <?php } ?> 
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



