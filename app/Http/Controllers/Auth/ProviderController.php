<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    //

    public function redirect($provider) 
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) 
    {
        try {
            $SocialUser = Socialite::driver($provider)->user();
            if(User::where('email', $SocialUser->getEmail())->exists()) {
                $user = User::where('email', $SocialUser->getEmail())->first();
                Auth::login($user);
                return redirect()->route('home');
            }

            $user = User::where([
                'provider' => $provider,
                'provider_id' =>  $SocialUser->id,
            ])->first();
          
            if($user == null) {
                // dd($SocialUser->id);
                $user = User::create([
                    'name' => $SocialUser->name,
                    'email' => $SocialUser->email,
                    'provider' => $provider,
                    'provider_id' => $SocialUser->id,
                    'provider_token' => $SocialUser->token,
                    'email_verified_at' => now(),
                    'role_id' => 1,
                    'user_status_id' => 1
                ]);

                // dd($user, 'đã tạo được user');

                Auth::guard('web')->login($user);
                
                return redirect()->route('home');
            }
        } catch (\Exception $th) {
            //throw $th;
            // dd($th  );
            return redirect()->route('auth.index');
        }
       
    }
}
