<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
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
        $handle = $next($request);

        if (method_exists($handle, 'header')) {
            $handle
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, X-XSRF-TOKEN, Application, X-Perahub-Gateway-Token, X-Treasury-Token');
        } else {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, X-XSRF-TOKEN, Application, X-Perahub-Gateway-Token, X-Treasury-Token');
        }
        
        return $handle;

        // $headers = [
        //     'Access-Control-Allow-Origin' => '*',
        //     'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
        //     'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization, Access-Control-Request-Headers, X-Perahub-Gateway-Token', 'X-Treasury-Token', 
        // ];

        // if ($request->isMethod('OPTIONS'))
        // {
        //     return response()->json('{"method":"OPTIONS"}', 200, $headers);
        // }

        // $response = $next($request);
        // foreach($headers as $key => $value)
        // {
        //     /* $response->header($key, $value); */
        //     $response->headers->set($key, $value);
        // }

        // return $response;

    }
}
