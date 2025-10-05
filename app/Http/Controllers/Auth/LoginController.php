<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->estado == 0) {
            $this->auth()->logout(); // <- 
            return redirect('/login')->withErrors(['email' => 'Su cuenta está desactivada. Por favor, contacte al administrador.']);
        }

        // if($user->isSuperAdmin()) {
        //     return redirect('/admin');
        // }

        if($user->is_owner == 1 && $user->hasRole('admin')) {
            return redirect('/workspace/dashboard');
        } else {
            return redirect('/home');
        }

    }

}
