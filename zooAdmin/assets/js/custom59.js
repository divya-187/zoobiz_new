jQuery(document).ready(function($){
    //your custom2.js code here
});



function  getStates() {
  var country_id = $("#country_id").val();
  $.ajax({
        url: "getStates.php",
        cache: false,
        type: "POST",
        data: {country_id : country_id,getStates:'getStates'},
        success: function(response){
            $('#state_id').html(response);
          
            
        }
     });
}

function  getCity() {
  var state_id = $("#state_id").val();
  $.ajax({
        url: "getCities.php",
        cache: false,
        type: "POST",
        data: {state_id : state_id,getCity:'getCity'},
        success: function(response){
            $('#city_id').html(response);
          
            
        }
     });
}


function  getArea() {
  var city_id = $("#city_id").val();
  $.ajax({
        url: "getArea.php",
        cache: false,
        type: "POST",
        data: {city_id : city_id,getArea:'getArea'},
        success: function(response){
            $('#area_id').html(response);
          
            
        }
     });
}

function  getLatLong() {
  var area_id = $("#area_id").val();
  $.ajax({
        url: "getArea.php",
        cache: false,
        type: "POST",
        data: {area_id : area_id,getLatLong:'getLatLong'},
        success: function(response){
             // $('#area_id').html(response);
            var fields = response.split('~');
            document.getElementById('lat').value = fields[0];
            document.getElementById('lng').value = fields[1];

            initialize();
            
        }
     });
}

function DeleteAll(deleteValue) {
    // var myArray = [];
    // var val = [];
    var oTable = $("#example").dataTable();
    // $(".multiDelteCheckbox:checked", oTable.fnGetNodes()).each(function(i) {
    //     if (val != "") {
    //         val[i] = val + "," + $(this).val();
    //     } else {
    //         val = $(this).val();
    //     }
    // });

    var val = [];
          $(".multiDelteCheckbox:checked", oTable.fnGetNodes()).each(function(i) {
            val[i] = $(this).val();
          });
    if(val=="") {
      swal(
        'Warning !',
        'Please Select at least 1 item !',
        'warning'
      );
    } else {
      // alert(val);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              // $('form.deleteForm'+id).submit();
          $.ajax({
              url: "controller/deleteController.php",
              cache: false,
              type: "POST",
              data: {ids : val,deleteValue
                :deleteValue},
              success: function(response){
                console.log(response)
                if(response==1) {
                  // document.location.reload(true);
                  history.go(0);
                } else {
                  // document.location.reload(true);
                  history.go(0);
                }
              }
            });

             
            } else {
              // swal("Your data is safe!");
            }
          });
    }
}


function DeleteAll2(deleteValue) {
    // var myArray = [];
    // var val = [];
    var oTable = $("#default-datatable1").dataTable();
    // $(".multiDelteCheckbox:checked", oTable.fnGetNodes()).each(function(i) {
    //     if (val != "") {
    //         val[i] = val + "," + $(this).val();
    //     } else {
    //         val = $(this).val();
    //     }
    // });

    var val = [];
          $(".multiDelteCheckbox:checked", oTable.fnGetNodes()).each(function(i) {
            val[i] = $(this).val();
          });
    if(val=="") {
      swal(
        'Warning !',
        'Please Select at least 1 item !',
        'warning'
      );
    } else {
      // alert(val);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              // $('form.deleteForm'+id).submit();
          $.ajax({
              url: "controller/deleteController.php",
              cache: false,
              type: "POST",
              data: {ids : val,deleteValue
                :deleteValue},
              success: function(response){
                console.log(response)
                if(response==1) {
                  // document.location.reload(true);
                  history.go(0);
                } else {
                  // document.location.reload(true);
                  history.go(0);
                }
              }
            });

             
            } else {
              // swal("Your data is safe!");
            }
          });
    }
}

function DeleteAll3(deleteValue) {
    // var myArray = [];
    // var val = [];
    var oTable = $("#default-datatable2").dataTable();
    // $(".multiDelteCheckbox:checked", oTable.fnGetNodes()).each(function(i) {
    //     if (val != "") {
    //         val[i] = val + "," + $(this).val();
    //     } else {
    //         val = $(this).val();
    //     }
    // });

    var val = [];
          $(".multiDelteCheckbox:checked", oTable.fnGetNodes()).each(function(i) {
            val[i] = $(this).val();
          });
    if(val=="") {
      swal(
        'Warning !',
        'Please Select at least 1 item !',
        'warning'
      );
    } else {
      // alert(val);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              // $('form.deleteForm'+id).submit();
          $.ajax({
              url: "controller/deleteController.php",
              cache: false,
              type: "POST",
              data: {ids : val,deleteValue
                :deleteValue},
              success: function(response){
                console.log(response)
                if(response==1) {
                  // document.location.reload(true);
                  history.go(0);
                } else {
                  // document.location.reload(true);
                  history.go(0);
                }
              }
            });

             
            } else {
              // swal("Your data is safe!");
            }
          });
    }
}
function  getSubCategory() {
  var business_categories = $("#business_categories").val();
  $.ajax({
        url: "getBusSubCategory.php",
        cache: false,
        type: "POST",
        data: {business_categories : business_categories},
        success: function(response){
            $('#business_categories_sub').html(response);
        }
     });
}

