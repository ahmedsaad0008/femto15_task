<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::when(request()->has('query'), function ($q) {
			$q->where('name', 'LIKE', '%' . request('query') . '%')
				->orWhere('email', 'LIKE', '%' . request('query') . '%');
		})->paginate(30);
		return view('user.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$user = User::find($id);
		return view('user.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$rules = [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		];
		$vresult = Validator::make(request()->all(), $rules);
		if (!$vresult->fails()) {
			$user = User::find($id);
			$update = $user->update([
				'name' => request('name'),
				'email' => request('email'),
				'password' => Hash::make(request('password')),
			]);
			return redirect('/user')->with('success', 'user has been updated');
		} else {
			return redirect('/user/' . $id . '/edit')->with('errors', $vresult->errors());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$user = User::find($id);
		$user->delete();
		return redirect('/user')->with('success', 'user has been deleted Successfully');
	}

	/**
	 * deactive the specified user from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function deactivate($id) {
		$user = User::find($id);
		$deactivate = $user->update(
			['active' => false]);
		if ($deactivate) {
			return back();
		}
	}

	/**
	 * active the specified user from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function activate($id) {
		$user = User::find($id);
		$activate = $user->update(['active' => true]);
		if ($activate) {
			return back();
		}
	}

	/**
	 * active the specified user from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function chart() {
		$days = User::selectRaw("DATE(created_at) as day")->pluck('day');
		$data = [];
		foreach ($days as $day) {
			$users = User::whereDate('created_at', $day)->count();
			array_push($data, ['y' => $users, 'label' => $day]);
		}
		$jsonData = json_encode($data, JSON_NUMERIC_CHECK);
		return view('user.chart', compact('jsonData'));
	}

}
