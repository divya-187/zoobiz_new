<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Language Key List  </h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="welcome">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Language Key List</li>
        </ol>
      </div>
      <div class="col-sm-3"> 
        <div class="btn-group float-sm-right">

         <a href="languageKey" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i>Add New Language Key</a>

       </div>
     </div>
   </div>
   <!-- End Breadcrumb-->
   <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
          <div class="card-body">
            <form <?php if(isset($language_key_id)){ ?> id="EditlangKeyFrm" <?php  } else {?> id="langKeyFrm" <?php } ?>  method="POST" class="form-horizontal" action="controller/languagekeyController.php">
              <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="key_name">Key Name <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="key_name" name="key_name" placeholder="Key Name" required="" value="<?php if(isset($language_key_id)){ echo $key_name;} ?>" />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="key_name">Type  <span class="required">*</span></label>
                <div class="col-sm-10">
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <?php if(isset($language_key_id)) { ?>
                      <input type="radio" <?php if(isset($language_key_id) && $key_type=='0'){echo "checked";} ?>  class="form-check-input" value="0" name="key_type"> String  
                    <?php } else { ?>
                      <input type="radio" checked class="form-check-input" value="0" name="key_type"> String  
                    <?php } ?>
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <?php if(isset($language_key_id)) { ?>
                      <input type="radio"  <?php if(isset($language_key_id) && $key_type=='1'){echo "checked";} ?>  class="form-check-input" value="1" name="key_type"> Array
                      <?php } else { ?>
                      <input type="radio"  class="form-check-input" value="1" name="key_type"> Array  
                    <?php } ?>
                    </label>
                  </div>
                </div>
              </div>
              <div id="no_of_keyDiv"  <?php if(isset($language_key_id) && $key_type=='1') { echo "style='display:block'"; } else { echo "style='display:none'"; } ?>>
               <div class="form-group row" >
                <label class="col-sm-2 col-form-label" for="no_of_key">Number of Values <span class="required">*</span></label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="no_of_key" name="no_of_key" placeholder="Number of Values" required="" value="<?php if(isset($language_key_id)){ echo $no_of_key;} ?>" />
                </div>
              </div>
             </div>
              <div class="form-footer text-center">
                <?php if(isset($language_key_id)){ ?>
                <input type="hidden" name="language_key_id" value="<?php echo $language_key_id;?>">
                <button type="submit" class="btn btn-success" name="UpdateLanguageKey"  value="Update">Submit</button>
                <?php } else {?>
                <button type="submit" class="btn btn-success" name="AddLanguageKey"  value="Save">Submit</button>
                <?php } ?>
                
              </div>
            </form>
            
          </div>
          
        </div>
      </form>
    </div>
  </div>

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
                  <th>Key Name</th>
                  <th>Type</th>
                  <th>Action</th>

                </thead>
                <!-------------select query-------------------->
                <tbody>
                  <?php
                  $i = 1 ;
                  $q=$d->select("language_key_master","","");
                  while ($row=mysqli_fetch_array($q)) {

                    ?>
                    <tr>
                      <td><?php echo $i; $i++;?></td>
                      <td><?php echo $row['key_name'];?></td> 
                      <td><?php if( $row['key_type']==1) {
                        echo "Array";
                      } else {
                        echo "String";
                      }?></td> 
                      
                      <td>

                         <?php
                          $language_key_id  = $row['language_key_id'];
                          
                        $cnt = $d->count_data_direct("language_key_id","language_key_value_master  ","  language_key_id='$language_key_id'  ");
                        if( $cnt <= 0  ){
                            if($row['key_status']=="0"){
                            ?>
                              <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $row['language_key_id']; ?>','langKeyDeactive');" data-size="small"/>
                              <?php } else { ?>
                             <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $row['language_key_id']; ?>','langKeyActive');" data-size="small"/>

                             <a href="javascript:void();" onclick="deleteSliderImage(<?=$app_slider_id?>);" class="btn btn-sm btn-danger shadow-primary">Delete</a>
                            <?php } 
                          }?>

                        <div style="display: inline-block;">

                          <form action="languageKey" method="post" >
                            <input type="hidden" name="language_key_id" value="<?=$row['language_key_id']?>">
                            <button type="submit" class="btn btn-sm btn-primary  " name="edit"  value="edit"><i class="fa fa-edit"></i></button>
                          </form>
                        </div>
                        <?php if(  $cnt <= 0  ){ ?> 
                        <div style="display: inline-block;" >
                          <form action="controller/languagekeyController.php" method="post">
                            <input type="hidden" name="delete_language_key_id" value="<?=$row['language_key_id']?>">
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