function  getSubCategory2() {
  var business_categories = $("#filter_business_category_id").val();
  $.ajax({
        url: "filterSubCat.php",
        cache: false,
        type: "POST",
        data: {business_categories : business_categories,classified_filter:'Yes'},
        success: function(response){
            $('#filter_business_categories_sub').html(response);
        }
     });
}
//27oct
function  getSendTo() {
  var send_to = $("#send_to").val();
   
  if(send_to!=0 && send_to!= 5 && send_to != 6 ){
    $('#detail_div').css('display','block');

    

    if(send_to==7){
      $('#drp_div').css('display','none');
      $('#txt_div').css('display','block');
      $.ajax({
        url: "getSendTo.php",
        cache: false,
        type: "POST",
        data: {send_to : send_to},
        beforeSend: function(){
        $('#txt_div').html('');
               
        },
        success: function(response){

             $('#txt_div').html('');
            $('#txt_div').html(response);
        }
     });
    } else {
      $('#drp_div').css('display','block');
      $('#txt_div').css('display','none');
      $.ajax({
        url: "getSendTo.php",
        cache: false,
        type: "POST",
        data: {send_to : send_to},
        beforeSend: function(){
        $('#send_to_details_div').html('');
               
        },
        success: function(response){

            $('#send_to_details_div').html('');
            $('#send_to_details_div').html(response);
        }
     });
    }

    
  } else {
    $('#send_to_details_div').html('');
    $('#detail_div').css('display','none');
  }
  
}
function  getSubCategoryDeals() {
  //var business_categories = $("#business_categories").val();
  var business_categories = $("#business_categories_deals option:selected").val();
 
  $.ajax({
        url: "getSendTo.php",
        cache: false,
        type: "POST",
        data: {business_categories : business_categories},
        success: function(response){
            $('#business_categories_sub').html(response);
        }
     });
}


function wasDeselected (sel, val) {
  if (!val) {
    return true;      
  }
  return sel && sel.some(function(d) { return val.indexOf(d) == -1; })
}


function wasDeselected2 (sel2, val2) {
  if (!val2) {
    return true;      
  }
  return sel2 && sel2.some(function(d) { return val2.indexOf(d) == -1; })
}
$(document).on('change', '#promotion_frame_id', function (event) {
  var message,
      $select = $(event.target),
      val     = $select.val(),
      sel     = $('#promotion_frame_id').data('selected');

  // Store the array of selected elements
  $select.data('selected', val);
 var promotion_frame_id = $("#promotion_frame_id option:selected").val();
  
  // Check the previous and current val
  if ( wasDeselected(sel, val) ) {
    message = "You have deselected this item.";
    if(promotion_frame_id >0){ 
    $( "#frm_img_"+promotion_frame_id ).remove();
  } else {
    $('#getImage1_div').html('');
  }

  } else {

    
 
  $.ajax({
        url: "getImageUrl.php",
        cache: false,
        type: "POST",
        data: {promotion_frame_id : val, imageOne:"imageOne"},
        success: function(response){
          
            //$('#getImage1_div').append(response);
            $('#getImage1_div').html(response);
        }
     });
 
    message = "You have selected this item.";
  }
 // alert(message);
});

$(document).on('change', '#promotion_center_image_id', function (event) {
  var message,
      $select = $(event.target),
      val2     = $select.val(),
      sel2     = $('#promotion_center_image_id').data('selected');
 

 

  // Store the array of selected elements
  $select.data('selected', val2);
 var promotion_center_image_id = $("#promotion_center_image_id option:selected").val();
 
  // Check the previous and current val
  if ( wasDeselected2(sel2, val2) ) {
    message = "You have deselected this item.";
    
    if(promotion_center_image_id >0){   
    $( "#center_img_"+promotion_center_image_id ).remove();
  } else {
    $('#getImage2_div').html('');
  }

  } else {

    
 
  $.ajax({
        url: "getImageUrl.php",
        cache: false,
        type: "POST",
        data: {promotion_center_image_id : val2, imageTwo:"imageTwo"},
        success: function(response){
          
           // $('#getImage2_div').append(response);
           $('#getImage2_div').html(response);
        }
     });
 
    message = "You have selected this item.";
  }
 // alert(message);
});

function  getImage1() {
  //var business_categories = $("#business_categories").val();
  var promotion_frame_id = $("#promotion_frame_id option:selected").val();
 if(promotion_frame_id >0){ 
  $.ajax({
        url: "getImageUrl.php",
        cache: false,
        type: "POST",
        data: {promotion_frame_id : promotion_frame_id, imageOne:"imageOne"},
        success: function(response){
          
            $('#getImage1_div').append(response);
        }
     });
} else {
  $('#getImage1_div').html('');
}
}
function  getImage2() {
  //var business_categories = $("#business_categories").val();
  var promotion_center_image_id = $("#promotion_center_image_id option:selected").val();
   

  if(promotion_center_image_id >0){
      
     $.ajax({
        url: "getImageUrl.php",
        cache: false,
        type: "POST",
        data: {promotion_center_image_id : promotion_center_image_id, imageTwo:"imageTwo"},
        success: function(response){
           
            $('#getImage2_div').append(response);
        }
     });
   }   else {
    $('#getImage2_div').html('');
  
   }
 
}
//27oct

function  getFloorList() {
	var no_of_floor = $("#no_of_floor").val();
	var floor_type = $("#floor_type").val();
	$.ajax({
        url: "getFloorList.php",
        cache: false,
        type: "POST",
        data: {no_of_floor : no_of_floor,floor_type:floor_type},
        success: function(response){
        		$('#floorResp').html(response);
        	
            
        }
     });
}

function  editAgent(agent_id) {
  
  $.ajax({
        url: "editAgent.php",
        cache: false,
        type: "POST",
        data: {agent_id : agent_id},
        success: function(response){
            $('#agentEditDiv').html(response);
        }
     });
}


function  otherCheck() {
  var business_categories_sub = $("#business_categories_sub").val();
  if (business_categories_sub=='Other') {
    if (business_categories_sub=='Other') {
      $("#ProfessionalTypeOther").show();
    }else {
      $("#ProfessionalTypeOther").hide();
    }

  }

}


