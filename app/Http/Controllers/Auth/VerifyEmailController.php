<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME)->with('error','Email already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            $user = $request->user();
            $user->status = 1;
            $user->save();

            event(new Verified($request->user()));
        }

        //dd("eher");
        return redirect(route('verified-email'))->with('success','Email verified successfully.');
    }

    public function verifiedEmail(){
        return view('auth.verified-email');
    }

}
