$().ready(function() {

    $.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
           && /[A-Z]/.test(value) // has a lowercase letter
           && /\d/.test(value) // has a digit
    });

    $.validator.addMethod("addressCheck", function(value) {
        /*alert(value);*/
        /*alert((/^[A-Za-z ]+/.test(value) || value==""  ))*/
         return /^[A-Za-z 0-9\d=!,\n\-@._*]*$/.test(value) // consists of only these
            && (/\w*[a-zA-Z ]\w*/.test(value) || value==''  )// has a lowercase letter
           // && /\d/.test(value) // has a digit
    });

    $.validator.addMethod("acceptName", function(value, element, param) {
        return value.match(new RegExp("." + param + "$"));
    });


    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]*$/);
    }, jQuery.validator.format(" enter a Valid Name."));

    $.validator.addMethod("alphaRestSpeChartor", function(value, element) {
        return this.optional(element) || value == value.match(/^[A-Za-z 0-9\d=!,:\n\-@&()/?%._*]*$/);
    }, jQuery.validator.format("special characters not allowed"));


    $.validator.addMethod("noSpace", function(value, element) { 
        return value == '' || value.trim().length != 0;  
    }, "No space  and don't leave it empty");

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
    }, jQuery.validator.format(" add a valid image file."));



    jQuery.validator.addMethod("logo", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "jpeg|jpg|png|gif|JPG|JPEG|PNG";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, jQuery.validator.format(" add a valid image file."));



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
    },$.validator.format(" select a file with a valid extension (png,jpeg,jpg,gif)."));

    $.validator.addMethod("extensionDoc", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif|pdf";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, $.validator.format(" select a file with a valid extension (png,jpeg,jpg,gif,pdf)."));

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
    },$.validator.format(" select a file with a valid extension (png,jpeg,jpg,txt,xls,csv,pdf,docx,odt,ods,xlsx)."));

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
    
    $("#registerUser").validate({
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
            userName: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor:true 
            },
            email:{
                required:true,
                noSpace:true,
                alphaRestSpeChartor:true 
            }, 
            phoneNumber:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            }
        },
        messages: {
            userName: {
                required: " enter your name", 
                },
            email:{
                required: " enter your email"
            },
            phoneNumber:{
                required:" your phone number",
                minlength:" enter at least 10 Digits." 
            }
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });

//1july2020
$("#registerFrm").validate({
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
            salutation: {
                required: false 
            },
            user_first_name:{
                required:true,
                noSpace:true,
                alphaRestSpeChartor:true 
            },
            user_last_name:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            user_email:{
                 required:true,
                 noSpace:true,
                alphaRestSpeChartor:true ,
                email:true,
            },
            //7oct2020
            refer_by:{
                required:true
            },

            refer_friend_id:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },

            refer_friend_name:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },
            /*refere_by_name:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },
            refere_by_phone_number:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                minlength: 10,
                maxlength: 10,
                noSpace:true 
            },*/
            //7oct2020
            user_mobile:{
                required:true,
            },
            country_code:{
                required:true,
            },
            business_category_id:{
                required:false,
            },
             business_categories_sub:{
                required:true,
            },
            company_name:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            designation:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            adress:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            country_id:{
                required:true,
            },
            state_id:{
                required:true,
            },
            city_id:{
                required:true,
            },
            plan_id:{
                required:true
            },
             area_id:{
                required:true,
            },
            pincode:{
                 required:true,
                noSpace:true,
                alphaRestSpeChartor:true 
            },
            adress_type:{
                required:true 
            } ,
            user_profile_pic:{
                required: false,
                filesize2MB:true,
                logo: true
            },
            company_logo:{
                required: false,
                filesize2MB:true,
                logo:true
                
            } 
        },
        messages: {
            plan_id:{
                required:" Select membership plan"
            },
            country_code: {
                required: " Select country code" 
            },
            refer_friend_id:{
                 required: " Select Referred By Member" 
            },
            refer_friend_name:{
                required: "Type Member Name" 
            },
            user_first_name:{
                required:" provide first name"
            },
            user_last_name:{
                required:" provide last name" 
            },
            user_mobile:{
                required:" provide mobile number"
            },
             business_categories_sub:{
                required:" select sub category"
            },
            //24sept
            user_email:{
                required:" provide user email"
            },
            //7oct2020
            refer_by:{
                 required:" select Referred by" 
            },
            refere_by_name:{
                required:" enter Referred by person name" 
            },
             refere_by_phone_number:{
                required:" enter Referred by person Mobile Number" ,
                minlength:" enter at least 10 Digits." 
            },
            //7oct2020
            company_name:{
                required:" provide company name"
            },
            designation:{
                required:" provide designation"
            },
            adress:{
                required:" provide adderess" 
            },
            country_id:{
                required:" select country"
            },
            state_id:{
                required:" select state"
            },
            city_id:{
                required:" select city"
            },
             area_id:{
                required:" select area"
            },
            pincode:{
                 required:" provide pin code" 
            },
            adress_type:{
                required:" select adderess type" 
            } 
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });
//1july2020

     $("#loginForm").validate({
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
            
            loginPhone:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            }
        },
        messages: {
            
            phoneNumber:{
                required:" your phone number",
                minlength:" enter at least 10 Digits." 
            }
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });

     $("#subscribeFrm").validate({
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
            
            subName:{
                required:true,
                noSpace:true
            },
            subMobile:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            },
            subEmail:{
                required:true,
                noSpace:true,
                email:true
            }
        },
        messages: {
            
            subName:{
                required:" enter your name"
            },
             subMobile:{
                required:" enter your mobile number",
                minlength:" enter at least 10 Digits." 
            },
             subEmail:{
                required:" enter Email"
            }
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });




     $("#reachUsFrm").validate({
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
            
            userName:{
                required:true,
                noSpace:true
            },
            mobileNumber:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            },
            email:{
                required:true,
                noSpace:true,
                email:true
            },
             message:{
                required:true,
                noSpace:true
            },
        },
        messages: {
            
            userName:{
                required:" enter name"
            },
             mobileNumber:{
                required:" enter mobile number",
                minlength:" enter at least 10 Digits." 
            },
             email:{
                required:" enter Email"
            },
             message:{
                required:" enter message"
            }
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });

});