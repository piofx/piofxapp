@php
        if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
            $ext = 'webp';
        }
        else{
            $ext = 'jpg';
        }
        echo $ext;
    @endphp