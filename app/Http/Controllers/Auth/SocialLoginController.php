<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
     
        $user = $this->createUser($getInfo, $provider);
        return $user;
 
        //auth()->login($user);
 
        //return redirect()->to('/home');
    }
    public function createUser($getInfo, $provider)
    {
        $user = User::where('social_id', $getInfo->id)->where('email',$getInfo->email)->first();
 
        if (!$user) {
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'socail_type' => $provider,
                'social_id' => $getInfo->id
            ]);
        }
        return $user;
    }
}
