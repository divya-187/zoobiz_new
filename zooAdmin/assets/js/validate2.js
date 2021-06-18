$().ready(function() {

    $.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
           && /[A-Z]/.test(value) // has a lowercase letter
           && /\d/.test(value) // has a digit
       }  , "<br />Your password must be at least 5 characters long and require alphanumeric values."

       );
    //message added 21sept2020

    $.validator.addMethod("addressCheck", function(value) {
        /*alert(value);*/
        /*alert((/^[A-Za-z ]+/.test(value) || value==""  ))*/
         return /^[A-Za-z 0-9\d=!,\n\-@._*]*$/.test(value) // consists of only these
            && (/\w*[a-zA-Z ]\w*/.test(value) || value==''  )// has a lowercase letter
           // && /\d/.test(value) // has a digit
       });

    jQuery.validator.addMethod("acceptName", function(value, element, param) {
        return value.match(new RegExp("." + param + "$"));
    });


    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]*$/);
    }, jQuery.validator.format("Please enter a Valid Name."));

    $.validator.addMethod("alphaRestSpeChartor", function(value, element) {
        return this.optional(element) || value == value.match(/^[A-Za-z 0-9\d=!,:\n\-@&()/?%._*]*$/);
    }, jQuery.validator.format("special characters not allowed"));


    $.validator.addMethod("noSpace", function(value, element) { 
        return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");

 

    $.validator.addMethod('minStrict', function (value, el, param) {
        return value >= param;
    });

    jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
            || (Number(value) > Number($(params).val())); 
        },'Must be greater than {0}.');

    jQuery.validator.addMethod("image", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, jQuery.validator.format("Please add a valid image file."));


    $('input[type="file"]').change(function(){
        $(this).valid()
    });

    //IS_639 divya
    $.validator.addMethod('filesize', function (value, element, arg) {
        var size =3000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }

    }, $.validator.format("file size must be less than or equal to 3MB."));



//18sept2020
 $.validator.addMethod('filesize2MB', function (value, element, arg) {
        var size =2000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }

    }, $.validator.format("file size must be less than or equal to 2MB."));

