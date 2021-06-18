$().ready(function() {

//9nov
    /*$.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
           && /[A-Z]/.test(value) // has a lowercase letter
           && /\d/.test(value) // has a digit
       }  , "<br />Your password must be at least 5 characters long and require alphanumeric values."

       );*/

     $.validator.addMethod("pwcheck", function(value) {
   return /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{5,16}$/.test(value) // consists of only these
    && /[A-Z]/.test(value)
       && /[a-z]/.test(value) // has a lowercase letter
       && /\d/.test(value) // has a digit
}, "<br />Your password must be at least 5 characters long and require at least 1 uppercase, 1 lowercase, 1 digit and 1 special character.");

//9 nov
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
    }, "No space Allowed and please don't leave it empty");

 

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


 $.validator.addMethod('filesize10MB', function (value, element, arg) {
        var size =10000000;
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

    }, $.validator.format("file size must be less than or equal to 10MB."));


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


//16feb21
 $("#addinterestForm").validate({
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
            interest_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'uniqueInterestName.php',
                    type: "post",
                    data:
                    {
                        interest_name: function()
                        {
                            return $('#addinterestForm :input[name="interest_name"]').val();
                        }
                    } 
                }
            }
        },
        messages: {
            interest_name: { 
            required: "Please enter Interest Name", 
            remote: "Interest Name is already exists, please use another Interest name to avoid confusion"
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
   
});


