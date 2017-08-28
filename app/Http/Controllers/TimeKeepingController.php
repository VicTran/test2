<?php

namespace App\Http\Controllers;

use App\Http\AuthTraits\OwnsRecord;
use App\calendar;
use App\timekeeping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $status = [2,2,2,2,2,2,2];
        // $this->validate($request,['week'=>'required|numeric']);
        $week = $request->week ? $request->week : 1;
        $calendars= DB::table('calendars')->where('countweek','=',$week)->orderBy('date','asc')->get();
        $firsttimekeeping = DB::table('timekeepings')
                          ->whereBetween('calendar_id',[$calendars
                            ->first()->id,$calendars
                            ->last()->id])
                          
                          ->get();
        if (!$firsttimekeeping)
        {
            return view('timekeeping.index',compact('status'));
        }else
        {
         $timekeepings = DB::table('timekeepings')->whereBetween('calendar_id',[$calendars->first()->id,$calendars->last()->id])->orderBy('calendar_id', 'asc')->get();
        $firstdate = Carbon::parse($calendars->first()->date);
        $lastdate = Carbon::parse($calendars->last()->date);

        $a=0;
        dd($lastdate);
        if ( $lastdate->dayOfWeek == 0 )
        {
            //$lastdate->dayOfWeek = 7;
        }
        //dd($calendars);
        for($i = $firstdate->dayOfWeek; $i<=7; $i++)
        {
            $status[$i-1] = $timekeepings[$a]->status;
            $a += 1;
        }
    
        // dd($status[6]);
        // $count[firstdate] = $firstday->dayOfWeek -  ;

        return view('timekeeping.index',compact('status'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countday= Carbon::now()->dayOfWeek;
        $firstday = Carbon::now()->subDays($countday);
        $lastday = Carbon::now()->subDays($countday)->addDays(7);
        $calendars = DB::table('calendars')->where('date', '>=', $firstday)->where('date', '<=', $lastday)
                ->orderBy('date', 'asc')
                ->get();
        return view('timekeeping.create', compact('calendars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['date' => 'date|required',
                                            'timework' => 'boolean|required',
                                             'description' => 'required']);
        $calendar = DB::table('calendars')->where('date', '=', $request->date)->first();
        $timekeeping = timekeeping::create([
                            'status' => $request->timework,
                            'description' => $request->description,
                            'user_id' => 1,
                            'calendar_id' => $calendar->id]);
    }
    /**
     *
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
