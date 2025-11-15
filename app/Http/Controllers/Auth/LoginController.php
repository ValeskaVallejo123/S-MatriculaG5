<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Credenciales incorrectas.');
        }

        return $this->authenticated($request, Auth::user());
    }

    protected function authenticated(Request $request, $user)
    {
        if (str_ends_with($user->email, '@gmail.edu')) {
            $user->rol = 'admin';
            $user->save();
            return redirect()->route('admins.index');
        }

        $user->rol = 'estudiante';
        $user->save();
        return redirect()->route('matriculas.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.show');
    }
}
