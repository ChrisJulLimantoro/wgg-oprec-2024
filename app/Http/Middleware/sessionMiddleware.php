<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class sessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('email')){
            session()->flush();

            // allow intended redirect to these urls
            $allowedIntent = ['admin/interview/*', 'admin/applicant-cv/*', 'admin/interview/reschedule'];   

            foreach($allowedIntent as $intent){
                if($request->is($intent)) {
                    session()->put('url.intended', $request->url());
                    break;
                }
            }

            return redirect()->to(route('login'))->with('error','Session Expired, You need to login again!');
        }
        return $next($request);
    }
}
