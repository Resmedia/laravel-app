<?php

namespace App\Http\Controllers\Admin;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: rogozhuk
 * Date: 18.02.20
 * Time: 13:26
 */

class IndexController extends Controller
{
    public function index(): View
    {
        return view('admin.main.index');
    }

    /*public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
    }*/
}