function DeleteBlock(block_id) {
    // alert(block_id);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/blockController.php",
                cache: false,
                type: "POST",
                data: {deleteBlock : block_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                    
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Proof! Your data has been deleted!", {
                            icon: "error",
                          });
                  }
                }
              });
             
            } else {
              //swal("Your data is safe!");
            }
          });

}

function DeleteFloor(floor_id) {
    // alert(floor_id);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/floorController.php",
                cache: false,
                type: "POST",
                data: {deleteFloor : floor_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Proof! Your data has been deleted!", {
                            icon: "error",
                          });
                  }
                }
              });

             
            } else {
              //swal("Your data is safe!");
            }
          });



}


function DeleteUnit(unit_id) {
    // alert(unit_id);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/unitController.php",
                cache: false,
                type: "POST",
                data: {deleteUnit : unit_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Proof! Your data has been deleted!", {
                            icon: "error",
                          });
                  }
                }
              });

             
            } else {
              //swal("Your data is safe!");
            }
          });



}


function DeleteParking(parking_id) {
    // alert(parking_id);
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/parkingController.php",
                cache: false,
                type: "POST",
                data: {deleteParking_id : parking_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Proof! Your data has been deleted!", {
                            icon: "error",
                          });
                  }
                }
              });

             
            } else {
              //swal("Your data is safe!");
            }
          });



}


function editFloor (floor_id,floor_name) {
    $('#floorId').val(floor_id);
    $('#oldFloorname').val(floor_name);

}


function editBlock (block_id,block_name) {
    $('#floorId').val(block_id);
    $('#oldFloorname').val(block_name);

}


function editParking (parking_id,parking_name,society_parking_id) {
    $('#parking_id').val(parking_id);
    $('#oldParkingName').val(parking_name);
    $('#society_parking_id').val(society_parking_id);

}

function addParking(parking_id,Type,parking_name,society_parking_id) {
   $('#addParking').modal('show');
  $('#P_id').val(parking_id);
  $('#sParking_id').val(society_parking_id);
  $('#pType').html(Type);
  $('#parkingName').html(parking_name);

}

function updateParking(parking_id,Type,parking_name,society_parking_id,unit_id,vehicle_no) {
   $('#updateParking').modal('show');
  $('#P_id11').val(parking_id);
  $('#sParking_id1').val(society_parking_id);
  $('#unitId').val(unit_id);
  $('#vehicle_no').val(vehicle_no);
  $('#pType1').html(Type);
  $('#parkingName1').html(parking_name);

   $.ajax({
        url: "getParkingDetails.php",
        cache: false,
        type: "POST",
        data: {unit_id : unit_id},
        success: function(response){
            $('#getParkingDetails').html(response);
        }
      });

}


$('#summernoteImgage').summernote({
  height: 400,
  tabsize: 2,
  toolbar: [
  [ 'style', [ 'style' ] ],
  [ 'font', [ 'bold', 'italic', 'underline', 'clear'] ],
  [ 'fontname', [ 'fontname' ] ],
  [ 'fontsize', [ 'fontsize' ] ],
  [ 'color', [ 'color' ] ],
  [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
  [ 'table', [ 'table' ] ],
  [ 'insert', [ 'link','picture'] ],
  [ 'view', [ 'undo', 'redo', 'codeview', 'help' ] ]
  ],
  callbacks: {
    onImageUpload: function(image) {
      uploadImage(image[0]);
    }
  }
});
 function uploadImage(image) {
  var data = new FormData();
  data.append("image", image);
  $.ajax({
    url: 'controller/noticeBoardImage.php',
    cache: false,
    contentType: false,
    processData: false,
    data: data,
    type: "post",
    success: function(url) {
      var image = $('<img width=320>').attr('src', url);
      console.log(image);
      $('#summernoteImgage').summernote("insertNode", image[0]);
    },
    error: function(data) {
      console.log(data);
    }
  });
}

function checkMobileSociety() {
  var secretary_mobile= $('#secretary_mobile').val();
  
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {secretary_mobile : secretary_mobile,checkSocietyMobile:'checkSocietyMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
}


function checkMobileUser() {
  var userMobile= $('#userMobile').val();
   if($.trim(userMobile) !=''){ 
     $.ajax({
        url: "controller/userController.php",
        cache: false,
        type: "POST",
        data: {userMobile : userMobile,checkUserMobile:'checkUserMobile'},
        success: function(response){
           if (response==2) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This Account Is Deactivated.'
                });
                  
           } else if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'Number Already Registered.'
                });
                  
           } else  {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
   }
}

//15dec2020
function checkMobileAdmin() {
  var admin_mobile= $('#admin_mobile').val();
  
  if($.trim(admin_mobile) !=''){ 
     $.ajax({
        url: "controller/adminController.php",
        cache: false,
        type: "POST",
        data: {admin_mobile : admin_mobile,checkAdminMobile:'checkAdminMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("admAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("admAddBtn").disabled=false;
           }
        }
      });
   }
}
//15dec2020

function checkMobileUserTenant() {
  var userMobile= $('#userMobileTenant').val();
  
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {userMobile : userMobile,checkUserMobile:'checkUserMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtnTenat").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtnTenat").disabled=false;
           }
        }
      });
}



function checkEmailUser() {
  var userEmail= $('#userEmail').val();
    if (userEmail!='') {
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {userEmail : userEmail,checkEmailMobile:'checkEmailMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This Email is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
    } else {
      document.getElementById("socAddBtn").disabled=false;
    }
}

function checkEmailUserTenant() {
  var userEmail= $('#userEmailTenant').val();
    if (userEmail!='') {
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {userEmail : userEmail,checkEmailMobile:'checkEmailMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtnTenat").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This Email is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtnTenat").disabled=false;
           }
        }
      });
    } else {
       document.getElementById("socAddBtnTenat").disabled=false;
    }
}

