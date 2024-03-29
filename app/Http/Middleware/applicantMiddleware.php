<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use App\Models\Applicant;

class applicantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $active = Setting::where('key','Active')->first();
        if ($active->value == 0 && !session('isAdmin')){
            if(session('applicant_id') == null){
                return redirect()->route('applicant.comming.soon');
            }else{
                $app = Applicant::where('id',session('applicant_id'))->get()->first();
                if($app->stage <= 3){
                    return redirect()->route('applicant.comming.soon');
                }
            }
        }
        return $next($request);
    }
}
