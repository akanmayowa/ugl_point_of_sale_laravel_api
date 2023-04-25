<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnums;
use App\Traits\ResponseTraits;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{

    use ResponseTraits;
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user && $user->user_role === UserRoleEnums::Admin) {
            return $next($request);
        }

        return $this->errorResponse('You Dont Have Admin Access',401);
    }
}
