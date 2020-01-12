<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Login Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles authenticating users for the application and
		    | redirecting them to your home screen. The controller uses a trait
		    | to conveniently provide its functionality to your applications.
		    |
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/user';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		Config::set('auth.defaults.guard', 'admin');
		$this->middleware('guest')->except('logout');
	}

	public function showLoginForm() {
		return view('auth.admin_login');
	}

}
