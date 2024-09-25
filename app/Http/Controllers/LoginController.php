<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->with('errors', $validator->errors());
        }

        if (!Auth::attempt($validator->validated())){
            return back()->with('errors', 'invalid credentials');
        }

        return $this->redirect();
    }

    public function redirect()
    {
        $role = Auth::user()->role;
        
        if ($role == 'admin')
        {
            return redirect()->route('filament.admin.pages.dashboard');
        }

        if ($role == 'supervisor')
        {
            return redirect()->route('filament.supervisor.pages.dashboard');
        }

        return redirect()->route('filament.division.pages.dashboard');
    }
}
