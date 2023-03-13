<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerIndex()
    {
        return view('register');
    }

    public function loginIndex()
    {
        return view('login');
    }

    public function homeIndex()
    {
        return view('home');
    }

    //  submit

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
            'phone' => ['required', 'min:8', 'unique:users,phone'],
            'password' => ['required', 'min:6']
        ]);

        $user = [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ];

        User::create($user);
        // you can add toast or alert
        return redirect(route('login.index'));
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'exists:users,phone'],
            'password' => ['required', 'min:6']
        ]);

        $checkUser = User::where('phone', $request->phone)->first();



        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            // now go to otp screen for first time login
            if ($checkUser->is_phone_verify == false) {
                return view('otp')->with('phone', $checkUser->phone);
            }
            // login success
            // you can show alert for success
            return redirect(route('home.index'));
        } else {
            // login info wrong
            // you can show alert for error
            return back();
        }
    }

    public function otpVerified()
    {
        User::where('id', Auth::id())->update(['is_phone_verify' => true]);
        return redirect(route('home.index'));
    }
}
