<!--Site Footer Here-->
<!-- <footer id="site-footer" class=" bgdark padding_top">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="footer_panel padding_bottom_half bottom20 pl-0 pl-lg-5">
          <h4 class="whitecolor bottom25">© Copyright <?php echo date("Y");?> By ZooBiz | <a href="termsConditions"> Terms & Conditions </a></h4>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <h4 class="whitecolor bottom25"> Developed by <a href="https://www.silverwingtechnologies.com" target="_blank"> Silverwing Technologies Pvt. Ltd.</a> </h4>
      </div>
    </div>
  </div>
</footer> -->
<footer id="site-footer" class="bgdark pt-5">
  <div class="container">
    <div class="text-center text-white footer_panel padding_bottom_half pt-5">
      <a href="index#pricing"> Plans </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="about"> About Us </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="index#contact"> Contact Us </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="termsConditions"> Terms & Conditions </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="privacyPolicy"> Privacy Policy </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="cancellationPolicy"> Cancellation Policy </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="refundPolicy"> Refund Policy </a>
    </div>
    <div class="text-center text-white pb-2">
      © Copyright 2020 By ZooBiz
    </div>
    <div class="text-center text-white pb-5">
      Developed by <a href="https://www.silverwingtechnologies.com" target="_blank"> Silverwing Technologies Pvt. Ltd.</a>
    </div>
  </div>
</footer>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.4.1.min.js"></script>
<!--Bootstrap Core-->
<script src="js/propper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--to view items on reach-->
<script src="js/jquery.appear.js"></script>
<!--Owl Slider-->
<script src="js/owl.carousel.min.js"></script>
<!--number counters-->
<script src="js/jquery-countTo.js"></script>
<!--Parallax Background-->
<script src="js/parallaxie.js"></script>
<!--Cubefolio Gallery-->
<script src="js/jquery.cubeportfolio.min.js"></script>
<!--Fancybox js-->
<script src="js/jquery.fancybox.min.js"></script>
<!--Tooltip js-->
<script src="js/tooltipster.min.js"></script>
<!--wow js-->
<script src="js/wow.js"></script>
<!--Revolution SLider-->
<script src="js/jquery.themepunch.tools.min.js"></script>
<script src="js/jquery.themepunch.revolution.min.js"></script>
<!-- SLIDER REVOLUTION 5.0 EXTENSIONS -->
<script src="js/revolutionextensions/revolution.extension.actions.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.carousel.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.kenburn.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.layeranimation.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.migration.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.navigation.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.parallax.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.slideanims.min.js"></script>
<script src="js/revolutionextensions/revolution.extension.video.min.js"></script>
<!--map js-->
<?php
//old AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A
//new AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY"></script>
<script src="js/map.js"></script>
<!--Form Validatin Script-->
<script src="js/jquery.validate.min.js"></script>
<script src="js/validate12.js"></script>
<script src="js/functions3.js"></script>
<script src="js/custom10.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/jquery-multi-select/jquery.multi-select.js"></script>
<script src="assets/plugins/jquery-multi-select/jquery.quicksearch.js"></script>
<script type="text/javascript" src="assets/js/select.js"></script>
<?php //CCAVENUE CHANGE ?>
<script language="javascript" type="text/javascript" src="js/json.js"></script>
<script type="text/javascript">

  $('#addNewMemberccAvenue').on("click",function(event) {
    $("#registerFrm").attr("action", "controller/ccavRequestHandler.php");
    if($('#coupon_code').val() ==""){
      $("#chkError").html('');
      $("#chkError").removeClass('text-danger');
    }
    event.preventDefault();

   // var salutation = $("#salutation").val();
    var plan_id = $("#plan_id").val();
    var user_first_name = $("#user_first_name").val();
    var user_last_name = $("#user_last_name").val();
    var user_email = $("#user_email").val();
    var user_mobile = $("#user_mobile").val();
    var city_id = $("#city_id").val();
    var gender = $('input[name="gender"]:checked').val();
    var refer_by = $("#refer_by option:selected").val();
    if(refer_by==2){
      var refere_by_name = $("#refere_by_name").val();
      var refere_by_phone_number = $("#refere_by_phone_number").val();
      var refer_friend_id = $("#refer_friend_id option:selected").val();
    } else {
      var refere_by_name = "NULL";
      var refere_by_phone_number = "NULL";
      var refer_friend_id = "-1";
    }
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (!testEmail.test(user_email)){
      user_email ='';
      $("#user_email").val('');
    }
    if(     $.trim(plan_id) ==""   || $.trim(user_first_name) =="" || $.trim(user_last_name) =="" || $.trim(user_email) =="" || $.trim(user_mobile) =="" || $.trim(refer_by) ==""     || $.trim(refer_friend_id) =="" || $.trim(refer_friend_id) =="0"  ){

      if($('#registerFrm').valid() == true){
        $( "#registerFrm" ).submit();
      }

    } else {

      event.preventDefault();
      var user_mobile= $('#user_mobile').val();
      var cpn_success = $('#cpn_success').val();
      var coupon_code = $('#coupon_code').val();
      var cpn_success_n = $('#cpn_success').val();
      if(cpn_success_n==0){
        coupon_code ='';
      }
      $.ajax({
        url: "controller/registerController.php",
        cache: false,
        type: "POST",
        data: {city_id : city_id,plan_id:plan_id,user_first_name:user_first_name,user_last_name:user_last_name,user_email:user_email,gender:gender,userMobile : user_mobile,checkUserMobileFormSubmit:'checkUserMobileFormSubmit'},
        success: function(response){
          if (response==1) {
            swal("Error", "This mobile number is Already Registered.", "error");
            event.preventDefault();
          } else {
            if(cpn_success ==1){
              if($('#registerFrm').valid() == true){

                $( "#registerFrm" ).submit();
              } else {
                alert("Error !");
              }
            } else {
              $( "#registerFrm" ).submit();

            }

          }
        }
      });
    }
  });



