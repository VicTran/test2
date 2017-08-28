<?php

namespace App\Http\Controllers;

use App\Http\AuthTraits\OwnsRecord;
use App\calendar;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CalendarController extends Controller
{
    use OwnsRecord;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars = calendar::paginate(10);
        return view('calendar.index', compact('calendars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                                    'timework' => 'boolean|required',
                                    'date' => 'date|required']);
        $calendarExists = $this->calendarExists($request->date);
        $time = Carbon::yesterday();
        if ($time >= $request->date) {
            alert()->error('Errors!', 'Errors date  ');
            return Redirect::route('calendar.create');
        }
        if ($calendarExists) {
            alert()->error('Congrats!', 'Calendar already exists  ');
            return Redirect::route('calendar.index');
        }
        $date = Carbon::parse($request->date);
        $firstcalendar = calendar::first();
        if (!$firstcalendar) {
            $count = 1;
        } else {
            $firstDate = Carbon::parse($firstcalendar->date);
            $firstdayOfirstWeek = Carbon::parse($firstcalendar->date)->subDays($firstDate->dayOfWeek);
            $count = ceil(($date->dayOfYear - $firstdayOfirstWeek->dayOfYear) / 7);
            if ($count < 1) {
                $count = 1;
            }
        }
        $calendar = calendar::created(['date' => $request->date,
            'status' => $request->timework,
            'user_id' => Auth::user()->id,
            'countweek' => $count]);
        $calendar->save();
        alert()->success('Congrats!', 'You create new calendar');
        return Redirect::route('calendar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function calendarExists($date)
    {
        $calendarExists = DB::table('calendars')
            ->where('date', $date)
            ->exists();
        return $calendarExists;
    }
}
