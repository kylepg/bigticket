<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Define redirect paths for error, logout and login
     */
    protected $loginPath = '/login';
    protected $redirectAfterLogout = '/';
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Microsoft Azure authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToAzure()
    {
        return Socialite::driver('azure')->redirect();
    }

    /**
     * Obtain the user information from Microsoft Azure.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleAzureCallback()
    {
        $user = Socialite::driver('azure')->user();

        // $user->token;
    }
}