function checkMobileUser1() {
  var userMobile= $('#userMobile1').val();
  
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {userMobile : userMobile,checkUserMobile:'checkUserMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn1").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn1").disabled=false;
           }
        }
      });
}



function checkEmailUser1() {
  var userEmail= $('#userEmail1').val();
 
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {userEmail : userEmail,checkEmailMobile:'checkEmailMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn1").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This Email is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn1").disabled=false;
           }
        }
      });
}


function checkMobileSocietyEdit() {

  var secretary_mobile= $('#secretary_mobile').val();
  var secretary_mobile_old= $('#secretary_mobile_old').val();
  if (secretary_mobile_old!=secretary_mobile) {
    // alert("call");
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {secretary_mobile : secretary_mobile,secretary_mobile_old:secretary_mobile_old,checkSocietyMobileEdit:'checkSocietyMobileEdit'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This Mobile Number  is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
    } else {
         document.getElementById("socAddBtn").disabled=false;
    }
}

function checkemailSociety() {
  var secretary_email= $('#secretary_email').val();
  
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {secretary_email : secretary_email,checkSocietyEmail:'checkSocietyEmail'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'Email already used'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
}


function checkemailSocietyEdit() {

  var secretary_email= $('#secretary_email').val();
  var secretary_email_old= $('#secretary_email_old').val();
  if (secretary_email_old!=secretary_email) {
    // alert("call");
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {secretary_email : secretary_email,secretary_email_old:secretary_email_old,checkSocietyEmailEdit:'checkSocietyEmailEdit'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'Email already used'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
    } else {
         document.getElementById("socAddBtn").disabled=false;
    }
}


function checkMobileEmp() {
  var emp_mobile= $('#empNumber').val();
  
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {emp_mobile : emp_mobile,checkUserEmp:'checkUserEmp'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
}


function checkMobileEmpEdit() {
  var emp_mobile= $('#empNumber').val();
  var empNumberOld= $('#empNumberOld').val();
  if (empNumberOld!=emp_mobile) {
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {emp_mobile : emp_mobile,checkUserEmp:'checkUserEmp'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
    }
}



function checkMobileUserEdit() {
  var userMobile= $('#userMobile').val();
  var userMobileOld= $('#userMobileOld').val();
    if($.trim(userMobile) !=''){ 
    if (userMobile!=userMobileOld) {
     $.ajax({
        url: "controller/uniqueController.php",
        cache: false,
        type: "POST",
        data: {userMobile : userMobile,checkUserMobile:'checkUserMobile'},
        success: function(response){
           if (response==1) {
                document.getElementById("socAddBtn").disabled=true;
              Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'fa fa-times-circle',
                msg: 'This mobile number is Already Used.'
                });
                  
           } else {
               document.getElementById("socAddBtn").disabled=false;
           }
        }
      });
   }
  } else {
    document.getElementById("socAddBtn").disabled=false;
  }
}


function checkEmailUserEdit() {
  var userEmail= $('#userEmail').val();
  var userEmailOld= $('#userEmailOld').val();
  if (userEmail!='') {
    if (userEmail!=userEmailOld) {
       $.ajax({
          url: "controller/uniqueController.php",
          cache: false,
          type: "POST",
          data: {userEmail : userEmail,checkEmailMobile:'checkEmailMobile'},
          success: function(response){
             if (response==1) {
                  document.getElementById("socAddBtn").disabled=true;
                Lobibox.notify('error', {
                  pauseDelayOnHover: true,
                  continueDelayOnInactiveTab: false,
                  position: 'top right',
                  icon: 'fa fa-times-circle',
                  msg: 'This Email is Already Used.'
                  });
                    
             } else {
                 document.getElementById("socAddBtn").disabled=false;
             }
          }
        });
      }
     } else {
       document.getElementById("socAddBtn").disabled=false;
    }
}


 function changePlan(society_id) {
   $.ajax({
      url: "getPlan.php",
      cache: false,
      type: "POST",
      data: {society_id : society_id},
      success: function(response){
          document.getElementById("planFormRes").innerHTML=response;
      }
    });


}




/*$(document).on('keyup', '.select2-search__field', function (e) {  
       var country_id = $("#country_id").val();
       var city_id = $("#city_id").val();
       var state_id = $("#state_id").val();
       var search = $("#search").val();
        $.ajax({
        url: "getSocieties.php",
        cache: false,
        type: "POST",
        data: {city_id : city_id,search : search,getSociety:'getSociety'},
        success: function(response){
            $('#society_id').html(response);
          
            
        }
     });
       


});*/

function  getSubCategorySp() {
  var local_service_master_id = $("#local_service_master_id").val();
  $.ajax({
        url: "getSubCategory.php",
        cache: false,
        type: "POST",
        data: {local_service_master_id : local_service_master_id,getSubCategory:'getSubCategory'},
        success: function(response){
            $('#local_service_provider_sub_id').html(response);
          
            
        }
     });
}


function deletePost(feed_id) {
    // alert(block_id);
    swal({
            title: "Are you sure to Delete this Post ?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/newsFeedController.php",
                cache: false,
                type: "POST",
                data: {feed_id_delete : feed_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                    
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Proof! Your data has been deleted!", {
                            icon: "error",
                          });
                  }
                }
              });
             
            } else {
              //swal("Your data is safe!");
            }
          });

}

function deleteComment(comments_id) {
    // alert(block_id);
    swal({
            title: "Are you sure delete this Comment ?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/newsFeedController.php",
                cache: false,
                type: "POST",
                data: {comments_id_delete : comments_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                    
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Proof! Your data has been deleted!", {
                            icon: "error",
                          });
                  }
                }
              });
             
            } else {
              //swal("Your data is safe!");
            }
          });

}