//18sept2020

    //21FEB2020
    $.validator.addMethod('filesize1MB', function (value, element, arg) {
        var size =1097152;
        if(element.files.length){
            if(element.files[0].size<size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than  1MB."));

    $.validator.addMethod('MaxUploadFile', function (value, element, arg) {
        var FIlelength = 20;

        if(element.files.length <= FIlelength){

            return true;
        }else{
            return false;
        }
    }, $.validator.format("You are allowed to upload only maximum 20 files at a time"));

    //21FEB2020


    //24feb2020
    $.validator.addMethod("extension", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    },$.validator.format("Please select a file with a valid extension (png,jpeg,jpg,gif)."));

    $.validator.addMethod("extensionDoc", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif|pdf";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, $.validator.format("Please select a file with a valid extension (png,jpeg,jpg,gif,pdf)."));

    $.validator.addMethod('filesize4MB', function (value, element, arg) {
        var size =4000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than or equal to 4MB."));
    //24feb2020
    $.validator.addMethod('filesize2MB', function (value, element, arg) {
        var size =2000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than or equal to 2MB."));

    $.validator.addMethod("extensionDocument", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|txt|xls|csv|pdf|docx|odt|ods|xlsx";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    },$.validator.format("Please select a file with a valid extension (png,jpeg,jpg,txt,xls,csv,pdf,docx,odt,ods,xlsx)."));

    $.validator.addMethod('compare', function (value, element, param) {
        return this.optional(element) || parseInt(value) > 0 || parseInt($(param).val()) > 0;
    }, $.validator.format('Invalid value'));


    //19march2020 eve
    $.validator.addMethod('filesize12MB', function (value, element, arg) {
        var size =12000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than or equal to 12MB."));
 //19march2020   

 $("#personal-info").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        }
    });
 $("#personal-info1").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            parking_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'UniqueParkingName.php',
                    type: "post",
                    data:
                    {
                        oldParkingName: function()
                        {
                            return $('#personal-info1 :input[name="parking_name"]').val();
                        },
                        society_parking_id: function()
                        {
                            return $('#personal-info1 :input[name="society_parking_id"]').val();
                        }, 
                        society_id: function()
                        {
                            return $('#personal-info1 :input[name="society_id"]').val();
                        } 
                        , 
                        parking_id: function()
                        {
                            return $('#personal-info1 :input[name="parking_id"]').val();
                        } 
                    } 
                }
            }
        },
        messages: {
            parking_name: {
            //2march2020 -new
            required: "Please enter Parking Name", 
            remote: "Parking Name is already exists, please use another parking name to avoid confusion"
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
    //28feb2020
});




    //IS_914  //2march2020 -new
    $("#addAddress").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             //18sept2020 start
            user_id:{
                required:true
            },
            country_id:{
                required:true
            },
            state_id:{
                required:true
            },
            city_id:{
                required:true
            },
            area_id:{
                required:true
            },
             //18sept2020 end
            adress: {
                required: true,
                noSpace:true 
            },
            pincode:{
                required:true
            }, 
            booked_date:{
                required:true
            }
            
        },
        messages: {
             //18sept2020 start
            user_id:{
                required:"please select member"
            },
            country_id:{
                required:"please select country"
            },
            state_id:{
                required:"please select state"
            },
            city_id:{
                required:"please select city"
            },
            area_id:{
                required:"please select area"
            },
            //18sept2020 end
            adress: {
                required: "Please enter address", 
            },
            pincode:{
                required: "Please enter pincode"
            },
            booked_date:{
                required:"please select booking date"
            }
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });
    $("#payFacilityFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            payment_type: {
                required: true,
                noSpace:true 
            } ,
            payment_bank:{
                required:{
                    depends: function(element) { 
                      return $('#payFacilityFrm :input[name="payment_type"]').val() =="1"  || $('#payFacilityFrm :input[name="payment_type"]')=="2" ;
                  }
              },
              noSpace:true 
          },
          payment_number:{
            required:{
                depends: function(element) {
                   return $('#payFacilityFrm :input[name="payment_type"]').val() =="1"  || $('#payFacilityFrm :input[name="payment_type"]')=="2" ;
               }
           },
           noSpace:true 
       }
   },
   messages: {
    payment_type: {
        required: "Please select Payment Type", 
    },
    
    payment_bank:{
        required:"Please enter bank name"
    },
    payment_number:{
        required:"Please enter reference number"
    }
},
submitHandler: function(form) {
    $(':input[type="submit"]').prop('disabled', true);
    form.submit(); 
}

});
    
    //IS_914 //2march2020 -new




    
    $("#personal-info2").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        }
    });
    $("#personal-info3").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules:{
            employment_type:{
                required:true,
            },
            business_categories:{
                required:true,
            },
            business_categories_sub:{
                required:true,
            },
            company_name:{
                required:true,
                noSpace:true,
                alphaRestSpeChartor: true,
            },
            designation:{
                required:true,
                noSpace:true,
                alpha: true,
            },
            company_address:{
                required:true,
                noSpace:true,
            },
            company_contact_number:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            }
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    });
    $(".common-form").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        }
    });
    $("#companyDetails").validate({
       errorPlacement: function (error, element) {
           if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            firstname: "required",
            lastname: "required",
            username: {
                required: true,
                minlength: 2,
                alpha:true
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            contactnumber: {
                required: true,
                minlength: 10,
                maxlength:10

            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            contactnumber: "Please enter your 10 digit number",
            agree: "Please accept our policy",
            topic: "Please select at least 2 topics"
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    });
    
    $("#documentTypeAdd").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            document_type_name: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            },
            employee_type_name_edit: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            }
            
            
        },
        messages: {
            document_type_name: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },
            employee_type_name_edit: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },

        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    });
    $("#empTypeAdd").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            employee_type_name_add: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            },
            employee_type_name_edit: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            }
            ,emp_type_icon:{
                filesize2MB:true
            }
            
            
        },
        messages: {
            employee_type_name_add: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },
            employee_type_name_edit: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },

        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    });
    

    $("#addCategoryForm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            category_name: {
                required: true,
                noSpace:true
            },
            game_date:{
                required: true,
                noSpace:true
            },
            //18sept2020 start
            category_images:{
                required: true,
                filesize:true
            },
            //18sept2020 end
            
        },
        messages: {
            category_name: {
                required : "Please enter name"
            },
            //18sept2020 start
            category_images:{
                required: "Please select image"
            },
            //18sept2020 end
            game_date: {
                required : "Please enter date"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });

    $("#editCatForm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            category_name_edit: {
                required: true,
                noSpace:true
            },
            game_date:{
                required: true,
                noSpace:true
            },
            //18sept2020 start
            category_images:{
                required: true,
                filesize:true
            },
            //18sept2020 end
            
            
        },
        messages: {
            category_name_edit: {
                required : "Please enter name"
            },
            //18sept2020 start
            category_images:{
                required: "Please select image"
            },
            //18sept2020 end
            game_date: {
                required : "Please enter date"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });


    $("#addSubCat").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            sub_category_name: {
                required: true,
                noSpace:true
            },
            business_category_id:{
                required: true,
                noSpace:true
            },
            //18sept2020 start
            sub_category_images:{
                required: true,
                filesize:true
            },
            //18sept2020 end
            
            
        },
        messages: {
            sub_category_name: {
                required : "Please enter name"
            },
            //18sept2020 start
            sub_category_images:{
                required: "Please select image"
            },
            //18sept2020 end
            business_category_id: {
                required : "Please select category"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });



