  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9 col-6">
        <h4 class="page-title">Admin Notification</h4>
     </div>
     <div class="col-sm-3 col-6">
       <div class="btn-group float-sm-right">
        <!-- <a href="sos" class="btn btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New</a> -->
         <a href="javascript:void(0)" onclick="DeleteAll('deleteAdminNotification');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>

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
                        <th>#</th>
                        <th>#</th>
                        <th> Title</th>
                        <th> Description</th>
                        <th>Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                     <?php 
                  $m->set_data('read_status','1');
                  $arrayName = array('read_status'=>'1');
                    $q2=$d->update("admin_notification",$arrayName,"");
                    
                  $i=1;
                  $q=$d->select("admin_notification","  admin_id=0   ","ORDER BY notification_id DESC LIMIT 1000");
                  while($row=mysqli_fetch_array($q))
                  {
                    extract($row);
                  ?>
                    <tr>
                      <td class='text-center'>
                      <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $row['notification_id']; ?>">
                        </td>
                        <td><?php echo $i++; ?></td>
                        <td><a href="readNotification.php?link=<?php echo $row['admin_click_action']; ?>&id=<?php echo $row['notification_id']; ?>"><?php echo $notification_tittle; ?></a></td>
                        <td><?php echo $notification_description;  ?></td>
                        <td><?php echo $notifiaction_date; ?></td>
                        
                    </tr>
                    <?php }?>
                    
                </tbody>
                                
                </div>
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



