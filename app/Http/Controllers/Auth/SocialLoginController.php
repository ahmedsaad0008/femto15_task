<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Socialite;

class SocialLoginController extends Controller {
	public function redirectToProvider($provider) {
		return Socialite::driver($provider)->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function handleProviderCallback($provider) {
		$getInfo = Socialite::driver($provider)->user();
		$user = User::where('social_id', $getInfo->id)->Where('email', $getInfo->email)->first();
		if (!User::Where('email', $getInfo->email)->first()) {
			$user = $this->createUser($getInfo, $provider);
			auth()->login($user);
			return redirect()->to('/home');
		} elseif ($user && $user->active) {
			auth()->login($user);
			return redirect()->to('/home');
		} else {
			$error = "email was found";
			return redirect()->to('/login')->withErrors(['msg' => $error]);
		}
	}
	public function createUser($getInfo, $provider) {
		$user = User::create([
			'name' => $getInfo->name,
			'email' => $getInfo->email,
			'social_type' => $provider,
			'social_id' => $getInfo->id,
		]);
		$user->markEmailAsVerified();
		return $user;
	}
}
