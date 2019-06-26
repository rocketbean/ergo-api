<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\JobOrderItem;
use App\Models\Supplier;
use App\Models\Property;
use App\Models\JobRequest;
use App\Models\JobOrder;
use App\Models\Photo;
use Illuminate\Http\Request;

class JobOrderItemController extends Controller
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
    public function store(Supplier $supplier, Property $property, JobRequest $jr, JobOrder $jo, Request $request)
    {
        return $jo->items()->create([
            'user_id'             => Auth::user()->id,
            'job_request_id'      => $jr->id,
            'property_id'         => $property->id,
            'supplier_id'         => $supplier->id,
            'job_request_item_id' => $request->job_request_item_id,
            'remarks'             => $request->remarks,
            'amount'              => $request->amount,
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOrderItem  $jobOrderItem
     * @return \Illuminate\Http\Response
     */
    public function show(JobOrderItem $jobOrderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOrderItem  $jobOrderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOrderItem $jobOrderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobOrderItem  $jobOrderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOrderItem $jobOrderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOrderItem  $jobOrderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOrderItem $jobOrderItem)
    {
        //
    }
}
