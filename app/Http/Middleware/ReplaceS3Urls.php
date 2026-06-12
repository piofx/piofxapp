<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReplaceS3Urls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only process HTML responses
        if ($response->headers->get('Content-Type') &&
            strpos($response->headers->get('Content-Type'), 'text/html') !== false) {

            $content = $response->getContent();

            // Replace all S3-style URLs (AWS S3 and Wasabi) with local paths
            $content = preg_replace(
                '#https?://[a-z0-9.\-]+\.(?:amazonaws|wasabisys)\.com/#',
                '',
                $content
            );

            $response->setContent($content);
        }

        return $response;
    }
}
