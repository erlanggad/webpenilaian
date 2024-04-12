<?php

namespace App\Http\Controllers;

use App\Mail\SendOTP;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Forgot_Password extends Controller
{
    public function index()
    {
        return view('forgot_password');
    }



    public function sendOTP(Request $request)
    {

        // return view('verify_otp');

        $request->validate([
            'email' => 'required|email'
        ]);

        $user = Pegawai::where('email', $request->email)->first();

        // dd($request);
        // return response()->json(['message' => $request]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Save OTP to user table
        $user->otp = $otp;
        $user->save();

        // Send OTP to user's email
        // dd($user);
        // return redirect()->route('verify-otp');
        if($user == null) {
            Session::flash('email','Email Tidak Ada');
            return Redirect('/lupapassword');
        } else {
            Mail::to($user->email)->send(new SendOTP($otp));

            Session::flash('showmodal',$user->email);
            return Redirect('/forgot-password');
        }
    }

    public function showOTPForm()
    {
        return view('verify_otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = Pegawai::where('otp', $request->otp)->first();

        // if (!$user) {
        //     return redirect()->back()->with('error', 'Invalid OTP');
        // }

        // return redirect()->route('reset-password');

        if($user != null) {
            return response()->json([
                'status' => 1,
                'message' => 'success otp',
            ]);
        } else {
            return response()->json([
                'status' => 2,
                'message' => 'gagal otp',
            ]);
        }
    }

    public function showResetPasswordForm(Request $req)
    {
        if ($req->otp != null) {
            $data = Pegawai::where('otp', $req->otp)->where("email", $req->email)->first();
                    // ->where("otp", $req->otp)
                    // ->where("email", $req->email)
                    // ->first();
        return view('reset_password', compact('data'));
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = Pegawai::where('email', $request->email)->where('otp', $request->otp)->update([
            "password" => $request->password
        ]);;

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid OTP');
        }

        return redirect('/login');
    }



    // public function store(Request $request)
    // {
    //     if (Karyawan::create($request->all())) {
    //         return redirect('/login')->with('success', 'Berhasil membuat karyawan');
    //     } else {
    //         return redirect('/login')->with('failed', 'Gagal membuat karyawan');
    //     }
    // }
}
