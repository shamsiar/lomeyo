<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Country;  //country model
use Route;

class CountryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //$countryShortcode = $request->route('country');  //get country part from url
        $country = Country::where('status', '=', 1)->first();
        if ($country === null) {
            return redirect('/');
        }
        $request->session()->put('country', $country);
        $request->session()->save();
        return $next($request);
    }
}
