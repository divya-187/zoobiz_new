<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Language List</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="welcome">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Language List</li>
        </ol>
      </div>
      <div class="col-sm-3"> 
        <div class="btn-group float-sm-right">
         <a href="language" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i>Add New Language</a>

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
            <form method="POST" id="form" action="">

            </form>

            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Language Name</th>
                  <th>Language Name 1</th>
                  <th>continue Button name</th>
                  <th>Action</th>

                </thead>
                <!-------------select query-------------------->
                <tbody>
                  <?php $q=$d->select("language_master","","");
                  while ($row=mysqli_fetch_array($q)) {

                    ?>
                    <tr>
                      <td><?php echo $row['language_id'];?></td>
                      <td><?php echo $row['language_name'];?></td>
                      <td><?php echo $row['language_name_1'];?></td>
                      <td> <?php echo $row['continue_btn_name'];?></td> 

                      
                      <td>

                         <?php
                          $language_id = $row['language_id'];
                        $cnt = $d->count_data_direct("language_id","language_key_value_master  ","  language_id='$language_id'  ");
                        if( $cnt <= 0){
                if($row['active_status']=="0"){
                ?>
                  <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $row['language_id']; ?>','langDeactive');" data-size="small"/>
                  <?php } else { ?>
                 <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $row['language_id']; ?>','langActive');" data-size="small"/>

                 <a href="javascript:void();" onclick="deleteSliderImage(<?=$app_slider_id?>);" class="btn btn-sm btn-danger shadow-primary">Delete</a>
                <?php } 
              }?>

                        <div style="display: inline-block;">

                          <form action="language" method="post">
                            <input type="hidden" name="language_id" value="<?=$row['language_id']?>">
                            <button type="submit" class="btn btn-sm btn-primary  " name="edit"  value="edit"><i class="fa fa-edit"></i></button>
                          </form>
                        </div>
                       <?php
                        
                        if( $cnt  <= 0 ){ ?>
                          <div style="display: inline-block;">
                            <form action="controller/languageController.php" method="post">
                              <input type="hidden" name="deleteid" value="<?=$row['language_id']?>">
                              <button type="submit" class="btn btn-sm btn-danger form-btn" name="delete"  value="delete"><i class="fa fa-trash"></i></button>
                            </form>

                          </div>
                        <?php } ?>

                      </div>
                    </td>
                  </tr>
                <?php } ?>

                <!-------------------end select query-------------------------------->
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->
</div>
<!-- End container-fluid-->

</div>

</div><!--End wrapper-->