//new chnages
$("#companyFrm").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            company_name: {
                required: true,
                noSpace:true
            },
            company_email:{
                required: true,
                noSpace:true,
                email:true
            },
            company_contact_number:{
                required: true 
            },
            company_website:{
                required: true 
            },
            country_id:{
                required: true 
            },
            state_id:{
                required: true 
            },
            city_id:{
                required: true 
            },
            company_address:{
                required: true,
                noSpace:true
            },
            //23sept
            comp_gst_number:{
                required: true,
                noSpace:true
            },
            company_logo:{
                filesize:true
            },
            
            payment_getway_name:{
             required: true,
             noSpace:true
         },
         merchant_id:{
             required: true,
             noSpace:true
         },
         merchant_key:{
             required: true,
             noSpace:true
         },
         salt_key:{
             required: false,
             noSpace:true
         },
         currency_id:{
            required: true,
            noSpace:true
        },
        payment_getway_email:{
         required: false,
         noSpace:true,
         email:true
     },
     payment_getway_contact:{
         required: false,
         noSpace:true,
         minlength:6,
         maxlength:12
     },
     payment_getway_logo:{
        filesize:true
    }
    
},
messages: {
    company_name: {
        required : "Please enter company name"
    },
    company_email: {
        required : "Please enter compnay email"
    } ,
    company_contact_number: {
        required : "Please enter compnay contact number"
    } 
    ,
    company_website: {
        required : "Please enter compnay company website"
    } ,country_id:{
     required : "Please select country"
 }
 ,state_id:{
     required : "Please select state"
 }
 ,city_id:{
     required : "Please select city"
 }
 ,company_address:{
     required : "Please enter Address"
 },
 //23sept
            comp_gst_number:{
               required : "Please enter gst number"
            },
 payment_getway_name:{
     required : "Please enter payment getway name"
 },
 merchant_id:{
     required : "Please enter  id"
 },
 merchant_key:{
     required : "Please enter  key"
 },
 salt_key:{
     required : "Please enter salt key"
 },
 currency_id:{
     required : "Please enter display currency"
 } 
}
, submitHandler: function(form) {
    form.submit();
}
});


