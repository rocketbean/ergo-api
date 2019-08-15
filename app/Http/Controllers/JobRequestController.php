<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\JobRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Notifications\NewJobRequest;
use App\Notifications\PublishJobRequest;

class JobRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JobRequest $jr)
    {
        return $jr->load(['items', 'joborders']);
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

        $jr = $property->jobrequests()->create([
            'user_id'     => Auth::user()->id,
            'name'        => $request->name,
            'description' => $request->description,
            'status_id'   => $property->authorized('publish_jobrequest') ? 1 : 0
        ]);
        $property->push_notification(new NewJobRequest(Auth::user(), $jr));
        return $jr;
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
            $property->push_notification(new PublishJobRequest(Auth::user(), $jr));
            $jr->update(['status_id' => 2]);
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

            $property->photos()->detach($item->id);
            $property->files()->detach($item->id);
            $property->videos()->detach($item->id);

            $item->delete();
        }
        $jr->delete();
        return $property->load(['jobrequests', 'photos', 'location', 'videos','users']);
    }
}
