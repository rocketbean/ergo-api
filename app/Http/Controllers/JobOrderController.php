<?php

namespace App\Http\Controllers;
use App\Models\JobOrder;
use App\Models\JobOrderItem;
use App\Models\JobRequest;
use App\Models\Property;
use App\Models\Supplier;
use App\Notifications\approveJobOrder;
use App\Notifications\newQuote;
use Auth;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JobOrder $jo)
    {
        return $jo;
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
                    'amount' => $item['amount'],
                    'remarks' => $item['description'],
                    'user_id' => Auth::user()->id,
                    'job_request_item_id' => $item['jobrequestitem']['id'],
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
            $property->owner->notify(new newQuote($jo, $jr, $supplier));
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

    /**
     * Set joborder as Viewed by Client state
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function viewed (JobOrder $jo) {
        $jo->update([
            'view' => 1
        ]);
        return $jo;
    }

    /**
     * Set joborder as Approved status
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function approve (JobOrder $jo, JobRequest $jr) {
        $user = Auth::user();
        $njo  = JobOrder::Approve($jo, $user);
        $njr  = JobRequest::Approve($jr, $jo, $user);
        $jo->supplier->user->notify(new approveJobOrder($jo, $jr, $jr->property));
        return [
            'joborder' => $njo,
            'jobrequest' => $njr
        ];

    }

    /**
     * Set joborder as confirmed status
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return \Illuminate\Http\Response
     */
    public function confirm (JobOrder $jo, JobRequest $jr) {
        $user = Auth::user();
        $njo  = JobOrder::Confirm($jo, $user);
        $njr  = JobRequest::Confirm($jr, $jo, $user);
        $jr->property->user->notify(new confirmJobOrder($jo, $jr, $jr->property));
        return [
            'joborder' => $njo,
            'jobrequest' => $njr
        ];

    }
}