$("#CurrFrm").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            currency_name: {
                required: true,
                noSpace:true
            },
            currency_code: {
                required: true,
                noSpace:true
            },
            currency_symbol:{
                required: true,
                noSpace:true 
            } 
        },
        messages: {
            currency_name: {
                required : "Please enter currency name"
            },
            currency_code: {
                required : "Please enter currency Code"
            },
            currency_symbol: {
                required : "Please enter currency symbol"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });

$("#companyDetailFrm").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            company_name: {
                required: true,
                noSpace:true
            },
            company_email:{
                required: true,
                noSpace:true,
                email:true
            },
            company_contact_number:{
                  required: true 
            },
            //23sept
             comp_gst_number:{
                  required: true ,
                  noSpace:true
            },
            company_website:{
                required: true 
            },
            country_id:{
                required: true 
            },
            state_id:{
                required: true 
            },
            city_id:{
                required: true 
            },
            company_address:{
                required: true,
                noSpace:true
            },
            company_logo:{
                filesize:true
            } 
            
        },
        messages: {
            company_name: {
                required : "Please enter company name"
            },
            company_email: {
                required : "Please enter compnay email"
            } ,
            company_contact_number: {
                required : "Please enter compnay contact number"
            } 
            ,
            company_website: {
                required : "Please enter compnay company website"
            } ,country_id:{
             required : "Please select country"
         }
         ,state_id:{
             required : "Please select state"
         }
         ,city_id:{
             required : "Please select city"
         }
         ,company_address:{
             required : "Please enter Address"
         } ,
         //23sept
             comp_gst_number:{
                 required : "Please enter GST Number"
            }
     }
     , submitHandler: function(form) {
        form.submit();
    }
});

$("#companyPayFrm").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            
            payment_getway_name:{
             required: true,
             noSpace:true
         },
         merchant_id:{
             required: true,
             noSpace:true
         },
         merchant_key:{
             required: true,
             noSpace:true
         },
         salt_key:{
             required: false,
             noSpace:true
         },
         payment_getway_email:{
             required: false,
             noSpace:true,
             email:true
         },
         payment_getway_contact:{
             required: false,
             noSpace:true,
             minlength:6,
             maxlength:12
         },
         currency_id:{
             required: true,
             noSpace:true
         },
         payment_getway_logo:{
            filesize:true
        }
        
    },
    messages: {
     
        payment_getway_name:{
         required : "Please enter payment getway name"
     },
     merchant_id:{
         required : "Please enter merchant id"
     }, 
     currency_id:{
         required : "Please SELECT currency"
     },
     merchant_key:{
         required : "Please enter  key"
     },
     salt_key:{
         required : "Please enter salt key"
     } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});

