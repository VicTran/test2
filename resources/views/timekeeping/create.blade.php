@extends('layouts.master')

@section('title')

    <title>Create a Calendar</title>

@endsection

@section('content')

    <ol class='breadcrumb'>
        <li><a href='/'>Home</a></li>
        <li class='active'>Create Calendar</li>
    </ol>

    <h2>Create New Calendar</h2>

    <hr/>

    <form class="form" role="form" method="POST" action="{{ url('/timekeeping') }}">

    {{ csrf_field() }}

    <!-- Date Form Input -->

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">

            <label class="control-label">Date</label>
                <select class="form-control" id="date" name="date">
                <option >Please Choose One</option>
                @foreach($calendars as $calendar)
                    <option value="{{$calendar->date}}">{{Carbon\Carbon::parse($calendar->date)->format('d-m-Y')}}</option>
                @endforeach
                </select>
            @if ($errors->has('date'))

                <span class="help-block">
                <strong>{{ $errors->first('date') }}</strong>
                </span>

            @endif

        </div>

        <!-- Time Form Input -->

        <div class="form-group{{ $errors->has('timework') ? ' has-error' : '' }}">

            <label class="control-label">Time Working</label>


                <select class="form-control" id="timework" name="timework">
                    <option value="{{old('timework')}}">
                        {{ ! is_null(old('timework')) ?
                        (old('timework') == 1 ? 'Yes' :'No')
                        : 'Please Choose One'}}</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option> -->
                    
                </select>


            @if ($errors->has('timework'))

                <span class="help-block">
                <strong>{{ $errors->first('timework') }}</strong>
                </span>

            @endif

        </div>

    <!-- Description -->    

        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label">Description</label>
            <textarea  class="form-control" id="description"  name="description" placeholder="Enter Your report"></textarea>
        </div>

        
        <div class="form-group">

            <button type="submit" class="btn btn-primary btn-lg">

                Register

            </button>

        </div>

    </form>

@endsection