//17march21
$("#addUpiFrm").validate({
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
            app_name:
            {
                required: true,
                noSpace: true 
            },
            app_package_name:
            {
                required: true,
                noSpace: true 
            }
        },
        messages: {
            app_name: { 
            required: "Please enter App Name" 
        },app_package_name: { 
            required: "Please enter App Package Name" 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
   
});
$("#editUPIForm").validate({
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
            app_name:
            {
                required: true,
                noSpace: true 
            },
            app_package_name:
            {
                required: true,
                noSpace: true 
            }
        },
        messages: {
            app_name: { 
            required: "Please enter App Name" 
        },app_package_name: { 
            required: "Please enter App Package Name" 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
   
});
//17march21

$("#approveCustomCatFrm").validate({
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
            business_categories:{
                required:true
            },
            sub_category_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'uniqueSubCategoryName.php',
                    type: "post",
                    data:
                    {
                        sub_category_name: function()
                        {
                            return $('#approveCustomCatFrm :input[name="sub_category_name"]').val();
                        } 
                    } 
                }
            }
        },
        messages: {
            sub_category_name: { 
            required: "Please enter Sub Category Name", 
            remote: "Sub Category Name is already exists, please use another Sub Category name to avoid confusion"
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
   
});


$("#approveCustomIntFrm").validate({
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
            interest_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'uniqueInterestName.php',
                    type: "post",
                    data:
                    {
                        interest_name: function()
                        {
                            return $('#approveCustomIntFrm :input[name="interest_name"]').val();
                        }
                    } 
                }
            }
        },
        messages: {
            interest_name: { 
            required: "Please enter interest", 
            remote: "interest is already exists, please use another interest to avoid confusion"
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
   
});

 $("#editInterestForm").validate({
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
            interest_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'uniqueInterestName.php',
                    type: "post",
                    data:
                    {
                        interest_name: function()
                        {
                            return $('#editInterestForm :input[name="interest_name"]').val();
                        },
                        interest_id: function()
                        {
                            return $('#editInterestForm :input[name="interest_id"]').val();
                        }
                    } 
                }
            }
        },
        messages: {
            interest_name: { 
            required: "Please enter Interest Name", 
            remote: "Interest Name is already exists, please use another Interest name to avoid confusion"
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
    }
   
});
//16feb21


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
            adress2:{
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
                required: "Please enter House No./ Floor/ Building", 
            },adress2: {
                required: "Please enter landmark/ Street", 
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



//22feb21
 $("#seasonalGreetFrm").validate({
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
            title: {
                required: true,
                noSpace:true 
            } ,
            start_date:{
                required:{
                    depends: function(element) { 
                      return $('#seasonalGreetFrm :input[name="is_expiry"]').val() =="Yes" ;
                  }
              },
              noSpace:true 
          },
          end_date:{
            required:{
                depends: function(element) {
                   return $('#seasonalGreetFrm :input[name="is_expiry"]').val() =="Yes" ;
               }
           },
           noSpace:true 
       }
   },
   messages: {
    title: {
        required: "Please provide title", 
    },
    
    start_date:{
        required:"Please select start date"
    },
    end_date:{
        required:"Please select end date"
    }
},
submitHandler: function(form) {
    $(':input[type="submit"]').prop('disabled', true);
    form.submit(); 
}

});


 $("#seasonalGreetImageFrm").validate({
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
            cover_image:{
                required:{
                    depends: function(element) { 
                      return $('#seasonalGreetImageFrm :input[name="cover_image_old"]').val() =="" ;
                  }
                },
                filesize:true,
                image:true
            }, 
            background_image:{
               required:{
                    depends: function(element) { 
                      return $('#seasonalGreetImageFrm :input[name="background_image_old"]').val() =="" ;
                  }
                },
                filesize:true,
                image:true
            },
            title_on_image: {
                required: false,
                noSpace:false 
            } , 
            description_on_image: {
                required: false,
                noSpace:false 
            } ,
            page_alignment:{
                required: true,
            },
            title_font_name:{
                required: true,
            },
            description_font_name:{
                required: true,
            },
            to_name_font_name:{
                required:{
                    depends: function(element) { 
                      return $('#seasonalGreetImageFrm :input[name="show_to_name"]').val() =="Yes" ;
                  }
              },
              noSpace:true 
          },
          from_name_font_name:{
            required:{
                depends: function(element) {
                   return $('#seasonalGreetImageFrm :input[name="show_from_name"]').val() =="Yes" ;
               }
           },
           noSpace:true 
       }
   },
   messages: {
    cover_image:{
                required: "Please select cover image"
            },
            background_image:{
                 required: "Please select background image"
            },
            title_on_image: {
                required: "Please provide title on image", 
            },
            description_on_image: {
                required: "Please provide description on image", 
            },
            page_alignment:{
                        required: "Please select Page alignment", 
                    },
            title_font_name:{
                    required: "Please select title font", 
            },
            description_font_name:{
                    required: "Please select description font", 
            },
            to_name_font_name:{
                required: "Please select to name font", 
            },
            from_name_font_name:{
                required: "Please select from name font", 
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
     });
//22feb21


    
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
             

            category_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'uniqueCatName.php',
                    type: "post",
                    data:
                    {
                        category_name: function()
                        {
                            return $('#addCategoryForm :input[name="category_name"]').val();
                        }
                    } 
                }
            },


            game_date:{
                required: true,
                noSpace:true
            },
            cat_icon:{
                required: true,
                noSpace:true,
                filesize:true,
                image:true
            },
            //18sept2020 start
            category_images:{
                required: true,
                filesize:true,
                image:true
            },
            //18sept2020 end
            
        },
        messages: {
            category_name: {
                required : "Please enter name",
                remote:"This Category already exists."
            },
            //18sept2020 start
            category_images:{
                required: "Please select image"
            },
             cat_icon:{
                required: "Please select cat icon"
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
            
            category_name_edit:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'uniqueCatName.php',
                    type: "post",
                    data:
                    {
                        category_name: function()
                        {
                            return $('#editCatForm :input[name="category_name_edit"]').val();
                        },
                        business_category_id: function()
                        {
                            return $('#editCatForm :input[name="business_category_id"]').val();
                        }
                    } 
                }
            },


            game_date:{
                required: true,
                noSpace:true
            }, 
            cat_icon:{
                required:false,
                noSpace:true,
                filesize:true,
                image:true
            },
            //18sept2020 start
            category_images:{
                required: false,
                filesize:true,
                image:true
            },
            //18sept2020 end
            
            
        },
        messages: {
            category_name_edit: {
                required : "Please enter name",
                remote:"Category Already exists"
            },
            //18sept2020 start
            category_images:{
                required: "Please select image"
            },
            cat_icon:{
                required: "Please select cat icon"
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
                noSpace:true,
                remote:
                {
                    url: 'uniqueCatName.php',
                    type: "post",
                    data:
                    {
                        sub_category_name: function()
                        {
                            return $('#addSubCat :input[name="sub_category_name"]').val();
                        },
                        business_category_id: function()
                        {
                            return $('#addSubCat :input[name="business_category_id"]').val();
                        }
                    } 
                }
            },
            business_category_id:{
                required: true,
                noSpace:true
            },
            //18sept2020 start
            sub_category_images:{
                required: true,
                filesize:true,
                image: true
            },
            //18sept2020 end
            
            
        },
        messages: {
            sub_category_name: {
                required : "Please enter name",
                remote:"this sub category already exists in selected main category"
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
        required : "Please enter Business name"
    },
    company_email: {
        required : "Please enter Business email"
    } ,
    company_contact_number: {
        required : "Please enter Business contact number"
    } 
    ,
    company_website: {
        required : "Please enter Business website"
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
     required : "Please enter payment gateway name"
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
            image:true,
            filesize:true
        } 
            
        },
        messages: {
            company_name: {
                required : "Please enter Business name"
            },
            company_email: {
                required : "Please enter Business email"
            } ,
            company_contact_number: {
                required : "Please enter Business contact number"
            } 
            ,
            company_website: {
                required : "Please enter Business website"
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
            image:true,
            filesize:true
        }
        
    },
    messages: {
     
        payment_getway_name:{
         required : "Please enter payment gateway name"
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
                noSpace:true,
                remote:
                {
                    url: 'uniqueCatName.php',
                    type: "post",
                    data:
                    {
                        sub_category_name: function()
                        {
                            return $('#editSubCatFrm :input[name="sub_category_name"]').val();
                        },
                        business_category_id: function()
                        {
                            return $('#editSubCatFrm :input[name="business_category_id"]').val();
                        },
                        business_sub_category_id: function()
                        {
                            return $('#editSubCatFrm :input[name="business_sub_category_id"]').val();
                        },
                    } 
                }
            },
            business_category_id:{
                required: true,
                noSpace:true
            } 
      },
        messages: {
            sub_category_name: {
                required : "Please enter name",
                remote:"Sub category already exists in selected main category"
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
            refer_by:{
                required:true
            },

            refer_friend_name:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },

            refer_friend_id:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },


            refere_by_name:{
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
                  required:false,
                  /*required:{
                    depends: function(element) { 
                     return $("#memberFrm :input[name='company_logo_old']"). val() ==""  ;
                  }
                 },*/
                filesize:true
            },
            user_profile_pic:{
                  
                  required:{
                    depends: function(element) { 
                     return $("#memberFrm :input[name='user_profile_pic_old']"). val() ==""  ;
                  }
                 },
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
            },adress2: {
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
            //5nov2020
            , amount_with_gst:{
                required:{
                    depends: function(element) {
                      return $("#is_paid").val()=="0"  ;
                    }
                },

            },
        },
        messages: {
            refer_friend_name:{
                required: "Type Member Name"
            },
            refer_friend_id:{
                required: "Select Reffered Person"
            },
            //5nov2020
            amount_with_gst:{
                required: "Please enter paid amount"
            },
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
                required: "Please enter Mobile Number",
                maxlength:"PLEASE ENTER MAX LEAST 10 digits.",
                minlength:"PLEASE ENTER at LEAST 10 digits."
            },
            //7oct2020
            refer_by:{
                 required:"Please select Referred by" 
            },
            refere_by_name:{
                required:"Please enter Referred by person name" 
            },
             refere_by_phone_number:{
                required:"Please enter Referred by person Mobile Number" 
            },
            //7oct2020
            business_category_id:{
                required: "Please select business category"
            },
            business_sub_category_id:{
                required: "Please select business sub category"
            },
            company_name:{
                required: "Please enter Business Name"
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
                required: "Please enter House No./ Floor/ Building", 
            },adress2: {
                required: "Please enter landmark/ Street", 
            },
            pincode:{
                required: "Please enter pincode",
                minlength:"Please enter 6 digit pin code",
                maxlength:"Please enter 6 digit pin code"
            },
            booked_date:{
                required:"please select booking date"
            },
            company_logo:{
                required:"please select Business logo"
            },
            user_profile_pic:{
                required:"please select user profile"
            },
        },
        submitHandler: function(form) {
            //5nov
            if($("#is_paid").val() ==0 && $("#amount_with_gst").val() <= 0  ){
                 swal("Please enter paid amount.!");
            } else {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
            }
            
        }
        
    });



