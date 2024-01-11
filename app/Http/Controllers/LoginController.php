<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->position == "Admin" && $user->authorization_level == 2) {
                return redirect()->route('dashboardAdmin');
            } else if ($user->position == "Staff Human Resource" && $user->authorization_level == 1) {
                return redirect()->route('dashboardHR');
            } else if (($user->position == "Staff Inventory" && $user->authorization_level == 1) || ($user->position == "Supplier" && $user->authorization_level == 1)) {
                return redirect()->route('dashboardInven');
            } else if ($user->position == "Staff Sales" && $user->authorization_level == 1) {
                return redirect()->route('dashboardSales');
            } else if ($user->position == "Staff Finance" && $user->authorization_level == 1) {
                return redirect()->route('dashboardFinance');
            }
        }
        return back()->with('loginError', 'Login Failed!');
    }

    // protected function authenticated(Request $request, $user)
    // {

    //     if ($user->position == "Staff Human Resource") {
    //         return redirect()->intended('dashboard');
    //     }

    //     if ($user->position == "Staff Inventory") {
    //         return redirect()->route('dashboardInven');
    //     }

    //     return redirect('/home');
    // }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function callCenter()
    {
        return view('auth.CC');
    }
}
