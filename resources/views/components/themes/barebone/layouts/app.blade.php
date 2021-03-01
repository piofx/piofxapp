@if(request()->get('app.theme.prefix')) {!! request()->get('app.theme.prefix') !!} @endif
{{$slot}}
@if(request()->get('app.theme.suffix')) {!! request()->get('app.theme.suffix') !!} @endif