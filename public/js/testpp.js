
$(function(){

    var prefix_url = 'https://learn.packetprep.com/';

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
                    ele = "<div class='row no-gutters q_"+slug+"_"+i+"' data-answer='"+d.answer+"' >\
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
                            <div class='text-success correct correct_"+slug+"_"+i+" ' style='display:none'>Wow! you have picked the  correct option (<span class='text-primary text-bold ans_"+slug+"_"+i+" '>D</span>)</div>\
                            <div class='bg-soft-success p-3 rounded mt-1 explanation_"+slug+"_"+i+" ' style='display:none'><h5>Explanation</h5>"+d.explanation.replace("'","")+"</div></div>"

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
            if(!$('.expl_'+$slug+'_'+$qno).length){
                $('.correct_'+$slug+'_'+$qno).append("&nbsp;<span class='text-primary explanation expl_"+$slug+"_"+$qno+"' style='cursor:pointer' data-anchor='explanation_"+$slug+"_"+$qno+"' > view explanation</span>");
            }
            confetti({
              particleCount: 100,
              spread: 70,
              origin: { y: 0.6 }
            });

        }else{
            $('.incorrect_'+$slug+'_'+$qno).show();
            if(!$('.expll_'+$slug+'_'+$qno).length){
                $('.incorrect_'+$slug+'_'+$qno).append("&nbsp;<span class='text-primary explanation expll_"+$slug+"_"+$qno+"' style='cursor:pointer' data-anchor='explanation_"+$slug+"_"+$qno+"' > view explanation</span>");
            }
        }
        
    });

    $(document).on('click','.explanation',function(){
        var item = $(this).data('anchor');
        $('.'+item).toggle();
    });

 

 


    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }


    
    function testUrl(slug,answers=false,button=false){
        return prefix_url+'apitest/'+slug+'?api=1';
    }
});