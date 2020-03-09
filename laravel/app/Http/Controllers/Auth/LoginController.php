<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        session()->get('soc.token');
        if(Auth::id()){
            return redirect('/');
        }
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback(UserRepository $userRepository)
    {
        $user = Socialite::driver('github')->user();
        //dump($user);
        session(['soc.token' => $user->token]);
        $socialUser = $userRepository->getUserBySocId($user, 'github');
        if(!$socialUser) {
            return redirect('/login')->with('error', 'Такой email есть уже в системе!');
        }
        Auth::login($socialUser);
        return redirect('/')->with('success', 'Добро пожаловать ' . $user->getName() . ' пользователь GitLab');
    }
}
