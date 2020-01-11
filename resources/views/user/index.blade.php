@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-sm">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Active</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @if($user->active)
                    <td>
                        <form action="{{ route('user.deactivate', $user->id)}}" method="post">
                        @csrf
                            <button type="submit" class="btn btn-dark">InActive</button>
                        </form>
                    </td>
                    @else
                    <td>
                        <form action="{{ route('user.activate', $user->id)}}" method="post">
                        @csrf
                            <button type="submit" class="btn btn-success">Active</button>
                        </form>
                    </td>
                    @endif
                    <td>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('user.destroy', $user->id)}}" method="post">
                                @method('DELETE')
                                @csrf
                                <button  type="submit" class="btn btn-danger btn-block" type="submit">Delete</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning btn-block">Update</a>
                        </div>
                    </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
