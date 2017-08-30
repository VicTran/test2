<?php

namespace App\Http\Controllers;

use App\Http\AuthTraits\OwnsRecord;
use App\calendar;
use App\timekeeping;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TimeKeepingController extends Controller
{
    use OwnsRecord;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses = [2, 2, 2, 2, 2, 2, 2];
        $week = $request->week ? $request->week : 1;

        $calendars = DB::table('calendars')
            ->where('countweek', '=', $week)
            ->orderBy('date', 'asc')
            ->get();
        if($calendars->isEmpty())
        {
            dd('a');
            return view('timekeeping.index', compact('statuses','user_id'));
        }

//        dd(User::find(1)->timekeeping()->get());

        $timeKeepings = DB::table('timekeepings')
            ->whereBetween('date', [$calendars
                ->first()->date, $calendars
                ->last()->date])
            ->where('user_id', Auth::user()->id)
            ->orderBy('date', 'asc')
            ->get();
//        dd($timeKeepings->groupBy('user_id'));

        foreach ($timeKeepings as $timeKeeping) {
            $date = Carbon::parse($timeKeeping->date);
            if ($date->dayOfWeek == 0) {
                $statuses[6] = $timeKeeping->status;
            } else {
                $statuses[$date->dayOfWeek-1] = $timeKeeping->status;
            }
        }
        $user_id = Auth::user()->id;
        return view('timekeeping.index', compact('statuses','user_id'));
    }

    public function showWithIndex(Request $request)
    {

        $week = $request->week ? $request->week : 1;

        $calendars = DB::table('calendars')
            ->where('countweek', '=', $week)
            ->orderBy('date', 'asc')
            ->get();

        if($calendars->isEmpty())
        {
            $statuses[0]= [2,2,2,2,2,2,2];
            return view('timekeeping.index', compact('statuses','user_id'));
        }

        $timeKeepings = DB::table('timekeepings')
            ->whereBetween('date', [$calendars
                ->first()->date, $calendars
                ->last()->date])
            ->orderBy('date', 'asc')
            ->get();
        if($timeKeepings->isEmpty())
        {
            $statuses[0]= [2,2,2,2,2,2,2];
            return view('timekeeping.adminindex', compact('statuses'));
        }
        $timeKeepings = $timeKeepings->groupBy('user_id');

        foreach ($timeKeepings as $key => $timeKeeping) {
            $statuses[$key]= [2,2,2,2,2,2,2];
            foreach ($timeKeeping as $key2 => $item)
            {
                $date = Carbon::parse($item->date);
                if ($date->dayOfWeek == 0) {
                    $statuses[$key][6] = $item->status;
                } else {
                    $statuses[$key][$date->dayOfWeek-1] = $item->status;
                }
            }

        }
        return view('timekeeping.adminindex', compact('statuses'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countDay = Carbon::now()->dayOfWeek;
        $firstDay = Carbon::now()->subDays($countDay);
        $lastDay = Carbon::now()->subDays($countDay)->addDays(7);
        $calendars = DB::table('calendars')
            ->where('date', '>=', $firstDay)
            ->where('date', '<=', $lastDay)
            ->orderBy('date', 'asc')
            ->get();
        return view('timekeeping.create', compact('calendars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['date' => 'date|required',
            'timework' => 'boolean|required',
            'description' => 'required']);

        $calendar = $this->getCalendarExists($request);
        $timeKeepingExists = $this->timekeepingExists($request);
        if ($timeKeepingExists > $request->date) {
            alert()->error('Errors', 'Errors Date');
            return Redirect::route('timekeeping.create');
        }
        $timeKeeping = timekeeping::create([
            'status' => $request->timework,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'calendar_id' => $calendar->id,
            'date' => $request->date]);
        $timeKeeping->save();
        return Redirect::route('timekeeping.index');
    }

    /**
     *
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

    }

    /**
     * @param Request $request
     * @return bool
     */
    private function timekeepingExists(Request $request): bool
    {
        $timeKeeping = DB::table('timekeepings')
            ->where('date', $request->date)
            ->exists();
        return $timeKeeping;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getCalendarExists(Request $request)
    {
        $calendar = DB::table('calendars')
            ->where('date', '=', $request->date)
            ->first();
        return $calendar;
    }
}
