<?php

namespace App\Http\Controllers;

use App\Models\TbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route("dashboard");
        }

        return view("auth.login");
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            "user_name" => ["required", "string"],
            "password" => ["required", "string"],
        ]);

        $user = TbUser::where("user_name", $validated["user_name"])
            ->where("user_aktif", 1)
            ->first();

        if ($user && password_verify($validated["password"], $user->user_password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(route("dashboard"));
        }

        return back()
            ->withErrors(["user_name" => "Username atau password salah, atau akun nonaktif."])
            ->onlyInput("user_name");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/login");
    }
}