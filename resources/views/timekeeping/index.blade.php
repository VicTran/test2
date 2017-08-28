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
            <th>UserName</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
            </thead>
            <tr> 
                <td><button type="button" class="btn btn-default">tung</button></td>
                @foreach($status as $statu )
                    @if($statu == 2)
                        <td></td>
                    @endif
                    @if($statu == 1)
                        <td><button type="button" class="btn btn-success">Yes</button></td>
                    @endif
                    @if($statu == 0)
                        <td><button type="button" class="btn btn-danger">No</button></td>
                    @endif

                @endforeach
            </tr>
          

        </table>





        <div>Sorry, no profiles</div>




@endsection