//15dec2020
$("#adminFrm").validate({
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
            role_id:{
                required: true
            },
            admin_name:{
                required: true,
                noSpace:true
            },
            
            admin_email:{
                required: true,
                noSpace:true ,
                email:true,
                remote: { 
                    url: 'ajaxValidateUserData.php',
                    type: "post",
                    data: {
                         admin_email: function() {
                            return $('#adminFrm :input[name="admin_email"]').val();
                        }, zoobiz_admin_id: function() {
                            return $('#adminFrm :input[name="zoobiz_admin_id_edit"]').val();
                        }, 
                           
                        validateAdmin_email:'yes' 
                     } 
                }
            },
            admin_mobile:{
                required: false
            },

             password:{  required:true,  noSpace:true, minlength: 5, pwcheck:true },
             password2:{  required:true,  noSpace:true,minlength: 5,equalTo: "#password" },
 
            admin_profile:{
                  required:{
                    depends: function(element) { 
                     return $("#adminFrm :input[name='isedit']"). val() =="no"  ;
                  }
                 },

                filesize:true
            } 
              ,
        },
        messages: {
            //5nov2020
            role_id:{
                required: "Please select role"
            },
            admin_name:{
                required: "Please enter admin name"
            },
            admin_email:{
                required: "Please enter admin email",
                remote:"Email Already Exists"
            },
            admin_mobile:{
                required: "Please enter mobile number"
            },
            password:{
                required:"please enter new password"
            }  ,
            password2:{
                required:"please enter Confirm password",
                equalTo: "Please enter the same password"
            },
            admin_profile:{
                 required:"Please select profile" 
            } 
        },
        submitHandler: function(form) {
             form.submit(); 
            
        }
        
    });
