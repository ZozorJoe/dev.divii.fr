<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Web\WebController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends WebController
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        if($user->hasVerifiedEmail()){
            return redirect()
                ->route('login');
        }

        return view('auth.verify-email')
            ->with('model', $user);
    }

    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        try{
            $user->sendEmailVerificationNotification();
        }catch (\Exception $e){
            return back()
                ->with('error', $e->getMessage());
        }

        return back()
            ->with('success', 'Verification link sent!');
    }

    public function update(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/');
    }
}
