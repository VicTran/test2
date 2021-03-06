@extends('layouts.master')

@section('title')

    <title>Users</title>

@endsection

@section('content')

    <ol class='breadcrumb'>
        <li><a href='/'>Home</a></li>
        <li class='active'>Users</li>
    </ol>

    @if(Auth::user()->isAdmin())
    <div class="pull-right">

        <a href="{{ url('/user/create') }}">

            <button type="button" class="btn btn-lg btn-primary">

                Create User

            </button>

        </a>

    </div>
    @endif

    <h2>Users</h2>

    <hr/>

    @if($users->count() > 0)

        <table class="table table-hover table-bordered table-striped">

            <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Admin</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Edit</th>
            <th>Delete</th>
            </thead>

            <tbody>

            @foreach($users as $user)

                <tr id="user{{$user->id}}">
                    <td>{{ $user->id }}</td>
                    <td><a href="/user/{{ $user->id }}">{{ $user->name }}</a></td>
                    <td>{{ $user->showAdminStatusOf($user) }}</td>
                    <td>{{ $user->showStatusOf($user) }}</td>
                    <td>{{ $user->created_at->format('m-d-Y') }}</td>


                        <td> <a href="/user/{{ $user->id }}/edit">

                            <button type="button" class="btn btn-default">Edit</button></a></td>

                    <td>
                        <div class="form-group">
                            <button class="btn btn-danger  btn-delete delete-task" value="{{$user->id}}">Delete</button>
                        </div>
                    </td>
                </tr>

            @endforeach

            </tbody>

        </table>



    @else

        Sorry, no Users

    @endif

    {{ $users->links() }}




@endsection