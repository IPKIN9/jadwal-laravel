<?php

namespace App\Http\Controllers;

use App\Interfaces\UserManageInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private UserManageInterface $userRepo;
    public function __construct(UserManageInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index ()
    {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        } else {
            return view('page.Login');
        }
    }

    public function getToken(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect(route('dashboard'));
        }
 
        return back()->with('statusErr', 'Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'))->with('status', 'Berhasil Logout');
    }
}
