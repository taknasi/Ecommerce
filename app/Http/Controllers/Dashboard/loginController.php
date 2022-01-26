<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.login');
    }

    public function postLogin(AdminLoginRequest $request)
    {
        $rmember_me = $request->has('remember_me') ? true : false;
        if (auth()->guard('admin')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $rmember_me)) {
            return redirect()->route('dashboard.index');
        }
        return redirect()->back()->with(['error' => 'هناك خطأ في البيانات']);
    }
}
