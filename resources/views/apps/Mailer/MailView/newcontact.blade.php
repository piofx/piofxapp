<html>
    <body>
        <h3>New Contact</h3>
        <p>Number of People Filled the Form : {{ $counter }} </p>
            @if(!empty($details['name']))
                {{ $details['name'] }}
                {{ $details['email'] }}
                {{ $details['message'] }}
            @endif
            {!! $details['content'] !!}
    </body>
</html>