$('#addNewMemberPayTm').on("click",function(event) {
 
    $("#registerFrm").attr("action", "controller/pgRedirect.php");
    if($('#coupon_code').val() ==""){
      $("#chkError").html('');
      $("#chkError").removeClass('text-danger');
    }
    event.preventDefault();

   
    var plan_id = $("#plan_id").val();
    var user_first_name = $("#user_first_name").val();
    var user_last_name = $("#user_last_name").val();
    var user_email = $("#user_email").val();
    var user_mobile = $("#user_mobile").val();
    var city_id = $("#city_id").val();
    var gender = $('input[name="gender"]:checked').val();
    var refer_by = $("#refer_by option:selected").val();
    if(refer_by==2){
      var refere_by_name = $("#refere_by_name").val();
      var refere_by_phone_number = $("#refere_by_phone_number").val();
      var refer_friend_id = $("#refer_friend_id option:selected").val();
    } else {
      var refere_by_name = "NULL";
      var refere_by_phone_number = "NULL";
      var refer_friend_id = "-1";
    }
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (!testEmail.test(user_email)){
      user_email ='';
      $("#user_email").val('');
    }
    if(    $.trim(plan_id) ==""   || $.trim(user_first_name) =="" || $.trim(user_last_name) =="" || $.trim(user_email) =="" || $.trim(user_mobile) =="" || $.trim(refer_by) ==""     || $.trim(refer_friend_id) =="" || $.trim(refer_friend_id) =="0"  ){

      if($('#registerFrm').valid() == true){
        $( "#registerFrm" ).submit();
      }

    } else {

      event.preventDefault();
      var user_mobile= $('#user_mobile').val();
      var cpn_success = $('#cpn_success').val();
      var coupon_code = $('#coupon_code').val();
      var cpn_success_n = $('#cpn_success').val();
      if(cpn_success_n==0){
        coupon_code ='';
      }
      $.ajax({
        url: "controller/registerController.php",
        cache: false,
        type: "POST",
        data: {city_id : city_id,plan_id:plan_id,user_first_name:user_first_name,user_last_name:user_last_name,user_email:user_email,gender:gender,userMobile : user_mobile,checkUserMobileFormSubmit:'checkUserMobileFormSubmit'},
        success: function(response){
          if (response==1) {
            swal("Error", "This mobile number is Already Registered.", "error");
            event.preventDefault();
          } else {
            if(cpn_success ==1){
              if($('#registerFrm').valid() == true){

                $( "#registerFrm" ).submit();
              } else {
                alert("Error !");
              }
            } else {
              $( "#registerFrm" ).submit();

            }

          }
        }
      });
    }
  });