//15dec2020
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
                required: false
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
                  
                  required:{
                    depends: function(element) { 
                     return $("#memberBasicFrm :input[name='user_profile_pic_old']"). val() ==""  ;
                  }
                 },
                filesize:true
            },
        },
        messages: {
            user_profile_pic:{
                required: "Please select profile picture"
            },
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
            //2dec2020
             /*var user_social_media_name_valid= $('#user_social_media_name_valid').val();
             
               if(user_social_media_name_valid =="0") {
                 swal("Please enter valid social media name..!");
              } else {
                  form.submit();
              }*/
               $(':input[type="submit"]').prop('disabled', true);
              form.submit();
              //2dec2020
            
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
            image:true,
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
                required: "Please enter Business Name"
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
                required: true,
                noSpace:true
            },

            company_logo:{
                  
                 /* required:{
                    depends: function(element) { 
                     return $("#professionalInfoFrm :input[name='company_logo_old']"). val() ==""  ;
                  }
                 },*/
                 required:false,
                filesize:true
            },
             company_broucher:{
                filesize10MB:true
            }, 
            company_profile:{
                filesize10MB:true
            } 
            
        },
        messages: {
            designation:{
                required : "Please enter designation"
            },
              company_logo:{
                required:"Please provide Business logo."
              }  ,
             company_email: {
                required : "Please enter Business email"
             } ,
             company_name:{
                required: "Please enter Business Name"
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
             filesize: true,
             image:true
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
             filesize: true,
             image:true
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
             filesize2MB: true,
             image:true
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
             //9oct
             gst_slab_id:{
                required:true
             },
             //9oct
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
                required:"Please enter duration value"
             },
              package_amount:{
                required:"Please enter package amount"
             },
             //9oct
             gst_slab_id:{
                required:"Please select gst slab."
             },
             //9oct
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

//3dec2020
$("#manageSubCateFrm").validate({
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
             
            
        },
        messages: {
              
        },
        submitHandler: function(form) {
             var checked = 0;
                  $( 'input[type=checkbox]' ).each(function() {
                      
                    if (this.checked) {
                        checked++;
                    }
                });
                if (checked == 0  && 0 ) {
              swal("Please select atleast one Sub Category.!");
              } else {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
            }
        }
        
    });
