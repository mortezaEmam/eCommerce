<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function RedirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handelProviderCallback($provider)
    {
        try {
            $socialite_user = Socialite::driver($provider)->user();
            $user = User::query()->where('email',$socialite_user->getEmail())->first();

            if (blank($user)) {
                $user = User::query()->create([
                    'name' => $socialite_user->getName(),
                    'email' => $socialite_user->getEmail(),
                    'avatar' => $socialite_user->getAvatar(),
                    'password' => Hash::make($socialite_user->getId()),
                    'provider_name' => $provider,
                    'email_verified_at' => Carbon::now(),
                ]);
            }
            Auth::login($user,remember:true );
            alert()->success('خوش آمدید','گرامی به سایت من خوش اومدی'.$user->name);
        } catch (\Exception $ex) {
            alert()->error('اوه مشکلی پیش اومده!!', $ex->getMessage());
            return redirect()->route('login');
        }
return redirect(RouteServiceProvider::HOME);
    }
}
