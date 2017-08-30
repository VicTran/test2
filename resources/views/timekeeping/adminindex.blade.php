@extends('layouts.master')

@section('title')

    <title>TimeKeeping</title>

@endsection

@section('content')

    <ol class='breadcrumb'>
        <li><a href='/'>Home</a></li>
        <li class='active'>timekeeping</li>
    </ol>

    <h2>TimeKeeping</h2>

    <hr/>
    <form method="GET" action="">
        <input type="" name="week" value="" placeholder="nhap tuan">
        <button type="submit"> Tim </button>
    </form>
    <table class="table table-hover table-bordered table-striped">

        <thead>
        <th>UserId</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
        </thead>

        @foreach($statuses as $key => $status )
            <tr>
                <td>{{$key}}</td>
                @foreach($status as $item)
                    @if($item == 1)
                        <td><button type="button" class="btn btn-success">Yes</button></td>
                    @elseif($item == 0)
                        <td><button type="button" class="btn btn-danger">No</button></td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach

    </table>





    <div>Sorry, no profiles</div>




@endsection