function deleteSpCategory(local_service_provider_id) {
    // alert(block_id);
    swal({
            title: "Are you sure to Delete this Category ?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/serviceProviderController.php",
                cache: false,
                type: "POST",
                data: {local_service_provider_id_delete : local_service_provider_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                    
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  }
                }
              });
             
            } else {
            }
          });

}

function deleteSpSubCategory(local_service_provider_sub_id) {
    // alert(block_id);
    swal({
            title: "Are you sure to Delete this Sub Category ?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/serviceProviderController.php",
                cache: false,
                type: "POST",
                data: {local_service_provider_sub_id_delete : local_service_provider_sub_id},
                success: function(response){
                  console.log(response)
                  if(response==1) {
                         swal("Proof! Your data has been deleted!", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } 
                }
              });
             
            } else {
            }
          });

}


function editCategory(local_service_provider_id,service_provider_category_name,service_provider_category_image,menu_icon_old) {
  $('#req_icon').css('display','none');
  if(menu_icon_old==""){
    
     $('#req_icon').css('display','block');
  } else {
     $('#req_icon').css('display','none');
  }
   $("#local_service_provider_id").val(local_service_provider_id);
   $("#service_provider_category_name").val(service_provider_category_name);
   $("#service_provider_category_image").val(service_provider_category_image);
   $("#cat_icon_old").val(menu_icon_old);
    

}


//16feb21
function editInterest(interest_id,interest_name) {
  
   $("#interest_id").val(interest_id);
   $("#interest_name").val(interest_name); 
    

}

function editUPI(app_id,app_name,app_package_name) {
  
   $("#app_id").val(app_id);
   $("#app_name").val(app_name); 
   $("#app_package_name").val(app_package_name); 
    

}
//16feb21



var entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;'
};

function escapeHtml(string) {
    return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });
}


function editSubCategory(business_category_id,local_service_provider_sub_id,service_provider_sub_category_name,service_provider_sub_category_image,totalSubCategory) {
   $("#local_service_provider_sub_id").val(local_service_provider_sub_id);

 //  var service_provider_sub_category_name = escapeHtml(service_provider_sub_category_name);
//service_provider_sub_category_name = service_provider_sub_category_name.replace(/'/g,"");

   $("#service_provider_sub_category_name").val(service_provider_sub_category_name);
   $("#service_provider_sub_category_image").val(service_provider_sub_category_image);

   options = $('#business_category_id').children('select').children('option');
   // alert(business_category_id);

    //the following does not seem to work since the elements of options are DOM ones not jquery's
    // option11 = options.find("[value='" + business_category_id + "']");
    //alert(option.attr("value")); //undefined

    $('#business_category_id option[value='+business_category_id+']').attr('selected','selected');

    if(totalSubCategory>0){
      
     // $('#editSubCatFrm :input[name="business_category_id"]').prop('readonly', true);
      $('#editSubCatFrm :input[name="business_category_id"]').attr("disabled", true); 

    } else {
      $('#editSubCatFrm :input[name="business_category_id"]').attr("disabled", false); 
    }
}



function  getCategorySp() {

  $.ajax({
        url: "https://www.fincasys.com/main_api/local_service_provider_controller.php",
        cache: false,
        type: "POST",
         dataType: 'JSON',
        data: {getLocalServiceProviders : 'getLocalServiceProviders'},
        success: function(response){
          // console.log(response['local_service_provider'][1]);
            
          $.each(response.local_service_provider, function (key, value) {
              $("#dropDownDest").append($('<option></option>').val(value.local_service_provider_id+'~'+value.service_provider_category_name).html(value.service_provider_category_name));
          });

          $('#dropDownDest').change(function () {
              // alert($(this).val());
              //Code to select image based on selected car id
          })
            
        }
     });
}

function showError(msg) {
  swal(msg, {
    icon: "error",
  });
}
$('.eventPrice').hide();

$('input[type=radio][name=event_type]').change(function() {
    if (this.value == '1') {
      $('.eventPrice').show();

    }
    else if (this.value == '0') {
      $('.eventPrice').hide();
      
    }
});

function hideData() {
  var empType = $('.employment_type').val();
  if (empType=='Not employed' || empType=='Student' || empType=='Others') {
    $('.proExtDiv').hide();
  } else {
    $('.proExtDiv').show();
  }

}

 $(".onlyNumber,#secretary_mobile,#trlDays,#emp_sallary,#no_of_option,#month_working_days,#working_days,#leave_days,#no_of_person,#no_of_month,#expAmoint,#no_of_unit_bill,#no_of_unit,#no_of_blocks,#no_of_floor,#emrNumber,#userMobile,#ownerMobile,#empNumber,#cMobile,#editMobile1,#noofCar,#noofBike,#person_limit_day,#person_limit").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

 $(".alphanumeric").keypress(function (e) {
  var keyCode = e.which;
    
  if ( !( (keyCode >= 48 && keyCode <= 57) 
   ||(keyCode >= 65 && keyCode <= 90) 
   || (keyCode >= 97 && keyCode <= 122) 
    
   ) 
   && keyCode != 8 ) {
   e.preventDefault();
  }
});


  $(".mem-alphanumeric").keypress(function (e) {
  var keyCode = e.which;
 
  if ( !( (keyCode >= 48 && keyCode <= 57) 
   ||(keyCode >= 65 && keyCode <= 90) 
   || (keyCode >= 97 && keyCode <= 122) 
    
   ) 
   && ( keyCode != 8 &&  keyCode != 32 )  ) {
   e.preventDefault();
  }
});

