

<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('themes/metronic/plugins/global/plugins.bundle.js?v=7.0.5')}}"></script>
<script src="{{ asset('themes/metronic/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5')}}"></script>
<script src="{{ asset('themes/metronic/js/scripts.bundle.js?v=7.0.5')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('themes/metronic/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.5') }}"></script>
<script src="{{ asset('themes/metronic/plugins/custom/gmaps/gmaps.js?v=7.0.5')}}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('themes/metronic/js/pages/widgets.js?v=7.0.5')}}"></script>
<!-- begin::highlight js-->
<script src="{{  asset('js/highlight/highlight.pack.js') }}"></script>
<script>hljs.initHighlightingOnLoad();</script>
<!-- end::highlight js-->

<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('themes/metronic/js/pages/features/charts/apexcharts.js?v=7.0.5') }}"></script>
<script src="{{ asset('js/loyalty/loyalty.js') }}"></script>

<script src="{{  asset('js/codemirror/lib/codemirror.js') }}"></script>
<script src="{{  asset('js/codemirror/mode/javascript/javascript.js') }}"></script>
<script src="{{asset('js/codemirror/mode/xml/xml.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/javascript/javascript.js')}}"></script> 
<script src="{{asset('js/codemirror/mode/clike/clike.js')}}"></script>  
<script src="{{asset('js/codemirror/addon/display/autorefresh.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/markdown/markdown.js')}}"></script>  
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
     var editor2 = CodeMirror.fromTextArea(document.getElementById("editor2"), options);
   }
</script>
<!--end::Page Scripts-->