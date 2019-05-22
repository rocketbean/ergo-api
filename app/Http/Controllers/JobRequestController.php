<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\JobRequest;
use App\Models\Property;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Property $property, JobRequest $jr, Request $request)
    {
        return $jr->load('items');
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
    public function store(Property $property, Request $request)
    {
        return $property->jobrequests()->create([
            'user_id'     => Auth::user()->id,
            'name'        => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\Response
     */
    public function show(JobRequest $jobRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(JobRequest $jobRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobRequest $jobRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\Response
     */
    public function publish(Property $property, JobRequest $jr)
    {
        if(count($jr->items) < 1 ){
            return response()->json('job requests that has no items cannot be published', 406);
        } else {
            $jr->update(['status_id' => 1]);
            return $jr;
        }
    }

    /**
     * attaches the photo
     */
    public function attachPhoto(Photo $photo, JobRequest $jr)
    {
        (new JobRequest)->attachPhoto($jr, $photo);
        return JobRequest::find($jr->id)->load('photos');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobRequest  $jobRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property, JobRequest $jr)
    {
        foreach ($jr->items as $item) {
            $item->photos()->detach($item->id);
            $item->files()->detach($item->id);
            $item->videos()->detach($item->id);
            $item->delete();
        }
        $jr->delete();
        return $property->load(['jobrequests', 'photos', 'location', 'videos','users']);
    }
}
