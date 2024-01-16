<?php

namespace App\Http\Middleware;

use App\Models\Division;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userDivisionId = session('division_id');
        $divisionSlugsWithFullAccess = ['bph', 'it'];
        $divisionIdsWithFullAccess = Division::whereIn('slug', $divisionSlugsWithFullAccess)->pluck('id')->toArray();

        if (in_array($userDivisionId, $divisionIdsWithFullAccess)) {
            return $next($request);
        }

        $pageDivision = $request->route()->parameter('division');

        if (!$pageDivision || $userDivisionId != $pageDivision->id) {
            return redirect()->route('admin.project', ['division' => $userDivisionId]);
        } else {
            return $next($request);
        }
    }
}
