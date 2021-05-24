<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Language Key Value List</h4>
         <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="welcome">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Language Key Value List</li>
        </ol>
      </div>
      <div class="col-sm-3"> 
        <div class="btn-group float-sm-right">
     
 <a href="language_key_value_master" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i>Add New Language Key Value</a>

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
                    <th>ID</th>
                    <th>Language Name</th>
                    <th>Language Key</th>
                    <th>Language Key Value</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                   
                  <tbody>
                    <?php
                    $i = 1 ;

                     $language_key_master=$d->select("language_key_master","","");
                     $language_key_master_array = array();
                       while ($language_key_master_data=mysqli_fetch_array($language_key_master)) {
                        $language_key_master_array[$language_key_master_data['language_key_id']] = $language_key_master_data['key_name'];
                        }

                       $language_master=$d->select("language_master","","");
                       $language_master_data_array = array();
                       while ($language_master_data=mysqli_fetch_array($language_master)) {
                        $language_master_data_array[$language_master_data['language_id']] = $language_master_data['language_name'];
                        }


                     $q=$d->select("language_key_value_master","","");
                    while ($row=mysqli_fetch_array($q)) {

                      $language_key_id = $row['language_key_id'];
                      $key_name= $language_key_master_array[$language_key_id];


  $language_id = $row['language_id'];
  $language_name = $language_master_data_array[$language_id];

                      ?>
                      <tr>
                        <td><?php echo $i; $i++;?></td>
                         <td><?php echo $language_name;?></td> 
                        <td><?php echo $key_name;?></td> 
                        <td><?php echo $row['value_name'];?></td> 

                     
                      <td>
                        <div style="display: inline-block;">

                          <form action="edit_language_key_value" method="post" >
                            <input type="hidden" name="key_value_id" value="<?=$row['key_value_id']?>">
                             

                            <button type="submit" class="btn btn-sm btn-primary  " name="edit"  value="edit"><i class="fa fa-edit"></i></button>
                          </form>
                        </div> 
                        <div style="display: inline-block;" >
                          <form action="controller/languageKeyValueController.php" method="post">
                            <input type="hidden" name="delete_key_value_id" value="<?=$row['key_value_id']?>">
                            <button type="submit" class="btn btn-sm btn-danger form-btn" name="delete"  value="delete"><i class="fa fa-trash"></i></button>
                          </form>

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


