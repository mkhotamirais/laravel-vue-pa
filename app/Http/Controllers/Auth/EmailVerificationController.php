<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        // jika sudah verifikasi email, redirect ke home
        if (request()->user()->hasVerifiedEmail()) {
            return redirect()->route('public.home');
        }
        $msgVerify = session('msgVerify');
        return inertia('Auth/VerifyEmail', compact('msgVerify'));
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('dashboard');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('msgVerify', 'Verification link sent!');
    }
}
