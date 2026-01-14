<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:6',
            ],
            [
                'name.required' => 'নাম অবশ্যই দিতে হবে।',

                'email.required' => 'ইমেইল দিতে হবে।',
                'email.email'    => 'সঠিক ইমেইল ঠিকানা লিখুন।',
                'email.unique'   => 'এই ইমেইলটি আগে থেকেই ব্যবহার করা হয়েছে।',

                'password.required' => 'পাসওয়ার্ড দিতে হবে।',
                'password.min'      => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(
            [
                'message' => 'Registration Successful',
                "data" => $user
            ]
        );
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ],
            [
                'email.required' => 'ইমেইল অবশ্যই দিতে হবে',
                'email.email' => 'সঠিক ইমেইল ঠিকানা দিন',

                'password.required' => 'পাসওয়ার্ড দিতে হবে',
                'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে',
            ]
        );

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid Login'], 401);
        }

        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    // public function sendOtp(Request $request)
    // {
    //     $user = User::where('email',$request->email)->first();

    //     if(!$user) return response()->json(['error'=>'User not found']);

    //     $otp = rand(100000,999999);

    //     $user->update([
    //         'otp'=>$otp,
    //         'otp_expire'=>now()->addMinutes(10)
    //     ]);

    //     return response()->json(['message'=>'OTP sent','otp'=>$otp]);
    // }

    public function sendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expire' => now()->addMinutes(10)
        ]);

        // ✅ Send OTP Email
        Mail::to($user->email)->send(new SendOtpMail($otp));

        return response()->json([
            'message' => 'OTP sent to email successfully'
        ]);
    }



    public function verifyOtp(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expire', '>', now())
            ->first();


        if (!$user) {
            return response()->json(['error' => 'Invalid OTP']);
        }

        $user->update([
            'otp' => 111,
            'otp_expire' => null
        ]);

        return response()->json(['message' => 'OTP verified']);
    }


    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email,)
            ->where('otp', 111)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Password Reset Fail']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expire' => null
        ]);

        return response()->json(['message' => 'Password reset successful']);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successful']);
    }
}
