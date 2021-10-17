$(function(){


    if($(".test-container-json").length){

        $( ".test-container-json" ).each(function() {
            let r = (Math.random() + 1).toString(36).substring(7);
            var url = $(this).data('url')+'?r='+r;
            var container = $(this);
            fetch(url)
            .then(res => res.json())
            .then((out) => {
              $.each(out, function(key,val){
                    var set = key;
                     
                    container.append("<div class='"+key+"_block set_block'></div>");
                    $('body').append('<div class="'+set+' d-none" ></div>');
                    var subcontainer = $('.'+key+'_block');
                    
                    $.each(val, function(k,v){
                        if(k=='heading'){
                            subcontainer.append(v);
                        }
                        
                        if(k=='questions'){
                            $total=0;
                            $.each(v, function(qno,n){
                                if(!isNaN(qno)){
                                    $('.'+set).append(qno+" ");
                                    $total =$total+1;
                                    question(subcontainer,set,qno,n);
                                }
                            });
                            $('body').append('<div class="total_'+set+' d-none" >'+$total+'</div>'); 
                            
                            subcontainer.append('<div class="mt-3"><button class="btn btn-success mb-3 check_answers" data-set="'+set+'" >Check answers</button>'+
                                '<button class="btn btn-outline-dark mb-3 ml-3 clear_answers" data-set="'+set+'" >Clear</button>'+
                                '<span class="ml-3"><span class="score_'+set+' h4"></span></span></div>');
                            $('.score_'+set).hide();
                        }
                        
                    });

                });
            })
            .catch(err => { throw err });

             
        });
        
    }

    function question(subcontainer,set,qno,data){

        var html ="<div class='qblock qb_"+set+"_"+qno+"'>";
        
        if(data.type=='mcq')
        {
            if(data.question){
                html =html+ "<div class='question'><span class='badge badge-warning h2'>"+qno+"</span> &nbsp;<span class='qdata'>"+data.question+"</span></div>";
            }
             if(data.a){
                  html =html+ "<div class='opt'><div class='form-check'>"+
                  "<input class='form-check-input mt-1' type='radio' id='"+set+"_"+qno+"_a' name='"+set+"_"+qno+"' value='a'>"+
                    "<label class='form-check-label' for='"+set+"_"+qno+"_a'>"+data.a+"</label>"+
                    "<span class='ans_"+set+"_"+qno+" ans_"+set+"_"+qno+"_a'></span></div></div>";
             }
             if(data.b){
                  html =html+ "<div class='opt'><div class='form-check'>"+
                  "<input class='form-check-input mt-1' type='radio' id='"+set+"_"+qno+"_b' name='"+set+"_"+qno+"'  value='b'>"+
                    "<label class='form-check-label' for='"+set+"_"+qno+"_b'>"+data.b+"</label>"+
                    "<span class='ans_"+set+"_"+qno+" ans_"+set+"_"+qno+"_b'></span></div></div>";
             }
             if(data.c){
                  html =html+ "<div class='opt'><div class='form-check'>"+
                  "<input class='form-check-input mt-1' type='radio' id='"+set+"_"+qno+"_c' name='"+set+"_"+qno+"' value='c'>"+
                    "<label class='form-check-label' for='"+set+"_"+qno+"_c'>"+data.c+"</label>"+
                    "<span class='ans_"+set+"_"+qno+" ans_"+set+"_"+qno+"_c'></span></div></div>";
             }
             if(data.d){
                  html =html+ "<div class='opt'><div class='form-check'>"+
                  "<input class='form-check-input mt-1' type='radio' id='"+set+"_"+qno+"_d' name='"+set+"_"+qno+"' value='d'>"+
                    "<label class='form-check-label' for='"+set+"_"+qno+"_d'>"+data.d+"</label>"+
                    "<span class='ans_"+set+"_"+qno+" ans_"+set+"_"+qno+"_d'></span></div></div>";
             }
             if(data.e){
                  html =html+ "<div class='opt'><div class='form-check'>"+
                  "<input class='form-check-input mt-1' type='radio' id='"+set+"_"+qno+"_e' name='"+set+"_"+qno+"' value='e'>"+
                    "<label class='form-check-label' for='"+set+"_"+qno+"_e'>"+data.e+"</label>"+
                    "<span class='ans_"+set+"_"+qno+" ans_"+set+"_"+qno+"_e'></span></div></div>";
             }

             
        }

        if(data.type=='fillup'){
            if(data.question){
                html =html+ "<div class='question'><span class='badge badge-warning h2'>"+qno+"</span>"+
                            " &nbsp;<span class='qdata'>"+data.question+"</span>"+
                            "&nbsp;<input type='text' name='"+set+"_"+qno+"' class='' >"+
                            "<span class='ans_"+set+"_"+qno+"'></span></div>"
            }else{
                html =html+ "<div class='question'><span class='badge badge-warning h2'>"+qno+"</span>"+
                            "&nbsp;<input type='text' name='"+set+"_"+qno+"' class='' >"+
                            "<span class='ans_"+set+"_"+qno+"'></span></div>"
            }
        }

        html=html+"</div>";
        $('body').append('<div class="'+set+'_'+qno+'" data-answer="'+data.answer+'" data-type="'+data.type+'"></div>');
        subcontainer.append(html);
    }



    $(document).on('click', '.check_answers', function(e) {
        e.preventDefault();
        var set = $(this).data('set');
        $qset = $('.'+set).html();
        $q = $qset.split(" ");
        $score =0;
        $.each($q, function(k,qno){
            if(qno){
                $type = $('.'+set+'_'+qno).data('type');
                if($type=='mcq'){
                    $uans = $("input[name="+set+"_"+qno+"]:checked").val();
                    $ans = $('.'+set+'_'+qno).data('answer');
                    $each_ans = $ans.split("/");
                    if($uans)
                    if(match_answers($uans,$each_ans)){
                        $score++;
                        $('.ans_'+set+'_'+qno).html('');
                        $('.ans_'+set+'_'+qno+'_'+$uans).append("<span class='text-success pl-2'><i class='fa fa-check-circle'></i></span>").css('margin-left','0px')
                            .animate({"margin-left":"5px",}, 100 );;
                    }else{
                        $('.ans_'+set+'_'+qno).html('');
                        $('.ans_'+set+'_'+qno+'_'+$uans).append("<span class='text-danger pl-2'><i class='fa fa-times-circle'></i></span>").css('margin-left','0px')
                            .animate({"margin-left":"5px",}, 100 );
                    }
                }else{
                    $uans = $("input[name="+set+"_"+qno+"]").val();
                    $ans = $('.'+set+'_'+qno).data('answer');
                    $each_ans = $ans.split("/");

                    if(match_answers($uans,$each_ans)){
                        $score++;
                        $('.ans_'+set+'_'+qno).html('');
                        $('.ans_'+set+'_'+qno).append("<span class='text-success pl-2'><i class='fa fa-check-circle'></i></span>").css('margin-left','0px')
                            .animate({"margin-left":"5px",}, 100 );;
                    }else{
                        $('.ans_'+set+'_'+qno).html('');
                        $('.ans_'+set+'_'+qno).append("<span class='text-danger pl-2'><i class='fa fa-times-circle'></i></span>").css('margin-left','0px')
                            .animate({"margin-left":"5px",}, 100 );
                    }
                }

            } 
        });
        $total = $('.total_'+set).html();
        $('.score_'+set).html($score+'/'+$total).show();
        if($total==$score){
            confetti({
              particleCount: 100,
              spread: 70,
              origin: { y: 0.6 }
            });
        }

        
    });

     $(document).on('click', '.clear_answers', function(e) {
        e.preventDefault();
        var set = $(this).data('set');
        $qset = $('.'+set).html();
        $q = $qset.split(" ");
        $.each($q, function(k,qno){
            if(qno){
                $type = $('.'+set+'_'+qno).data('type');
                if($type=='mcq'){
                    $uans = $("input[name="+set+"_"+qno+"]").prop('checked', false);;
                   
                }else{
                    $uans = $("input[name="+set+"_"+qno+"]").val('');
                   
                }
                $('.ans_'+set+'_'+qno).html('');
                $('.score_'+set).hide();
                
               
            }
            
        });
     });

    function match_answers($uans,$each_ans){
        $flag=0;
        $.each($each_ans, function(i,$oans){
            if($uans.toLowerCase().replace(/\s+/g, '')==$oans.toLowerCase().replace(/\s+/g, '')){
                $flag = 1;
                return false;
            }
        });
        return $flag;
    }

    function score($set){

        $('.score_'+$set).html().show();
    }




});