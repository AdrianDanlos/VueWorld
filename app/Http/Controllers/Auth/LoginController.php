<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    }


    //The next 2 methods are overriding authenticated and loggedOut methods declared in AuthenticatesUsers class. 
    //We override them because we are woriking with a SPA, therefore we do not want to be redirected when logged in or logged out.
    protected function authenticated(Request $request, $user)
    {
        if ($request->isXmlHttpRequest()) { //If the request is an ajax call (sent by axios) instead of a regular form request.
            return response(null, 204);
        }
    }

    protected function loggedOut(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return response(null, 204);
        }
    }
}
