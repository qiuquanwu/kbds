<?php

namespace App\Http\Middleware;

use Closure;
use App\AdminUser;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$request->cookie('token');
        $adminUser=AdminUser::where('token',$token)->first();
        if($adminUser){
             return $next($request);
        }else{
            return response()->json([
                'code'=>204,
                'data'=>'',
                'message'=>'token不存在或已过期，请重新登录！'
            ]);
        }

    }
}
