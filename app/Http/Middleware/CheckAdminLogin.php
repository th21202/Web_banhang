<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utilities\Constant;

class CheckAdminLogin
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
        //neu chua dang nhap: chuyen huong toi trang dang nhap
        // if(Auth::guest()){
        //     return redirect()->guest('admin/login');
        // }
        // //neu da dang nhap, nhung sai level: dang xuat va dang nhap lai
        // if(Auth::user()->level != Constant::user_level_host && Auth::user()->level != Constant::user_level_admin){
        //     Auth::logout();
        //    return  redirect()->guest('admin/login'); 
        // }
        // return $next($request);
        // if (Auth::check()) {
        //     return redirect()->guest('admin/login');
        // }
    
        // // Nếu đã đăng nhập, nhưng có level không hợp lệ, đăng xuất và đăng nhập lại
        // if (Auth::user()->level != Constant::user_level_host && Auth::user()->level != Constant::user_level_admin) {
        //     Auth::logout();
        //     return redirect()->guest('admin/login');
        // }
    
        // return $next($request);

        
         //neu chua dang nhap: chuyen huong toi trang dang nhap   
        if (!Auth::check()) {
            return redirect()->guest('admin/login');
        }
    
        // Kiểm tra level của người dùng
        $userLevel = Auth::user()->level;
        $validLevels = [Constant::user_level_host, Constant::user_level_admin];
    
        if (!in_array($userLevel, $validLevels)) {
            Auth::logout();
            return redirect()->guest('admin/login');
        }
    
        return $next($request);
    }
}
