<?php 
extract($_REQUEST);
if(isset($language_id)){
    extract($_POST);
    
    $qry = $d->select("language_master","language_id='$language_id'");
    $language_master = mysqli_fetch_array($qry);
     extract($language_master);
  }
   
   ?>
 
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title"> Add Language Key Value  </h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Language Key Value</li>
         </ol>
      </div> 
      <div class="col-sm-3">
        <a href="language_key_master_value_list" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-list mr-1"></i>View List</a>
      </div>
    </div>
  </div>
  <!-- End Breadcrumb-->

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        
        <div class="card-body">


 <form method="POST"   enctype="multipart/form-data" action="controller/languageKeyValueController.php">
         
 <?php
           
          $data=$d->select("language_master","active_status=0","");
         

          while ($row=mysqli_fetch_array($data)) { ?>
             <div class="form-group row">
               <label class="col-md-2 col-form-label" for="language_name"> </label>
           <div class="col-md-3">
                  <input type="checkbox" class="lang_chk"  name="key_value_id[]" id="<?php echo $row['language_id'];?>"  > <span><?php echo $row['language_name']; ?></span>
           </div>   
            <div class="col-md-6" id="detail_div<?php echo $row['language_id'];?>" style="display: none">    
                  <?php
           
           $language_key_master=$d->select("language_key_master","","");
          while ($language_key_master_data=mysqli_fetch_array($language_key_master)) { ?>
              
           <div class="form-group row">
            <div class="col-md-6">  
                  <input type="checkbox" class="key_name_cls" name="language_key_id[]" id="<?php echo $row['language_id'].'_'.$language_key_master_data['language_key_id'];?>" value="<?php echo $row['language_id'].'_'.$language_key_master_data['language_key_id'];?>"  /> <span><?php echo $language_key_master_data['key_name']; ?></span>
                </div>
                <div class="col-md-6" id="txt_div<?php echo $row['language_id'].'_'.$language_key_master_data['language_key_id'];?>" style="display: none">  
                  <input type="text" class="form-control" id="value_name" name="ValueName<?php echo $row['language_id'].'_'.$language_key_master_data['language_key_id'];?>[]" placeholder="value Name"   />
                </div>
              </div>

                  <br>
           
          <?php }  ?>
  </div>      
               
              </div>
          <?php } ?>
        


         
         <div class="form-footer text-center">
            <?php if(isset($language_id)){ ?> 
              <input type="hidden" name="language_id" value="<?php echo $language_id;?>">
               <button type="submit" class="btn btn-success" name="UpdateLanguage"  value="Update">Submit</button>
            <?php } else {?>
            <button type="submit" class="btn btn-success" name="AddLanguageKeyValue"  value="Save">Submit</button>
          <?php } ?> 
          
        </div>



 

          
      </form>
    </div>
  </div>
</div><!--End Modal -->

</div><!--End wrapper-->

<?php //include_once 'common/footer.php'; ?>