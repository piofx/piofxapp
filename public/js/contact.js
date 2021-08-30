$(function(){

    if($("form").length){
        $url = $("form").attr('action');
        //general form submission
        if($("form").data('api')==1){
            $(document).on("click",".contact_button", function(e){
                e.preventDefault();
                var formValues= $("form").serialize();
                $.get('/contact/api',function(data){
                    var token = JSON.parse(data).token;
                    var d = formValues+'&_token='+token+'&api=1';
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

        //form submission with otp verification
        if($("form").data('otp')==1){
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
                var otp = parseInt($('.otp_input').data('otp'));
                var user_otp = parseInt($('.otp_input').val());
                console.log(otp+ ' - '+user_otp);
                if(otp!=user_otp){
                    $('.otp_message').show();
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
                            return false;  
                        });
                    });

                }
                
            });
        }

    }
	
});