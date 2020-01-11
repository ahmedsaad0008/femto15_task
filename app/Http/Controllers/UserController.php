<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::when(request()->has('query'), function ($q) {
            $q->where('name', 'LIKE', '%'.request('query').'%')
            ->orWhere('name', 'LIKE', '%'.request('query').'%');
        })->paginate(30);
        return view('user.index',compact($users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    public function update(Request $request, $id)
    {
        $rules = [
			'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
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
			return redirect('/users')->with('success', 'user has been updated');
		} else {
			return redirect('/users/' . $id . '/edit')->with('errors', $vresult->errors());
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'user has been deleted Successfully');
    }

    /**
     * deactive the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactive($id)
    {
        $user=User::find($id);
        $deactive = $user->update(['active'=>false]);
        if ($deactive) {
            return redirect('/users')->with('success', 'user has been deactivated Successfully');
        }
    }

    /**
     * active the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $user=User::find($id);
        $active = $user->update(['active'=>true]);
        if ($active) {
            return redirect('/users')->with('success', 'user has been activated Successfully');
        }
    }


}
