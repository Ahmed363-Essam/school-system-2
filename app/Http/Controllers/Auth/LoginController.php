<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\AuthTrait;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Traits;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthTrait;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function loginForm($type)
    {

 
        return view('auth.login', compact('type'));
    }

    public function login(Request $request)
    {


        if (Auth::guard($this->checkGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication was successful...

       

            return $this->redirect($request);
        }


    }

    public function logout(Request $request,$type)
    {
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
