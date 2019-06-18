<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\JobOrder;
use App\Models\Supplier;
use App\Models\Property;
use App\Models\JobOrderItem;
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
        if($jr->status_id == 1){
            return response()->json('cannot create joborder from unpublished request', 406);

        } else {
            $jo = $supplier->joborders()->create([
                'user_id'        => Auth::user()->id,
                'property_id'    => $property->id,
                'job_request_id' => $jr->id,
                'remarks'        => $request->remarks,
                'estimation'     => JobOrder::getEstimation($request->items)
            ]);

            foreach ($request->items as $item) {
                $joi = $jo->items()->create([
                    'amount' => $item['estimation'],
                    'remarks' => $item['description'],
                    'user_id' => Auth::user()->id,
                    'job_request_item_id' => $item['jr']['id'],
                    'job_request_id' => $jr->id,
                    'property_id' => $property->id,
                    'supplier_id' => $supplier->id,
                ]);

                if(!empty($item['photos'])) {
                    foreach ($item['photos'] as $photo) {
                        Supplier::RelateTo($supplier, $photo, 'photos');
                        JobOrder::RelateTo($jo, $photo, 'photos');
                        JobOrderItem::RelateTo($joi, $photo, 'photos');
                    }
                }

                if(!empty($item['files'])) {
                    foreach ($item['files'] as $file) {
                        Supplier::RelateTo($supplier, $file, 'files');
                        JobOrder::RelateTo($jo, $file, 'files');
                        JobOrderItem::RelateTo($joi, $file, 'files');
                    }
                }

                if(!empty($item['videos'])) {
                    foreach ($item['videos'] as $video) {
                        Supplier::RelateTo($supplier, $video, 'videos');
                        JobOrder::RelateTo($jo, $video, 'videos');
                        JobOrderItem::RelateTo($joi, $video, 'videos');
                    }
                }

                if(!empty($item['tags'])) {
                    foreach ($item['tags'] as $tag) {
                        JobOrder::RelateTo($jo, $tag, 'tags');
                        JobOrderItem::RelateTo($joi, $tag, 'tags');
                    }
                }
            }

            return $jo->load(['photos', 'files', 'videos','items']);
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
