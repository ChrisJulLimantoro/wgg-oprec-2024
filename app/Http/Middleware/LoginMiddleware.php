<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Applicant;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( session()->has('admin_id') ){
            return redirect()->route('admin.dashboard');
        }else if( session()->has('applicant_id')){
            $stage = Applicant::where('id', session('applicant_id'))->first()->stage;
            if($stage == 1){
                return redirect()->route('applicant.documents-form');
            }else if($stage == 2 && $stage == 3){
                return redirect()->route('applicant.schedule-form');
            }else if($stage == 4){
                return redirect()->route('applicant.projects-form');
            }
            return redirect()->route('applicant.application-form');
        }else if( session()->has('email')){
            return redirect()->route('applicant.application-form');
        }
        return $next($request);
    }
}
