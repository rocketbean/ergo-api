<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\JobRequestItem;
use App\Models\User;
use App\Models\JobRequest;
use App\Models\Property;
use App\Models\Photo;
use App\Models\Video;
use App\Models\File;
use Illuminate\Http\Request;

class JobRequestItemController extends Controller
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
    public function store(Property $property, JobRequest $jr, Request $request)
    {
        $jri = JobRequestItem::create([
            'property_id'       => $property->id,
            'user_id'           => Auth::user()->id,
            'name'              => $request->name,
            'job_request_id'    => $jr->id,
            'description'       => $request->description
        ]);

        if(!empty($request->photos)) {
            foreach ($request->photos as $photo) {
                Property::RelateTo($property, $photo, 'photos');
                JobRequest::RelateTo($jr, $photo, 'photos');
                JobRequestItem::RelateTo($jri, $photo, 'photos');
            }
        }

        if(!empty($request->files)) {
            foreach ($request->files as $file) {
                Property::RelateTo($property, $file, 'files');
                JobRequest::RelateTo($jr, $file, 'files');
                JobRequestItem::RelateTo($jri, $file, 'files');
            }
        }

        if(!empty($request->videos)) {
            foreach ($request->videos as $video) {
                Property::RelateTo($property, $video, 'videos');
                JobRequest::RelateTo($jr, $video, 'videos');
                JobRequestItem::RelateTo($jri, $video, 'videos');
            }
        }

        if(!empty($request->tags)) {
            foreach ($request->tags as $tag) {
                Property::RelateTo($property, $tag, 'tags');
                JobRequest::RelateTo($jr, $tag, 'tags');
                JobRequestItem::RelateTo($jri, $tag, 'tags');
            }
        }

        return $jr->load('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobRequestItem  $jobRequestItem
     * @return \Illuminate\Http\Response
     */
    public function show(JobRequestItem $jobRequestItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobRequestItem  $jobRequestItem
     * @return \Illuminate\Http\Response
     */
    public function edit(JobRequestItem $jobRequestItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobRequestItem  $jobRequestItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobRequestItem $jobRequestItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobRequestItem  $jobRequestItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobRequest $jr, JobRequestItem $item)
    {
        $item->photos()->detach($item->id);
        $item->files()->detach($item->id);
        $item->videos()->detach($item->id);
        $item->delete();
        return $jr->load('items');
    }

    /**
     * attaches the photo
     */
    public function attachPhoto(JobRequest $jr, JobRequestItem $item, Photo $photo )
    {
        (new JobRequest)->attachPhoto($jr, $photo);
        (new JobRequestItem)->attachPhoto($item, $photo);
        return JobRequest::find($jr->id)->load('items.photos');
    }
}
