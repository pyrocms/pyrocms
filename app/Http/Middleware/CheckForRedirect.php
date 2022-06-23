<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Streams\Core\Support\Facades\Streams;

class CheckForRedirect
{
    public function handle(Request $request, Closure $next)
    {
        $redirects = Streams::entries('redirects')->get();

        $match = $redirects->first(
            fn ($entry) => Str::is($entry->from, $request->Is ())
        );

        if ($match) {
            return Redirect::to($match->to, $match->status);
        }

        return $next($request);
    }
}
