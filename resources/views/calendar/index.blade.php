@extends('layouts.master')

@section('title')

    <title>Calendar</title>

@endsection

@section('content')

    <ol class='breadcrumb'>
        <li><a href='/'>Home</a></li>
        <li class='active'>Calendars</li>
    </ol>

    <h2>Calendars</h2>

    <hr/>

    @if($calendars->count() > 0)

        <table class="table table-hover table-bordered table-striped">

            <thead>
            <th>Id</th>
            <th>Date</th>
            <th>Moring</th>
            <th>Evening</th>
            </thead>

            <tbody>

            @foreach($calendars as $calendar)

                <tr>
                    <td>{{ $calendar->id }}</td>
                    <td>{{ $calendar->date->format('d-m-Y') }}</td>
                    @if($calendar->status == 1)
                    <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                    @else
                    <td> </td>
                    @endif
                    @if($calendar->status == 0)
                    <td> <i class="fa fa-check" aria-hidden="true"></i></td>
                    @else
                    <td> </td>
                    @endif      

                </tr>

            @endforeach

            </tbody>

        </table>

        {{ $calendars->links() }}

    @else

        <div>Sorry, no calendars</div>

    @endif





@endsection