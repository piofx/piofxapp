$(function(){


    //login form
    if($("form").length){
        $url = $("form").attr('action');
        //general form submission
        console.log('login js');
        //login form submission
        if($("form").data('register')==1 || $(".registerform").data('register')==1){
            console.log('login register 1');
            $(document).on("click",".generate_otp", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                var name = $('input[name=name]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();
                if(name && phone && email){
                $('.otp_spinner').show();
                $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&api=1&sendotp=1';
                    $.get('/register', d, function(data){
                        // Display the returned data in browser
                       console.log(data);
                        if(data==1){
                            $('.otp_spinner').hide();
                            alert('OTP has been sent to your email, It will take a few seconds to reach. Kindly check SPAM and Promotions folder before retrying.')
                        }
                        
                        return false;  
                    });
                });
                }else{
                    alert('Kindly fill name,phone and email.');
                }
            });


            $(document).on("click",".validate_otp", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                var otp = parseInt($('input[name=otp]').val());
                var otp_server = parseInt($('.validate_otp').data('otp'));
                if(otp!=otp_server){
                    alert('Invalid OTP');
                }else{
                    $('.otp_success').show();
                }
               
            });

            $(document).on("click",".register_otp", function(e){
                console.log('form sms otp');
                e.preventDefault();
                var formValues= $(this).closest("form").serialize();
                var phone = $(this).closest("form").find("input[name=phone]").val();
                var name = $(this).closest("form").find("input[name=name]").val();
                var email= $(this).closest("form").find("input[name=email]").val();
                console.log('phone - '+email);

                if(!name && !email && !phone){
                    $(".alert_message").html("Enter name, email and phone number!");
                    $(".alert_block").show();
                    return false;

                }
                if(!email){
                    $(".alert_message").html("Enter email address!");
                    $(".alert_block").show();
                    return false;
                    
                }
                if(!phone){
                    $(".alert_message").html("Enter phone number!");
                    $(".alert_block").show();
                    return false;
                    
                }

                $(".error").hide();
                if(phone ){
                    $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&generate_otp=1';
                    $.post($url, d, function(data){
                        console.log(data);
                        var d = JSON.parse(data);
                        console.log(d);

                        if(typeof(d.code) != "undefined" && d.code !== null){
                            $(".otp_block").show();
                            $(".register_block").hide();
                            $(".alert_block").hide();
                            return false; 
                        }else{
                            $(".alert_message").html(d.error);
                            $(".alert_block").show();
                           
                        }
                    });
                });
                }else{
                    $(".alert_message").html("Enter a valid phone number");
                    $(".alert_block").show();
                }
            });


            $(document).on("click",".register", function(e){
                 console.log('clicked register');
                e.preventDefault();
                var formValues= $("form").serialize();
                var otp = parseInt($('input[name=otp]').val());
                var otp_server = parseInt($('.validate_otp').data('otp'));
               
                if(!otp_server)
                    otp_server = parseInt($('.v_otp').data('otp'));
                var name = $('input[name=name]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();
                var password = $('input[name=password]').val();
                var repassword = $('input[name=password_confirmation]').val();
                var redirect = $('input[name=redirect]').val();
                var _token = $('input[name=_token]').val();
                
                if(password !=repassword)
                    alert('Given password and re-password dint match!');
                if(!password)
                    password = phone;

                if($(".registerform").data('register'))
                    $url = $(".registerform").attr('action');

                if(name && phone && email ){
                    if(otp!=otp_server){
                         $(".alert_message").html("Invalid OTP!");
                                            $(".alert_block").show();
                    }else{
                        $('.login_spinner').show();
                        $.get('/contact/api',function(data){
                        var token = JSON.parse(data).token;
                        var d = formValues;
                        console.log(d);
                        console.log($url);
                        $.post($url, d, function(data){
                             // Display the returned data in browser
                             d = JSON.parse(data);
                             console.log(d);
                                if(d.login==1){
                                    d='email='+email+'&password='+password+'&_token='+_token;
                                    console.log(d);
                                     $.get('user/apilogin', d, function(data){

                                            $(".alert_message").html("Registration Successful! The page will reload in few seconds!");
                                            $(".alert_block").show();
                                        setTimeout(function(){
                                            $('.login_spinner').hide();
                                            
                                        window.location.replace(redirect);
                                        },3000);
                                     });
                                     
                                }else{
                                    $('.login_spinner').hide();
                                    $(".alert_message").html(d.message);
                                    $(".alert_block").show();
                                }
                            return false;  
                        });
                    });
                    }
                }else{
                    alert('Kindly fill name,phone,email and password.');
                }
               
            });

        }else{
            console.log('no register '+ $("form").data('register'));
        }

        // login form via otp
         //form submission with otp verification
        if($("form").data('otp')==1){
            
            $(document).on("click",".generate_phone_otp", function(e){
                e.preventDefault();
                var formValues= $(this).closest("form").serialize();
                var phone = $(this).closest("form").find("input[name=phone]").val();
                console.log('phone - '+phone);
                if(phone ){
                    $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&generate_otp=1';
                    $.post($url, d, function(data){
                        console.log(data);
                        var d = JSON.parse(data);
                        console.log(d);

                        if(typeof(d.code) != "undefined" && d.code !== null){
                            alert('OTP has been sent to your phone number! Kindly wait for 2min before retrying.');
                      
                            return false; 
                        }else{
                             alert(d.error);
                        }
                       
                        
                    });
                });
                }else{
                    alert('Kindly enter a valid phone number!');
                }
                
            });


        }

        // register form via otp
         //form submission with otp verification
        if($("form").data('register_otp')==1 || $(".registerform").data('register')==1){

            if($(".registerform").data('register'))
                $url = $(".registerform").attr('action');
            console.log('register form otp');
            $(document).on("click",".generate_phone_otp", function(e){
                e.preventDefault();
                var formValues= $(this).closest("form").serialize();
                var phone = $(this).closest("form").find("input[name=phone]").val();
                console.log('phone - '+phone+ ' - '+formValues);
                if(phone ){
                    $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&generate_otp=1';
                    $.post($url, d, function(data){
                        console.log(data);
                        var d = JSON.parse(data);
                        console.log(d);
                        if(typeof(d.code) != "undefined" && d.code !== null){
                            alert('OTP has been sent to your phone number! Kidly wait for 2min before retrying.');
                            return false; 
                        }else if(d.error =="undefined"){
                            alert("Invalid Phone number");
                        }
                        else{
                             alert(d.error);
                        }
                       
                        
                    });
                });
                }else{
                    alert('Kindly enter a valid phone number!');
                }
                
            });
        }

    
    }

	
});