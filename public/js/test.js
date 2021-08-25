$(function(){

    var prefix_url = 'https://prep.firstacademy.in/';

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
                container.html(data);
            });    
        });
        
    }

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
        var container = $("."+slug);
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
        if(answers)
            return prefix_url+'apitest/'+slug+'?answers=1';
        else if(button)
            return prefix_url+'apitest/'+slug+'?answer_button=1';
        else
            return prefix_url+'apitest/'+slug+'?none=1';
    }
});