//3dec2020
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
            admin_email:{  required:true,  noSpace:true,   email:true
                //9nov
                ,remote: { 
                    url: 'ajaxValidateUserData.php',
                    type: "post",
                    data: {
                         admin_email: function() {
                            return $('#profileDetailFrm :input[name="admin_email"]').val();
                        },
                        zoobiz_admin_id: function() {
                            return $('#profileDetailFrm :input[name="zoobiz_admin_id"]').val();
                        }, 
                           
                        validateAdmin_email:'yes' 
                     } 
                }
            }
            //9nov2020
            /*,
            profile_image:{
                required: function(element){
                    return $("#profile_image_old").val()=="";
                },
                filesize: true
            }*/
        },
        messages: {
            
            full_name:{
                required:"please enter Full Name"
            }  ,
            admin_email:{
                required:"please enter email",
                 remote:"Email Already Exists "
            }
            //9nov2020
            /*,
            profile_image: {
                required : "Please select image",
                noSpace: "No space please and don't leave it empty",
            } */  
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

//27oct
$("#dealsFrm").validate({
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
              
             deal_title:{ 
              required:true,
              noSpace:true   
          }  ,
          deal_desc:{ 
              required:true,
              noSpace:true   
          },
          deal_image:{ 
            required:false,
            filesize:true
               
          },
          pincode:{ 
           required:{
                    depends: function(element) { 
                      return $('#dealsFrm :input[name="send_to"]').val() =="7"  ;
                  }
              }
          }     

        },
        messages: {
            
            deal_title:{
                required:"please enter title."
            },
            deal_desc:{
                required:"please enter description."
            },
             pincode:{ 
                required:"please enter PIN Code.",
                maxlength:" please enter 6 digits",
                minlength:" please enter 6 digits"
             }   
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });


$("#promotionFrm").validate({
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
              
             event_name:{ 
              required:true,
              noSpace:true   
          }  ,
          event_date:{ 
              required:true,
              noSpace:true   
          }, 
          event_end_date:{ 
              required:true,
              noSpace:true   
          },
          order_date:{ 
              required:true,
              noSpace:true   
          },
          description:{ 
              required:false,
              noSpace:true   
          },


          /*'promotion_frame_id[]':{
                required:{
                    depends: function(element) { 
                      //return $("#promotion_frame_id option:selected").val() =="0"  ;
                      alert($('#promotionFrm :input[name="promotion_frame_new"]').val());
                       return $('#promotionFrm :input[name="promotion_frame_new"]').val() =="0"  ;
                  }
              }
                
            } ,
            'promotion_frame_new[]':{
                required:{
                    depends: function(element) { 
                      return $("#promotion_frame_id option:selected").val() =="0"  ;
                  }
              },
              MaxUploadFile:true
                
            } ,*/
            event_frame:{
                image:true,
                 filesize2MB: true
            },
            'promotion_frame_new[]':{

                image:true
            },
            'promotion_center_image_new[]':{
                  
                image:true
            },
          event_image:{
             required:false,
                filesize2MB: true,
                image:true
            } ,
            frame_image:{
             required:{
                    depends: function(element) { 
                      return $("#isEdit").val() =="no"  ;
                  }
              },
                filesize2MB: true,
                image:true
            } 
  

        },
        messages: {
           /* 'promotion_frame_id[]':{
                required:"Please select Frame",
            },
            'promotion_frame_new[]':{
                required:"Please select Frame",
            },*/
            event_name:{
                required:"please enter event name."
            },
            description:{
                required:"please enter description."
            },
            event_date:{
                required:"please select start date."
            }   ,
            event_end_date:{
                required:"please select end date."
            }   ,
            order_date:{
                required:"please select event date."
            }   ,
            
            frame_image:{
                required:"please select image."
            }   ,
             
        },
        submitHandler: function(form) {
            var err = 0 ; 
            var err1 = 0 ; 
            var err2 = 0 ; 
            var err3 = 0 ; 
            var err4 = 0 ; 
            var fi = document.getElementById('promotion_frame_new');
            var selected_frms = $("#promotion_frame_id option:selected").val();
             

             var fi2 = document.getElementById('promotion_center_image_new');
            var selected_frms2 = $("#promotion_center_image_id option:selected").val();

             
             if (fi.files.length <=0    ) {
                err4++;   
             }
             if (  selected_frms>0) {
               
             } else {
                 err1++; 
             }

             if(err4>0 && err1>0 ){
                err++;
             }

              if (fi2.files.length == 0    ) {
                err2++;  
             }
             if (  selected_frms2>0 ) {
               
             } else {
                 err3++; 
             }
              if(err2>0 && err3>0 ){
                err++;
             }
              
             if(err > 0 ){
                swal("Please Select Frame and Center Image.");
             } else {
                 $(':input[type="submit"]').prop('disabled', true);
                form.submit();
             }
              //  $(':input[type="submit"]').prop('disabled', true);
               // form.submit(); 
             
        }
        
    });