</script>
<?php //CCAVENUE CHANGE ?>
<script type="text/javascript">
  $('#coupon_code').keyup(function(){
    this.value = this.value.toUpperCase();
  });
  $("#city_id").change(function () {
    if($('#cpn_success').val() != 0){
      $('#removeCpn').click();
    }
    $('#coupon_code').val('');
    $('#cpn_success').val('0');
    $("#chkError").html('');
    $("#plan_id").attr('disabled',false);
    $("#plan_id option[value=0]").attr('selected', 'selected');
    $("#plan_id").prop('selected', false);
    <?php //CCAVENUE CHANGE ?>
    var sel_city_id =   $('#city_id').val();
    $.ajax({
      url: "ajax/getGatewayDatas.php",
      cache: false,
      type: "POST",
      data: {sel_city_id : sel_city_id},
      success: function(response){
        $('#gateway_div').html(response);
        $('#gateway_div').css('display', 'block');
      }
    });
    <?php //CCAVENUE CHANGE ?>
  });
  <?php //CCAVENUE CHANGE ?>
  function setCCAvenue(){
    $('.dynamicId').css('display','none');
    $('.dynamicIdPayTm').css('display','none');
    $('.dynamicIdCCAV').css('display','block');
  }
  function setPayTm(){
    $('.dynamicId').css('display','none');
    $('.dynamicIdCCAV').css('display','none');
    $('.dynamicIdPayTm').css('display','block');
  }
  function setRazorPay(){
//$('.dynamicId').attr('id','addNewMember');
$('.dynamicId').css('display','block');
$('.dynamicIdPayTm').css('display','none');
$('.dynamicIdCCAV').css('display','none');
}
<?php //CCAVENUE CHANGE ?>
/*$("input[name='payment_gateway_name']").click(function(){
alert('You clicked radio!');
if($('input:radio[name=type]:checked').val() == "walk_in"){
alert($('input:radio[name=type]:checked').val());
//$('#select-table > .roomNumber').attr('enabled',false);
}
});*/
$('#ccav_gateway').click(function(){
  alert('changed');
});
/* $("#user_mobile").change(function () {
checkMobileUser();


});*/
//timeline front start
function viewLikes(timeline_id) {
  $.ajax({
    url: "zooAdmin/getLikeDetails.php",
    cache: false,
    type: "POST",
    data: {timeline_id : timeline_id},
    success: function(response){
      $('#likeResp').html(response);
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
  url: "zooAdmin/controller/newsFeedController.php",
  cache: false,
  type: "POST",
  data: {feed_id_delete_new : feed_id},
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
//timeline front end
$("#user_mobile").keypress(function (e) {
  setTimeout(function() {
    var user_mobile = $("#user_mobile").val();
    if(user_mobile.length >= 10 ){
      checkMobileUser();
    }
  }, 0);
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
$( "#user_mobile" ).focus(function() {
  $('#addNewMember').attr('disabled',true);
});
function checkMobileUser() {
  var user_mobile= $('#user_mobile').val();
// alert(user_mobile);
if (user_mobile.length == 10) {
  $.ajax({
    url: "controller/registerController.php",
    cache: false,
    type: "POST",
    data: {userMobile : user_mobile,checkUserMobile:'checkUserMobile'},
    success: function(response){
      $('#addNewMember').attr('disabled',false);
      if (response==2) {
// document.getElementById("addNewMember").disabled=true;
swal("Error", "Your Account Is Deactivated, Please Contact ZooBiz Support Team.", "error");
$('#user_mobile').val('');
return true;
} else if (response==1) {
// document.getElementById("addNewMember").disabled=true;
swal("Error", "Number Already Registered.", "error");
$('#user_mobile').val('');
return true;
} else {
  return false;
// document.getElementById("addNewMember").disabled=false;
}
}
});
} else {
  swal("Error", "Enter 10 Digit Mobile Number", "error");
}
}
// $( "#registerFrm" ).submit(function( event ) {
//5oct2020
$('#removeCpn').on("click",function(event) {
  $('#ApplyCpn').css('display','block');
  $('#removeCpn').css('display','none');
  $("#cpn_success").val('0');
/*  $("#plan_id option[value='']").attr('selected', 'selected');
var sel = "--Select--";
$('#plan_id :selected').text(sel.toUpperCase());*/
$("#plan_id").attr('disabled',false);
$("#chkError").html('');
$("#plan_id_temp").val('0');
$("#coupon_code").val('');
$("#plan_id").val('0');
$("#plan_id option[value=''").attr('selected', 'selected');
$("#plan_containere_div").css('display','block');
$('#coupon_code').prop('readonly', false);
});
$('#ApplyCpn').on("click",function(event) {
  var coupon_code = $('#coupon_code').val();
  $.ajax({
    url: "ajax/checkCouponValidity.php",
    type: "POST",
    data: {coupon_code : coupon_code},
    success: function(response){
      var fields = response.split('~');

      $('#gateway_div').css('display','block');
      $("#plan_containere_div").css('display','block');
      $("#plan_id").attr('disabled',false);
      $("#plan_id_temp").val('');
      $('#plan_id').prop('readonly', false);
      $("#chkError").removeClass('text-danger');
      $("#chkError").removeClass('text-success');
      $("#cpn_success").val('0');
      if(fields[0]=="0"){
        $("#chkError").addClass('text-danger');
        $("#chkError").html('<label id="chkError-error" class="error" for="chkError">Invalid Coupon Code</label>');
      } else if(fields[0]=="1"){
        $("#chkError").addClass('text-success');
        $("#plan_containere_div").css('display','none');
        $("#plan_id").val(fields[2]);
        $("#plan_id option[value="+fields[2]+"]").attr('selected', 'selected');
//3nov 2020
if(fields[3]==0){
  $("#cpn_success").val('1');

  $('#gateway_div').css('display','none');

} else {
  $("#cpn_success").val('2');
  $('#gateway_div').css('display','block');
}
//3nov 2020

$("#chkError").html('<label id="chkError-error" class="" for="chkError">Coupon Applied Successfully for "'+fields[1]+'".</label>');
// $("#city_id").attr('disabled',true);
//  $('#plan_id :selected').text(fields[1].toUpperCase());
$("#plan_id_temp").val(fields[2]);
//  $("#plan_id option[value="+fields[2]+"]").attr('selected', 'selected');
//$('#plan_id').prop('readonly', true);
//$( "#registerFrm" ).submit();
$('#removeCpn').css('display','block');
$('#ApplyCpn').css('display','none');
$('#coupon_code').prop('readonly', true);
} else if(fields[0]=="4"){
  $("#chkError").addClass('text-danger');
  $("#chkError").html('<label id="chkError-error" class="error" for="chkError">Coupon Limit Exceeded, or coupon not Available</label>');
} else if(fields[0]=="3"){
  $("#chkError").addClass('text-danger');
  $("#chkError").html('<label id="chkError-error" class="error" for="chkError">Invalid Coupon Code</label>');
}  else if(fields[0]=="5"){
  $("#chkError").addClass('text-danger');
  $("#chkError").html('<label id="chkError-error" class="error" for="chkError">Coupon Not Available</label>');
}  else {
  $("#chkError").addClass('text-danger');
  $("#chkError").html('<label id="chkError-error" class="error" for="chkError">Invalid Coupon Code</label>');
}

}
});
});
//5oct2020
$('#addNewMember').on("click",function(event) {
//30nov2020
if($('#coupon_code').val() ==""){
  $("#chkError").html('');
  $("#chkError").removeClass('text-danger');
}
//30nov2020
event.preventDefault();

var plan_id = $("#plan_id").val();
var user_first_name = $("#user_first_name").val();
var user_last_name = $("#user_last_name").val();
var user_email = $("#user_email").val();
var user_mobile = $("#user_mobile").val();
var city_id = $("#city_id").val();
// var whatsapp_number = $("#whatsapp_number").val();
// var member_date_of_birth = $("#autoclose-datepicker-dob").val();
var gender = $('input[name="gender"]:checked').val();

// var company_name = $("#company_name").val();
// var designation = $("#designation").val();
// var gst_number = $("#gst_number").val();
// var company_website = $("#company_website").val();
// var business_categories_sub = $("#business_categories_sub").val();
// var adress = $("#adress").val();
// var country_id = $("#country_id").val();
// var state_id = $("#state_id").val();
// var city_id = $("#city_id").val();
// var area_id = $("#area_id").val();
// var pincode = $("#pincode").val();
// var latitude = $("#lat").val();
// var longitude = $("#lng").val();
//9nov 2020
var refer_by = $("#refer_by option:selected").val();
if(refer_by==2){
  var refere_by_name = $("#refere_by_name").val();
  var refere_by_phone_number = $("#refere_by_phone_number").val();
  var refer_friend_id = $("#refer_friend_id option:selected").val();
} else {
  var refere_by_name = "NULL";
  var refere_by_phone_number = "NULL";
  var refer_friend_id = "-1";
}
var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
if (!testEmail.test(user_email)){
  user_email ='';
  $("#user_email").val('');
}
/* alert( $.trim(plan_id) +'=="" ||'+ $.trim(user_first_name) +'=="" ||'+ $.trim(user_last_name) +'=="" ||'+ $.trim(user_email) +'=="" ||'+ $.trim(user_mobile) +'=="" ||'+ $.trim(refer_by) +'=="" ||'+ $.trim(refer_friend_id) +'=="" ||'+ $.trim(refer_friend_id)+'=="0" ' );
event.preventDefault(); */
// $.trim(refere_by_phone_number) =="" || refere_by_phone_number.length <10
if(   $.trim(plan_id) ==""   || $.trim(user_first_name) =="" || $.trim(user_last_name) =="" || $.trim(user_email) =="" || $.trim(user_mobile) =="" || $.trim(refer_by) ==""     || $.trim(refer_friend_id) =="" || $.trim(refer_friend_id) =="0"  ){
  if($('#registerFrm').valid() == true){
    $( "#registerFrm" ).submit();
}  /*else {
swal("Error ! Please Provide all required informations...!", {icon: "error", });
}*/
} else {
  event.preventDefault();
  var user_mobile= $('#user_mobile').val();
//5oct2020
var cpn_success = $('#cpn_success').val();
//3nov 2020

var coupon_code = $('#coupon_code').val();
var cpn_success_n = $('#cpn_success').val();
if(cpn_success_n==0){
  coupon_code ='';
}

//3nov 2020
$.ajax({
  url: "controller/registerController.php",
  cache: false,
  type: "POST",
  data: {city_id : city_id,plan_id:plan_id,user_first_name:user_first_name,user_last_name:user_last_name,user_email:user_email,gender:gender,userMobile : user_mobile,checkUserMobileFormSubmit:'checkUserMobileFormSubmit'},
  success: function(response){
    if (response==1) {
      swal("Error", "This mobile number is Already Registered.", "error");
      event.preventDefault();
    } else {
//5oct2020

if(cpn_success ==1){
  if($('#registerFrm').valid() == true){
    $( "#registerFrm" ).submit();
  } else {
    alert("Error !");
  }
} else {
//5oct2020
// $( "#registerFrm" ).submit();
$.ajax({
  url: "ajax/getPayRazorPay.php",
  type: "POST",
//3nov 2020 ,coupon_code:coupon_code
data: {plan_id : plan_id,city_id : city_id,user_first_name : user_first_name,user_last_name : user_last_name,user_email:user_email,user_mobile:user_mobile,coupon_code:coupon_code},
success: function(response){
  var options = jQuery.parseJSON(response);
  options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    if($('#registerFrm').valid() == true){
      $( "#registerFrm" ).submit();
    } else {
      alert("Error !");
    }
//document.razorpayform.submit();
};
// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;
options.modal = {
  ondismiss: function() {
  },
// Boolean indicating whether pressing escape key
// should close the checkout form. (default: true)
escape: true,
// Boolean indicating whether clicking translucent blank
// space outside checkout form should close the form. (default: false)
backdropclose: false
};
var rzp = new Razorpay(options);
rzp.open();
}
});
}
//5oct2020 only curly bracket end
}
}
});
}
});
function  PayRarorPay() {}
</script>
<!--custom functions and script-->
<script>
  /* script */
  if($("#lat").length){
    function initialize() {
// var latlng = new google.maps.LatLng(23.05669,72.50606);

var latitute =document.getElementById('lat').value;
var longitute =document.getElementById('lng').value;
var latlng = new google.maps.LatLng(latitute,longitute);
var map = new google.maps.Map(document.getElementById('map'), {
  center: latlng,
  zoom: 13
});
var marker = new google.maps.Marker({
  map: map,
  position: latlng,
  draggable: true,
  anchorPoint: new google.maps.Point(0, -29)
// icon:'img/direction/'+dirction+'.png'
});
var parkingRadition = 5;
var citymap = {
  newyork: {
    center: {lat: latitute, lng: longitute},
    population: parkingRadition
  }
};

var input = document.getElementById('searchInput5');
// map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
var geocoder = new google.maps.Geocoder();
var autocomplete10 = new google.maps.places.Autocomplete(input);
autocomplete10.bindTo('bounds', map);
var infowindow = new google.maps.InfoWindow();
autocomplete10.addListener('place_changed', function() {
  infowindow.close();
  marker.setVisible(false);
  var place5 = autocomplete10.getPlace();
  if (!place5.geometry) {
    window.alert("Autocomplete's returned place5 contains no geometry");
    return;
  }
// If the place5 has a geometry, then present it on a map.
if (place5.geometry.viewport) {
  map.fitBounds(place5.geometry.viewport);
} else {
  map.setCenter(place5.geometry.location);
  map.setZoom(17);
}

marker.setPosition(place5.geometry.location);
marker.setVisible(true);

var pincode="";
for (var i = 0; i < place5.address_components.length; i++) {
  for (var j = 0; j < place5.address_components[i].types.length; j++) {
    if (place5.address_components[i].types[j] == "postal_code") {
      pincode = place5.address_components[i].long_name;
// alert(pincode);
}
}
}
bindDataToForm(place5.formatted_address,place5.geometry.location.lat(),place5.geometry.location.lng(),pincode,place5.name);
infowindow.setContent(place5.formatted_address);
infowindow.open(map, marker);
});
// this function will work on marker move event into map
google.maps.event.addListener(marker, 'dragend', function() {
  geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        var places = results[0]       ;
        console.log(places);
        var pincode="";
        var serviceable_area_locality= places.address_components[4].long_name;
// alert(serviceable_area_locality);
for (var i = 0; i < places.address_components.length; i++) {
  for (var j = 0; j < places.address_components[i].types.length; j++) {
    if (places.address_components[i].types[j] == "postal_code") {
      pincode = places.address_components[i].long_name;
// alert(pincode);
}
}
}
bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng(),pincode,serviceable_area_locality);
// infowindow.setContent(results[0].formatted_address);
// infowindow.open(map, marker);
}
}
});
});
}
}
function bindDataToForm(address,lat,lng,pin_code,serviceable_area_locality){
// document.getElementById('poi_point_address').value = address;
document.getElementById('lat').value = lat;
document.getElementById('lng').value = lng;
document.getElementById('pincode').value = pin_code;
// document.getElementById('serviceable_area_locality').value = serviceable_area_locality;
// document.getElementById("POISubmitBtn").removeAttribute("hidden");
// initialize();
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
  <?php $dateOneYearAdded = date("Y-m-d", strtotime(" -15 year")) ;?>
  var date = new Date();
  date.setDate(date.getDate());
  var startDate =new Date('<?php echo $dateOneYearAdded; ?>');
  $('#autoclose-datepicker-dob').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy-mm-dd',
    startDate:startDate,
    setDate:startDate,
    endDate:date
  });
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5ead581c203e206707f8dc74/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
  })();
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="assets/plugins/notifications/js/notifications.min.js"></script>
<script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
<!--Sweet Alerts -->
<!-- <script src="assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>
  <script src="assets/plugins/alerts-boxes/js/sweet-alert-script.js"></script> -->
  <script src="js/jquery.sweet-alert.init.js"></script>
  <script src="assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>
  <script src="assets/plugins/alerts-boxes/js/sweet-alert-script.js"></script>
  <?php if(isset($_SESSION['msg'])) { ?>
    <script type="text/javascript">
      swal({
        title: "Success!",
        icon: "success",
        text: "<?php echo $_SESSION['msg']; ?>",
// type: "success",
timer: 3000
});
</script>
<?php
unset($_SESSION['msg']);
} elseif (isset($_SESSION['msg1'])) { ?>
  <script type="text/javascript">
    swal({
      title: "Error!",
      icon: "error",
      text: "<?php echo $_SESSION['msg1']; ?>",
// type: "error",
timer: 4000
});
</script>
<?php
unset($_SESSION['msg1']);
} ?>
</body>
</html>