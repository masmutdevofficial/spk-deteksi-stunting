<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function chooseRole()         { return view('login'); }
    public function showAdminForm()      { return view('login-admin'); }
    public function showTenagaForm()     { return view('login-tenaga-medis'); }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();

            // Redirect berdasarkan level
            return redirect()->intended($user->level == 2 ? '/data-bayi' : '/konsultasi');
        }

        return back()->with('error', 'Login Admin gagal, cek kembali data Anda.');
    }

    public function loginTenaga(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();

            return redirect()->intended($user->level == 2 ? '/data-bayi' : '/konsultasi');
        }

        return back()->with('error', 'Login Tenaga Medis gagal, cek kembali data Anda.');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login.choose')->with('success','Berhasil logout.');
    }
}
