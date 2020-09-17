<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Socialite;
use Modules\Users\Entities\User;

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
        $azure_user = Socialite::driver('azure')->user();
        $user = User::firstOrCreate(
            [
                'provider' => 'azure',
                'provider_id' => $azure_user->id
            ],
            [
                'name' => $azure_user->name,
                'email' => $azure_user->email
            ]
        );
        Auth::login($user);
        return redirect()->intended(property_exists($this,'redirectTo') ? $this->redirectTo : '/');
    }

    /**
     * Log out
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect(property_exists($this,'redirectTo') ? $this->redirectTo : '/');
    }
}