$('.form-btn').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
     swal({
        title: "Are you sure?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ['Cancel', 'Yes, I am sure !'],
      })
     .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });

});


//26feb21
/*$('.content-wrapper').click(function(e) {
   if($("#wrapper").hasClass("toggled")){
      $('#wrapper').removeClass("toggled"); 
         e.preventDefault();
      } 
});*/
//26feb21
 $('.toggle-menu').click(function(event){
     event.stopPropagation();
 });



function  getSocietyData(society_id) {
 
  $.ajax({
        url: "controller/cronGetData.php",
        cache: false,
        type: "POST",
        data: {society_id : society_id},
        success: function(response){
            $('#BlockResp').html(response);
            
        }
     });
}

 
function  editRef(user_id,refer_by,fromDate,toDate) {
 
  $.ajax({
        url: "getRefData.php",
        cache: false,
        type: "POST",
        data: {user_id : user_id,refer_by : refer_by,fromDate : fromDate,toDate : toDate},
        success: function(response){
            $('#data_ref').html(response);
            
        }
     });
}


function getPenalty(penalty_id) {
      // alert(receive_bill_id);
      $.ajax({
      url: "getPenalty.php",
      cache: false,
      type: "POST",
      data: {penalty_id : penalty_id},
      success: function(response){
      $('#billPayDiv').html(response);
      
      
      }
      });
}



$(".docOnly1").change(function () {
     var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'jpg'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        
    }
});


$(".docOnly").change(function () {
     var fileExtension = ['jpeg', 'jpg', 'png', 'doc','docx', 'pdf', 'jpg','csv', 'xls' , 'xlsx'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        $('.idProof').val('');
    }
});

$(".idProof").change(function () {
     var fileExtension = ['jpeg', 'jpg', 'png', 'doc','docx', 'pdf', 'jpg'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        $('.idProof').val('');
    }
});

$(".photoOnly").change(function () {
     // alert(this.files[0].size);
     var fileExtension = ['jpeg', 'jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        $('.photoOnly').val('');
    }
});


//   21sept2020
$(".allow_decimal").keydown(function (evt) {
     var self = $(this);
   self.val(self.val().replace(/[^0-9\.]/g, ''));
 
 
   if ( evt.keyCode==190 &&  self.val().indexOf('.') > -1 ) 
   {
     evt.preventDefault();
   }

 if ($.inArray(evt.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (evt.keyCode == 65 && ( evt.ctrlKey === true || evt.metaKey === true ) ) || 
         // Allow: home, end, left, right, down, up
        (evt.keyCode >= 35 && evt.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((evt.shiftKey || (evt.keyCode < 48 || evt.keyCode > 57)) && (evt.keyCode < 96 || evt.keyCode > 105)) {
        evt.preventDefault();
    }

});
function DeleteGallaryFolder(delete_frame_id) {
    
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
 
                // $('form.deleteForm'+id).submit();
                $.ajax({
                url: "controller/utilityBannerController.php",
                cache: false,
                type: "POST",
                data: {delete_frame_id : delete_frame_id},
                success: function(response){
                   
                  if(response==1) {
                         swal("Folder has been deleted Successfully", {
                            icon: "success",
                          });
                    document.location.reload(true);
                  } else {
                         swal("Something Went wrong, Please try again.", {
                            icon: "error",
                          });
                  }
                }
              });

             
            } else {
              //swal("Your data is safe!");
            }
          });



}
//21sept2020

//22sept2020
function  getCityNew() {
  var state_id = $("#state_id").val();
  var cmp= "yes";
  $.ajax({
        url: "getCities.php",
        cache: false,
        type: "POST",
        data: {state_id : state_id,getCity:'getCity',cmp:cmp},
        success: function(response){
            $('#city_id').html(response);
          
            
        }
     });
}
//22sept2020

//23sept2020
function popitup(url) {
  newwindow=window.open(url,'name','height=800,width=800, location=0');
  if (window.focus) {newwindow.focus()}
  return false;
}
 /*$("body").on("click", "#btnExport", function () {
            html2canvas($('#pdfId')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("invoice");
                }
            });
        });*/
//23sept2020


//28sept
$(document).on('change', '#frame_id', function() { 
  
    var frame_id = $("#frame_id option:selected").val();

  
  $.ajax({
        url: "getFrame.php",
        cache: false,
        type: "POST",
        data: {frame_id : frame_id},
        success: function(response){
            $('#frame_img').html(response);
          
            
        }
     });
});
//28sept


//5oct2020
function  isUnlimited() {
   var is_unlimited = $("#is_unlimited option:selected").val();
  if(is_unlimited=="0"){
    $('#cpn_use_div').css('display','block');
    $('#cpn_use_lbl').css('display','block');
  } else {
    $('#cpn_use_div').css('display','none');
    $('#cpn_use_lbl').css('display','none');
  }
}

function  isLifeTime() {
   var cpn_expiry = $("#cpn_expiry option:selected").val();
  if(cpn_expiry=="1"){
    $('#cpn_date_div').css('display','block');
    
  } else {
    $('#cpn_date_div').css('display','none');
     
  }
}

//22feb21
function  isExpire() {
   var is_expiry = $("#is_expiry option:selected").val();
  if(is_expiry=="Yes"){
    $('#date_div').css('display','block');
    
  } else {
    $('#date_div').css('display','none');
     
  }
}

function  showToName() {
   var show_to_name = $("#show_to_name option:selected").val();
  if(show_to_name=="Yes"){
    $('#to_name_div').css('display','block');
   } else {
    $('#to_name_div').css('display','none');
     
  }
}