//new chnages
 

 //18sept2020 start
 $("#editSubCatFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            sub_category_name: {
                required: true,
                noSpace:true
            },
            business_category_id:{
                required: true,
                noSpace:true
            },
            sub_category_images:{
                required: false,
                filesize:true
            },
      },
        messages: {
            sub_category_name: {
                required : "Please enter name"
            }, 
            sub_category_images:{
                required: "Please select image"
            }, 
            business_category_id: {
                required : "Please select category"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });

 $("#addHousesForm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            user_id: {
                required: true
            }
      },
        messages: {
            user_id: {
                required : "Please select member"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });

 $("#CircularFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            circular_title: {
                required: true,
                noSpace:true
            },
            circular_description:{
                required: true
            }
      },
        messages: {
            circular_title: {
                required : "Please enter circular title "
            } ,
            circular_description: {
                required : "Please enter circular description "
            } 
        }
        , submitHandler: function(form) {

            var circular_des= $('#summernoteImgage').val().trim();
              circular_des = circular_des.replace("&nbsp;", ""); 
              
              if(circular_des =="") {
                 swal("Please enter circular description.!");
              } else {
                  form.submit();
              }

          
        }
    });


 $("#memberFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            salutation:{
                required: true
            },
            user_first_name:{
                required: true,
                noSpace:true
            },
            user_mobile:{
                required: true,
            },
            user_last_name:{
                required: true,
                noSpace:true
            },
            user_email:{
                required: false,
                noSpace:true ,
                email:true
            },
            //7oct2020
            refere_by_name:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="-1"  ;
                    }
                },
                 noSpace:true 
            },
            //7oct2020
            business_category_id:{
                required:true
            },
            business_sub_category_id:{
                required:true
            },
            company_name:{
                 required: true,
                noSpace:true 
            },
            designation:{
                 required: true,
                noSpace:true 
            },
            company_logo:{
                filesize:true
            },
            company_logo_old:{
                filesize:true
            },
            user_profile_pic:{
                filesize:true
            },
            user_profile_pic_old:{
                filesize:true
            },
            country_id:{
                required:true
            },
            state_id:{
                required:true
            },
            city_id:{
                required:true
            },
            area_id:{
                required:true
            },
            plan_id:{
                required:true
            },
            adress_type:{
                required:true
            },
            adress: {
                required: true,
                noSpace:true 
            },
            pincode:{
                required:true,
                minlength:6,
                maxlength:6
            }, 
            booked_date:{
                required:true
            }
            
        },
        messages: {
            salutation:{
                required: "Please select salutation"
            },
            user_first_name:{
                required: "Please enter First Name"
            },
            user_last_name:{
                required: "Please enter Last Name"
            },
            user_mobile:{
                required: "Please enter Mobile Number"
            },
            //7oct2020
            refere_by_name:{
                required:"Please enter refer by person name" 
            },
            //7oct2020
            business_category_id:{
                required: "Please select business category"
            },
            business_sub_category_id:{
                required: "Please select business sub category"
            },
            company_name:{
                required: "Please enter compnay Name"
            },
            designation:{
                required: "Please enter designation"
            },
            country_id:{
                required: "Please select country"
            },
            state_id:{
                required: "Please select state"
            },
            city_id:{
                required: "Please select city"
            },
            area_id:{
                required: "Please select area"
            },
            plan_id:{
                required: "Please select Membership Plan"
            },
            adress_type:{
                required: "Please select Type"
            },
            adress: {
                required: "Please enter address", 
            },
            pincode:{
                required: "Please enter pincode",
                minlength:"Please enter 6 digit pin code",
                maxlength:"Please enter 6 digit pin code"
            },
            booked_date:{
                required:"please select booking date"
            }
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });


$("#memberBasicFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            salutation:{
                required: true
            },
            user_first_name:{
                required: true,
                noSpace:true
            },
            user_mobile:{
                required: true,
            },
            user_last_name:{
                required: true,
                noSpace:true
            },
            user_email:{
                required: false,
                noSpace:true ,
                email:true
            },
            user_profile_pic:{
                filesize:true
            }, 
        },
        messages: {
            salutation:{
                required: "Please select salutation"
            },
            user_first_name:{
                required: "Please enter First Name"
            },
            user_last_name:{
                required: "Please enter Last Name"
            },
            user_mobile:{
                required: "Please enter Mobile Number"
            }
                  
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });

$("#companyDetailFrm2").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
               
            company_name:{
                 required: true,
                noSpace:true 
            },
            company_contact_number:{
                //22sept2020
                required:false
            },
             
            company_logo:{
                filesize:true
            },
             
             
            billing_address: {
                //22sept2020
                required: false,
                noSpace:true 
            },
            billing_pincode:{
                required:false,
                minlength:6,
                maxlength:6
            } 
            
        },
        messages: {
           
            company_contact_number:{
                required: "Please enter contact Number"
            },
           
            company_name:{
                required: "Please enter compnay Name"
            },
             
            billing_address: {
                required: "Please enter address", 
            },
            billing_pincode:{
                required: "Please enter pincode",
                minlength:"Please enter 6 digit pin code",
                maxlength:"Please enter 6 digit pin code"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });

