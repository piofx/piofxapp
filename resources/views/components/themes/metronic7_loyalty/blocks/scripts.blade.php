

<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/plugins/global/plugins.bundle.js?v=7.0.5"></script>
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5"></script>
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/scripts.bundle.js?v=7.0.5"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.5"></script>
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/plugins/custom/gmaps/gmaps.js?v=7.0.5"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/pages/widgets.js?v=7.0.5"></script>
<!-- begin::highlight js-->
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.0.1/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<!-- end::highlight js-->

<!--begin::Page Scripts(used by this page)-->
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/pages/crud/file-upload/dropzonejs.js?v=7.2.3"></script>
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/pages/crud/forms/widgets/select2.js?v=7.0.5"></script>
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js?v=7.0.5"></script>
<!--end::Page Scripts-->

<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/pages/features/charts/apexcharts.js?v=7.0.5"></script>
<!-- <script src="https://piofx.s3.ap-south-1.amazonaws.com/themes/metronic/js/pages/widgets.js"></script> -->


<script src="{{  asset('js/codemirror/lib/codemirror.js') }}"></script>
<script src="{{asset('js/codemirror/addon/display/autorefresh.js')}}"></script>  
<script>
	var options = {
          lineNumbers: true,
          lineWrapping:true,
          styleActiveLine: true,
          matchBrackets: true,
          autoRefresh:true,
          mode: "text/x-c++src",
          theme: "eclipse",
          indentUnit: 4
        };
    if(document.getElementById("editor")){
    var editor = CodeMirror.fromTextArea(document.getElementById("editor"), options);
    editor.setSize(null, 900);
     var editor2 = CodeMirror.fromTextArea(document.getElementById("editor2"), options);
   }

   $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
   
</script>
<!--end::Page Scripts-->

<!-- contact form -->
<script>
     $(function () {
      $( "#contact_form" ).submit(function( event ) {
          alert( "Handler for .submit() called." );
          event.preventDefault();
        });
    });
</script>

<!--- end of contact form -->
<!-- Monaco editor -->
<script>
    var require = {
        paths: {
            'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs',
        }
    };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/loader.min.js"></script>
<script>
    require(['vs/editor/editor.main'], () => {
        // Initialize the editor
        if(document.getElementById("content")){
            const editor = monaco.editor.create(document.getElementById("content"), {
               theme: 'vs-dark',
               model: monaco.editor.createModel(document.getElementById("content_editor").value, "markdown"),
               wordWrap: 'on',
               minimap: {
                   enabled: true
               },
               scrollbar: {
                   vertical: 'auto'
               }
           });

           editor.onDidChangeModelContent(function (e) {
               document.getElementById('content_editor').value = editor.getModel().getValue();
            });

        }
        
        if(document.getElementById("content2")){
            const editor2 = monaco.editor.create(document.getElementById("content2"), {
            theme: 'vs-dark',
            model: monaco.editor.createModel(document.getElementById("content_editor2").value, "markdown"),
            wordWrap: 'on',
            minimap: {
                enabled: false
            },
            scrollbar: {
                vertical: 'auto'
            }
        });

        editor2.onDidChangeModelContent(function (e) {
            document.getElementById('content_editor2').value = editor2.getModel().getValue();
         });


        }
        
        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                    event.preventDefault();
                    if(document.getElementById("content") || document.getElementById("content2")){
                        $url = $('.url_codesave').attr('action');
                        var formValues= $("form").serialize();
                        saveCode($url,formValues);
                    }
                    break;
                }
            }
        });

        function saveCode($url,formValues){
            var formValues = formValues+'&api=1';
             $.post($url, formValues, function(data){
                console.log('code saved');
                $('.code_saved').show().delay(2000).fadeOut('slow');
                return false;  
            });
           
        }

    });
</script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>




<!-- Summernote Js -->
<script src="{{ asset('plugins/summernote/summernote.min.js') }}"></script>

<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>

<!-- Lightbox Plugin -->
<script src="{{ asset('plugins/lightbox2/dist/js/lightbox.min.js/lightbox.js') }}"></script>

<!-- Loyalty Js -->
<script src="{{ asset('js/loyalty/loyalty.js') }}"></script>

<!-- Blog Js -->
<script src="{{ asset('js/Blog/blog.js') }}"></script> 

<!-- Statistics Js -->
<script src="{{ asset('js/statistics/statistics.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
<script>
        $( document ).ready(function() {
            var d = new Date();
            var n = d.getTimezoneOffset();
            $('#timezone').val(n)
        });        
</script>