function  toNameDemo() {
   var to_name_font_name = $("#to_name_font_name option:selected").val();
   $('#demo_to_text').html('<span class="'+to_name_font_name+'">Greetings</span>');
}
function fromNameDemo(){
    var from_name_font_name = $("#from_name_font_name option:selected").val();
   $('#demo_from_text').html('<span class="'+from_name_font_name+'">Greetings</span>');
}
function descNameDemo(){
    var description_font_name = $("#description_font_name option:selected").val();
   $('#demo_desc_text').html('<span class="'+description_font_name+'">Greetings</span>');
}
function titleNameDemo(){
    var title_font_name = $("#title_font_name option:selected").val();
   $('#demo_title_text').html('<span class="'+title_font_name+'">Greetings</span>');
}


function  showFromName() {
   var show_from_name = $("#show_from_name option:selected").val();
  if(show_from_name=="Yes"){
    $('#from_name_div').css('display','block');
   } else {
    $('#from_name_div').css('display','none');
     
  }
}

 
/*$('.color-val').blur(function(){ 
   var colorval= $(this).val();
   var par_ele = $(this).closest('input').attr('id');
   alert($(this).closest('[id]').attr('id'));
   //alert($(this).closest('input').attr('id'));


    $('#'+par_ele).val(colorval);

});*/
//22feb21


$(document).on('click', '#generate', function() { 
  var isGen = 'yes';
   $.ajax({
        url: "getCpnCode.php",
        cache: false,
        type: "POST",
        data: {isGen : isGen},
        success: function(response){
            $('#coupon_code').val(response);
            $('#cpn_valid').val('1');
            $('#loader_cpn').html('');
          $('#coupon_code').valid();

            
        }
     });
});

$( "#coupon_code" ).keypress(function() {
  var isGen = 'no';
   var checkCPN = 'yes';
    var cpn_cod = $('#coupon_code').val();
    var isedit = $('#isedit').val();
    var coupon_id = 0 ; 
    if(isedit=="yes"){
      var coupon_id = $('#coupon_id').val();
    }
   $.ajax({
        url: "getCpnCode.php",
        cache: false,
        type: "POST",
        data: {isGen : isGen,checkCPN:checkCPN,cpn_cod:cpn_cod,coupon_id:coupon_id},
        beforeSend: function(){
        $('#loader_cpn').html('<center><i class="fa fa fa-spinner fa-2x mr-3 text-primary"></i></center>')
               
            },
        success: function(response){
           
           if(response==1){
            //$('#coupon_code_div').html(response);
             $('#loader_cpn').html('<center><i class="fa fa fa-check fa-2x mr-3 text-success"></i></center>')
             $('#cpn_valid').val('1');
          } else if(response==2 || response==0){
             $('#loader_cpn').html('<center><i class="fa fa fa-times fa-2x mr-3 text-danger"></i></center>')
             $('#cpn_valid').val('0');
          }
          
            
        }
     });
});


//2dec2020
 $( "#user_social_media_name" ).blur(function() {
  var isGen = 'no';
   var checkCPN = 'yes';
    var user_social_media_name = $('#user_social_media_name').val();
    var isedit = $('#isedit').val();
     
    if(isedit=="yes"){
      var user_id_edit = $('#user_id_edit').val();
    } else {
      var user_id_edit =0;
    }
   $.ajax({
        url: "chkSocialMediaName.php",
        cache: false,
        type: "POST",
        data: {isGen : isGen,checkCPN:checkCPN,user_social_media_name:user_social_media_name,user_id_edit:user_id_edit},
        beforeSend: function(){
        $('#loader_cpn').html('<center><i class="fa fa fa-spinner fa-2x mr-3 text-primary"></i></center>')
               
            },
        success: function(response){
          if(response==1){

             
             $('#loader_cpn').html('<center><i class="fa fa fa-check fa-2x mr-3 text-success"></i></center>')
        $('#user_social_media_name_valid').val('1');
          }
          if(  response==0){
           $('#loader_cpn').html('<center><i class="fa fa fa-times fa-2x mr-3 text-danger"></i></center>')
        $('#user_social_media_name_valid').val('0');
          }
          
            
        }
     });
});


 


//2dec2020
$( "#coupon_code" ).blur(function() {
  var isGen = 'no';
   var checkCPN = 'yes';
    var cpn_cod = $('#coupon_code').val();
   $.ajax({
        url: "getCpnCode.php",
        cache: false,
        type: "POST",
        data: {isGen : isGen,checkCPN:checkCPN,cpn_cod:cpn_cod},
        beforeSend: function(){
        $('#loader_cpn').html('<center><i class="fa fa fa-spinner fa-2x mr-3 text-primary"></i></center>')
               
            },
        success: function(response){
          
          if(response==1){
            //$('#coupon_code_div').html(response);
             $('#loader_cpn').html('<center><i class="fa fa fa-check fa-2x mr-3 text-success"></i></center>')
             $('#cpn_valid').val('1');
          } else if(response==2 || response==0){
             $('#loader_cpn').html('<center><i class="fa fa fa-times fa-2x mr-3 text-danger"></i></center>')
             $('#cpn_valid').val('0');
          }
          
            
        }
     });
});

 


$("#refer_friend_name").keypress(function (e) {

   setTimeout(function() {
   var refer_friend_name = $("#refer_friend_name").val();
   var userMobile = $("#userMobile").val();
  
   if(refer_friend_name.length > 2 ){
      $.ajax({
        url: "getRefUsers.php",
        cache: false,
        type: "POST",
        data: {refer_friend_name : refer_friend_name,userMobile:userMobile},
        success: function(response){
            $('#refer_friend_id').html(response);
          
            
        }
     });
   }
  
  }, 0);
   
});
  

