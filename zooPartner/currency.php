<?php  error_reporting(0);
extract($_REQUEST);
if(isset($currency_id)){
$currency_master=$d->select("currency_master","  currency_id= '$currency_id' ","");
$currency_master_data=mysqli_fetch_array($currency_master);
extract($currency_master_data);
}
?>
<style type="text/css">
  input { 
    text-transform: uppercase;
}
::-webkit-input-placeholder { /* WebKit browsers */
    text-transform: none;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    text-transform: none;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    text-transform: none;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
    text-transform: none;
}
::placeholder { /* Recent browsers */
    text-transform: none;
}
</style>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php if(isset($currency_id)){?>
        <h4 class="page-title">Edit Currency</h4>
        <?php  } else {?>
        <h4 class="page-title">Add Currency</h4>
        <?php } ?>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item"><a href="currencyList">Currency List</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php if(isset($currency_id)){?>
       Edit Currency 
        <?php  } else {?>
        Add Currency 
        <?php } ?></li>
         </ol>
      </div>
      
    </div>
    <!-- End Breadcrumb-->
    
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
           
            <form id="CurrFrm" action="controller/currencyController.php" method="post" enctype="multipart/form-data">
              
              
                <div class="form-group row">
                  
                  <label class="col-lg-2 col-form-label form-control-label">Currency Name <span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input  required="" type="text" class="form-control  " name="currency_name" id="currency_name" value="<?php if(isset($currency_id)){  echo $currency_name;} ?>" placeholder="Currency Name" minlength="5" maxlength="50"  >
                    
                  </div>
                  
                   <label class="col-lg-2 col-form-label form-control-label">Currency Code<span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input class="form-control text-uppercase" name="currency_code" id="currency_code" type="text" minlength="3" maxlength="10" value="<?php if(isset($currency_id)){  echo $currency_code;} ?>" required="" placeholder="Currency Code">
                  </div>
                </div>

               
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label form-control-label">Currency Symbol<span class="required">*</span></label>
                  <div class="col-lg-4">
                    <input class="form-control " name="currency_symbol" id="currency_symbol" type="text" minlength="1" maxlength="10" value="<?php if(isset($currency_id)){  echo $currency_symbol;} ?>" required="" placeholder="Currency Symbol">
                  </div>
                  
                </div>
                
              
               
              <div class="form-footer text-center">
                
                <?php  if(isset($currency_id)){ ?>
                <input type="hidden" name="currency_id" value="<?php echo $currency_id;?>">
                <button type="submit" name="currEditBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> UPDATE</button>
                <?php  } else {?>
                <button type="submit" name="currAddBtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                <?php }?>
                <button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> RESET</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div><!--End Row-->
    </div>
    <!-- End container-fluid-->
    </div><!--End content-wrapper-->