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

    <form class="form" role="form" method="POST" action="{{ url('/calendar') }}">

    {{ csrf_field() }}

        <!-- Date Form Input -->

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">

            <label class="control-label">Date</label>

            <div>

                {{  Form::date('date') }}

            </div>

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
                        (old('timework') == 1 ? 'Morning' :'Evening')
                        : 'Please Choose One'}}</option>
                    <option value="1">Morning</option>
                    <option value="0">Evening</option>
                    
                </select>


            @if ($errors->has('timework'))

                <span class="help-block">
                <strong>{{ $errors->first('timework') }}</strong>
                </span>

            @endif

        </div>


        <div class="form-group">

            <button type="submit" class="btn btn-primary btn-lg">

                Create

            </button>

        </div>

    </form>

@endsection