if($('#refer_friend_name').length){

 var inputxx = document.getElementById('refer_friend_name');

inputxx.onkeydown = function() {
    var key = event.keyCode || event.charCode;
     
    if( key == 8 ){
      var refer_friend_name = $("#refer_friend_name").val();
       var userMobile = $("#userMobile").val();
           if(refer_friend_name.length > 3 ){
              $.ajax({
                url: "getRefUsers.php",
                cache: false,
                type: "POST",
                data: {refer_friend_name : refer_friend_name ,userMobile:userMobile },
                success: function(response){
                    $('#refer_friend_id').html(response);
                  
                    
                }
             });
           } else {
            $('#refer_friend_id').html('');
           }
    }
};
}


$('#refer_friend_name').change(function() {
   var refer_friend_name = $("#refer_friend_name").val();
   if(refer_friend_name.length ==0 ){
       $('#refer_friend_id').html('');
   }
});



//5oct2020
//7oct2020
function  referBy() {
    var refer_by = $("#refer_by option:selected").val();
   
    if(refer_by=="2"){
      $('#remark_lbl').css('display','none');
      $('#remark_div').css('display','none');

      $('#refere_by_name_lbl').css('display','none');
      $('#refere_by_name_div').css('display','none');

      $('#refere_by_phone_number_lbl').css('display','none');
      $('#refere_by_phone_number_div').css('display','none');

$('#refere_by_user_div').css('display','block');
$('#refere_by_user_div2').css('display','block');
      


    } else if(refer_by=="3"){
      $('#refere_by_user_div').css('display','none');
$('#refere_by_user_div2').css('display','none');

      $('#refere_by_name_lbl').css('display','none');
      $('#refere_by_name_div').css('display','none');

      $('#refere_by_phone_number_lbl').css('display','none');
      $('#refere_by_phone_number_div').css('display','none');

      $('#remark_lbl').css('display','block');
      $('#remark_div').css('display','block');
    } else {
            $('#refere_by_user_div').css('display','none');
$('#refere_by_user_div2').css('display','none');
        $('#refere_by_name_lbl').css('display','none');
      $('#refere_by_name_div').css('display','none');

      $('#refere_by_phone_number_lbl').css('display','none');
      $('#refere_by_phone_number_div').css('display','none');

      $('#remark_lbl').css('display','none');
      $('#remark_div').css('display','none');
    }
}
//7oct2020

//29oct
$("input[type='radio']").click(function(){
            var radioValue = $("input[name='time_slab']:checked").val();
            
            if(radioValue == 0){
              $('#time_slab_lbl').text('Month');
               // alert("Your are a - " + radioValue);
            } else if(radioValue == 1 ){
              $('#time_slab_lbl').text('Days');
               // alert("Your are a - " + radioValue);
            } else {
              $('#time_slab_lbl').text('Month');
            }
        });

 $(document).on("click", ".open-AddBookDialog", function () {
   
   var event_date = $(this).data('eventdate');
   var event_end_date = $(this).data('eventenddate');
   var description = $(this).data('description');
    var event_name_data = $(this).data('eventname');
    var eventstatus_data = $(this).data('eventstatus');
  
  $(".modal-body #event_name_data").text( '' );
 $(".modal-body #description_data").text( '' );
   $(".modal-body #event_date_data").text( '' );
    $(".modal-body #event_end_date_data").text( '' );
   $(".modal-body #eventstatus_data").text( '' );

$(".modal-body #event_name_data").text(event_name_data);
   $(".modal-body #description_data").text( description );
   $(".modal-body #event_date_data").text( event_date );
   
   $(".modal-body #event_end_date_data").text( event_end_date );
    $(".modal-body #eventstatus_data").text( eventstatus_data );
   });
//29oct


//30oct2020
function getNewPriceDiscountFlat() {
   var coupon_amount = parseFloat($('#coupon_amount').val());
    if (coupon_amount>0) {
       $('#coupon_per').val('0');
       $('#coupon_per').attr('min','0');
    }
 }
 function getNewPriceDiscountPer() {
    var coupon_per = parseFloat($('#coupon_per').val());
    if (coupon_per > 0) {
       $('#coupon_amount').val('0.00');
       $('#coupon_amount').attr('min','0');
    }
 }

 function planDetails(){
   var plan_id = $("#plan_id option:selected").val();
 
  $.ajax({
        url: "getPlanDetails.php",
        cache: false,
        type: "POST",
        data: {plan_id : plan_id},
        success: function(response){
          $('#coupon_amount').attr('max', response);

             
        }
     });
 }
//30oct2020

//19JAN2020
function hideNewsFeedInfo(timline_id){
 
if( $('#showNewsFeedIfo'+timline_id).css('display') == 'block' ) {
  $('#showNewsFeedIfo'+timline_id).css('display','none');
} else {
   $('#showNewsFeedIfo'+timline_id).css('display','block');
}


}
//19JAN2020

//5nov2020
function  isPaidUser() {
   var is_paid = $("#is_paid option:selected").val();
 
   if(is_paid=="0"){
    $('#lbl_paid').css('display','block');
    $('#div_paid').css('display','block');
  } else {
    $('#lbl_paid').css('display','none');
    $('#div_paid').css('display','none');
  }
}
//5nov2020

//4DEC2020
$('.lang_chk').change(function() {
 var elmId = $(this). attr("id");
 
   if(this.checked) {
       $('#detail_div'+elmId).css('display','block');
        
   } else {
    $('#detail_div'+elmId).css('display','none');
 
  
    }
       
  });


$('.key_name_cls').change(function() {
 var elmId = $(this). attr("id");
 
   if(this.checked) {
       $('#txt_div'+elmId).css('display','block');
        
   } else {
    $('#txt_div'+elmId).css('display','none');
 
  
    }
       
  });
//4DEC2020