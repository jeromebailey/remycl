<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Leavetypes;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $leaveTypes = Leavetypes::all()->sortBy('leave_type');

        $data = array(
            'leave_types' => $leaveTypes
        );
        return view('requests.make-request', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $data = array(
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        );

        try{
            LeaveRequest::create();
        } catch(Exception $e){

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function show(Request $request)
    // {
    //     //
    //     return view('requests.my-request');
    // }

    public function showUserRequestsByYear()
    {
        $year = now()->year;
        $allRequests = LeaveRequest::getAllLeaveRequestsForUserByYear(Auth::user()->id, $year);

        $data = array(
            'leave_requests' => $allRequests
        );

        return view('requests.my_requests', $data);
    }

    public function showAllUsersRequestsByYear()
    {
        $year = now()->year;
        $allRequests = LeaveRequest::getAllUsersLeaveRequestsByYear($year);

        $data = array(
            'all_leave_requests' => $allRequests
        );

        return view('requests.all_requests', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
