<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\JobOrder;
use App\Models\Supplier;
use App\Models\Property;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Supplier $supplier, Property $property, JobRequest $jr, Request $request)
    {
        return $request->all();
        if($jr->status_id != 1){
            return response()->json('cannot create joborder from unpublished request', 406);
        } else {
            return $supplier->joborders()->create([
                'user_id'        => Auth::user()->id,
                'property_id'    => $property->id,
                'job_request_id' => $jr->id,
                'remarks'        => $request->remarks,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function show(JobOrder $jobOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOrder $jobOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOrder $jobOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOrder $jobOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function publish(Supplier $supplier, Property $property, JobRequest $jr, JobOrder $jo, Request $request)
    {
        if(count($jo->items) < 1) {
            return response()->json('job orders that has no items cannot be published', 406);
        } else {
           $jo->update(['status_id' => 1]);
           return $jo;
        }
    }
}
