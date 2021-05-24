<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Seasonal Greetings List</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Seasonal Greetings List</li>
         </ol>
      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right"> 
           <a href="managePromotionImages"  class="btn  btn-sm btn-secondary pull-right"><i class="fa fa-cogs"></i> Manage Frame & Center Images</a>

          <a href="promote"  class="btn  btn-sm btn-primary pull-right"><i class="fa fa-plus fa-lg"></i> Add New </a>
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
                  
                  <th>Event name</th>
                   
                  
                  <th>Frame</th>
               
                  <th>Manage</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <?php if($_SESSION['role_id'] == 1){  ?>
                  <th>Action</th>
                  <?php } ?> 
                </tr>
              </thead>
              <tbody>
                <?php
                $i=1;
                $q=$d->select("promotion_master"," status!=2 order by order_date desc ");
                while ($data=mysqli_fetch_array($q)) {
                  extract($data);
                  ?>
                  <tr>
                    
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo  $event_name; ?></td> 
                     
                  

                <td>
                      <?php if(trim($event_frame) !=""){ ?>
                      <a href="../img/promotion/<?php echo $event_frame; ?>" data-fancybox="images" data-caption="Photo Name : <?php echo $event_frame; ?>">
                    <img src="../img/promotion/<?php echo $event_frame; ?>" alt="<?php echo $event_frame; ?>" class="lightbox-thumb img-thumbnail" style="width:50px;height:50px;">
                  </a>
                <?php  } ?> 
                </td>

                     
                

                  <td>

                     


                    <?php 
                      $FrmCnt = $d->count_data_direct("promotion_rel_frame_id","promotion_rel_frame_master "," promotion_id= '$promotion_id'   "," ");
                      if($FrmCnt>0){ 
                      ?>
                    <div style="display: inline-block;">
                        <form action="manageFrame" method="post" >
                          <input type="hidden" name="promotion_id" value="<?php echo $promotion_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm ">Frames (<?php echo $FrmCnt;?>)</button>
                        </form>
                      </div>
                      <?php 
                    }
                      $centerCnt = $d->count_data_direct("promotion_rel_center_id","promotion_rel_center_master "," promotion_id= '$promotion_id'   "," ");
                      if($centerCnt>0){ 
                      ?>
                      <div style="display: inline-block;">
                        <form action="manageCenterImage" method="post" >
                          <input type="hidden" name="promotion_id" value="<?php echo $promotion_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm ">Center Images (<?php echo $centerCnt;?>)</button>
                        </form>
                      </div>
                    <?php } 
                    if($centerCnt>0 &&  $FrmCnt>0){ 
                    ?> 
                      <div style="display: inline-block;">

                        <form action="business_promotions" method="post" >
                          <input type="hidden" name="promotion_id" value="<?php echo $promotion_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm ">View (<?php echo ($FrmCnt * $centerCnt);?>)</button>
                        </form>
                      </div>
                    <?php } ?> 
                  </td>
                   <td data-order="<?php echo date("U",strtotime($data['event_date'])); ?>" > <?php  echo date("d-m-Y", strtotime($data['event_date']));?> </td>

                    <td data-order="<?php echo date("U",strtotime($data['event_end_date'])); ?>" > <?php echo date("d-m-Y", strtotime($data['event_end_date']));  ?> </td>

<?php if($_SESSION['role_id'] == 1){  ?>
                    <td>
            <?php if($event_status == 0) {
              $es = "Running";
            } else {
              $es = "Upcomming";
            } ?>            
<!-- <a data-toggle="modal" data-eventname="<?php echo $event_name; ?>" data-eventstatus="<?php echo $es; ?>" data-description="<?php echo $description; ?>" data-eventdate="<?php echo  date("d-m-Y", strtotime($event_date)); ?>" data-eventenddate="<?php echo  date("d-m-Y", strtotime($event_end_date)); ?>"  title="Details" class="open-AddBookDialog btn btn-sm  btn-success" href="#addCmtModal"><i class="fa fa-info"></i></a> -->

                      <?php 
                      $today = date("Y-m-d");

                      if(   $data['status']=="0"    ){ ?>
                             <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_id; ?>','promotionDeactive');" data-size="small"/>
                         <?php } else { ?>
                      <input    type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_id; ?>','promotionActive');" data-size="small"/> 
                      <?php  }

                      /*if( strtotime($data['event_date']) < strtotime($today) && $data['auto_expire'] == 0 ){
                        ?>
                        <input disabled=""  type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_id; ?>','promotionActive');" data-size="small"/> 
                        <?php 
                      } else  if( strtotime($data['event_date']) == strtotime($today) && $data['auto_expire'] == 0 ){
                        ?>
                        <input disabled=""  type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_id; ?>','promotionActive');" data-size="small"/> 
                        <?php 
                      } else 


                      if(   $data['status']=="1"    ){
                        ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_id; ?>','promotionActive');" data-size="small"/>
                          <?php } else { ?>
                             <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $promotion_id; ?>','promotionDeactive');" data-size="small"/>
                         
                        <?php }*/ ?>
                      <div style="display: inline-block;">
                        <form action="promote" method="post" >
                          <input type="hidden" name="promotion_id" value="<?php echo $promotion_id; ?>">
                          <button type="submit" name="" class="btn btn-primary btn-sm "> Edit</button>
                        </form>
                      </div>
                      
                      <?php   ?>
                        <div style="display: inline-block;">
                        <form  action="controller/businessPromotionController.php" method="post">
                          <input type="hidden" name="deletefrm" value="deletefrm">
                          <input type="hidden" name="promotion_id" value="<?php echo $promotion_id; ?>">
                          <button type="submit" name="deletefrmBtn" class=" form-btn btn btn-danger btn-sm "> Delete</button>
                        </form>
                      </div>
                      <?php    ?>
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


    <div class="modal fade" id="addCmtModal">
      <div class="modal-dialog">
        <div class="modal-content border-fincasys">
          <div class="modal-header bg-fincasys">
            <h5 class="modal-title text-white" id="cmt_header">Event Info</h5>
            <button type="button" class="close text-white"
            data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="addCommentModalDiv">
          
          
          <div class="form-group row">
            <label for="Comment"
            class="col-sm-4 col-form-label">Event Name</label>
            <div class="col-sm-8" id="event_name_data">
               
            </div>
          </div>

          <div class="form-group row">
            <label for="Comment"
            class="col-sm-4 col-form-label">Event Status</label>
            <div class="col-sm-8" id="eventstatus_data">
               
            </div>
          </div>

            <div class="form-group row">
            <label for="Comment"
            class="col-sm-4 col-form-label">Start Date</label>
            <div class="col-sm-8" id="event_date_data">
               
            </div>
          </div>

           <div class="form-group row">
            <label for="Comment"
            class="col-sm-4 col-form-label">End Date</label>
            <div class="col-sm-8" id="event_end_date_data">
               
            </div>
          </div>

            <div class="form-group row">
            <label for="Comment"
            class="col-sm-4 col-form-label">Event Description</label>
            <div class="col-sm-8" id="description_data">
               
            </div>
          </div>

           
</div>

</div>
</div>
</div>