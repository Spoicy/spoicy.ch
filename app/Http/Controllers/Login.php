<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    /** 
     * Validates the user inputted password.
     * 
     * @param Request $request
     * @return void $redirect
     */
    public static function validateLogin(Request $request) {
        $password = $request->request->get("loginPass");
        $token = csrf_token();
        if ($password && $token == $request->request->get("_token")) {
            $passwordHash = Hash::make($password);
            if (Hash::check($password, env("BLOG_PASS"))) {
                $request->session()->put('loggedin', $password);
                return redirect('/blog');
            }
            return redirect('/blog/login')->with('status', 1);
        }
    }

    /**
     * Returns the view for the login page.
     * 
     * @return View $view
     */
    public static function view(): \Illuminate\Contracts\View\View {
        return view('pages/login');
    }
}