$("#professionalInfoFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             company_name:{
                 required: true,
                noSpace:true 
            },   
            company_contact_number:{
                //23sept2020
                required:false
            },
            business_category_id:{
                 required: true 
            },
            business_categories_other:{
                required:true,
                noSpace:true 
            },
            business_sub_category_id:{
                 required: true 
            }, 
             professional_other:{
                required:true,
                noSpace:true 
            },
            company_email:{
                //23sept2020
                required: false,
                noSpace:true,
                email:true
            },
            designation:{
                //23sept2020
                required: false,
                noSpace:true
            },

            company_logo:{
                filesize:true
            },
             company_broucher:{
                filesize:true
            }, 
            company_profile:{
                filesize:true
            } 
            
        },
        messages: {
            designation:{
                required : "Please enter designation"
            },
            
             company_email: {
                required : "Please enter compnay email"
             } ,
             company_name:{
                required: "Please enter compnay Name"
            },
            company_contact_number:{
                required: "Please enter contact Number"
            },
            business_category_id:{
                required: "Please select buisness category"
            },
            business_categories_other:{
                required: "Please enter category name"
            },
            business_sub_category_id:{
                required: "Please select Professional Type"
            }, 
            professional_other:{
                required: "Please enter Professional Type"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });


$("#utilityFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             /*banner_image:{
             required: true ,
             filesize: true
         } */
         //21sept
          
         frame_id:{
             required: true 
         }, 
          'banner_image[]':{
                required: true,
                filesize2MB: true,
                MaxUploadFile:true
            } 

    },
    messages: {
     /* banner_image:{
         required : "Please select banner image"
     } */
     //21sept
          
         frame_id:{
             required: "Please select Frame" 
         },
           'banner_image[]': {
               required : "Please select image",
               noSpace: "No space please and don't leave it empty",
           } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});

$("#renewPlanFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             plan_id:{
             required: true  
         } 
    },
    messages: {
      plan_id:{
         required : "Please select Membership Plan"
     } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});
$("#appBannerFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            business_category_id:{
                //21sept2020
                required:false
            },
             slider_image:{
             required: true ,
             filesize: true
         } 
    },
    messages: {
      business_category_id:{
         required : "Please select business category"
      } ,
      slider_image:{
         required : "Please select banner image"
     } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});
$("#editAppBannerFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            business_category_id:{
                //21sept2020
                required:false
            },
             slider_image:{
             filesize: true
            } 
    },
    messages: {
      business_category_id:{
         required : "Please select business category"
      } ,
      slider_image:{
         required : "Please select banner image"
     } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});

$("#advertiseFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             
             advertisement_url:{
             filesize2MB: true
            } 
    },
    messages: {
       
      advertisement_url:{
         required : "Please select image"
     } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});
//18sept2020 end


//18sept2020 new
$("#planFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             no_of_month:{
                required:true
             },
             package_amount:{
                required:true/* 21sept2020,
                digits:true*/
             },
             package_name:{
                required:true,
                noSpace:true
             } ,
             packaage_description:{
                required:true,
                noSpace:true
             } 
    },
    messages: {
       no_of_month:{
                required:"Please enter number of months"
             },
              package_amount:{
                required:"Please enter package amount"
             },
      package_name:{
         required : "Please enter package name"
     } ,
      packaage_description:{
         required : "Please enter package description"
     } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});


//18sept2020 new


$("#addHousieQuestion").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            "question_name[]": "required",
            "answer[]": "required"
        },
        messages: {
            "question_name[]": "Please enter question",
            "answer[]": "Please enter answer",
        }
    });


$("#addKbgQuestion").validate({
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            "kbg_question[]": "required",
            "kbg_option_1[]": "required"
        },
        messages: {
            "kbg_question[]": "Please enter question",
            "kbg_option_1[]": "Please enter option a",
        }
    });


//30march2020


//21sept2020

