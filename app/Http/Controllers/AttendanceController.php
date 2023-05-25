<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendees = Attendance::all();
        $best_dress_department = Attendance::select('department', DB::raw('COUNT(*) as total_nominees'))
                                ->where('best_dress', 1)
                                ->groupBy('department')
                                ->get();
        return view('home',compact('attendees','best_dress_department'));
    }
    public function updatedData()
    {
        $attendees = Attendance::all();

        // Return the updated data as a JSON response
        return Response::json($attendees);
    }

    public function search(Request $request)
    {

            $search = $request->input('search');
            if ($search) {
                $attendees = Attendance::where('name', 'like', '%' . $search . '%')->get();
                $best_dress_department = Attendance::select('department', DB::raw('COUNT(*) as total_nominees'))
                                            ->where('best_dress', 1)
                                            ->groupBy('department')
                                            ->get();

                return view('home', compact('attendees', 'best_dress_department'));
            } else {
                return redirect()->back()->with('error', 'Please provide a search term.');
            }


    }

    public function validateRegistration($id)
    {
        $attendee = Attendance::findOrFail($id);
        $attendee->present = 1;
        $attendee->save();

        return redirect('/attendance');
    }

    public function validateBestDress($id)
    {
        $attendee = Attendance::findOrFail($id);
        $attendee->best_dress = 1;
        $attendee->save();

        return redirect('/attendance');
;
    }
    public function validateLuckyDraw($id)
    {
        $attendee = Attendance::findOrFail($id);
        $attendee->lucky_draw = 1;
        $attendee->save();

        return redirect('/attendance');
;
    }

    public function cancelBestDress($id)
    {
        $attendee = Attendance::findOrFail($id);
        $attendee->best_dress = 0;
        $attendee->save();

        return redirect('/attendance');
;
    }

    public function listNotReceivedLuckyDraw()
    {
        $attendees = Attendance::where('lucky_draw',0)->where('present',1)->get();
        return view('not-received',compact('attendees'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ingest');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        // Read the CSV file and insert into the database
        $file = $request->file('csv_file');
        $rows =  array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            $name = Attendance::create([
                'name' => $data['Name'],
                'department' => $data['Department'],
            ]);


        }

        return redirect()
            ->back()
            ->with('success', 'CSV file imported successfully.');
    }

    public function result(){
        $best_dress_nominees = Attendance::where('best_dress',1)->get();
        $best_dress_department = Attendance::select('department', DB::raw('COUNT(*) as total_nominees'))
                                ->where('best_dress', 1)
                                ->groupBy('department')
                                ->get();

        $present = Attendance::where('present',1)->where('lucky_draw',0)->get();

        return view('best-dress',compact('best_dress_nominees','best_dress_department','present'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
