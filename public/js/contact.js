$(function(){


    //contact form
    if($("form").length){
        $url = $("form").attr('action');
        //general form submission
        if($("form").data('api')==1){
            console.log('api');
            $(document).on("click",".contact_button", function(e){
                console.log('clicked');
                e.preventDefault();
                var formValues= $("form").serialize();
                $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var query = window.location.search.substring(1);
                    var qs = parse_query_string(query);
                  
                    if(qs.source){
                        formValues = formValues+'&settings_source='+qs.source;
                    }
                    if(qs.campaign){
                        formValues = formValues+'&settings_campaign='+qs.campaign;
                    }

                    if(qs.utm_source){
                        formValues = formValues+'&settings_utm_source='+qs.utm_source;
                    }
                    if(qs.utm_campaign){
                        formValues = formValues+'&settings_utm_campaign='+qs.utm_campaign;
                    }
                    if(qs.utm_medium){
                        formValues = formValues+'&settings_utm_medium='+qs.utm_medium;
                    }
                    if(qs.utm_item){
                        formValues = formValues+'&settings_utm_item='+qs.utm_item;
                    }
                    if(qs.utm_content){
                        formValues = formValues+'&settings_utm_content='+qs.utm_content;
                    }
                    var d = formValues+'&_token='+token+'&api=1';
                    console.log(d);
                    $.post($url, d, function(data){
                        // Display the returned data in browser
                        console.log(data);
                        $('.contact_block').hide();
                        $('.alert_message').html(data);
                        $('.alert_block').show();
                        return false;  
                    });
                });
            });
        }

        function parse_query_string(query) {
          var vars = query.split("&");
          var query_string = {};
          for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            var key = decodeURIComponent(pair[0]);
            var value = decodeURIComponent(pair[1]);
            // If first entry with this name
            if (typeof query_string[key] === "undefined") {
              query_string[key] = decodeURIComponent(value);
              // If second entry with this name
            } else if (typeof query_string[key] === "string") {
              var arr = [query_string[key], decodeURIComponent(value)];
              query_string[key] = arr;
              // If third or later entry with this name
            } else {
              query_string[key].push(decodeURIComponent(value));
            }
          }
          return query_string;
        }

        //login form submission
        if($("form").data('login')==1){
            $(document).on("click",".login_button", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&api=1';
                    $.post($url, d, function(data){
                        // Display the returned data in browser
                       
                        d = JSON.parse(data);
                        if(d.login==1){
                            $('.login_message').html("<p class='text-white mb-0'><b>"+d.message+".</b> This page will be relaoded in few seconds</p>").show();
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        }else{
                            $('.login_message').html("<p class='text-white mb-0'><b>"+d.message+"</b><br> Incase of a query, Kindly reach out to the admin team.</p>").show();
                           
                        }
                        return false;  
                    });
                });
            });
        }

        //form submission with otp verification
        if($("form").data('otp')==1){
            console.log('form sms otp');
            $(document).on("click",".contact_button", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                var name = $('input[name=name]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();
                if(name && phone && email){
                    $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&otp=1';
                    $.post($url, d, function(data){
                        console.log(data);
                        var d = JSON.parse(data);
                        console.log(d);
                        if(typeof(d.otp) != "undefined" && d.otp !== null){
                            var otp = JSON.parse(data).otp;
                            $('.otp_input').data('otp',otp);
                            $('.contact_block').hide();
                            // Display the returned data in browser
                            $('.otp_block').show();
                            return false; 
                        }else{
                             alert(d.error);
                        }
                        
                    });
                });
                }else{
                    alert('Kindly fill all the fields to submit the form!');
                }
                
            });

            $(document).on("click",".otp_button", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                $('.spinner-border').show();
                var otp = parseInt($('.otp_input').data('otp'));
                var user_otp = parseInt($('.otp_input').val());
                console.log(otp+ ' - '+user_otp);
                if(otp!=user_otp){
                    $('.otp_message').show();
                    $('.spinner-border').hide();
                    return false;
                }else{
                    $.get('/contact/api',function(data){
                        var token = JSON.parse(data).token;
                        var d = formValues+'&_token='+token+'&api=1';
                        $.post($url, d, function(data){
                             // Display the returned data in browser
                            console.log(data);
                            $('.contact_block').hide();
                            $('.alert_message').html(data);
                            $('.alert_block').show();
                            $('.otp_block').hide();
                            $('.spinner-border').hide();
                            return false;  
                        });
                    });

                }
                
            });
        }


         //form submission with email verification
        if($("form").data('email')==1){
            console.log('form email');
            $(document).on("click",".contact_button", function(e){
                e.preventDefault();

                 
                var formValues= $("form").serialize();
                var name = $('input[name=name]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();
                if(name && phone && email){
                    $('.spinner-border').show();
                    $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&email_otp=1';
                      console.log($url);
                     
                    $.post($url, d, function(data){
                        console.log(data);
                        var d = JSON.parse(data);
                        console.log(d);
                       
                        if(typeof(d.otp) != "undefined" && d.otp !== null){
                            var otp = JSON.parse(data).otp;
                            $('.spinner-border').hide();
                            $('.otp_input').data('otp',otp);
                            $('.contact_block').hide();
                            // Display the returned data in browser
                            $('.otp_block').show();

                            return false; 
                        }else{
                             $('.spinner-border').hide();
                             alert(d.error);
                        }
                        
                    });
                });
                }else{
                    alert('Kindly fill all the fields to submit the form!');
                }
                
            });

            $(document).on("click",".otp_button", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                $('.spinner-border').show();
                var otp = parseInt($('.otp_input').data('otp'));
                var user_otp = parseInt($('.otp_input').val());
                console.log(otp+ ' - '+user_otp);
                if(otp!=user_otp){
                    $('.otp_message').show();
                    $('.spinner-border').hide();
                    return false;
                }else{
                    $.get('/contact/api',function(data){
                        var token = JSON.parse(data).token;
                        var d = formValues+'&_token='+token+'&api=1';
                        $.post($url, d, function(data){
                             // Display the returned data in browser
                            console.log(data);
                            $('.contact_block').hide();
                            $('.alert_message').html(data);
                            $('.alert_block').show();
                            $('.otp_block').hide();
                            $('.spinner-border').hide();
                            return false;  
                        });
                    });

                }
                
            });
        }

    }

    //login form

	
});