$("#addTimelineFrm").validate({
    errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                    element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             feed_msg:{
                required:true,
                noSpace:true
             },
             image:{
                required:false,
                filesize:true
             }  
    },
    messages: {
       feed_msg:{
                required:"Please enter message"
             } 
 }
 , submitHandler: function(form) {
    form.submit();
}
});


$("#addAreaFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
            country_id:{
                required:true
            },
            state_id:{
                required:true
            },
            city_id:{
                required:true
            },
            area_name:{
                required:true,
                noSpace:true
            } ,
            pincode:{
                required:true
            } 
            
        },
        messages: {
            
            country_id:{
                required:"please select country"
            },
            state_id:{
                required:"please select state"
            },
            city_id:{
                required:"please select city"
            },
            
            area_name: {
                required: "Please enter area", 
            },
            pincode:{
                required: "Please enter pincode"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });

$("#cityFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             city_name:{  required:true,  noSpace:true  } 
            
        },
        messages: {
            city_name:{
                required:"please enter city name"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });
$("#stateFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             state_name:{  required:true,  noSpace:true  } 
            
        },
        messages: {
            state_name:{
                required:"please enter state name"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });
$("#countryFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             country_name:{  required:true,  noSpace:true  } 
            
        },
        messages: {
            country_name:{
                required:"please enter country name"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });
$("#configration").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             sender_email_id:{  required:true,  noSpace:true, email:true  },
             email_password:{  required:true  } 
            
        },
        messages: {
            sender_email_id:{
                required:"please enter SENDER EMAIL ID"
            } ,
             email_password:{
                required:"please enter password"
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });

$("#roleFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             role_nameEdit:{  required:true,  noSpace:true   },
             role_name:{  required:true,  noSpace:true   },
             role_description:{  required:true,  noSpace:true   },
             menu_id: {
             required: function(elem) {
                return $("input.select:checked").length > 0;
                        }
             }
            
        },
        messages: {
            role_nameEdit:{
                required:"please enter role name"
            } ,
            role_name:{
                required:"please enter role name"
            } ,
             role_description:{
                required:"please enter role description"
            } ,
             email_password:{
                required:"please enter password"
            } 
        },
        submitHandler: function(form) {
             var checked = 0;
                  $( 'input[type=checkbox]' ).each(function() {
                      
                    if (this.checked) {
                        checked++;
                    }
                });
                if (checked == 0 ) {
              swal("Please select atleast one menu.!");
              } else {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
            }
        }
        
    });