$("#promoFrmFrm").validate({
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
              
             promotion_id:{ 
              required:true,
              noSpace:true   
          }  ,
          frame_name:{ 
              required:true,
              noSpace:true   
          },
          image_name:{ 
              required:false,
              filesize:true
          },
          center_image:{ 
              required:false,
              filesize:true
          } 
  

        },
        messages: {
            
            promotion_id:{
                required:"please select event."
            },
            frame_name:{
                required:"please enter frame name."
            },
            image_name:{
                required:"please select background image."
            }   ,
            center_image:{
                required:"please select center image."
            }
             
        },
        submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
             
        }
        
    });

//27oct


$.validator.addMethod("custom_rule", function(value, element) {
    var dropdown_val = $('#cpnFrm :input[name="coupon_amount"]').val();
    if(  dropdown_val>=0  ) {
       return true;
    } else {
       return false;
    }
 }, "Please Provide Value more than 0");
$.validator.addMethod("custom_rule2", function(value, element) {
    var coupon_per = $('#cpnFrm :input[name="coupon_per"]').val();
    if(  coupon_per>=0  ) {
       return true;
    } else {
       return false;
    }
 }, "Please Provide Value more than 0");

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
              plan_id:{ 
              required:true,
              noSpace:true   
          }  , 
             coupon_name:{ 
              required:true,
              noSpace:true   
          }  ,
          coupon_code:{ 
              required:true,
              noSpace:true ,
              remote:
                {
                    url: 'getCpnCode.php',
                    type: "post",
                    data:
                    {
                        cpn_cod: function()
                        {
                            return $('#cpnFrm :input[name="coupon_code"]').val();
                        },
                        checkCPNVal: 'Yes',
                        isedit: function()
                        {
                            return $('#cpnFrm :input[name="isedit"]').val();
                        }, 
                    } 
                }  
          },
          coupon_limit:{ 
             required:{
                    depends: function(element) { 
                      return $('#cpnFrm :input[name="is_unlimited"]').val() =="0"  ;
                  }
              }
          },
          start_date:{ 
             required:{
                    depends: function(element) { 
                      return $('#cpnFrm :input[name="cpn_expiry"]').val() =="1"  ;
                  }
              }
          }  ,
          end_date:{ 
             required:{
                    depends: function(element) { 
                      return $('#cpnFrm :input[name="cpn_expiry"]').val() =="1"  ;
                  }
              }
          } 
          ,
          coupon_amount:{ 
             required:{
                    depends: function(element) {  
                      return $('#cpnFrm :input[name="coupon_per"]').val() <= 0   ;
                  }
              } 
          }   ,
          coupon_per:{ 
             required:{
                    depends: function(element) { 
                      return $('#cpnFrm :input[name="coupon_amount"]').val() <="0.00"  ;
                  }
              } 
          }        

        },
        messages: {
            coupon_amount:{
                required:"please enter coupon amount."
            },
             coupon_per:{
                required:"please enter coupon percentage."
            },
             plan_id:{
                required:"please select Membership Plan."
            },
            coupon_name:{
                required:"please enter coupon name."
            },
            start_date:{
                required:"please select start date."
            },
            end_date:{
                required:"please select end date."
            },
            coupon_code:{
                required:"please enter coupon code.",
                remote:" Coupon Code Already Used."
            },
            coupon_limit:{
                required:"please enter coupon limit."
            } 
        },
        submitHandler: function(form) {

             var cpn_valid= $('#cpn_valid').val();
            
            //5nov2020
            var coupon_per= $('#coupon_per').val();
            var coupon_amount= $('#coupon_amount').val();
            if(coupon_per<=0 && coupon_amount<=0 ){
                 swal("Please enter valid coupon values for coupon percentage or amount..!");
            }
            //5nov2020
              
             else if(cpn_valid =="0") {
                 swal("Please enter valid coupon code..!");
              } else {
                  form.submit();
              }


                
             
        }
        
    });
