<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/calendar',
            ])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent',
            ])
            ->redirect();
    }


    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where(
            'email',
            $googleUser->email
        )->first();

        if (!$user) {

            return Socialite::driver('google')
                ->scopes([
                    'https://www.googleapis.com/auth/calendar'
                ])
                ->with([
                    'access_type' => 'offline',
                    'prompt' => 'consent',
                ])->redirect();
        }

        $user->update([

            'google_id' => $googleUser->id,

            'google_token' => $googleUser->token,

            'google_refresh_token' =>
                $googleUser->refreshToken,

            'google_token_expires_at' => now()->addSeconds(
                $googleUser->expiresIn
            ),

        ]);

        Auth::login($user);

        return redirect()
            ->route('backend.index')
            ->with(
                'message',
                'Google Calendar Connected Successfully!'
            );
    }
}