$("#menuFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             menu_nameEdit:{  required:true,  noSpace:true   },
             menu_name:{  required:true,  noSpace:true   },
             menu_link:{  required:true,  noSpace:true   },
             menu_icon:{  required:true,  noSpace:true   },
             sub_menu:{  required:true,  noSpace:true   },
             order_no:{  required:true,  noSpace:true   } 
            
        },
        messages: {
            menu_nameEdit:{
                required:"please enter menu name"
            } ,
            menu_name:{
                required:"please enter menu name"
            } ,
             menu_link:{
                required:"please enter link"
            } ,
             menu_icon:{
                required:"please enter select icon"
            } ,
            sub_menu:{
                required:"please enter sub menu"
            } ,
            order_no:{
                required:"please enter order no"
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
$("#subMenuFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             parent_menu_id:{  required:true    },
             sub_menu_name:{  required:true,  noSpace:true   },
             menu_link:{  required:true,  noSpace:true   }, 
             order_no:{  required:true,  noSpace:true   } 
            
        },
        messages: {
            parent_menu_id:{
                required:"please select main menu"
            } ,
            sub_menu_name:{
                required:"please enter sub menu name"
            } ,
             menu_link:{
                required:"please enter link"
            } , 
             
            order_no:{
                required:"please enter order no"
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
$("#pageFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
             parent_menu_id:{  required:true    },
             sub_menu_name:{  required:true,  noSpace:true   },
             menu_link:{  required:true,  noSpace:true   }, 
             order_no:{  required:true,  noSpace:true   } 
            
        },
        messages: {
            parent_menu_id:{
                required:"please select main menu"
            } ,
            sub_menu_name:{
                required:"please enter sub menu name"
            } ,
             menu_link:{
                required:"please enter link"
            } , 
             
            order_no:{
                required:"please enter order no"
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
$("#FrameFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             frame_name:{  required:true,  noSpace:true   } ,
             //22sept2020
             layout_name:{  required:true,  noSpace:true   } ,
            frame_image:{  required:true,  filesize:true}
        },
        messages: {
            
            frame_name:{
                required:"please enter frame name"
            }  ,
            //22sept2020
            layout_name:{
                required:"please enter layout name"
            }  ,
            frame_image:{
                required:"please select frame image"
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });

$("#profileDetailFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             full_name:{  required:true,  noSpace:true   } ,
            admin_email:{  required:true,  noSpace:true,   email:true}
        },
        messages: {
            
            full_name:{
                required:"please enter Full Name"
            }  ,
            admin_email:{
                required:"please enter email"
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
$("#profileFrm1").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             old_password:{  required:true,  noSpace:true   } ,
             password:{  required:true,  noSpace:true, minlength: 5, pwcheck:true },
             password2:{  required:true,  noSpace:true,minlength: 5,equalTo: "#password" }
        },
        messages: {
            
            old_password:{
                required:"please enter old password"
            }  ,
            password:{
                required:"please enter new password"
            }  ,
            password2:{
                required:"please enter Confirm password",
                equalTo: "Please enter the same password"
            }
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
$("#commonFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             title:{  required:true,  noSpace:true   } ,
             description:{  required:true,  noSpace:true }
        },
        messages: {
            
            title:{
                required:"please enter title"
            }  ,
            description:{
                required:"please enter description"
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
//21sept2020

//22sept2020
$("#customFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             fcm_content:{ 
           
               required:{
                    depends: function(element) { 
                     return $("#customFrm :input[name='send_fcm']:checked"). val() =="1"  ;
                  }
              },
              noSpace:true   
          }  
        },
        messages: {
            
            fcm_content:{
                required:"please enter FCM Content."
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
//25sept2020
$("#customFrm2").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             fcm_content:{ 
           
               required:{
                    depends: function(element) { 
                     return $("#customFrm2 :input[name='send_fcm']:checked"). val() =="1"  ;
                  }
              },
              noSpace:true   
          }  
        },
        messages: {
            
            fcm_content:{
                required:"please enter Message."
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
//25sept2020
$("#appVersionFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             version_code_android:{ 
              required:true,
              noSpace:true   
          }  ,
          version_code_android_view:{ 
              required:true,
              noSpace:true   
          },
          version_code_ios:{ 
              required:true,
              noSpace:true   
          },
          version_code_ios_view:{ 
              required:true,
              noSpace:true   
          }      

        },
        messages: {
            
            version_code_android:{
                required:"please enter version code android."
            },
            version_code_android_view:{
                required:"please enter version code android view."
            },
            version_code_ios:{
                required:"please enter version code ios."
            },
            version_code_ios_view:{
                required:"please enter version code ios view."
            }  
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
//22sept2020


//5oct2020
$("#cpnFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
              
             coupon_name:{ 
              required:true,
              noSpace:true   
          }  ,
          coupon_code:{ 
              required:true,
              noSpace:true   
          },
          coupon_limit:{ 
             required:{
                    depends: function(element) { 
                      return $('#cpnFrm :input[name="is_unlimited"]').val() =="0"  ;
                  }
              }
          }      

        },
        messages: {
            
            coupon_name:{
                required:"please enter coupon name."
            },
            coupon_code:{
                required:"please enter coupon code."
            },
            coupon_limit:{
                required:"please enter coupon limit."
            } 
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });
//5oct2020
$("[name^=opening_time]").each(function () {
    $(this).rules("add", {
        required: true,
    });
});

$("[name^=closing_time]").each(function () {
    $(this).rules("add", {
        required: true,
    });
});
});