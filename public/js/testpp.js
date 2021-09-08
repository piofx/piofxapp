
$(function(){

    var prefix_url = 'https://xplore.in.net/';

    if($(".test-container").length){

        $( ".test-container" ).each(function() {
            var slug = $(this).data('container');
            var container = $(this);

            var answer_button = $(this).data('answer_button');
            var testname = $(this).data('test_name');
            var testcss = $(this).data('test_css');
            var testmode = $(this).data('test_mode');
            

            if(answer_button=='yes')
                var url = testUrl(slug,false,true);
            else
                var url = testUrl(slug);

            if(testname)
                url = url+'&layout=fa';
            if(testcss)
                url = url+'&style_test=1';
            if(testmode)
                url = url+'&test_score=1';

            $.get(url,function(data){
                $questions = JSON.parse(data);
                $questions.forEach(function(d,i){
                    console.log(d);
                    ele = "<div class='row no-gutters q_"+slug+"_"+i+"' data-answer='"+d.answer+"'>\
                            <div class='col-2 col-md-1'><div class=' bg-soft-info  py-1 px-1 text-center rounded'>"
                            +(i+1)+
                            "</div></div>\
                            <div class='col-10 col-md-11'><div class='ml-3'>"
                            +d.question+
                            "</div></div>\
                            </div>"+
                            "<div class='mb-4'><div class='row'>\
                                <div class='col-12 col-md-6'>\
                                    <div class='row'>\
                                        <div class='col-3 mb-2'>\
                                            <div class='bg-soft-warning py-1 px-1 text-center rounded'>\
                                            <input class='form-check-input mt-2' type='radio' name='q_"+slug+"_"+i+"' data-qno='"+i+"' data-slug='"+slug+"' value='a' >\
                                            A\
                                            </div>\
                                        </div>\
                                        <div class='col-9'>"
                                        + d.a +
                                        "</div>\
                                    </div>\
                                </div>\
                                <div class='col-12 col-md-6'>\
                                    <div class='row'>\
                                        <div class='col-3 mb-2'>\
                                            <div class='bg-soft-warning py-1 px-1 text-center rounded'>\
                                            <input class='form-check-input mt-2' type='radio' name='q_"+slug+"_"+i+"' data-qno='"+i+"' data-slug='"+slug+"' value='b' >\
                                            B\
                                            </div>\
                                        </div>\
                                        <div class='col-9'>"
                                        + d.b +
                                        "</div>\
                                    </div>\
                                </div>\
                            </div>"+
                            "<div class='row'>\
                                <div class='col-12 col-md-6'>\
                                    <div class='row'>\
                                        <div class='col-3 mb-2'>\
                                            <div class='bg-soft-warning py-1 px-1 text-center rounded'>\
                                            <input class='form-check-input mt-2' type='radio' name='q_"+slug+"_"+i+"' data-qno='"+i+"' data-slug='"+slug+"' value='c' >\
                                            C\
                                            </div>\
                                        </div>\
                                        <div class='col-9'>"
                                        + d.c +
                                        "</div>\
                                    </div>\
                                </div>\
                                <div class='col-12 col-md-6'>\
                                    <div class='row'>\
                                        <div class='col-3 mb-2'>\
                                            <div class='bg-soft-warning py-1 px-1 text-center rounded'>\
                                            <input class='form-check-input mt-2' type='radio' name='q_"+slug+"_"+i+"' data-qno='"+i+"' data-slug='"+slug+"' value='d' >\
                                            D\
                                            </div>\
                                        </div>\
                                        <div class='col-9'>"
                                        + d.d +
                                        "</div>\
                                    </div>\
                                </div>\
                            </div><div class='text-danger  incorrect incorrect_"+slug+"_"+i+" ' style='display:none'>Nah! Option (<span class='text-primary text-bold ans_"+slug+"_"+i+" '>D</span>) is not the correct answer</div>\
                            <div class='text-success correct correct_"+slug+"_"+i+" ' style='display:none'>Wow! you have picked the  correct option (<span class='text-primary text-bold ans_"+slug+"_"+i+" '>D</span>)</div></div>"

                    container.append(ele);
                    
                });
                //load mathjax dynamically
                setTimeout(function(){
                  var script = document.createElement("script");
                  script.type = "text/javascript";
                  script.src = "https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js";   // use the location of your MathJax

                  var config = 'MathJax.Hub.Config({' +
                                 'extensions: ["tex2jax.js"],' +
                                 'jax: ["input/TeX","output/HTML-CSS"]' +
                               '});' +
                               'MathJax.Hub.Startup.onload();';

                  if (window.opera) {script.innerHTML = config}
                               else {script.text = config}

                  document.getElementsByTagName("head")[0].appendChild(script);
                console.log('Mathjax loaded');

                    },500);
                //console.log($questions);
                //container.html(data);
            });    
        });
        
    }

    $(document).on('change','.form-check-input',function(){
        $qno = $(this).data('qno');
        $slug = $(this).data('slug');
        $response = $(this).val();
        $ans = $('.q_'+$slug+'_'+$qno).data('answer');
        $('.ans_'+$slug+'_'+$qno).html($response.toUpperCase());
        $('.correct_'+$slug+'_'+$qno).hide();
        $('.incorrect_'+$slug+'_'+$qno).hide();
        if($ans.toUpperCase() == $response.toUpperCase())
        {

            $('.correct_'+$slug+'_'+$qno).show();
            confetti({
              particleCount: 100,
              spread: 70,
              origin: { y: 0.6 }
            });

        }else{
            $('.incorrect_'+$slug+'_'+$qno).show();
        }
        
    });

    $(document).on('click', '.ajaxtestsubmit', function(e) {
        var slug = $(this).data('test');
        var container= $("."+slug);
        var url = submitTestUrl2(slug);
        e.preventDefault();

        var formValues= $('.form_'+slug).serialize()+'&answers=1&evaluate=1';
        console.log(formValues);
        
        $.get(url, formValues, function(data){
            var show_answers = parseInt($('.answer_button').val());
            if(isJson(data)){
                var d = JSON.parse(data);
                if(show_answers)
                    container.html("<div class='bg-white w-100 p-3 h4'><p>Your score is "+d.score+"/"+d.total+"</p><button class='btn btn-soft-primary showanswers' data-container='"+slug+"'>Show Answers</button><button class='btn btn-soft-success ml-2 trytest' data-container='"+slug+"'>Retry Test</button></div>");
                else 
                    container.html("<div class='bg-white w-100 p-3 h4'><p>Your score is "+d.score+"/"+d.total+"</p><button class='btn btn-soft-danger ml-2 trytest' data-container='"+slug+"'>Retry Test</button></div>");
                
                $('html, body').animate({
                    scrollTop: container.offset().top - 200
                }, 500);
            }else{
                if(show_answers)
                    container.html("<div class='mb-3'>"+data+"<button class='btn btn-soft-primary showanswers' data-container='"+slug+"'>Show Answers</button><button class='btn btn-soft-success ml-2 trytest' data-container='"+slug+"'>Retry Test</button></div>");
                else
                    container.html("<div class='mb-3'>"+data+"<button class='btn btn-soft-danger ml-2 trytest' data-container='"+slug+"'>Retry Test</button></div>");
            }
            

        });
    });

    $(document).on('click', '.showanswers', function(e) {
           e.preventDefault();
        var slug = $(this).data('container');
        var container = $("."+slug);
        var url = testUrl(slug,true);
        $.get(url,function(data){
            container.html(data).append("<p class='mt-3'><button class='btn btn-soft-success ml-2 trytest' data-container='"+slug+"'>Retry Test</button></p>");
                console.log('test data pulled');
            });    
    });

    $(document).on('click', '.trytest', function(e) {
        e.preventDefault();
        var slug = $(this).data('container');
        console.log(slug);
        var container = $("."+slug);
        if(!container.length){
            $(".test_container").html("<div class='"+slug+"'> loading...</div>");
            var container = $("."+slug);
        }
        if(!container.length)
            return false;
        console.log(container+ ' here');
        var answer_button = $(this).data('answer_button');
        var testname = $(this).data('test_name');
        var testcss = $(this).data('test_css');
        var testmode = $(this).data('test_mode');
        

        if(answer_button=='yes')
            var url = testUrl(slug,false,true);
        else
            var url = testUrl(slug);

        if(testname)
            url = url+'&layout=fa';
        if(testcss)
            url = url+'&style_test=1';
        if(testmode)
            url = url+'&test_score=1';

        $.get(url,function(data){
            container.html(data);
            $('html, body').animate({
                    scrollTop: container.offset().top - 200
            }, 500);

        });    
    });


    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function submitTestUrl(slug){
        return prefix_url+'apitestget/'+slug;
    }

    function submitTestUrl2(slug){
        return prefix_url+'apitest/'+slug;
    }
    
    function testUrl(slug,answers=false,button=false){
        return prefix_url+'apitest/'+slug+'?api=1';
    }
});