<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
        ];
    }

    protected function login(Request $request)
    {



        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_super_admin == 1) {
                return redirect()->route('panel.index');
            } elseif ($user->is_admin == 1) {
                return redirect()->route('panel.index');
            } else {
                return redirect()->intended($this->redirectTo);
            }
        }

        return redirect()->back()
        ->withInput($request->only('email'))
        ->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

}