//5oct2020


//2nov2020
$("#editReferFrm").validate({
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
            refere_by_name:{
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
                 noSpace:true 
            } 
        },
        messages: {
            refer_friend_id :{
                 required:"Please select Referred Member" 
            },
            refer_by:{
                 required:"Please select Referred by" 
            },
            refere_by_name:{
                required:"Please enter Referred by person name" 
            },
             refere_by_phone_number:{
                required:"Please enter Referred by person Mobile Number" 
            } 
        },
        submitHandler: function(form) {
            $(':input[type="submit"]').prop('disabled', true);
            form.submit(); 
        }
        
    });
//2nov2020


//4dec2020
$("#langFrm").validate({
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
            language_name:{ required: true, noSpace:true},
            language_name_1:{ required: true, noSpace:true},
            continue_btn_name:{ required: true, noSpace:true}
        }, messages: {
             language_name:{ required: "Please enter language name."},
            language_name_1:{ required: "Please enter language name 1."},
            continue_btn_name:{ required: "Please enter continue button name."},
        } 
    });
    $("#langKeyFrm").validate({
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
            key_name:{ 
                required: true, 
                noSpace:true,
                 remote:
                {
                    url: 'UniqueLangKeyName.php',
                    type: "post",
                    data:
                    {
                        key_name: function()
                        {
                            return $('#langKeyFrm :input[name="key_name"]').val();
                        }  
                    } 
                }
            } 
        }, messages: {
             key_name:{ 
                required: "Please enter key.",
                 remote: "Key Name is already exists, please use another Key name to avoid confusion"
           
            } 
        } 
    });

     $("#EditlangKeyFrm").validate({
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
            key_name:{ 
                required: true, 
                noSpace:true,
                 remote:
                {
                    url: 'UniqueLangKeyName.php',
                    type: "post",
                    data:
                    {
                        language_key_id: function()
                        {
                            return $('#EditlangKeyFrm :input[name="language_key_id"]').val();
                        },
                        key_name: function()
                        {
                            return $('#EditlangKeyFrm :input[name="key_name"]').val();
                        } 
                    } 
                }
            } 
        }, messages: {
             key_name:{ 
                required: "Please enter key.",
                remote: "Key Name is already exists, please use another Key name to avoid confusion"
           
         } 
        } 
    });
     $("#editLanguageValueKeyFrm").validate({
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
            value_name:{ 
                required: true, 
                noSpace:true 
            } 
        }, messages: {
             value_name:{ 
              required: "Please enter velue.",
              } 
        } 
    });
//4dec2020


//31dec2020
$("#smsConfigFrm").validate({
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
            sms_api_link:{ 
                required: true, 
                noSpace:true 
            },
            otp_api_link:{ 
                required: true, 
                noSpace:true 
            },
            multiple_sms_link:{ 
                required: true, 
                noSpace:true 
            }   
        }, messages: {
             sms_api_link:{ 
              required: "Please enter sms api link.",
              } ,
              otp_api_link:{ 
              required: "Please enter otp api link.",
              },
              multiple_sms_link:{ 
              required: "Please enter multiple sms api link.",
              } 
        } 
    });
//31dec2020


//8jan21
$("#apiFrm").validate({
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
            api_version:{ 
                required: true, 
                noSpace:true 
            },
            api_file:{ 
                required: true,
                extension:'apk'
            }   
        }, messages: {
             api_version:{ 
              required: "Please enter APK version.",
              } ,
              api_file:{ 
              required: "Please select APK.",
              } 
        } 
    });
//8jan21


//18jan21
$("#replyFeedbackFrm").validate({
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
            reply:{ 
                required: true, 
                noSpace:true 
            } 
        }, messages: {
             reply:{ 
              required: "Please enter Reply.",
              }  
        } 
    });

//18jan21
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